<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="{{ asset('plugins/accountingnumber/accounting.min.js') }}"></script>
    <style>
        body {
            /* display: grid; */
            margin: 20px;
            border: 1px solid black;
            font-size: 14px;
            width: 210mm;
            height: 275mm;
        }

        .center {
            text-align: center;
            justify-content: center;
        }

        .head {
            padding: 10px;
            margin-top: 10px;
        }

        .font-bold {
            font-weight: bold;
        }

        .bg-lightgray {
            background-color: lightgray !important;
        }

        .f-13 {
            font-size: 13px;
        }

        .border-right {
            border-right: 1px solid black;
        }

        .border-left {
            border-left: 1px solid black;
        }

        .border-top {
            border-top: 1px solid black !important;
        }

        .border-bottom {
            border-bottom: 1px solid black !important;
        }

        .border-all {
            border: 1px solid black;
        }

        .row,
        .col {
            margin: inherit;
            padding: inherit;
        }

        .col {
            padding-left: 10px;
        }

        .box {
            height: 100px;
        }

        .box-sm {
            height: 75px;
        }

        .box-detail {
            height: 220px;
        }

        hr {
            margin: 10px 20px;
            padding: 0px;
            opacity: 1;
        }

        #header {
            margin: 0px;

        }

        .price {
            font-size: small;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            hr {
                color: black;
                background-color: black;
                opacity: 1;
                border: 0.2px solid black;
            }

            .bg-lightgray {
                -webkit-print-color-adjust: exact;
            }

            .price {
                font-size: small;
            }
        }
    </style>

</head>

<body onload="window.print()">
    <div id="header">
        <h4 class="center">PERMINTAAN PERBAIKAN HARDWARE</h4>
        <h4 class="center">{{ $general->hard_fix_number }}</h4>
        <hr>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-5">Nama Pemohon</div>
                    <div class="col">: {{ $general->hard_fix_user }}</div>
                </div>
                <div class="row">
                    <div class="col-5">No Perangkat</div>
                    <div class="col">: {{ $list->hard_number }}</div>
                </div>

                <div class="row">
                    <div class="col-5">Tanggal Permohonan</div>
                    <div class="col">: {{ date('d-m-Y'), strtotime($general->created_at) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-5">Divisi</div>
                    <div class="col">: {{ $general->hard_fix_divisi }}</div>
                </div>
                <div class="row">
                    <div class="col-5">Nama Perangkat</div>
                    <div class="col">: {{ $general->hard_fix_hardware_name }}</div>
                </div>
                <div class="row">
                    {{-- <div class="col-5">Jam Permohonan</div> --}}
                    {{-- <div class="col">: {{ date('h:i:s A'), strtotime($general->created_at) }}</div> --}}
                    {{-- <div class="col">: {{ date('d-m-Y', strtotime($general->created_at . ' + 7 days')) }}</div> --}}
                </div>

            </div>
        </div>
    </div>
    <div class="mx-3 border-right border-left">
        <div id="Uraian">
            <div class="head bg-lightgray border-top font-bold">I. Uraian Perbaikan Hardware</div>

            <div class="border-top">
                <div class="row">
                    <div class="col-8">
                        <strong>Uraian Masalah : </strong>{{ $general->hard_fix_uraian }}
                        <br>
                    </div>
                    <div class="col-4 px-0">
                        <div class="row">
                            <div class="col border-left border-bottom bg-lightgray">Diajukan Oleh</div>
                            <div class="col border-left border-bottom bg-lightgray">Disetujui Oleh</div>
                        </div>
                        <div class="row">
                            <div class="col border-left box-sm border-bottom"></div>
                            <div class="col border-left box-sm border-bottom"></div>
                        </div>
                        <div class="row">
                            <div class="col border-left border-bottom">Tgl :</div>
                            <div class="col border-left border-bottom">Tgl :</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="Detail">
            <div id="DetailHeader" class="head bg-lightgray border-top font-bold">
                II. Detail Perbaikan Hardware
            </div>
            <div id="TableDetail" class="p-2 box-detail border-top border-bottom">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Perbaikan</th>
                            <th>Keterangan</th>
                            <th>Vendor</th>
                            <th>Biaya</th>
                            <th>Tanggal Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        @foreach ($detail as $detail)
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td>{{ $detail->hard_fix_kind }}</td>
                                <td>{{ $detail->hard_fix_desc }}</td>
                                <td>{{ $detail->hard_fix_vendor }}</td>
                                <td name="harga" class="price">{{ $detail->hard_fix_price }}</td>
                                <td>{{ $detail->hard_fix_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="Penyelesaian">
            <div id="PenyelesaianHeader" class="head bg-lightgray border-top font-bold">
                III. Persetujuan Perbaikan
            </div>
            <div id="PenyelesaianDetail" class="border-top">
                <div class="row">
                    <div class="col-8">
                        <strong>Analisa Masalah : </strong>{{ $general->hard_fix_analisa }}
                        <br>
                        <br>
                        <strong>Masalah : </strong> {{ $general->hard_fix_penyelesaian }}
                        <br>
                    </div>
                    <div class="col-4 px-0">
                        <div class="row">
                            <div class="col border-left border-bottom bg-lightgray">Diajukan Oleh</div>
                            <div class="col border-left border-bottom bg-lightgray">Disetujui Oleh</div>
                        </div>
                        <div class="row">
                            <div class="col border-left box-sm border-bottom"></div>
                            <div class="col border-left box-sm border-bottom"></div>
                        </div>
                        <div class="row">
                            <div class="col border-left border-bottom">Tgl :</div>
                            <div class="col border-left border-bottom">Tgl :</div>
                        </div>
                    </div>
                </div>


                {{-- Batas --}}
                {{-- <div class="row">
                    <div class="col-10">
                        Analisa Masalah : {{ $general->hard_fix_analisa }}
                    </div>
                    <div class="col-2 border-left border-bottom bg-lightgray">Pemeriksa</div>
                </div>
                <div class="row">
                    <div class="col-10">
                        Penyelesaian Masalah : {{ $general->hard_fix_penyelesaian }}
                    </div>
                    <div class="col-2 border-left box-sm border-bottom"></div>
                </div>
                <div class="row">
                    <div class="col-10">

                    </div>
                    <div class="col-2 border-left border-bottom">Tgl :</div>
                </div> --}}
            </div>
        </div>
        {{-- <div id="Uraian">
            <div class="head bg-lightgray border-top font-bold">I. Uraian Perbaikan Hardware</div>

            <div class="border-top">

                <div class="row">
                    <div class="col-8">
                        Uraian Masalah : {{ $general->hard_fix_uraian }}
                    </div>
                    <div class="col-2 border-left border-bottom bg-lightgray">Diajukan Oleh</div>
                    <div class="col-2 border-left border-bottom bg-lightgray">Disetujui Oleh</div>
                </div>
                <div class="row">
                    <div class="col-8">

                    </div>
                    <div class="col-2 border-left box-sm border-bottom"></div>
                    <div class="col-2 border-left box-sm border-bottom"></div>
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-2 border-left border-bottom">Tgl :</div>
                    <div class="col-2 border-left border-bottom">Tgl :</div>
                </div>

            </div>
        </div> --}}
        <div id="SerahTerima">
            <div id="SerahTerimaHeader" class="head bg-lightgray border-top font-bold">
                IV. Serah Terima Hasil Perbaikan Hardware
            </div>
            <div id="SerahTerimaDetail" class="border-top">
                <div class="row">
                    <div class="col-8">Catatan/Validasi
                        {{-- <input type="checkbox">Diterima <input type="checkbox"> Ditolak --}}
                    </div>
                    <div class="col-2 border-left border-bottom center bg-lightgray f-13">Diserahkan Oleh</div>
                    <div class="col-2 border-left border-bottom bg-lightgray center">Diterima Oleh</div>
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-2 border-left box-sm border-bottom"></div>
                    <div class="col-2 border-left box-sm border-bottom"></div>
                </div>
                <div class="row">
                    <div class="col-8 border-bottom ">
                    </div>
                    <div class="col-2 border-left border-bottom">Tgl :</div>
                    <div class="col-2 border-left border-bottom">Tgl :</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let loops = document.getElementsByName("harga").length;
        for (let i = 0; i < loops; i++) {
            let hargaid = document.getElementsByName('harga')[i].innerText;
            let
                convert = accounting.formatMoney(hargaid, "Rp. ", 0);
            // convert = accounting.formatMoney(hargaid, {
            //     symbol: "Rp. ",
            //     thousand: ".",
            //     decimal: ",",
            // });
            document.getElementsByName('harga')[i].innerText = convert;
        }
    </script>
</body>

</html>
