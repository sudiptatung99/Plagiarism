<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserPlan;
use Exception;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        activity()->log("Show Plan List");
        $plan = Plan::latest()->get();
        return view('pages.plan.plan_view', compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        activity()->log("Show Create Plan");
        return view('pages.plan.plan_create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $validation = $request->validate([
            'name' => 'required',
            'tag' => 'required',
            'price' => 'required',
            'for' => 'required',
            'detail' => 'required',
            'letter_count' => 'required',
        ]);
        activity()->log("New Plan Created");
        try {
            Plan::create([
                'name' => $request->name,
                'tag' => $request->tag,
                'price' => $request->price,
                'for' => $request->for,
                'details' => $request->detail,
                'letter_count' => $request->letter_count,
            ]);
            toastr()->success('Plan Created successfully!', 'sucess');
            return redirect()->back();
        } catch (Exception $e) {
            echo $e;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        activity()->log("Show Plan Updated");
        $id = decrypt($id);
        $plan = Plan::find($id);
        return view('pages.plan.plan_edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $id = decrypt($id);
        $validation = $request->validate([
            'name' => 'required',
            'tag' => 'required',
            'price' => 'required',
            'for' => 'required',
            'details' => 'required',
            'letter_count' => 'required',
        ]);
        activity()->log("Plan Updated");
        try {
            Plan::find($id)->update([
                'name' => $request->name,
                'tag' => $request->tag,
                'price' => $request->price,
                'for' => $request->for,
                'details' => $request->details,
                'letter_count' => $request->letter_count,
            ]);
            toastr()->success('Plan Update successfully!', 'sucess');
            return redirect('/plan');

        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        activity()->log("Plan Deleted");
        $id = decrypt($id);
        $plan = Plan::destroy($id);
        toastr()->success('Plan Deleted successfully!', 'sucess');
        return redirect()->back();
    }

    //userPlan Details

    public function userPlan()
    {
        $userplan = UserPlan::with('user')->get();
        return view('pages.user_plan.user_plan_view', compact('userplan'));
    }
}
