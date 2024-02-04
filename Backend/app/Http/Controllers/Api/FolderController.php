<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'step' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $folder = new Folder();
        $folder->user_id = $request->user_id;
        $folder->parent_id = $request->parent_id;
        $folder->name = $request->name;
        $folder->step = $request->step;
        $folder->save();
        return response()->json(['success' => true, 'msg' => 'Folder has been created successfully.'], 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $folder = Folder::where('id', $request->id)->with('document')->first();
        if (count($folder->document) > 0) {
            foreach ($folder->document as $key => $value) {
                $deleteDocument = Document::find($value->id);
                $deleteDocument->is_delete ='1';
                $deleteDocument->folder_id =null;
                $deleteDocument->save();
                $result = (new ReportController)->deleteDocument($deleteDocument->doc_id);
            }
        }
        $folder->delete();
        return response()->json(['success' => true, 'msg' => 'Folder has been deleted successfully.'], 200);
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $folder = Folder::find($request->id);
        return response()->json(['success' => true, 'data' => $folder], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $folder = Folder::find($request->id);
        $folder->name = $request->name;
        $folder->save();
        return response()->json(['success' => true, 'msg' => 'Folder has been updated successfully.'], 200);
    }

    public function moveFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'parent_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $folder = Folder::find($request->id);
        $folderId = $folder;
        $parentFolder = Folder::find($request->parent_id);
        if ($folder->id > $request->parent_id) {
            //
            // $folderData = Folder::find($request->id);
            $folder->parent_id = $parentFolder->parent_id;
            // $folder->id = $parentFolder->id;
            $folder->save();
            $parentFolder->parent_id = $folderId->parent_id;
            // $parentFolder->id =$folderId->id ;
            $parentFolder->save();

        } else {
            // return response()->json(['success' => true, 'msg' => 'Folder big successfully.'], 200);
            $parentFolder->parent_id = $request->id;
            $parentFolder->save();
        }
        return response()->json(['success' => true, 'msg' => 'Folder has been moved successfully.'], 200);
    }
}
