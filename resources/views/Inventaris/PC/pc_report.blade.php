@extends('layout.main')
@section('title')
    Report Pc
@endsection
@section('main_header')
    Report {{ $list->pc_user }} - {{$list->pc_number }}
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h4 class="text-center">Report Pc</h4>
        </div>
        <div class="card-body">
            <div id="Detail_Data">
                <button class="btn btn-success btn-block" type="button" data-toggle="collapse" data-target="#DetailSpec"
                    aria-expanded="false" aria-controls="DetailSpec">
                    Detail
                </button>
                <div class="collapse" id="DetailSpec">
                    <div class="card card-body">
                        <h1 class="text-center">Pc Detail - {{ $list->pc_number }} </h1>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_number" class="form-label">No Pc</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_number }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_user" class="form-label">User</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_user }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_tanggal" class="form-label">Tanggal Beli</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_buy_date }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_harga" class="form-label">Harga</label>
                            </div>
                            <div class="col-md">
                                <input readonly id="harga" class="form-control" type="text"
                                    value="{{ $list->pc_price }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_location" class="form-label">Kondisi</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_condition }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_mainboard" class="form-label">Mainboard</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_mainboard }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_processor" class="form-label">Processor</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_processor }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_vga" class="form-label">VGA</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_vga }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_ram" class="form-label">RAM</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_ram }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_hdd" class="form-label">HDD</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_hdd }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_ssd" class="form-label">SSD</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_ssd }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_ssd" class="form-label">Daya</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_energy }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pc_os" class="form-label">OS</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->pc_os }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="created_at" class="form-label">Data Awal</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->created_at }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="updated_at" class="form-label">Update Terakhir</label>
                            </div>
                            <div class="col-md">
                                <input readonly class="form-control" type="text" value="{{ $list->updated_at }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="Update_Data">
                <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#Update"
                    aria-expanded="false" aria-controls="Update">
                    Update Data
                </button>
                <div class="collapse" id="Update">
                    <div class="card card-body">
                        <table class="table table-stripped table-responsive">
                            <thead class="table-primary">
                                <tr>
                                    <th>Pc No</th>
                                    <th>User</th>
                                    <th>Condition</th>
                                    <th>Mainboard</th>
                                    <th>Processor</th>
                                    <th>VGA</th>
                                    <th>RAM</th>
                                    <th>HDD</th>
                                    <th>SSD</th>
                                    <th>OS</th>
                                    <th>Tgl Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report as $report)


                                    <tr>
                                        <td row="2">{{ $report->pc_number }}</td>
                                        <td>{{ $report->pc_old_user }}</td>
                                        <td>{{ $report->pc_old_condition }}</td>
                                        <td>{{ $report->pc_old_mainboard }}</td>
                                        <td>{{ $report->pc_old_processor }}</td>
                                        <td>{{ $report->pc_old_vga }}</td>
                                        <td>{{ $report->pc_old_ram }}</td>
                                        <td>{{ $report->pc_old_hdd }}</td>
                                        <td>{{ $report->pc_old_ssd }}</td>
                                        <td>{{ $report->pc_old_os }}</td>

                                        <td row="2" class="align-middle">{{ $report->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><i class="fas fa-angle-double-right"></i></td>
                                        <td>{{ $report->pc_new_user }}</td>
                                        <td>{{ $report->pc_new_condition }}</td>
                                        <td>{{ $report->pc_new_mainboard }}</td>
                                        <td>{{ $report->pc_new_processor }}</td>
                                        <td>{{ $report->pc_new_vga }}</td>
                                        <td>{{ $report->pc_new_ram }}</td>
                                        <td>{{ $report->pc_new_hdd }}</td>
                                        <td>{{ $report->pc_new_ssd }}</td>
                                        <td>{{ $report->pc_new_os }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div id="Perbaikan_Data">
                <button class="btn btn-warning btn-block" type="button" data-toggle="collapse" data-target="#perbaikan"
                    aria-expanded="false" aria-controls="perbaikan">
                    Perbaikan Data
                </button>
                <div class="collapse" id="perbaikan">
                    <div class="card card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Perbaikan</th>
                                    <th>Pengaju</th>
                                    <th>Nama Hardware</th>
                                    <th>Uraian</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=1;?>
                                @foreach ($fix as $fix)

                                <tr>
                                    <td>{{ $nomor++}}</td>
                                    <td>{{$fix->hard_fix_number}}</td>
                                    <td>{{$fix->hard_fix_user}}</td>
                                    <td>{{$fix->hard_fix_hardware_name}}</td>
                                    <td>{{$fix->hard_fix_uraian}}</td>
                                    <td>{{$fix->hard_fix_status}}</td>
                                    <td>{{$fix->created_at}}</td>
                                    <td><a target="_BLANK" href="{{ route('hard_fix_print', $fix->hard_fix_general_unique) }}">Print</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Maintenance Report --}}
            <div id="perawatan_data">
                <button class="btn btn-warning btn-block" type="button" data-toggle="collapse" data-target="#perawatan"
                    aria-expanded="false" aria-controls="perawatan">
                    Perawatan Data
                </button>
                <div class="collapse" id="perawatan">
                    <div class="card card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>User</th>
                                    <th>PIC</th>
                                    <th>Pengecekan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                    <th>Status/Keternagan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=1;
                                ?>


                                @foreach ($rawat as $rawat)
                                <?php
                                    $temp="";
                                    if ($rawat->kondisi_mainboard == "NOT") {
                                        $temp .= "Mainboard Bad, ";
                                    };
                                    if ($rawat->kondisi_penyimpanan == "NOT") {
                                        $temp .= "HDD Bad, ";
                                    };
                                    if ($rawat->kondisi_keyboardmouse == "NOT") {
                                        $temp .= "Keyboard Mouse Bad, ";
                                    };
                                    if ($rawat->kondisi_processor == "NOT") {
                                        $temp .= "Processor and PSU are Bad, ";
                                    };
                                    if ($rawat->kondisi_ram == "NOT") {
                                        $temp .= "RAM Bad, ";
                                    };
                                    if ($rawat->kondisi_jaringan == "NOT") {
                                        $temp .= "Network Bad, ";
                                    };
                                    if ($rawat->optimasi_os == "NOT") {
                                        $temp .= "OS Bad, ";
                                    };
                                    if ($rawat->optimasi_software == "NOT") {
                                        $temp .= "Software and Data are Bad, ";
                                    };
                                    if ($rawat->optimasi_antivirus == "NOT") {
                                        $temp .= "Antivirus Bad, ";
                                    };
                                    if ($rawat->backup_email == "NOT") {
                                        $temp .= "Email not backup, ";
                                    };
                                    if ($rawat->kebersihan_pc == "NOT") {
                                        $temp .= "CPU & Monitor Not Cleaned, ";
                                    };
                                    if ($temp == "") {
                                        $temp = "Semua OK";
                                    };
                                ?>
                                <tr>
                                    <td>{{ $nomor++}}</td>
                                    <td>{{$rawat->pc_location}}</td>
                                    <td>{{$rawat->pc_user}}</td>
                                    <td>{{$rawat->pic}}</td>
                                    <td>{{$temp}}</td>
                                    <td>{{$rawat->created_at}}</td>
                                    <td>-</td>
                                    <td>{{$rawat->keterangan}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
