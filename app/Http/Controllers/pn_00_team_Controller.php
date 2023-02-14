<?php

namespace App\Http\Controllers;

use App\Imports\pn_00_team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class pn_00_team_Controller extends Controller
{
    public function index(){
        $list = DB::table('pn_00_team')->orderBy('Fullname','asc')->get();
        return view('Produksi.admin_00_team.index')->with(compact('list'));
    }
    public function create(){
        return view('Produksi.admin_00_team.insert');
    }
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'alias' => 'required|string',
        ]);

        DB::table('pn_00_team')->insert([
            'Fullname' => $request->fullname,
            'Nickname' => $request->nickname,
            'Alias' => $request->alias,
            'created_at' =>Carbon::now()
        ]);

        return redirect()->route('pn_00_index')->with('status', 'Form data submitted successfully.');
    }

    public function edit($id){
        $list = DB::table('pn_00_team')->where('id',$id)->first();
        return view('Produksi.admin_00_team.edit')->with(compact('list'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'fullname' => 'required|string',
            'nickname' => 'required|string',
            'alias' => 'required|string',
        ]);

        DB::table('pn_00_team')
            ->where('Id', $request->id)
            ->update([
                'Fullname' => $request->fullname,
                'Nickname' => $request->nickname,
                'Alias' => $request->alias,
                'updated_at' => Carbon::now()
            ]);

        return redirect()->route('pn_00_index')->with('status', 'Form data updated successfully.');
    }

    public function delete($id){
        DB::table('pn_00_team')->where('id', '=', $id)->delete();
        return redirect()->back()->with('status', 'Data has been deleted.');
    }
    public function import()
    {
        // dd(request()->file('file'));
        Excel::import(new pn_00_team, request()->file('file'));

        return redirect()->route('pn_00_index')->with('status', 'All good!');
    }
}
