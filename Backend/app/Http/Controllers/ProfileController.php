<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        activity()->log("Show Profile Update");
        $user = Auth::guard('admin')->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        activity()->log("Profile Update");
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required',

        ]);
        $admin = Auth::guard('admin')->user();
        $adminData = Admin::find($admin->id);
        $adminData->name = $request->name;
        $adminData->email = $request->email;
        $adminData->save();
        toastr()->success('Profile Updated successfully!', 'sucess');
        return redirect()->back();
    }

    public function password()
    {
        activity()->log("Show Password Change");
        return view('profile.update-password-form');
    }
    public function updatePassword(Request $request)
    {
        activity()->log("Password Change");
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'=>'required'
        ]);
        $admin = Auth::guard('admin')->user();
        $adminData = Admin::find($admin->id);
        if(Hash::check($request->current_password,$admin->password)){
            $adminData->password = bcrypt($request->password);
            $adminData->save();
            toastr()->success('Password Updated successfully!', 'sucess');
            return redirect()->back();
        }else{
            toastr()->warning('Password does not matched', 'warning');
            return redirect()->back();
        }
    }
}
