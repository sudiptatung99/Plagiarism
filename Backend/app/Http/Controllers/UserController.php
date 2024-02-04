<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function allUser()
    {
        activity()->log("Show User List");
        $user = User::latest()->get();
        return view('pages.user-list.user_view', compact('user'));
    }
    public function edit($id)
    {
        activity()->log("Open user updated Form");
        $id = decrypt($id);
        $user = User::find($id);
        return view('pages.user-list.user_edit', compact('user'));
    }
    public function update($id, Request $request)
    {

        $id = decrypt($id);
        $validation = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'company_name' => 'required',
            'remain_doc' => 'required',
        ]);
        activity()->log("User updated");
        User::find($id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'company_name' => $request->company_name,
            'remain_doc' => $request->remain_doc,
        ]);

        toastr()->success('User Updateed successfully!', 'sucess');
        return redirect()->back();
    }
    public function delete($id)
    {
        activity()->log("User Delete");
        $id = decrypt($id);
        $user = User::find($id);
        $user->delete();
        toastr()->success('User Delete successfully!', 'sucess');
        return redirect()->back();
    }

}
