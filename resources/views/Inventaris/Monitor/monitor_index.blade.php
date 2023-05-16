@extends('layout.main')
@section('title')
    Inventaris Monitor
@endsection
@section('main_header')
    Inventaris Monitor
@endsection
@can('isAdmin')
    @section('header')
        <a href="{{ route('monitor_export') }}" class="btn btn-primary btn-round">Export</a>
        {{-- <a href="{{ route('pc_import_view') }}" class="btn btn-primary btn-round">Import PC</a> --}}
        <a href="{{ route('monitor_create') }}" class="btn btn-secondary btn-round">Add Monitor</a>
        <button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#importModal">
            Import
        </button>
    @endsection
@endcan
@section('content')
    <div class="card card-shadow">
        <div class="card-shadow">
            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered" id="monitor_master">
                    <caption>Inventaris Monitor</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Number</th>
                            <th>User</th>
                            <th>Lokasi</th>
                            <th>Nama Monitor</th>
                            <th>Ukuran</th>
                            <th>Daya(Watt)</th>
                            <th>Harga</th>
                            <th>Kondisi</th>
                            <th>Tanggal Input</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        @foreach ($list as $list)
                            {{-- {{dd($list->monitor_number)}} --}}

                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $list->monitor_number }}</td>
                                <td>{{ $list->monitor_user }}</td>
                                <td>{{ $list->monitor_location }}</td>
                                <td>{{ $list->monitor_name }}</td>
                                <td>{{ $list->monitor_size }}</td>
                                <td>{{ $list->monitor_energy }}</td>
                                <td>{{ $list->monitor_price }}</td>
                                <td>{{ $list->monitor_condition }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>
                                    @can('isAdmin')
                                        <a href="{{ route('monitor_edit', $list->id) }}" class="text-primary"><i
                                                class="fa fa-edit"data-toggle="tooltip" data-placement="top"
                                                title="Edit Data"></i></a>
                                        <a onclick="return confirm('Are you sure to delete {{ $list->monitor_number }} ?');"
                                            href="{{ route('monitor_destroy', $list->id) }}" class="text-danger"><i
                                                class="fa fa-trash"data-toggle="tooltip" data-placement="top"
                                                title="Delete Data"></i></a>
                                        <a target="__blank"
                                            onclick="return confirm('Yakin ingin Print {{ $list->monitor_number }} ?')"
                                            href="{{ route('monitor_qr', ['id' => $list->monitor_unique]) }}"
                                            class="btn btn-sm btn-primary">Print QR</a>
                                    @endcan
                                    {{-- <a href="{{ route('pc_report', $list->pc_unique) }}" class="text-success"><i class="fa fa-print"data-toggle="tooltip" data-placement="top" title="Report"></i></a> --}}
                                    {{-- <a target="__blank" onclick="return confirm('Yakin ingin Print {{$list->pc_number}} ?')" href="{{ route('pc_qr', ['id' => $list->pc_unique]) }}" --}}
                                    {{-- class="btn btn-sm btn-primary">Print QR</a> --}}
                                </td>
                            </tr>

                            <?php $nomor++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('monitor_import') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="exampleFormControlFile1">
                                <h3>Import File Monitor</h3>
                            </label>
                            <input type="file" class="form-control-file form-control"
                                name="your_file"id="exampleFormControlFile1">
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success mt-3 btn-block">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#monitor_master').DataTable();
        });
    </script>
@endsection
