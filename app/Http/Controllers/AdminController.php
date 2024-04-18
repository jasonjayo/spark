<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class AdminController extends Controller
{
    public function report(Request $request)
    {
        $report = Report::create([
            "reporter_id" => Auth::user()->id,
            "reported_id" => $request->reported_id,
            "reason" => $request->reason,
        ]);
        return back()->with(["report_id" => $report->id]);
    }
}
