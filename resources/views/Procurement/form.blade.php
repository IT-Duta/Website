<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
        body {
            font-family: 'DM Sans', sans-serif;
            padding: 0 10px;
            -webkit-print-color-adjust:exact !important;
            print-color-adjust:exact !important;
            margin-top: 50px;
            font-size: 12px;
        }
        .t-center{
            text-align: center;
        }
        .m-0{
            margin: 0;
        }
        .t-20{
            font-size: 20px;
        }
        .t-8{
            font-size: 8px;
        }
        .bg-lgray{
            background: lightgray;
        }
        /* Header */
        div.col {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
        }
        .col label {
            width: 200px;
            display: inline-block;
        }
        .col span {
            display: inline-block;
            min-width: 10ch;
            overflow: visible;
            text-decoration: underline;

        }

        #kiri {
            margin-left: 10px;
        }
        
        /* Table Barang */
        table#barang,#barang tr,#barang th,#barang td{
            border: 1px solid black;
            border-collapse: collapse;
            max-width: 100%;
            word-wrap: break-word;
            padding: 5px;
        }

        .desc{
            min-width: 400px;
            max-width: 500px;

        }
        .tipe,.merek{
            min-width: 100px;

        }

        #barang tbody td{
            height: 20px;
        }
        /* Footer */
        #info-footer{
            /* page-break-inside: avoid; */
        }
        #catatan{
            padding: 10px 0;
            /* height: 10px; */
        }
        table#forttd,#forttd tr,#forttd th,#forttd td{
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        #forttd{

            width: 100%;
        }
        #ttd{
            height: 50px;
        }
        #ttdnama{
            height: 15px;
            text-align: left;
        }
        .tgldate{
            text-align: left;
        }
        #info-table{
            margin: 0 px 10px;
            padding: 0 px 10px;
        }

        /* Print */
        @page {
            size: landscape;
            margin:25px 0px;
            margin: 25% auto;
            color: dimgray;
            font-size: 20px;
            letter-spacing: 5px;
            font-weight: bold;
            padding: 5px 8px;
            border: 5px solid dimgray;
            border-radius: 10px;
        }

        #asset {
            border: 4px solid dimgray;
            border-radius: 10px;
            margin: 5px 8px 0 0;
        }

        .text-asset {
            font-family: 'Poppins', sans-serif;
            margin: 0 auto;
            text-align: center;
            color: dimgray;
            font-size: 20px;
            letter-spacing: 5px;
            font-weight:bold;
        }

        /* Add */

    </style>
</head>
<body>
<table>
    <thead>
        <div id="info-header">
            <div class="t-center">
                <h3 class="t-20 m-0">PERMOHONAN PEMBELIAN BARANG</h3>
                <h5 class="bg-lgray" style="margin: 2px 0;padding:10px 0;">{{$pph->ppb_no}}</h5>
            </div>
            <div class="col">
                <div id="kiri">
                    <div>
                        <label for="">NAMA PELANGGAN</label>
                        <span >{{$pph->ppb_pelanggan}}</span>
                    </div>
                    <div>
                        <label for="">NO REFERENSI/PO</label>
                        <span>{{$pph->ppb_referensi}}</span>
                    </div>
                    <div>
                        <label for="">NRP</label>
                        <span>{{$pph->ppb_nrp}}</span>
                    </div>
                    <div>
                        <label for="">NPP</label>
                        <span>{{$pph->ppb_npp}}</span>
                    </div>
                    <div>
                        <label for="">NAMA PROYEK</label>
                        <span>{{$pph->ppb_proyek}}</span>
                    </div>
                    <div>
                        <label for="">ALASAN PEMBELIAN</label>
                        <span>{{$pph->ppb_alasan}}</span>
                    </div>
                </div>
                <div id="kanan">
                    <div>
                        <label for="">TGL PO/OC</label>
                        <?php
                        if ($pph->ppb_tgl_po==""){
                           $ppb_tgl_po="";}
                           else {
                            $ppb_tgl_po = $pph->ppb_tgl_po;
                        $ppb_tgl_po = date("d-m-Y", strtotime($ppb_tgl_po));
                           }
                           ?>
                        <span>{{$ppb_tgl_po}}</span>
                    </div>
                    <div>
                        <label for="">TGL PPB</label>
                        <?php
                        $datepengajuan = $pph->ppb_tgl_pengajuan;
                        $datepengajuan = date("d-m-Y", strtotime($datepengajuan));?>
                        <span>{{$datepengajuan}}</span>
                    </div>
                    <div>
                        <label for="">TGL DEADLINE KIRIM</label>
                        <?php
                        $ppb_tgl_deadline = $pph->ppb_tgl_deadline;
                        $ppb_tgl_deadline = date("d-m-Y", strtotime($ppb_tgl_deadline));?>
                        <span>{{$ppb_tgl_deadline}}</span>
                    </div>
                    @if($pph->ppb_tipe==="Asset" || $pph->ppb_tipe==="Inventory & Non")
                    <div id="asset">
                        <h1 class="text-asset">ASSET</h1>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </thead>
    <tbody>
        <div id="info-table">
            <table id="barang" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th colspan="6" class="t-8">(Diisi oleh pihak pemohon)</th>
                        <th colspan="3" class="t-8">(Diisi oleh Procurement)</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="bg-lgray border-bot">NO</th>
                        <th rowspan="2" class="bg-lgray border-bot">QTY</th>
                        <th rowspan="2" class="bg-lgray border-bot">SATUAN</th>
                        <th colspan="3" class="bg-lgray">Nama Barang</th>
                        <th rowspan="2" class="twarp sm-text bg-lgray tl border-bot">REFERENSI PEMASOK</th>
                        <th rowspan="2" class="twarp sm-text bg-lgray tl border-bot">Spesifikasi Penggunaan Energi Signifikan / K3L(*)</th>
                        <th rowspan="2" class="twarp sm-text bg-lgray tl border-bot">Keterangan / No. PO Procurement</th>
                    </tr>
                    <tr>
                        <th class="bg-lgray border-bot desc" >Deskripsi</th>
                        <th class="bg-lgray border-bot tipe">Tipe</th>
                        <th class="bg-lgray border-bot merek">Merek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1;
                    $style="page-break-after: always;";
                    ?>
                    @foreach ($ppd as $ppd)
                    <?php if ($nomor % 15 == 0 ) {
                        // echo "<tr style='page-break-after: always;'>";
                    }
                    else {
                        // echo "<tr>";
                    }
                    ?>
                    <tr>
                        <td><?php echo $nomor++;?></td>
                        <td>{{$ppd->ppb_qty}}</td>
                        <td>{{$ppd->ppb_satuan}}</td>
                        <td>{{$ppd->ppb_deskripsi}}</td>
                        <td>{{$ppd->ppb_tipe_barang}}</td>
                        <td>{{$ppd->ppb_merek}}</td>
                        <td>{{$ppd->ppb_pemasok_panel}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="9" class="t-center bg-lgray">(*) Spesifikasi Pengguna Energi Signifikan terdapat pada Standar Spesifikasi Pengguna Energi Signifikan / Pengadaan sesuai kententuan K3L</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </tbody>
    <tfoot>
        <footer>
            <div class="col" style="display: inline-block;padding:5px 0px;">
                <label for="" class="bg-lgray" id="catatan">Catatan atau alamat pengiriman</label>
                <span>{{$pph->ppb_catatan}}</span>
            </div>

            <table class="t-center" id="forttd">
                <thead>
                    <tr>
                        <th colspan="3">PIHAK PEMOHON</th>
                        <th colspan="2">PIHAK PROCUREMENT</th>
                        <th>PPB SELESAI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td class="center">Diajukan Oleh,</td>
                        <td class="center">Disetujui Oleh,</td>
                        <td class="seperate center">Diketahui Oleh, (**)</td>
                        <td class="center">Diterima Oleh,</td>
                            <td class="seperate center">Disetujui Oleh,</td>
                        <td class="center">Diterima Oleh,</td>
                    </tr>

                    <tr id="ttd">
                        <td></td>
                        <td></td>
                        <td class="seperate"></td>
                        <td></td>
                        <td class="seperate"></td>
                        <td></td>
                    </tr>

                    <tr id="ttdnama">
                        <td>Nama : {{$pph->ppb_pengaju}}</td>
                        <td>Nama :</td>
                        <td class="seperate">Nama :</td>
                        <td>Nama :</td>
                        <td class="seperate">Nama :</td>
                        <td>Nama :</td>
                    </tr>

                    <tr class="tgldate">
                        <td>Tgl : {{date('d M Y')}}</td>
                        <td>Tgl :</td>
                        <td class="seperate">Tgl :</td>
                        <td>Tgl :</td>
                        <td class="seperate">Tgl :</td>
                        <td>Tgl :</td>
                    </tr>
                </tbody>
            </table>
            <div class="noted" style="display: flex;">
                <span style="float: left;position:absolute;left:50%;">(**) Bila diperlukan diisi oleh Direktorat/Manajemen</span>
                <span style="float: right;position:absolute;right:20px">FM-PRO-06/REV-6</span>
            </div>
        </footer>
    </tfoot>
</table>


    {{-- <div id="info-footer"> --}}

    {{-- </div> --}}


</body>
</html>
