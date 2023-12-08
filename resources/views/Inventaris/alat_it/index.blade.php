@extends('layout.main')
@section('title')
    Alat IT
@endsection
@section('main_header')
    Alat IT
@endsection
@can('isAdmin')
    @section('header')
        <a href="#" class="btn btn-primary btn-round">Export</a>
        {{-- <a href="{{ route('pc_import_view') }}" class="btn btn-primary btn-round">Import PC</a> --}}
        <a href="{{ route('ait_create') }}" class="btn btn-secondary btn-round">Add Alat</a>
        <button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#importModal">
            Import
        </button>
    @endsection
@endcan
@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered" id="ait_master">
                    <caption>List Alat IT</caption>
                    <thead class="text-center">
                        <tr class="table-primary">
                            <th>No</th>
                            <th class="w-100">Nama Alat</th>
                            @can('isAdmin')
                                <th class="d-sm-none d-md-none d-lg-table-cell">Serial No.</th>
                            @endcan
                            <th>Type</th>
                            @can('isAdmin')
                                <th class="d-sm-none d-md-none d-lg-table-cell">Harga</th>
                            @endcan
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Stok (Item)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($list) > 0)
                            @foreach ($list as $no => $item)
                                <tr>
                                    <td class="text-center">{{ ++$no }}</td>
                                    <td>{{ $item->name }}</td>
                                    @can('isAdmin')<td class="text-center d-sm-none d-md-none d-lg-table-cell">{{ $item->serial_number }}</td>@endcan
                                    <td>{{ $item->ait_type_name }}</td>
                                    @can('isAdmin')<td class="text-right d-sm-none d-md-none d-lg-table-cell">Rp. {!! number_format($item->price, 0, '.', ',') !!}</td>@endcan
                                    <td>{{ $item->condition }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-xs btn-success btn-pinjam-create text-white" disabled>
                                            <i class="fas fa-file-export" data-toggle="tooltip" data-placement="top" title="Pinjam"></i>
                                        </button>
                                        @can('isAdmin')
                                        <a href="{{ route('ait_edit', $item->id) }}" class="btn btn-xs btn-primary text-white">
                                            <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                        </a>
                                        <a onclick="return confirm('Yakin ingin hapus Alat IT dengan Nomor {{ $item->number }}?');"
                                            href="{{ route('ait_destroy', $item->id) }}" class="btn btn-xs btn-danger text-white">
                                            <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                        </a>
                                        <a target="__blank" onclick="return confirm('Yakin ingin Print QR Alat IT dengan Nomor {{$item->number}} ?')" href="{{ route('ait_qr_generator', ['id' => $item->unique]) }}"
                                            class="btn btn-xs btn-dark text-white">
                                            <i class="fas fa-qrcode" data-toggle="tooltip" data-placement="top" title="Print QR"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal modal-create-pinjam fade">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-warning">
                <div class="modal-header bg-primary rounded-0">
                    <h3 class="modal-title">Pinjam Alat IT</h3>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if (count($list) > 0)
                    <form action="{{ url('/inventaris/alat-it/pinjam-it/create/'.$item->id) }}" method="POST">
                        <input type="hidden" name="ait_id" value="{{ $item->id }}"/>
                        <div class="form-group">
                            <label for="">Input label</label>
                            <input type="text" class="form-control is-valid" name="inputName" />
                        </div>
                        <div class="d-inline">
                            <button class="btn btn-xs btn-success" type="submit">
                                <i class="fas fa-sign-in-alt"></i> Submit
                            </button>
                            <button class="btn btn-xs btn-secondary" data-dismiss="modal">
                                <i class="fa fa-window-close"></i> Close
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
                <!-- TODO: This is for server side, there is another version for browser defaults -->
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(function() {
            $('#ait_master').DataTable();

            $(".btn-pinjam-create").on("click", function(){
                $(".modal-create-pinjam").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true,
                });
            });
        });
    </script>
@endsection
