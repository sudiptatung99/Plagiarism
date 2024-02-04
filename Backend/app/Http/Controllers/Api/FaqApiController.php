<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqApiController extends Controller
{
    public function index(){
        $faq = Faq::latest()->get();
        return response()->json(['success' => true, 'data'=>$faq], 200);
    }
}
