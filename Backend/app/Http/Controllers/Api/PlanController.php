<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function list(Request $request)
    {
        $plan = Plan::orderByDesc('created_at')->get();
        return response()->json(['success' => true, 'data' => $plan], 200);
    }

    public function addPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'plan_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'Required field is missing !'], 400);
        }
        $transactionId = "plan" . rand(0000, 9999);
        $plan = Plan::find($request->plan_id);
        $user = User::find($request->user_id);
        $user->remain_doc = $plan->letter_count - $user->uses_doc;
        $user->save();
        $plan = new UserPlan();
        $plan->user_id = $request->user_id;
        $plan->transaction_id = $transactionId;
        $plan->plan_id = $request->plan_id;
        $date = Carbon::now();
        $date->addDays(180);
        $plan->exp_date = $date;
        $plan->save();
        $user->exp_date = $date;
        $user->save();
        return response()->json(['success' => true, 'msg' => 'Plan has been added successfully.'], 200);
    }

    public function planCount(Request $request)
    {

        $userDocument = UserPlan::where('user_id', $request->user_id)->get();
        $count = 0;
        foreach ($userDocument as $key => $value) {
            $count = $count + $value->document_no;
        }
        return response()->json(['success' => true, 'data' => $count], 200);
    }
}
