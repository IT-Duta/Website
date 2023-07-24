<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Display Produksi</title>
    <style type="text/css">
        .none{
            display: none;
        }
        @font-face {
          font-weight: 400;
          font-style:  normal;
          font-family: 'Circular-Loom';

          src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Book.woff2') format('woff2');
        }

        @font-face {
          font-weight: 500;
          font-style:  normal;
          font-family: 'Circular-Loom';

          src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Medium.woff2') format('woff2');
        }

        @font-face {
          font-weight: 700;
          font-style:  normal;
          font-family: 'Circular-Loom';

          src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Bold.woff2') format('woff2');
        }

        @font-face {
          font-weight: 900;
          font-style:  normal;
          font-family: 'Circular-Loom';

          src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Black.woff2') format('woff2');
        }</style>
</head>
<body class="bg-primary bg-opacity-75">
<header>
    <h1 class="text-center text-white fs-1">STATUS PRODUKSI TERKINI</h1>
    <h2 class="text-center text-white fs-2">
        <span id="jam"></span> | <span id="waktu"></span>
    </h2>
</header>
<div class="mx-4">
    <table class="table table-bordered border-2">
        <thead class="bg-white bg-opacity-50 text-center align-middle">
            <tr>
                <th rowspan="2" style="width: 6ch;">NO</th>
                <th rowspan="2" style="width:12ch">NO SERI PANEL</th>
                <th rowspan="2">NAMA PANEL</th>
                <th rowspan="2" style="width:4ch">CELL</th>
                <th rowspan="2">NAMA PROYEK</th>
                <th rowspan="2" style="width: 10ch">SPV</th>
                <th rowspan="1" colspan="2">TIM PRODUKSI</th>
                <th rowspan="1" colspan="2">DEADLINE</th>
                <th rowspan="2" style="width: 10ch">KOMPONEN</th>
            </tr>
            <tr>
                <th style="width: 20ch">WIRING</th>
                <th style="width: 20ch">MEKANIK</th>
                <th style="width: 12ch">PRODUKSI</th>
                <th style="width: 12ch">QC</th>
            </tr>
        </thead>
        <tbody class="text-center align-middle border-black" id="list">
            <?php $nomor=1;
                // $freeWaspada=0; //Nilai Waspada Freestanding
                // $freeProgress=0;//Nilai Progress Freestanding
                // $freeSelesai=0;//Nilai Selesai Freestanding
                // $freeTunda=0;//Nilai Tunda Freestanding
                // $freeTotal=0;
                // $wallWaspada=0;
                // $wallProgress=0;
                // $wallSelesai=0;
                // $wallTunda=0;
                // $wallTotal=0;
                // $willNone="";
                $fCompleteCount=0;
                $fProgressCount=0;
                $fWaspadaCount=0;
                $fTundaCount=0;
                $fTotal=0;
                $wCompleteCount=0;
                $wProgressCount=0;
                $wWaspadaCount=0;
                $wTundaCount=0;
                $wTotal=0;

            ?>
            @foreach ($list as $list)
            @php
                $deleteRow = "";
                $pDoneTimestamp = $list->PDone;
                $qDoneTimestamp = $list->QDone;
                $nowTimestamp = time(); // get current Unix timestamp
                $dProduksi = new DateTime($list->deadline_produksi);
                $dQC = new DateTime($list->deadline_qc_pass);

                // Determine production status
                if ($pDoneTimestamp !== null) {
                    $pdStatsClass = "bg-success text-white"; // Production completed
                } elseif ($nowTimestamp > $dProduksi->getTimestamp()) {
                    $pdStatsClass = "bg-danger text-white 3"; // Production deadline missed
                } else {
                    $pdStatsClass = ""; // Production in progress
                }

                // Determine QC status and panel counts
                if ($qDoneTimestamp !== null) {
                    $qcStatsClass = "bg-success text-white"; // QC completed
                    $qDoneTimestampUnix = strtotime($qDoneTimestamp);
                    if ($qDoneTimestampUnix < strtotime('-7 days')) {
                        $deleteRow = "deleteRow";
                    }
                    if ($list->jenis_panel === 'W') {
                        $wCompleteCount++;
                        $wTotal++;
                    } elseif ($list->jenis_panel === 'F') {
                        $fCompleteCount++;
                        $fTotal++;
                    }
                } elseif ($list->status_pekerjaan === "Tunda") {
                    $qcStatsClass = "bg-warning text-dark"; //QC Tunda
                    if ($list->jenis_panel === 'W') {
                        $wTundaCount++;
                        $wTotal++;
                    } elseif ($list->jenis_panel === 'F') {
                        $fTundaCount++;
                        $fTotal++;
                    }
                } elseif ($nowTimestamp > $dQC->getTimestamp()) {
                    $qcStatsClass = "bg-danger text-white"; // QC deadline missed
                    if ($list->jenis_panel === 'W') {
                        $wWaspadaCount++;
                        $wTotal++;
                    } elseif ($list->jenis_panel === 'F') {
                        $fWaspadaCount++;
                        $fTotal++;
                    }
                } else {
                    $qcStatsClass = ""; // QC in progress
                    if ($list->jenis_panel === 'W') {
                        $wProgressCount++;
                        $wTotal++;
                    } elseif ($list->jenis_panel === 'F') {
                        $fProgressCount++;
                        $fTotal++;
                    }
                }


            @endphp
            <tr class="bg-light {{$deleteRow}}">
                <td>{{$nomor++}}</td>
                <td class="fw-bold">{{$list->nomor_seri_panel}}</td>
                <td> {{$list->nama_panel}}</td>
                <td>{{$list->cell}}</td>
                <td>{{$list->nama_proyek}}</td>
                <td>{{$list->spv}}</td>
                <td>{{implode(", ",explode(",",$list->wiring))}}</td>
                <td>{{implode(", ",explode(",",$list->mekanik))}}</td>
                <td class="{{$pdStatsClass}}">{{date("d/m/Y",strtotime(substr($list->deadline_produksi,0,10)))}}</td>
                <td class="{{$qcStatsClass}}">{{date("d/m/Y",strtotime(substr($list->deadline_qc_pass,0,10)))}}</td>
                <td>{{$list->status_komponen}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<footer>
    <div class="mx-4">
    <table class="table table-bordered bg-light text-center table-sm">
        <thead>
            <tr>
                <th>TIPE PANEL</th>
                <th>PROGRESS</th>
                <th class="bg-success text-white">SELESAI</th>
                <th class="bg-danger text-white">WASPADA</th>
                <th class="bg-warning text-dark">TUNDA</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Free Standing</td>
                <td>{{$fProgressCount}}</td>
                <td>{{$fCompleteCount}}</td>
                <td>{{$fWaspadaCount}}</td>
                <td>{{$fTundaCount}}</td>
                <td>{{$fTotal}}</td>
            </tr>
            <tr>
                <td>Wall Mounting</td>
                <td>{{$wProgressCount}}</td>
                <td>{{$wCompleteCount}}</td>
                <td>{{$wWaspadaCount}}</td>
                <td>{{$wTundaCount}}</td>
                <td>{{$wTotal}}</td>
                </tr>
        </tbody>
    </table>
</div>
</footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/3.29.3/moment.min.js"  referrerpolicy="no-referrer"></script>
    <script src="{{asset('plugins/moment/moment.js')}}"></script>
    <script>
        let tanggal =moment().format("DD MMM YYYY");
        let upp = tanggal.toString("dd MMM yyyy").toUpperCase();
        document.getElementById("waktu").innerHTML=upp;
        setInterval(jam,1000);
        function jam(){
            let jam =moment().format("HH:mm:ss");
            document.getElementById("jam").innerHTML=jam;
        }
    </script>

    <script>
        $(document).ready(function(){
            // Delete Row
            $('tr.deleteRow').remove();

            var table = $("#list");
            var tableRows = $("#list tr");
            var numRows = tableRows.length;

            // Reset or refresh page
            var time=numRows*7000;
            setTimeout("location.reload(true);",time);


            var rowsToAdd = 5 - (numRows % 5);
            var rowIndex = 0;

            // Add blank rows if needed
            for(var i = 0; i < rowsToAdd; i++) {
                table.append("<tr><td>&nbsp;</td></tr>");
            }

            tableRows = $("#list tr");
            numRows = tableRows.length;
            // Hide all rows except the first 10
            tableRows.hide();
            tableRows.slice(0, 5).show();

            setInterval(function(){
                // Hide the previous 10 rows
                tableRows.slice(rowIndex, rowIndex + 5).hide();

                // Increment the row index
                rowIndex += 5;

                // If we've reached the end of the table, reset the row index
                if(rowIndex >= numRows){
                    rowIndex = 0;
                }

                // Show the next 10 rows
                tableRows.slice(rowIndex, rowIndex + 5).show();
                // $('marquee[behavior=""][direction=""]').marquee('destroy').marquee();

            }, 12000); // 5 seconds

        });
    </script>

</body>
</html>
