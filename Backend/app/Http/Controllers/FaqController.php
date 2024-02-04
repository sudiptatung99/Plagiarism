<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Exception;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        activity()->log("Show FAQ List");
        $faq = Faq::latest()->get();
        return view('faq.faq_list', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        activity()->log("Show Create FAQ Page");
        return view('faq.add_edit_faq');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validation = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        activity()->log("New FAQ Created");
        try {
            Faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
            toastr()->success('FAQ Created successfully!', 'sucess');
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
        activity()->log("Show FAQ Updated");
        $id = decrypt($id);
        $faq = Faq::find($id);
        return view('faq.add_edit_faq',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $id = decrypt($id);
        $validation = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        activity()->log("FAQ Updated");
        try {
            Faq::find($id)->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
            toastr()->success('FAQ Update successfully!', 'sucess');
            return redirect('/faq');

        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        activity()->log("FAQ Deleted");
        $id = decrypt($id);
        $plan = Faq::destroy($id);
        toastr()->success('FAQ Deleted successfully!', 'sucess');
        return redirect()->back();
    }

    //userPlan Details

  
}
