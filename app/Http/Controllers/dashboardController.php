<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class dashboardController extends Controller
{
    private function calculateWorkingDays($month, $year, $publicHolidays)
    {
        // Mendapatkan jumlah total hari dalam bulan ini
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Menghitung jumlah hari Sabtu dan Minggu dalam bulan ini
        $weekendDays = 0;
        for ($day = 1; $day <= $totalDays; $day++) {
            $dayOfWeek = date('N', strtotime("$year-$month-$day"));
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                $weekendDays++;
            }
        }

        // Menghitung jumlah hari libur nasional dalam bulan ini
        $publicHolidayDays = 0;
        foreach ($publicHolidays as $publicHoliday) {
            list($holidayMonth, $holidayDay) = explode('-', $publicHoliday);
            if ($holidayMonth == $month && $holidayDay <= $totalDays) {
                $publicHolidayDays++;
            }
        }

        // Menghitung jumlah hari kerja
        $workingDays = $totalDays - $weekendDays - $publicHolidayDays;

        return $workingDays;
    }

    public function index()
    {
        $hard_req_done = DB::table('hard_req')->where('hard_req_status', 'Selesai')->count();
        $hard_req_total = DB::table('hard_req')->count();

        $hard_fix_done = DB::table('hard_fix_general')->where('hard_fix_status', 'Selesai')->count();
        $hard_fix_total = DB::table('hard_fix_general')->count();

        $soft_req_done = DB::table('soft_req')->where('soft_req_status', 'Selesai')->count();
        $soft_req_total = DB::table('soft_req')->count();
        // Status
        $arra = DB::table('ticketing')->select(DB::raw('ticket_status'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('ticket_status')
            ->pluck('jumlah', 'ticket_status');
        // ->get();
        $label = $arra->keys();
        $val = $arra->values();

        $daily = DB::table('ticketing')->select(DB::raw('count(*) as jumlah'), DB::raw('date(created_at) as tanggal'))
            ->orderBy('id', 'desc')
            ->latest()
            ->take(7)
            ->groupBy('tanggal')
            ->pluck('jumlah', 'tanggal');
        $dailylabel = $daily->keys();
        $dailyval = $daily->values();

        // Top Solver
        $solver = DB::table('ticketing')->select(DB::raw('ticket_solver'), DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('ticket_solver')
            ->groupBy('ticket_solver')
            ->pluck('jumlah', 'ticket_solver');
        $solverlabel = $solver->keys();
        $solverval = $solver->values();

        // Jumlah Kategori
        $solver = DB::table('ticketing')->select(DB::raw('ticket_type'), DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('ticket_type')
            ->orderBy('ticket_type', 'asc')
            ->groupBy('ticket_type')
            ->pluck('jumlah', 'ticket_type');
        // ->get();
        $typelabel = $solver->keys();
        $typeval = $solver->values();
        $query = "WITH get_min AS (
            SELECT
              id,
              TIMESTAMPDIFF(MINUTE, created_at, updated_at) AS menit
            FROM ticketing
            WHERE ticket_status = 'Done'
          ),
          get_hour AS (
              SELECT
                  id,
                  menit,
                 floor(menit/ 60) as jam
              from get_min
          )
          SELECT count(*) as Jumlah,
              CASE WHEN jam < 1 THEN 'Less than an hour'
              WHEN jam >1 and jam < 4 THEN '1 - 4 hours'
              WHEN jam >4 and jam < 8 THEN '4 - 8 hours'
              ELSE 'More than a day'
              END AS Kondisi
          from get_hour
          WHERE menit IS NOT NULL
          GROUP BY Kondisi
        ";
        $durasi = DB::connection()->select($query);
        //Ubah hasil ke array
        $collect = collect($durasi);
        // Ubah hasil ke object
        $durasi = $collect->pluck("Jumlah", "Kondisi");
        $durasilabel = $durasi->keys();
        $durasival = $durasi->values();

        $petugas = DB::table('ticketing')
            ->select('ticket_solver')
            ->distinct()
            ->where('ticket_status', 'Done')
            ->get();


        //================================================================================================

        $year = date('Y'); // Tahun saat ini
        $month = date('m'); // Bulan saat ini

        // Daftar hari libur nasional
        $publicHolidays = [
            // Format: 'bulan-hari'
            '1-1', // Tahun Baru 2024 Masehi
            '2-8', //Isra' Mi'raj Nabi Muhammad SAW
            '2-9', //Cuti Bersama Imlek 2575 Kongzili
            '2-10', //Tahun Baru Imlek 2575 Kongzili
            '3-11', //Hari Raya Nyepi Tahun Baru Saka 1946
            '3-12', //Cuti Bersama Hari Raya Nyepi
            '3-29', //Wafat Isa Al Masih
            '3-31', //Hari Paskah
            '4-8', //Cuti Bersama Hari Raya Idul Fitri
            '4-9', //Cuti Bersama Hari Raya Idul Fitri
            '4-10', //Hari Raya Idul Fitri 1445 H
            '4-11', //Hari Raya Idul Fitri 1445 H
            '4-12', //Cuti Bersama Hari Raya Idul Fitri
            '4-15', //Cuti Bersama Hari Raya Idul Fitri
            '5-1', //Hari Buruh Internasional
            '5-9', //Kenaikan Isa Al Masih
            '5-10', //Cuti Bersama Kenaikan Isa Al Masih
            '5-23', //Hari Raya Waisak 2568 BE
            '5-24', //Cuti Bersama Hari Raya Waisak
            '6-1', //Hari Lahir Pancasila
            '6-17', //Hari Raya Idul Adha 1445 H
            '6-18', //Cuti Bersama Hari Raya Idul Adha
            '7-7', //Tahun Baru Islam 1446 H
            '8-17', //Hari Kemerdekaan Republik Indonesia ke 79
            '9-16', //Maulid Nabi Muhammad SAW
            '12-25', //Hari Raya Natal
            '12-26', //Cuti Bersama Hari Raya Natal
        ];

        $workingDays = $this->calculateWorkingDays($month, $year, $publicHolidays);
        $workingDaysInSeconds = $workingDays * 8 * 60 * 60;

        // Downtime ( Waktu internet mati bulan ini )
        $query = "WITH DIFF_SECS AS(
                    SELECT
                        sum(TIMESTAMPDIFF(SECOND, case_start, case_finish)) AS totals,
                        DATE_FORMAT(created_at, '%Y %m') as monthYear
                    FROM ticketing WHERE ticket_type = 'Down'
                    GROUP BY monthYear),
                SHOW_PERCENT AS(
                    SELECT
                    monthYear,
                    (($workingDaysInSeconds-totals)/$workingDaysInSeconds * 100) as percen,
                    SEC_TO_TIME(totals) AS TO_SHOW
                    FROM DIFF_SECS
                    ORDER BY monthYear DESC)
                    SELECT * FROM SHOW_PERCENT ORDER BY monthYear DESC LIMIT 1 ";
        $downtime = DB::connection()->select($query);

        //================================================================================================

        $workingDaysLastMonth = $this->calculateWorkingDays($month - 1, $year, $publicHolidays);
        $workingDaysInSecondsLastMonth = $workingDaysLastMonth * 8 * 60 * 60;

        // Downtime ( Waktu internet mati bulan kemarin )
        $queryLastMonth = "WITH DIFF_SECS AS(
                    SELECT
                        sum(TIMESTAMPDIFF(SECOND, created_at, updated_at)) AS totals,
                        DATE_FORMAT(created_at, '%Y %m') as monthYear
                    FROM ticketing WHERE ticket_type = 'Down'
                    GROUP BY monthYear),
                SHOW_PERCENT AS(
                    SELECT
                    monthYear,
                    (($workingDaysInSecondsLastMonth-totals)/$workingDaysInSecondsLastMonth * 100) as percen,
                    SEC_TO_TIME(totals) AS TO_SHOW
                    FROM DIFF_SECS
                    ORDER BY monthYear DESC)
                    SELECT * FROM SHOW_PERCENT ORDER BY monthYear DESC LIMIT 1 OFFSET 1";
        $downtimeLastMonth = DB::connection()->select($queryLastMonth);


        //================================================================================================

        $jar_query = "
            SELECT
                sum(TIMESTAMPDIFF(SECOND, case_start, case_finish)) AS totals,
                DATE_FORMAT(case_start, '%Y %m') as monthYear,
                DATE_FORMAT(case_start, '%m') as say_bulan
            FROM ticketing WHERE ticket_type = 'Down' and DATE_FORMAT(case_start, '%Y')=" . $year . "
            GROUP BY monthYear, say_bulan
            ORDER BY monthYear DESC
        ";
        $jar_results = DB::connection()->select($jar_query);

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Membuat array untuk semua bulan dalam tahun
        $jar_downtime = [];
        for ($jar_month = 1; $jar_month <= 12; $jar_month++) {
            $jar_monthYear = "2024 " . str_pad($jar_month, 2, "0", STR_PAD_LEFT);
            $jar_downtime[$jar_monthYear] = [
                'monthYear' => $jar_monthYear,
                'say_bulan' => $months[$jar_month - 1],
                'percen' => 100,
                'TO_SHOW' => '00:00:00',
            ];
        }

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Mengisi data untuk bulan yang ada dalam hasil query
        foreach ($jar_results as $jar_result) {
            $jar_year = substr($jar_result->monthYear, 0, 4);
            $jar_month = substr($jar_result->monthYear, 5, 2);
            $jar_workingDays = $this->calculateWorkingDays($jar_month, $jar_year, $publicHolidays);
            $jar_workingDaysInSeconds = $jar_workingDays * 8 * 60 * 60;
            $jar_percentage = (($jar_workingDaysInSeconds - $jar_result->totals) / $jar_workingDaysInSeconds) * 100;
            $jar_downtime[$jar_result->monthYear] = [
                'monthYear' => $jar_result->monthYear,


                'say_bulan' => $months[$jar_result->say_bulan - 1],

                'percen' => $jar_percentage,
                'TO_SHOW' => gmdate("H:i:s", $jar_result->totals),
            ];
        }

        // Mengubah array asosiatif kembali menjadi array numerik
        $jar_data = array_values($jar_downtime);

        // Mengubah setiap array dalam $jar_data menjadi objek
        foreach ($jar_data as $key => $value) {
            $jar_data[$key] = json_decode(json_encode($value));
        }

        // dd($jar_data);

        //================================================================================================

        return view('dashboard')
            ->with(compact('hard_req_done', 'hard_req_total', 'hard_fix_done', 'hard_fix_total', 'soft_req_done', 'soft_req_total'))
            ->with(compact('downtime', 'workingDays', 'downtimeLastMonth', 'workingDaysLastMonth'))
            ->with(compact('label', 'val'))
            ->with(compact('dailylabel', 'dailyval'))
            ->with(compact('solverlabel', 'solverval'))
            ->with(compact('typelabel', 'typeval'))
            ->with(compact('durasilabel', 'durasival'))
            ->with(compact('jar_data'))
            ->with(compact('petugas'));
    }

    //======================================================

    public function getDatadaily(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $data = $request->data;
            if ($data == "All") {

                $daily = DB::table('ticketing')->select(DB::raw('count(*) as jumlah'), DB::raw('date(created_at) as tanggal'))
                    ->orderBy('id', 'desc')
                    ->latest()
                    ->take(7)
                    ->groupBy('tanggal')
                    ->pluck('jumlah', 'tanggal');
            } else {

                $daily = DB::table('ticketing')->select(DB::raw('count(*) as jumlah'), DB::raw('date(created_at) as tanggal'))
                    ->orderBy('id', 'desc')
                    ->latest()
                    ->take(7)
                    ->where('ticket_solver', $data)
                    ->groupBy('tanggal')
                    ->pluck('jumlah', 'tanggal');
            }

            return response($daily);
        }
    }

    //======================================================

    public function getDatakategori(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $data = $request->data;
            if ($data == "All") {
                $typecat = DB::table('ticketing')
                    ->select(DB::raw('count(*) as jumlah, ticket_type'))
                    ->groupBy('ticket_type')
                    // ->get();
                    ->pluck('jumlah', 'ticket_type');
            } else {
                $typecat = DB::table('ticketing')
                    ->select(DB::raw('count(*) as jumlah, ticket_type'))
                    ->where('ticket_solver', $data)
                    ->groupBy('ticket_type')
                    // ->get();
                    ->pluck('jumlah', 'ticket_type');
            }

            return response($typecat);
        }
    }

    //======================================================

    public function getDatastatus(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $data = $request->data;
            if ($data == "All") {
                $status = DB::table('ticketing')->select(DB::raw('ticket_status'), DB::raw('COUNT(*) as jumlah'))
                    ->groupBy('ticket_status')
                    ->pluck('jumlah', 'ticket_status');
            } else {

                $status = DB::table('ticketing')->select(DB::raw('ticket_status'), DB::raw('COUNT(*) as jumlah'))
                    ->where('ticket_solver', $data)
                    ->orWhere('ticket_user', $data)
                    ->groupBy('ticket_status')
                    ->pluck('jumlah', 'ticket_status');
            }

            return response($status);
        }
    }

    //======================================================

    public function getDataduration(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $data = $request->data;
            if ($data == "All") {
                $query = "WITH get_min AS (
                    SELECT
                      id,
                      TIMESTAMPDIFF(MINUTE, created_at, updated_at) AS menit
                    FROM ticketing
                    WHERE ticket_status = 'Done'
                  ),
                  get_hour AS (
                      SELECT
                          id,
                          menit,
                         floor(menit/ 60) as jam
                      from get_min
                  )
                  SELECT count(*) as Jumlah,
                      CASE WHEN jam < 1 THEN 'Less than an hour'
                      WHEN jam >1 and jam < 4 THEN '1 - 4 hours'
                      WHEN jam >4 and jam < 8 THEN '4 - 8 hours'
                      ELSE 'More than a day'
                      END AS Kondisi
                  from get_hour
                  WHERE menit IS NOT NULL
                  GROUP BY Kondisi
                ";
            } else {

                $query = "WITH get_min AS (
                    SELECT
                      id,
                      TIMESTAMPDIFF(MINUTE, created_at, updated_at) AS menit
                    FROM ticketing
                    WHERE ticket_status = 'Done' and ticket_solver ='" . $data . "'
                  ),
                  get_hour AS (
                      SELECT
                          id,
                          menit,
                         floor(menit/ 60) as jam
                      from get_min
                  )
                  SELECT count(*) as Jumlah,
                      CASE WHEN jam < 1 THEN 'Less than an hour'
                      WHEN jam >1 and jam < 4 THEN '1 - 4 hours'
                      WHEN jam >4 and jam < 8 THEN '4 - 8 hours'
                      ELSE 'More than a day'
                      END AS Kondisi
                  from get_hour
                  WHERE menit IS NOT NULL
                  GROUP BY Kondisi
                ";
            }
            $durasi = DB::connection()->select($query);
            //Ubah hasil ke array
            $collect = collect($durasi);
            // Ubah hasil ke object
            $durasi = $collect->pluck("Jumlah", "Kondisi");

            return response($durasi);
        }
    }
}
