<?php

namespace App\Http\Controllers;

use App\Models\HardFixG;
use App\Models\HardReq;
use App\Models\InkReport;
use App\Models\SoftReq;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RequestViewController extends Controller
{

    public function index()
    {
        $hardReq = HardReq::whereNotIn('hard_req_status', ['Finish'])->get();
        $hardFix = HardFixG::whereNotIn('hard_fix_status', ['Finish'])->get();
        $SoftReq = SoftReq::whereNotIn('soft_req_status', ['Finish'])->get();
        //    $ink=InkReport::whereNotIn('ink_status',['Selesai','Batal'])->get();
        return view('Form.Request.index')->with(compact('hardReq', 'hardFix', 'SoftReq'));
    }
    //======================================================================================================
    public function index_ink()
    {
        $ink = InkReport::whereNotIn('ink_status', ['Selesai', 'Batal'])->orderby('id', 'desc')->get();
        return view('Form.Request.indexTinta')->with(compact('ink'));
    }
    //======================================================================================================
    public function ink_req($id)
    {
        DB::table('inventaris_ink_report')->where('id', $id)->update([
            'ink_status' => 'Selesai'
        ]);
        return redirect()->route('request_ink')->with('status', 'Request has been approved');
    }
    //======================================================================================================
    public function ink_dec($id, $ink, $qty)
    {
        $qty_now = DB::table('inventaris_ink')->where('ink_code', $ink)->first();
        $qty = $qty_now->ink_qty + $qty;

        DB::table('inventaris_ink_report')->where('id', $id)->update([
            'ink_status' => 'Batal'
        ]);

        DB::table('inventaris_ink')->where('ink_code', $ink)->update([
            'ink_qty' => $qty
        ]);

        return redirect()->route('request_ink')->with('status', 'Request has been declined');
    }
    //======================================================================================================
    public function soft_req($id)
    {
        $now = Carbon::now();
        DB::table('soft_req')->where('id', $id)->update([
            'soft_req_status' => 'Progress',
            'soft_req_progress' => $now,
        ]);
        return redirect()->route('request')->with('status', 'Success');
    }
    //======================================================================================================
    public function soft_req_finish($id)
    {
        $now = Carbon::now();
        DB::table('soft_req')->where('id', $id)->update([
            'soft_req_status' => 'Finish',
            'soft_req_finish' => $now,
        ]);
        return redirect()->route('request')->with('status', 'Success');
    }
    //======================================================================================================
    public function hard_fix($id)
    {
        $now = Carbon::now();
        DB::table('hard_fix_general')->where('id', $id)->update([
            'hard_fix_status' => 'Progress',
            'hard_fix_progress' => $now,
        ]);
        return redirect()->route('request')->with('status', 'Success');
    }
    //======================================================================================================
    public function hard_fix_finish($id)
    {
        $now = Carbon::now();
        DB::table('hard_fix_general')->where('id', $id)->update([
            'hard_fix_status' => 'Finish',
            'hard_fix_finish' => $now,
        ]);
        return redirect()->route('request')->with('status', 'Success');
    }
    //======================================================================================================
    public function hard_req($id)
    {
        $now = Carbon::now();
        DB::table('hard_req')->where('id', $id)->update([
            'hard_req_status' => 'Progress',
            'hard_req_progress' => $now,
        ]);
        return redirect()->route('request')->with('status', 'Success');
    }
    //======================================================================================================
    public function hard_req_finish($id)
    {
        $now = Carbon::now();
        DB::table('hard_req')->where('id', $id)->update([
            'hard_req_status' => 'Finish',
            'hard_req_finish' => $now,
        ]);
        return redirect()->route('request')->with('status', 'Success');
    }
    //======================================================================================================
}
