<?php

namespace App\Http\Controllers;

use App\Exports\ticketExport;
use App\Mail\newTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
// use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ticketingController extends Controller
{
    public function index()
    {
        $list = DB::table('ticketing')->orderByDesc('id')->get();

        // Menambahkan kolom baru untuk menyimpan selisih waktu
        foreach ($list as $item) {
            $case_start = strtotime($item->case_start);
            $case_finish = strtotime($item->case_finish);

            $difference = abs($case_finish - $case_start);

            $days = floor($difference / (60 * 60 * 24));
            $hours = floor(($difference - $days * 60 * 60 * 24) / (60 * 60));
            $minutes = floor(($difference - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
            $seconds = $difference % 60;

            $item->time_difference = "$days hari, $hours jam, $minutes menit";
        }

        return view('ticketing.index', compact('list'));
    }
    public function create()
    {
        $karyawan = DB::table('duta_karyawan')->orderBy('k_nama', 'asc')->get();
        return view('ticketing.create')->with(compact('karyawan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ticket_user' => 'required',
            'ticket_referrer' => 'required',
            'ticket_type' => 'required',
            'ticket_judul' => 'required',
            'ticket_detail' => 'required',
        ]);
        $fileName = "";
        $filePath = "";
        $imageName = "";
        $sequence = 1;
        $check = DB::table('ticketing')->orderBy('id', 'desc')->first();
        if (empty($check)) {
            $sequence = 1;
        } else {
            $sequence = $check->urut + 1;
        }
        // Ubah ketika ganti tahun, jika tahun sekarang tidak sama dengan tahun terakhir input maka ubah nilai ke 1
        $currentYear = date("Y");
        $createdAtYear = date("Y", strtotime($check->created_at));
        if ($currentYear != $createdAtYear) {
            $sequence = 1;
        }
        $tahun = date('Y');
        $bulan = date('m');
        $number = substr(str_repeat(0, 3) . $sequence, -3);
        $numberTicket = '' . $number . '/E-TICKET/' . $bulan . '/' . $tahun . '';
        if (!empty($request->file('file'))) {
            $fileName = $request->file('file')->getClientOriginalName();
            // dd($request->file('file')->getClientOriginalName());
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $imageName = $number . '_eticket_' . $bulan . '_' . $tahun . '.' . $fileExt . '';
            // $filePath = $request->file('file')->storeAs('public/images', $imageName);
            $filePath = $request->file('file')->move(public_path('storage\images'), $imageName);
            // dd($name);
        }
        DB::table('ticketing')->insert([
            'ticket_number' => $numberTicket,
            'urut' => $sequence,
            'ticket_user' => $request->ticket_user,
            'ticket_referrer' => $request->ticket_referrer,
            'ticket_type' => $request->ticket_type,
            'ticket_judul' => $request->ticket_judul,
            'ticket_detail' => $request->ticket_detail,
            'ticket_filename' => $imageName,
            'ticket_filepath' => $filePath,
            'ticket_status' => 'Waiting',
            'case_start' => now()
        ]);
        // Send Email

        // Mail::mailer('IT')->to('edp@ptduta.com', 'IT Staff')->send(new newTicket);

        return redirect()->route('ticket')->with('status', 'Data has been submitted');
    }
    public function update(Request $request)
    {
        $fileName = "";
        $request->validate([
            'id' => 'required',
            'ticket_referrer' => 'required',
            'ticket_type' => 'required',
            'ticket_judul' => 'required',
            'ticket_detail' => 'required',
            'ticket_solver' => 'required',
            'ticket_solve' => 'required',
            'ticket_status' => 'required',
        ]);
        if (!empty($request->file('ticket_file_solve'))) {
            $fileName = $request->file('ticket_file_solve')->getClientOriginalName();
            // dd($request->file('file')->getClientOriginalName());
            // $fileName = pathinfo($fileName, PATHINFO_EXTENSION);
            $request->file('ticket_file_solve')->storeAs('public/images', $fileName);
        }

        $caseFinish = $request->case_finish ? $request->case_finish : Carbon::now();

        DB::table('ticketing')->where('id', $request->id)->update([
            'ticket_judul' => $request->ticket_judul,
            'ticket_type' => $request->ticket_type,
            'ticket_referrer' => $request->ticket_referrer,
            'ticket_detail' => $request->ticket_detail,
            'ticket_solver' => $request->ticket_solver,
            'ticket_solve' => $request->ticket_solve,
            'ticket_file_solve' => $fileName,
            'ticket_status' => $request->ticket_status,
            'case_start' => $request->case_start,
            'case_finish' => $caseFinish,
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('ticket')->with('status', 'Data has been updated');
    }
    public function delete($id)
    {
        DB::table('ticketing')->where('id', $id)->delete();
        return redirect()->back()->with('status', 'Data has been deleted');
    }
    public function view($id)
    {
        $list = DB::table('ticketing')->where('id', $id)->first();
        // $url = Storage::url($list->ticket_filepath);
        // dd($url);
        // return view('ticketing.view',compact('list','url'));
        return view('ticketing.view', compact('list'));
    }
    // public function download($id){
    //     $file=DB::table('ticketing')->where('id',$id)->first();
    //     $file=$file->ticket_file_solve;
    //     return Storage::download($file);
    // }
    // function download($id){
    //     $file=DB::table('ticketing')->where('id',$id)->first();
    //     $file=$file->ticket_file_solve;
    //     $file = Storage::disk('public')->get($file);

    //     return (new Response($file));
    // }
    public function download($id)
    {
        $file = DB::table('ticketing')->where('id', $id)->first();
        $file = $file->ticket_file_solve;
        $filepath = public_path('storage/images/' . $file . '');
        return Response::download($filepath);
    }
    // public function export()
    // {
    //     $time = Carbon::now();
    //     $time = date_format($time, 'd-m-y, H.i.s');
    //     $filename = 'Laporan Tiket ' . $time . '.xlsx';
    //     return Excel::download(new ticketExport, $filename);
    // }

    public function export(Request $request)
    {
        // Ambil nilai bulan dan tahun dari permintaan
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Membuat nama file dengan format yang sesuai
        $time = Carbon::now()->format('d-m-y_H.i.s');
        $filename = 'Laporan Tiket ' . $time . '.xlsx';

        // Mendownload file Excel menggunakan ticketExport dengan bulan dan tahun yang dipilih
        return Excel::download(new ticketExport($bulan, $tahun), $filename);
    }

    public function getTitle(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('searchTerm');

        // Query the database for search suggestions
        $suggestions = DB::table('ticketing')
            ->select('ticket_judul')
            ->where('ticket_judul', 'like', "%$searchTerm%")
            ->limit(5)
            ->get();

        // Return the search suggestions as a JSON response
        return response()->json($suggestions);
    }
}
