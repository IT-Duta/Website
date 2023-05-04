@extends('layout.main')
@section('title')
    Permintaan Pengajuan Hardware
@endsection
@section('main_header')
    List Pengajuan Hardware
@endsection
@section('header')
    <a href="{{ route('hard_req_export') }}" class="btn btn-secondary btn-round">Export Pengajuan Hardware</a>
    <a href="{{ route('hard_req_create') }}" class="btn btn-secondary btn-round">Add Pengajuan Hardware</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">List Pengajuan Hardware</h3>
        </div>
        <div class="card-body">
            <div class="text-center ">
                <table class="table table-striped table-bordered display" id="pengajuan_master">
                    <caption>List Pengajuan Hardware</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nomor Pengajuan</th>
                            <th>User Pengaju</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $nomor = 1; ?>
                        @foreach ($hardReq as $hardReq)
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td>{{ $hardReq->hard_req_number }}</td>
                                <td>{{ $hardReq->hard_req_user }}</td>
                                <td>{{ $hardReq->hard_req_alasan }}</td>
                                <td>{{ $hardReq->hard_req_status }}</td>
                                <td>
                                    <a onClick="showData({{ $hardReq->id }})" data-toggle="modal"
                                        data-target="#showData"class="text-success"><i class="fas fa-desktop"
                                            data-toggle="tooltip" data-placement="top" title="Show Data"></i>
                                    </a>
                                    @can('HardReqView', $hardReq)
                                        <a target="__BLANK" href="{{ route('hard_req_print', $hardReq->hard_req_unique) }}"
                                            class="text-primary"><i class="fas fa-print"data-toggle="tooltip"
                                                data-placement="top" title="Print Data"></i></a>
                                    @endcan
                                    @if ($hardReq->hard_req_status === 'Progress')
                                        @can('HardReqUpdate', $hardReq)
                                            <a target="__BLANK" href="{{ route('hard_req_edit', $hardReq->hard_req_unique) }}"
                                                class="text-primary"><i class="fa fa-edit"data-toggle="tooltip"
                                                    data-placement="top" title="Edit Data"></i></a>
                                        @endcan
                                    @endif
                                    @can('isAdmin')
                                        <a onclick="return confirm('Are you sure to delete {{ $hardReq->hard_req_number }} ?');"
                                            href="{{ route('hard_req_delete', $hardReq->hard_req_unique) }}"
                                            class="text-danger"><i class="fa fa-trash"data-toggle="tooltip" data-placement="top"
                                                title="Delete Data"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
    {{-- Modal untuk show Data --}}
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
@endsection

@section('javascript')
    <script>
        $('#pengajuan_master').DataTable({
            autoWidth: true
        });

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
    </script>
@endsection
