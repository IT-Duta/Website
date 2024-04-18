@extends('layout.main')
@section('head')
    <style>
        .card-primary {
            background-color: blue !important;
        }

        .card-info {
            background-color: #48abf7 !important;
        }

        .card-success {
            background-color: #31ce36 !important;
        }

        .card-secondary {
            background-color: #6861ce !important;
        }

        .sticky {
            position: fixed;
            top: 0;
            width: 77%;
            background: steelblue;
            height: 150px;
            z-index: 100;
            border-radius: 25px;
        }
    </style>
@endsection
@section('title')
    Dashboard EDP
@endsection
@section('main_header')
    Selamat Datang
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Perbaikan Hardware</p>
                                <h4 class="card-title">{{ $hard_fix_done }} of {{ $hard_fix_total }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-info card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-interface-6"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Permintaan Software</p>
                                <h4 class="card-title">{{ $soft_req_done }} of {{ $soft_req_total }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-success card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-analytics"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Pengadaan Hardware</p>
                                <h4 class="card-title">{{ $hard_req_done }} of {{ $hard_req_total }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-secondary card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Pengajuan Untuk Tinta</p>
                                <h4 class="card-title">{{ $ink_report }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Filter Petugas --}}
    <div id="filter">
        <div class="form-group">

            <h1>Filter Petugas</h1>
            <select name="" id="petugas" class="form-control my-5">
                <option value="All" disabled selected>Filter Pilih Petugas</option>
                <option value="All">All</option>
                @foreach ($petugas as $petugas)
                    <option value="{{ $petugas->ticket_solver }}">{{ $petugas->ticket_solver }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <h1 class="text-center mb-4">Analisis Performa Jaringan</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center bg-secondary text-light">
                    Waktu Ketidakaktifan Internet Bulan Ini
                    (<b>{{ \Carbon\Carbon::createFromFormat('Y m', $downtime[0]->monthYear)->format('F Y') }}</b>) <br>
                    ( {{ $workingDays }} Hari Kerja )
                </div>
                <div class="card-body">
                    @php
                        $thisMonth = date('Y m');
                        foreach ($downtime as $downtimeData) {
                            if ($downtimeData->monthYear != $thisMonth) {
                                $show = '00:00:00';
                                $percent = '100';
                            } else {
                                $show = $downtimeData->TO_SHOW;
                                $percent = $downtimeData->percen;
                            }
                            echo '<h3 class="text-center">';
                            echo '<span class="text-danger">';
                            echo $show;
                            echo '</span> | ';
                            if ($percent < 80) {
                                $span = 'text-warning';
                            } elseif ($percent < 50) {
                                $span = 'text-danger';
                            } else {
                                $span = 'text-success';
                            }
                            echo '<span class="' . $span . '">' . $percent . '%</span>';
                            echo '</h3>';
                        }
                    @endphp
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center bg-dark text-light">
                    Waktu Ketidakaktifan Internet Bulan Lalu
                    <b>{{ \Carbon\Carbon::createFromFormat('Y m', $downtimeLastMonth[0]->monthYear)->format('F Y') }}</b><br>
                    ( {{ $workingDaysLastMonth }} Hari Kerja )
                </div>
                <div class="card-body">
                    @php
                        $thisMonth = date('Y m');
                        foreach ($downtimeLastMonth as $downtimeLastMonthData) {
                            $show = $downtimeLastMonthData->TO_SHOW;
                            $percent = $downtimeLastMonthData->percen;
                            echo '<h3 class="text-center">';
                            echo '<span class="text-danger">';
                            echo $show;
                            echo '</span> | ';
                            if ($percent < 80) {
                                $span = 'text-warning';
                            } elseif ($percent < 50) {
                                $span = 'text-danger';
                            } else {
                                $span = 'text-success';
                            }
                            echo '<span class="' . $span . '">' . $percent . '%</span>';
                            echo '</h3>';
                        }
                    @endphp
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Unduh Laporan</h5><br>
                    <a href="#" class="btn btn-primary btn-block">Download Report</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="jar_chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="jar_chart2"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-8">
            <h1>7 Hari Terakhir</h1>
            <canvas id="daily"></canvas>
        </div>
        <div class="col-4">
            <h1>Status Tiket</h1>
            <canvas id="status"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h1>Kategori</h1>
            <canvas id="typechart_canvas"></canvas>
        </div>
        <div class="col-6">
            <h1>Petugas</h1>
            <canvas id="topsolver"></canvas>
        </div>
    </div>
    <div>
        <h1>Durasi Pengerjaan</h1>
        <canvas id="durasi"></canvas>
    </div>
@endsection
@section('javascript')
    <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("filter");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-Tfw6etYMUhL4RTki37niav99C6OHwMDB2iBT5S5piyHO+ltK2YX8Hjy9TXxhE1Gm/TmAV0uaykSpnHKFIAif/A==" crossorigin="anonymous" referrerpolicy="no-referrer">
        Chart.register(ChartDataLabels);
    </script>
    {{-- Jaringan Chart --}}
    <script id="jaringan">
        let jar_label = [];
        let jar_data = [];
        let jar_percent = [];
        @foreach ($jar_data as $dur)
            jar_label.push('{{ $dur->say_bulan }}');
            jar_data.push('{{ $dur->TO_SHOW }}');
            jar_percent.push('{{ $dur->percen }}');
        @endforeach
        const jar_datas = {
            labels: jar_label,
            datasets: [{
                label: 'Persentase',
                data: jar_percent,
                backgroundColor: 'rgb(54, 100, 235)',
                type: 'line',
                order: 0
            }]
        };
        const jar_chart = {
            type: 'bar',
            data: jar_datas,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            },
        };
    </script>
    {{-- Jaringan Chart 2 --}}
    <script id="jaringan2">
        let jar_label2 = [];
        let jar_data2 = [];
        @foreach ($jar_data as $dur)
            jar_label2.push('{{ $dur->say_bulan }}');
            jar_data2.push('{{ strtotime("1970-01-01 $dur->TO_SHOW UTC") }}');
        @endforeach
        const jar_datas2 = {
            labels: jar_label2,
            datasets: [{
                label: 'Menit Down',
                data: jar_data2,
                backgroundColor: 'rgb(54, 100, 235)',
                type: 'line',
                order: 0
            }]
        };
        const jar_chart2 = {
            type: 'bar',
            data: jar_datas2,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            },
        };
    </script>
    {{-- Tipe Chart donut Ticket Status --}}
    <script id="status">
        let statusLabel = {{ Js::from($label) }};
        let statusData = {{ Js::from($val) }};

        const datadonut = {
            labels: statusLabel,
            datasets: [{
                label: 'My First Dataset',
                data: statusData,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        const status = {
            type: 'doughnut',
            data: datadonut,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',

                    }
                }
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    datalabels: {
                        color: 'white',
                    }
                }
            }
        };
    </script>
    {{-- Daily ticket --}}
    <script id="dailyjs">
        var dailylabel = {{ Js::from($dailylabel) }};
        var dailydata = {{ Js::from($dailyval) }};
        let daData = {
            labels: dailylabel,
            datasets: [{
                label: 'Tickets',
                data: dailydata,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                // tension: 0.1
            }]
        };
        const dailyjs = {
            type: 'line',
            data: daData,
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',

                    }
                }
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    datalabels: {
                        color: 'white',
                        anchor: 'end',
                        align: 'top',
                        // font:{
                        //     weight:'bold'
                        // },
                        backgroundColor: 'rgb(75, 192, 192)',
                        borderRadius: 10,
                        padding: 5
                    }
                }
            }
        };
    </script>
    {{-- Type Report Chart --}}
    <script id="type">
        var typelabel = {{ Js::from($typelabel) }};
        var typeval = {{ Js::from($typeval) }};
        const typedata = {
            labels: typelabel,
            datasets: [{
                label: 'PIC',
                data: typeval,
                backgroundColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        };
        const typeshow = {
            type: 'bar',
            data: typedata,

            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',

                    }
                }
            }
        };
    </script>
    {{-- Solver Chart --}}
    <script id="topSolver">
        const topsolverdata = {
            labels: {{ Js::from($solverlabel) }},
            datasets: [{
                label: 'PIC',
                data: {{ Js::from($solverval) }},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ],
                borderWidth: 1,
            }]
        };
        const topsolver = {
            type: 'bar',
            data: topsolverdata,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    datalabels: {
                        color: 'white',
                        anchor: 'end',
                        backgroundColor: 'rgb(75, 192, 192)',
                        borderRadius: 10,
                        padding: 5
                    },
                    legend: {
                        display: false,
                    }
                }
            }
        };
    </script>
    {{-- Durasi chart --}}
    <script>
        const durasidata = {
            labels: {{ Js::from($durasilabel) }},
            // {{ Js::from($solverlabel) }},
            datasets: [{
                label: 'PIC',
                data: {{ Js::from($durasival) }},
                // {{ Js::from($solverval) }},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ],
                borderWidth: 1
            }]
        };
        const durasichart = {
            type: 'bar',
            data: durasidata,
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    datalabels: {
                        color: 'white',
                        anchor: 'end',
                        backgroundColor: 'rgb(75, 192, 192)',
                        borderRadius: 10,
                        padding: 5
                    },
                    legend: {
                        display: false,
                    }
                }
            }
        };
    </script>
    {{-- Run JS Chart --}}
    <script>
        new Chart(
            document.getElementById('jar_chart'),
            jar_chart
        );
        new Chart(
            document.getElementById('jar_chart2'),
            jar_chart2
        );
        const statusChart = new Chart(
            document.getElementById('status'),
            status
        );
        const dailychart = new Chart(
            document.getElementById('daily'),
            dailyjs
        );
        const typechart = new Chart(
            document.getElementById('typechart_canvas'),
            typeshow
        );
        const solverchart = new Chart(
            document.getElementById('topsolver'),
            topsolver
        );
        const durationchart = new Chart(
            document.getElementById('durasi'),
            durasichart
        );
    </script>
    <script id="cari_petugas">
        $("#petugas").on("change", function() {
            var data = $(this).find(":selected").val();
            // Take data from server
            $.get("{{ route('getDatakategori') }}", {
                    'data': data
                },
                function(hasil) {
                    // Ganti Kategori chart
                    typelabel = Object.keys(hasil);
                    typeval = Object.values(hasil);
                    typedata.labels = typelabel;
                    typedata.datasets[0].data = typeval;
                    typechart.update();
                });
        });
        $("#petugas").on("change", function() {
            var data = $(this).find(":selected").val();
            // Take data from server
            $.get("{{ route('getDatadaily') }}", {
                    'data': data
                },
                function(hasil) {
                    // Ganti Kategori chart
                    dailylabel = Object.keys(hasil);
                    dailydata = Object.values(hasil);
                    daData.labels = dailylabel;
                    daData.datasets[0].data = dailydata;
                    dailychart.update();
                });
        });
        $("#petugas").on("change", function() {
            var data = $(this).find(":selected").val();
            // Take data from server
            $.get("{{ route('getDatastatus') }}", {
                    'data': data
                },
                function(hasil) {
                    // Ganti Kategori chart
                    // statuslabel = Object.keys(hasil);
                    // console.log(hasil);
                    // statuss = Object.values(hasil);
                    datadonut.labels = Object.keys(hasil);
                    datadonut.datasets[0].data = Object.values(hasil);
                    statusChart.update();
                });
        });
        $("#petugas").on("change", function() {
            var data = $(this).find(":selected").val();
            // Take data from server
            $.get("{{ route('getDataduration') }}", {
                    'data': data
                },
                function(hasil) {
                    // console.log(hasil);
                    // Ganti Kategori chart
                    // statuslabel = Object.keys(hasil);
                    // statuss = Object.values(hasil);
                    durasidata.labels = Object.keys(hasil);
                    durasidata.datasets[0].data = Object.values(hasil);
                    durationchart.update();
                });
        });
    </script>
@endsection
