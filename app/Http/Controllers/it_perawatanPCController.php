<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class it_perawatanPCController extends Controller
{
    public function index(){
        $list=DB::table('it_perawatanPC')->orderBy('id','asc')->get();
        return view('Perawatan.PC.index')->with(compact('list'));
    }
    public function create(){
        $user=DB::table('duta_karyawan')->select('k_nama')->orderBy('k_nama','asc')->get();
        $lokasi=DB::table('duta_lokasi')->select('loc_name')->orderBy('loc_name','asc')->get();
        $nomor_cpu=DB::table('inventaris_pc')->select('pc_user','pc_number','pc_location')->orderBy('pc_number','asc')->get();
        $nomor_monitor=DB::table('inventaris_monitor')->select('monitor_user','monitor_number','monitor_location','monitor_name')->orderBy('monitor_number','asc')->get();
        return view('Perawatan.PC.insert')->with(compact('user','lokasi','nomor_cpu','nomor_monitor'));
    }
    public function store(Request $request){
        // Get the last record's running number
        $check=DB::table('it_perawatanPC')->select('nomor','created_at')->orderBy('id', 'desc')->first();
        if (empty($check->nomor)) {
            $runningNumber = 1;
        } else {
            $runningNumber = $check->nomor + 1;
        }

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');
        // dd($check);
        $createdAtYear =  (!empty($check->created_at)) ? date('Y', strtotime($check->created_at)) : null ;
        // $createdAtYear = date('Y', strtotime($check->created_at));
        if ($currentYear != $createdAtYear) {
            $runningNumber=1;
        }

        $nomorPerawatan = sprintf('%04d/PC-MAIN/%s/%s', $runningNumber, $currentMonth, $currentYear);
        $data = $request->validate([
            'pic' => 'required|string',
            'user' => 'required|string',
            'lokasi' => 'required|string',
            'nomor_cpu' => 'required|string',
            'nomor_monitor' => 'required|string',
            'kebersihan_monitor' => 'required|string',
            'kebersihan_pc' => 'required|string',
            'kondisi_monitor' => 'required|string',
            'kondisi_keyboardmouse' => 'required|string',
            'kondisi_mainboard' => 'required|string',
            'kondisi_penyimpanan' => 'required|string',
            'kondisi_processor' => 'required|string',
            'kondisi_ram' => 'required|string',
            'kondisi_jaringan' => 'required|string',
            'optimasi_os' => 'required|string',
            'optimasi_antivirus' => 'required|string',
            'optimasi_software' => 'required|string',
            'backup_email' => 'required|string',
            'keterangan' => 'required|string'
        ]);

        // Insert the data into the database
       DB::table('it_perawatanPC')->insert([
            'uuid_perawatan' => Str::uuid(),
            'nomor' => $runningNumber,
            'nomor_perawatan' => $nomorPerawatan,
            'pic' => $data['pic'],
            'user' => $data['user'],
            'lokasi' => $data['lokasi'],
            'nomor_cpu' => $data['nomor_cpu'],
            'nomor_monitor' => $data['nomor_monitor'],
            'kebersihan_monitor' => $data['kebersihan_monitor'],
            'kebersihan_pc' => $data['kebersihan_pc'],
            'kondisi_monitor' => $data['kondisi_monitor'],
            'kondisi_keyboardmouse' => $data['kondisi_keyboardmouse'],
            'kondisi_mainboard' => $data['kondisi_mainboard'],
            'kondisi_penyimpanan' => $data['kondisi_penyimpanan'],
            'kondisi_processor' => $data['kondisi_processor'],
            'kondisi_ram' => $data['kondisi_ram'],
            'kondisi_jaringan' => $data['kondisi_jaringan'],
            'optimasi_os' => $data['optimasi_os'],
            'optimasi_antivirus' => $data['optimasi_antivirus'],
            'optimasi_software' => $data['optimasi_software'],
            'backup_email' => $data['backup_email'],
            'keterangan' => $data['keterangan'],
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('perawatan.pc.index')->with('status','Data telah di tambahkan');
    }
    public function destroy($id){
        DB::table('it_perawatanPC')->where('uuid_perawatan',$id)->delete();
        return redirect()->back()->with('status','Data Telah Dihapus');
    }
    public function getData($id){
        $item = DB::table('it_perawatanPC')
        ->where('uuid_perawatan',$id)
        ->first();
        return response()->json($item);
    }
}
