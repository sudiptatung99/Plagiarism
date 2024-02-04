<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use App\Models\CountDoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $user_id = $request->user_id;
        $user = User::find($user_id);
        $formatted_dt1=Carbon::now();
        $formatted_dt2=Carbon::parse($user->exp_date);
        $date_diff=$formatted_dt1->diffInDays($formatted_dt2);
        if($formatted_dt1->gt($formatted_dt2)){
            return response()->json(['success' => true, 'user'=>$user, 'usesDoc'=> $user->uses_doc ,'remainDoc'=> $user->remain_doc,'plan'=>'Expired'], 200);
        }
        return response()->json(['success' => true, 'user'=>$user, 'usesDoc'=> $user->uses_doc ,'remainDoc'=> $user->remain_doc,'plan'=>$date_diff], 200);

    }

}
