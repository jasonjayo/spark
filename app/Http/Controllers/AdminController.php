<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\User;
use Termwind\Components\Raw;

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

    public function ban(Request $request)
    {
        $ban = Ban::create([
            "user_id" => $request->user_id,
            "admin_id" => Auth::user()->id,
            "reason" => $request->reason,
            "report_id" => $request->report_id,
            "active_from" => date_create("now"),
            "active_to" => $request->expiry
        ]);

        if (isset($request->report_id)) {
            $this->closeReportById($request->report_id);
        }

        return back()->with(["ban_id" => $ban->id]);
    }

    public function revokeBan(Request $request)
    {
        Ban::destroy($request->id);
        return back()->with(["ban_revoked" => true]);
    }

    public function closeReport(Request $request)
    {
        $this->closeReportById($request->id);
        return back()->with(["report_closed" => true]);
    }

    private function closeReportById($id)
    {
        $report = Report::find($id);
        $report->status = "CLOSED";
        $report->save();
    }

    public function dashboard()
    {
        return view("admin-dashboard");
    }

    // method for admin to delete a user account
    public function deleteUserAccount(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return redirect()->route("admin")->with(["account_deleted" => true]);
    }

    public function updateUserAccount(Request $req)
    {
        return view('profile.edit', [
            'user' => User::findOrFail($req->id),
        ]);
    }

    public function bansIndex()
    {
        return view("admin-bans");
    }


    public function reportsIndex()
    {
        return view("admin-reports");
    }
}
