<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangPinjamController extends Controller
{
    public function index(){
        $list = DB::table('data_barang_pinjam')->get();
        return view('PinjamBarang.Barang.index',compact('list'));
    }
}
