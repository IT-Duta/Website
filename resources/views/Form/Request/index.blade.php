@extends('layout.main')
@section('title')
    List Request
@endsection
@section('main_header')
    List Request
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <div class="text-center" id="teks" style="font-size: 24px">List Request</div>
            <div class="text-center" id="teks2" style="font-size: 16px"></div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <button id="pengadaan" type="button" class="btn btn-sm btn-outline-primary"
                        onclick="UbahJudul1()">Pengadaan Hardware</button>
                    <button id="perbaikan" type="button" class="btn btn-sm btn-outline-primary"
                        onclick="UbahJudul2()">Perbaikan Hardware</button>
                    <button id="permintaan" type="button" class="btn btn-sm btn-outline-primary"
                        onclick="UbahJudul3()">Permintaan
                        Software</button>
                    <button id="waiting" type="button" class="btn btn-sm btn-outline-success"
                        onclick="UbahJudul4()">Waiting</button>
                    <button id="progress" type="button" class="btn btn-sm btn-outline-success"
                        onclick="UbahJudul5()">Progress</button>
                    <button id="finish" type="button" class="btn btn-sm btn-outline-success"
                        onclick="UbahJudul6()">Finish</button>
                    <button id="reset" type="button" class="btn btn-sm btn-outline-danger"
                        onclick="UbahJudul0()">Reset</button>
                </div>
            </div>

            <div class="text-center ">
                <table id="list_request" class="table table-striped table-bordered display table-responsive compact">
                    <caption>List Request</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nomor Pengajuan</th>
                            <th>Tipe Pengajuan</th>
                            <th>User Pengaju</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Tgl Buat</th>
                            <th>Tgl Terima</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        {{-- This is for Hardreq View --}}
                        @foreach ($hardReq as $hardReq)
                            @can('HardReqView', $hardReq)
                                <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td class="req_id">{{ $hardReq->id }}</td>
                                    <td class="req_no">{{ $hardReq->hard_req_number }}</td>
                                    <td class="req_type">Pengadaan Hardware</td>
                                    <td class="req_user">{{ $hardReq->hard_req_user }}</td>
                                    <td class="req_alasan">{{ Str::limit($hardReq->hard_req_alasan, 50, '...') }}</td>
                                    <td>{{ $hardReq->hard_req_status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($hardReq->created_at)->format('d M Y') }}</td>
                                    @if ($hardReq->hard_req_progress == '')
                                        <td class="req_progress">-</td>
                                    @else
                                        <td class="req_progress">
                                            {{ \Carbon\Carbon::parse($hardReq->hard_req_progress)->format('d M Y') }}</td>
                                    @endif
                                    <td>
                                        <a onClick="showData({{ $hardReq->id }})" data-toggle="modal" data-target="#showData"
                                            class="text-success"><i class="fas fa-desktop" data-toggle="tooltip"
                                                data-placement="top" title="Show Data"></i>
                                        </a>
                                        <a data-toggle="modal" data-target="#reqModal" class="text-success preview">
                                            <i class="fas fa-desktop" data-toggle="tooltip" data-placement="top"
                                                title="Show Request"></i>
                                        </a>
                                        @can('HardReqView', $hardReq)
                                            <a target="__BLANK" href="{{ route('hard_req_print', $hardReq->hard_req_unique) }}"
                                                class="text-primary"><i class="fas fa-print" data-toggle="tooltip"
                                                    data-placement="right" title="Print Data"></i></a>
                                        @endcan
                                        {{-- @if ($hardReq->hard_req_status === 'Progress')
                                            @can('HardReqUpdate', $hardReq)
                                            <a target="__BLANK" href="{{ route('hard_req_edit', $hardReq->hard_req_unique) }}"
                                                class="text-primary"><i class="fa fa-edit"data-toggle="tooltip" data-placement="bottom" title="Edit Data"></i></a>
                                            @endcan
                                        @endif --}}
                                        @can('isAdmin')
                                            <a onclick="return confirm('Are you sure to delete {{ $hardReq->hard_req_number }} ?');"
                                                href="{{ route('hard_req_delete', $hardReq->hard_req_unique) }}"
                                                class="text-danger"><i class="fa fa-trash" data-toggle="tooltip"
                                                    data-placement="top" title="Delete Data"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endcan
                        @endforeach
                        {{-- This is for SoftReq --}}
                        @foreach ($SoftReq as $list)
                            @can('softReqView', $list)
                                <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td class="req_id">{{ $list->id }}</td>
                                    <td class="req_no">{{ $list->soft_req_number }}</td>
                                    <td class="req_type">Permintaan Software</td>
                                    <td class="req_user">{{ $list->soft_req_user }}</td>
                                    <td class="req_alasan">{{ Str::limit($list->soft_req_reason, 50, '...') }}</td>
                                    <td>{{ $list->soft_req_status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d M Y') }}</td>
                                    @if ($list->soft_req_progress == '')
                                        <td class="req_progress">-</td>
                                    @else
                                        <td class="req_progress">
                                            {{ \Carbon\Carbon::parse($list->Soft_req_progress)->format('d M Y') }}</td>
                                    @endif
                                    <td>
                                        <a target="__BLANK" href="{{ route('soft_req_print', $list->soft_req_unique) }}"
                                            class="text-primary"><i class="fas fa-print" data-toggle="tooltip"
                                                data-placement="top" title="Print Data"></i>
                                        </a>
                                        <a data-toggle="modal" data-target="#reqModal" class="text-success preview">
                                            <i class="fas fa-desktop" data-toggle="tooltip" data-placement="top"
                                                title="Show Request"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endcan
                        @endforeach
                        @foreach ($hardFix as $list)
                            @can('HardFixView', $list)
                                <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td class="req_id">{{ $list->id }}</td>
                                    <td class="req_no">{{ $list->hard_fix_number }}</td>
                                    <td class="req_type">Perbaikan Hardware</td>
                                    <td class="req_user">{{ $list->hard_fix_user }}</td>
                                    <td class="req_alasan">{{ Str::limit($list->hard_fix_uraian, 50, '...') }}</td>
                                    <td>{{ $list->hard_fix_status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d M Y') }}</td>
                                    @if ($list->hard_fix_progress == '')
                                        <td class="req_progress">-</td>
                                    @else
                                        <td class="req_progress">
                                            {{ \Carbon\Carbon::parse($list->hard_fix_progress)->format('d M Y') }}</td>
                                    @endif
                                    <td>
                                        <a target="__BLANK"
                                            href="{{ route('hard_fix_print', $list->hard_fix_general_unique) }}"
                                            class="text-primary"><i class="fas fa-print" data-toggle="tooltip"
                                                data-placement="top" title="Print Data"></i></a>
                                        <a data-toggle="modal" data-target="#reqModal" class="text-success preview">
                                            <i class="fas fa-desktop" data-toggle="tooltip" data-placement="top"
                                                title="Show Request"></i>
                                        </a>

                                        <a href="{{ route('hard_fix_edit', $list->hard_fix_general_unique) }}"
                                            class="text-primary"><i class="fa fa-edit"data-toggle="tooltip"
                                                data-placement="top" title="Edit Data"></i></a>
                                    </td>
                                </tr>
                            @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td class="text-center">Laptop / PC</td>
                                <td id="hard_req_name"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Mainboard</td>
                                <td id="hard_req_mainboard"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Processor</td>
                                <td id="hard_req_processor"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Memory</td>
                                <td id="hard_req_memory"></td>
                            </tr>
                            <tr>
                                <td class="text-center">HDD</td>
                                <td id="hard_req_hdd"></td>
                            </tr>
                            <tr>
                                <td class="text-center">SSD</td>
                                <td id="hard_req_ssd"></td>
                            </tr>
                            <tr>
                                <td class="text-center">VGA</td>
                                <td id="hard_req_vga"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Casing</td>
                                <td id="hard_req_casing"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Keyboard & Mouse </td>
                                <td id="hard_req_keyboard"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Printer</td>
                                <td id="hard_req_printer"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Monitor</td>
                                <td id="hard_req_monitor"></td>
                            </tr>
                            <tr>
                                <td class="text-center">Lainnya</td>
                                <td id="hard_req_other"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->

    {{-- Start Modal Request --}}
    <div class="modal fade" id="reqModal" tabindex="-1" aria-labelledby="reqModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reqModalLabel">Show Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-stripped">
                        <thead>
                            <th>#</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Id</td>
                                <td><input class="form-control" name="req_id" id="req_id" readonly></td>
                            </tr>
                            <tr>
                                <td>Pengaju</td>
                                <td><span id="req_user"></span></td>
                            </tr>
                            <tr>
                                <td>Nomor Pengajuan</td>
                                <td><span id="req_no"></span></td>
                            </tr>
                            <tr>
                                <td>Tipe Pengajuan</td>
                                <td><span id="req_type"></span></td>
                            </tr>
                            <tr>
                                <td>Alasan</td>
                                <td><span id="req_alasan"></span></td>
                            </tr>
                            <tr>
                                <td>Tanggal Terima</td>
                                <td><span id="req_progress"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#" id="acc_link_req" class="btn btn-success">Accept</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Req --}}
@endsection

@section('javascript')
    <script id="dataTables">
        $(document).ready(function() {
            // $('#list_request').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        });
        var table = $('#list_request').DataTable({
            paging: false,
            ordering: false,
            info: false,
        });
        $("#pengadaan").click(function() {
            table.column(3).search("Pengadaan Hardware").draw();
        });
        $("#perbaikan").click(function() {
            table.column(3).search("Perbaikan Hardware").draw();
        });
        $("#permintaan").click(function() {
            table.column(3).search("Permintaan Software").draw();
        });
        $("#waiting").click(function() {
            table.column(6).search("waiting").draw();
        });
        $("#progress").click(function() {
            table.column(6).search("progress").draw();
        });
        $("#finish").click(function() {
            table.column(6).search("finish").draw();
        });
        $("#reset").click(function() {
            table.column(3).search(" ").draw();
            table.column(6).search("").draw();
        });
    </script>

    <script>
        function UbahJudul0() {
            var teksElem = document.getElementById("teks");
            teksElem.innerHTML = "List Request";
            var teksElem2 = document.getElementById("teks2");
            teksElem2.innerHTML = "";
        }

        function UbahJudul1() {
            var teksElem = document.getElementById("teks");
            teksElem.innerHTML = "List Request Pengadaan Hardware";
        }

        function UbahJudul2() {
            var teksElem = document.getElementById("teks");
            teksElem.innerHTML = "List Request Perbaikan Hardware";
        }

        function UbahJudul3() {
            var teksElem = document.getElementById("teks");
            teksElem.innerHTML = "List Request Permintaan Software";
        }

        function UbahJudul4() {
            var teksElem = document.getElementById("teks2");
            teksElem.innerHTML = "Waiting";
        }

        function UbahJudul5() {
            var teksElem = document.getElementById("teks2");
            teksElem.innerHTML = "Progress";
        }

        function UbahJudul6() {
            var teksElem = document.getElementById("teks2");
            teksElem.innerHTML = "Finish";
        }
    </script>

    <script>
        function showData(id) {
            $.get('{{ route('hard_req_data') }}', {
                'id': id
            }, function(response) {
                $.each($.parseJSON(response), function(key, value) {
                    $("#hard_req_name").html(value.hard_req_name);
                    $("#hard_req_mainboard").html(value.hard_req_mainboard);
                    $("#hard_req_processor").html(value.hard_req_processor);
                    $("#hard_req_memory").html(value.hard_req_memory);
                    $("#hard_req_hdd").html(value.hard_req_hdd);
                    $("#hard_req_ssd").html(value.hard_req_ssd);
                    $("#hard_req_vga").html(value.hard_req_vga);
                    $("#hard_req_casing").html(value.hard_req_casing);
                    $keymouse = value.hard_req_keyboard + ' & ' + value.hard_req_mouse;
                    $("#hard_req_keyboard").html($keymouse);
                    $("#hard_req_mouse").html(value.hard_req_mouse);
                    $("#hard_req_printer").html(value.hard_req_printer);
                    $("#hard_req_monitor").html(value.hard_req_monitor);
                    $("#hard_req_other").html(value.hard_req_other);
                });
            });
        }

        $('.preview').click(function() {
            var req_id = $(this).parent().siblings('.req_id').text();
            var req_no = $(this).parent().siblings('.req_no').text();
            var req_type = $(this).parent().siblings('.req_type').text();
            var req_user = $(this).parent().siblings('.req_user').text();
            var req_progress = $(this).parent().siblings('.req_progress').text();
            var req_alasan = $(this).parent().siblings('.req_alasan').text();
            if (req_type == 'Permintaan Software' && req_progress == '-') {
                var link = "request/acc_soft/" + req_id;
            }
            if (req_type == 'Pengadaan Hardware' && req_progress == '-') {
                var link = "request/acc_hard/" + req_id;
            }
            if (req_type == 'Perbaikan Hardware' && req_progress == '-') {
                var link = "request/acc_hard_fix/" + req_id;
            }
            if (req_type == 'Permintaan Software' && req_progress != '-') {
                var link = "request/acc_soft/finish/" + req_id;
            }
            if (req_type == 'Pengadaan Hardware' && req_progress != '-') {
                var link = "request/acc_hard/finish/" + req_id;
            }
            if (req_type == 'Perbaikan Hardware' && req_progress != '-') {
                var link = "request/acc_hard_fix/finish/" + req_id;
            }
            $("#acc_link_req").attr("href", link);
            $("#req_id").val(req_id);
            $("#req_no").html(req_no);
            $("#req_type").html(req_type);
            $("#req_user").html(req_user);
            $("#req_alasan").html(req_alasan);
            $("#req_progress").html(req_progress);

        });
    </script>
@endsection
