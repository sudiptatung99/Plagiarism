<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::where('email', $credentials['email'])->where('isRegister', 1)->first();
        if (!$user) {
            return response()->json(['msg' => 'User does not exist !'], 400);
        }
        try
        {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'msg' => 'These credentials do not match !'], 400);
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json(['success' => false, 'msg' => 'Could not create token !'], 500);
        }
        $user = User::where('email', $credentials['email'])->first();
        // $user->remember_token = $token;
        // $user->save();
        return response()->json(['success' => true, 'userId' => $user->id, 'accessToken' => $token], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::where('email', $request->email)->where('isRegister', 1)->first();
        if ($user) {
            return response()->json(['success' => false, 'msg' => 'This email id is already exist !'], 400);
        } else {
            $otp = rand(000000, 999999);
            $user = new User();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->company_name = $request->company_name;
            $user->isRegister = 0;
            $user->otp = $otp;
            $user->password = Hash::make($request->password);
            $user->save();
            $details = [
                'otp' => $otp,
                'email' => $user->email,
            ];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://jk.haasil.in/api/send-mail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($details),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return response()->json(['success' => true, 'otp' => $otp, 'msg' => 'OTP send to your email.'], 200);
        }
    }

    public function checkRegisterOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => 'Required field is missing !'], 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user->otp == $request->otp) {
            $user->isRegister = 1;
            $user->save();
            return response()->json(['success' => true, 'msg' => 'Register has been successfully.'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'OTP does not matched !'], 400);
        }
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::find($request->user_id);
        return response()->json(['success' => true, 'data' => $user], 200);
    }

    public function folderList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $folder = Folder::where('user_id', $request->user_id)->whereNull('parent_id')->with('folder.folder.folder.folder.folder.folder.folder.folder.folder.folder', 'document', 'folder.document', 'folder.folder.document', 'folder.folder.folder.document', 'folder.folder.folder.folder.document', 'folder.folder.folder.folder.folder.document', 'folder.folder.folder.folder.folder.folder.document', 'folder.folder.folder.folder.folder.folder.folder.document', 'folder.folder.folder.folder.folder.folder.folder.folder.document', 'folder.folder.folder.folder.folder.folder.folder.folder.folder.document')->orderBy('name')->get();
        return response()->json(['success' => true, 'data' => $folder], 200);
    }

    public function planList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $plan = UserPlan::where('user_id', $request->user_id)->latest()->get();
        return response()->json(['success' => true, 'data' => $plan], 200);
    }

    public function documentList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $user = User::find($request->user_id);
        $Getdocument = Document::where('user_id', $request->user_id)->where('is_delete', '0')->where('doc_id','!=','')->where('document','!=','')->where('doc_status', 'InProgress')->orderByDesc('created_at')->get();
        foreach ($Getdocument as $key => $value) {
            $id = $value->doc_id;
            $one_doc = Document::find($value->id);
            $result = (new ReportController)->checkDoc($id);
            $one_doc->doc_status = $result->Status;
            $one_doc->save();

            $countDoc = (new ReportController)->getCount($id);
            if ($countDoc) {
                $apidoc = ceil($countDoc->TextSize / 60000);
                $one_doc->outDeductDocument = $apidoc;
                $one_doc->outTextCount = $countDoc->TextSize;
                $one_doc->outSentenceCount = $countDoc->SentenceCount;
                $one_doc->save();
            }
            if ($one_doc->inDeductDocument && $one_doc->outDeductDocument) {
                if ($one_doc->outDeductDocument > $one_doc->inDeductDocument) {
                    $remainDoc = $one_doc->outDeductDocument - $one_doc->inDeductDocument;
                    $one_doc->inDeductDocument = $one_doc->outDeductDocument;
					$one_doc->inTextCount = $one_doc->outTextCount;
					$one_doc->save();
                    $user->remain_doc = $user->remain_doc - $remainDoc;
                    $user->uses_doc = $user->uses_doc + $remainDoc;
                    $user->save();
                }
                if ($one_doc->outDeductDocument < $one_doc->inDeductDocument) {
                    $extendDoc = $one_doc->inDeductDocument - $one_doc->outDeductDocument;
                    $one_doc->inDeductDocument = $one_doc->outDeductDocument;
					$one_doc->inTextCount = $one_doc->outTextCount;
					$one_doc->save();
                    $user->remain_doc = $user->remain_doc + $extendDoc;
                    $user->uses_doc = $user->uses_doc - $extendDoc;
                    $user->save();
                }
            }

            if ($result->Status == "Ready") {
                $url = $result->Summary->SummaryReportWebId;
                $one_doc->report_url = "https://elztest.eaarjav.com$url";
                $one_doc->originality = round($result->Summary->BaseScore->Unknown, 2);
                $one_doc->save();

                $text = (new ReportController)->getText($one_doc->doc_id);
                $one_doc->doc_text = $text->GetDocumentTextResult;
                $one_doc->save();

            }
        }
        $document = Document::where('user_id', $request->user_id)->where('is_delete', '0')->where('document','!=','')->orderByDesc('created_at')->get();
        return response()->json(['success' => true, 'data' => $document], 200);
    }

    public function deleteDocumentList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $document = Document::where('user_id', $request->user_id)->where('is_delete', '1')->orderByDesc('created_at')->get();
        return response()->json(['success' => true, 'data' => $document], 200);
    }

    public function folderDocumentList(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'user_id' => 'required',
        //     'folder_id' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['msg' => 'Required field is missing !'], 400);
        // }
        if ($request->folder_id == null) {
            $document = Document::where('user_id', $request->user_id)->where('folder_id', null)->where('is_delete', '0')->orderByDesc('created_at')->get();
            return response()->json(['success' => true, 'data' => $document], 200);
        } else {
            $document = Document::where('user_id', $request->user_id)->where('folder_id', $request->folder_id)->where('is_delete', '0')->orderByDesc('created_at')->get();
            return response()->json(['success' => true, 'data' => $document], 200);
        }

    }

    public function getAllFolder(Request $request)
    {
        $folder = Folder::where('user_id', $request->user_id)->orderBy('name')->get();
        return response()->json(['success' => true, 'data' => $folder], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()], 400);
        }
        $user = User::find($request->user_id);
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'msg' => 'Password does not matched !'], 400);
        } else {
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['success' => true, 'msg' => 'Password updated successfully.'], 200);
        }
    }

    public function emailVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => 'Required field is missing !'], 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = rand(000000, 999999);
            $user->otp = $otp;
            $user->save();
            $details = [
                'otp' => $otp,
                'email' => $user->email,
            ];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://jk.haasil.in/api/send-mail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($details),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return response()->json(['success' => true, 'userId' => $user->id, 'msg' => 'OTP send to your email.'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'User does not exist'], 400);
        }
    }

    public function resendOtp(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $otp = rand(000000, 999999);
            $user->otp = $otp;
            $user->save();
            $details = [
                'otp' => $otp,
                'email' => $user->email,
            ];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://jk.haasil.in/api/send-mail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($details),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return response()->json(['success' => true, 'msg' => 'OTP resend to your email.'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'User does not exist !'], 400);
        }
    }

    public function checkOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => 'Required field is missing !'], 400);
        }
        $user = User::find($request->user_id);
        if ($user->otp == $request->otp) {
            return response()->json(['success' => true, 'msg' => 'Enter your new password.'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'OTP does not matched !'], 400);
        }
    }

    public function Resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()], 400);
        }
        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['success' => true, 'msg' => 'Password updated successfully.'], 200);
    }
}
