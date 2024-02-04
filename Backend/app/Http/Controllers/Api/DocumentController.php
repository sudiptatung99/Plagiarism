<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use URL;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::find($request->user_id);
        $ocr = $request->ocr;
        $formatted_dt1 = Carbon::now();
        $formatted_dt2 = Carbon::parse($user->exp_date);
        if ($formatted_dt1->gt($formatted_dt2)) {
            return response()->json(['success' => false, 'msg' => "Your plan is already expired !"], 400);
        }
        if ($user->remain_doc <= 0) {
            return response()->json(['success' => false, 'msg' => "Your don't have sufficient documents !"], 400);
        }
        if ($request->hasfile('document')) {
            $sentenceCount = 0;
            $file = $request->file('document');
            $extension = $file->extension();
            if ($extension == 'pdf') {
                $path = $request->document;
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($path);
                $text = $pdf->getText();
                $lCount = strlen($text);
                $totalDoc = ceil($lCount / 60000);
                $sentences = preg_split('/[.!?]/', $text, -1, PREG_SPLIT_NO_EMPTY);
                $sentenceCount = $sentenceCount + count($sentences);
            } else {
                $fileContent = fopen($file, "r");
                $contents = fread($fileContent, filesize($file));
                fclose($fileContent);
                $lCount = strlen($contents);
                $totalDoc = ceil($lCount / 60000);
                $sentences = preg_split('/[.!?]/', $contents, -1, PREG_SPLIT_NO_EMPTY);
                $sentenceCount = $sentenceCount + count($sentences);
            }
            if ($user->remain_doc >= $totalDoc) {
                $document = new Document();
                $document->user_id = $request->user_id;
                $document->folder_id = $request->folder_id;
                $document->name = $request->name;
                $document->type = $request->type;
                $document->inSentenceCount = $sentenceCount;
                $document->inTextCount = $lCount;
                $document->inDeductDocument = $totalDoc;
                $document->save();
                $fileName = $file->getClientOriginalName();
                $filePath = $document->id . '/' . $fileName;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($request->document));
                $path = Storage::disk('s3')->url($filePath);
                $document->document = $path;
                $document->save();
                $result = (new ReportController)->simpleCheck($path, $user, $ocr);
                $document->doc_status = "InProgress";
                $document->doc_id = json_encode($result);
                $document->save();
                $text = (new ReportController)->getText($document->doc_id);
                $document->doc_text = $text->GetDocumentTextResult;
                $document->save();
                $user->uses_doc = $user->uses_doc + $totalDoc;
                $user->remain_doc = $user->remain_doc - $totalDoc;
                $user->save();
                return response()->json(['success' => true,"doc"=>$user->remain_doc, 'msg' => 'Document has been uploaded successfully.'], 200);
            } else {
                return response()->json(['success' => false, 'msg' => "Please extend your plan !"], 400);
            }

        } else {
            return response()->json(['success' => false, 'msg' => "File does not exist !"], 400);
        }
    }

    // public function uploadDocument(Request $request)
    // {
    //     $user = User::find($request->user_id);

    // }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $document = Document::find($request->id);
        $document->is_delete = '1';
        $document->save();
        $result = (new ReportController)->deleteDocument($document->doc_id);
        return response()->json(['success' => true, 'msg' => 'Document has been deleted successfully.'], 200);
    }

    public function addToIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $document = Document::find($request->id);
        $document->is_index = '1';
        $document->save();
        $result = (new ReportController)->setIndex($document->doc_id);
        return response()->json(['success' => true, 'msg' => 'Documents have been added to the index.'], 200);
    }

    public function deletedFromIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $document = Document::find($request->id);
        $document->is_index = '0';
        $document->save();
        $result = (new ReportController)->removeIndex($document->doc_id);
        return response()->json(['success' => true, 'msg' => 'Documents have been deleted from the index.'], 200);
    }

    public function moveDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'doc_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $document = Document::find($request->doc_id);
        $document->folder_id = $request->id;
        $document->save();
        return response()->json(['success' => true, 'msg' => 'Documents has been moved successfully.'], 200);
    }

    public function documentCount(Request $request)
    {
        // return response()->json(['success' => true, 'text' =>"jkljk"], 200);
        $document = Document::find($request->id);
        $fileSize = ($data = @file_get_contents($document->document)) ? strlen($data) : false;
        return response()->json(['success' => true, 'size' => $fileSize, 'details' => $document], 200);

    }

    public function UploadText(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'text' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::find($request->user_id);
        $lCount = strlen($request->text);
        $totalDoc = ceil($lCount / 60000);
        if ($user->remain_doc >= $totalDoc) {
            $txt = $request->text;
            $document = new Document();
            $document->user_id = $request->user_id;
            $document->folder_id = $request->folder_id;
            $document->name = $request->name . '.txt';
            $document->type = $request->type;
            $document->isDoc = '0';
            $document->doc_status = "InProgress";
            $document->save();
            $filePath = $document->id . '/' . $request->name;
            $path = Storage::disk('s3')->put($filePath . '.txt', $txt);
            $path = Storage::disk('s3')->url($filePath . '.txt');
            $result = (new ReportController)->simpleCheckText($path, $user);
            $document->document = $path;
            $document->doc_id = json_encode($result);
            $document->save();
            $text = (new ReportController)->getText($document->doc_id);
            $document->doc_text = $text->GetDocumentTextResult;
            $document->save();
            $user->uses_doc = $user->uses_doc + $totalDoc;
            $user->remain_doc = $user->remain_doc - $totalDoc;
            $user->save();
            return response()->json(['success' => true, 'msg' => 'document uploaded successfully.'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => "Please extend your plan"], 400);
        }

        // $document = new Document;
        // $document->folder_id = $request->folder_id;
        // $document->user_id = $request->user_id;
        // $document->name = $request->name;
        // $document->text = $request->text;
        // $document->isDoc = '0';
        // $document->save();
        // $user = User::find($request->user_id);
        // $user->total_letter = $user->total_letter - $lCount;
        // $user->uses_letter = $user->uses_letter + $lCount;
        // $user->save();
        // return response()->json(['success' => true, 'msg' => 'Text has been uploaded successfully.'], 200);
    }
    public function report(Request $request)
    {
        $document = Document::find($request->id);
        return response()->json(['success' => true, 'data' => $document->report_url], 200);
    }

    public function countDocument(Request $request)
    {
        $id = decrypt($request->id);
        $documentCount = UserPlan::find($id);
        return response()->json(['success' => true, 'data' => $documentCount->document_no], 200);
    }

}
