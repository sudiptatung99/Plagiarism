<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function mail_send(Request $request){
       
        toastr()->success('Thank You For Contact Us', 'success');
        return back();
    }
}
