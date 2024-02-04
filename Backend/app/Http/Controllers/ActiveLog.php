<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActiveLog extends Controller
{
    public function showActive(){
        $activity = Activity::all();
        return view('pages.active_log.active_log',compact('activity'));
    }
}
