<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profileInfo(Request $request)
    {
        $profile = User::find($request->user_id);
        return response()->json(['success' => true, 'data' => $profile]);
    }
    public function profileEdit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            "id" => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::find($request->id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->company_name = $request->company_name;
        $user->phone_number = $request->phone_number;
        $user->save();
        return response()->json(['success' => true, 'msg' => "Profile update successfully."]);
    }
}
