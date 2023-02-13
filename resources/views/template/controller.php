<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class nama_controller extends Controller
{
    public function index()
    {
        $list=DB::table('nama_table')->orderBy('id','asc')->get();
        return view('template\list')->with(compact('list'));
    }
    public function create()
    {
        return view('template\create');
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'tgl_pengaju' => 'required|date',
            'nama_pengaju' => 'required|string',
        ]);

        DB::table('nama_table')->insert([
            'tgl_pengaju'=>$data['tgl_pengaju'],
            'nama_pengaju'=>$data['nama_pengaju']
        ]);
        return redirect()->route('list_index')->with('status','Data telah ditambahkan');
    }

    public function edit($id)
    {
    }
    public function update(Request $request)
    {

    }

    public function delete($id)
    {

    }

}
