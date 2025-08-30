<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use Illuminate\Http\Request;

class ProgressLogController extends Controller
{
    public function index()
    {
        $logs = ProgressLog::where('user_id', auth()->user()->id)->get();
        return view('progress-log.index', [
            'logs' => $logs
        ]);
    }
}
