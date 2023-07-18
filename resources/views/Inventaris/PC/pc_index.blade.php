@extends('layout.main')
@section('title')
    Inventaris PC
@endsection
@section('main_header')
    Inventaris PC
@endsection
@can('isAdmin')
    @section('header')
        <a href="{{ route('pc_export') }}" class="btn btn-primary btn-round">Export PC</a>
        <a href="{{ route('pc_import_view') }}" class="btn btn-secondary btn-round">Import PC</a>
        <a href="{{ route('pc_create') }}" class="btn btn-secondary btn-round">Add PC</a>
    @endsection
@endcan
@section('content')

    <div class="card card-shadow">
        <div class="card-shadow">
            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered" id="pc_master">
                    <caption>Inventaris PC</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Pc Number</th>
                            <th>User</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Tanggal Input</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        @foreach ($list as $list)

                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $list->pc_number }}</td>
                                <td>{{ $list->pc_user }}</td>
                                <td>{{ $list->pc_location }}</td>
                                <td>{{ $list->pc_condition }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>
                                    @can('isAdmin')
                                        <a href="{{ route('pc_edit', $list->pc_unique) }}" class="text-primary"><i class="fa fa-edit"data-toggle="tooltip" data-placement="top" title="Edit Data"></i></a>
                                        <a  onclick="return confirm('Are you sure to delete {{ $list->pc_number }} ?');" href="{{ route('pc_del', $list->pc_unique) }}" class="text-danger"><i class="fa fa-trash"data-toggle="tooltip" data-placement="top" title="Delete Data"></i></a>
                                    @endcan
                                    <a href="{{ route('pc_report', $list->pc_unique) }}" class="text-success"><i class="fa fa-print"data-toggle="tooltip" data-placement="top" title="Report"></i></a>
                                    <a target="__blank" onclick="return confirm('Yakin ingin Print {{$list->pc_number}} ?')" href="{{ route('pc_qr', ['id' => $list->pc_unique]) }}"
                                        class="btn btn-sm btn-primary">Print QR</a>
                                </td>
                            </tr>

                            <?php $nomor++; ?>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
    @section('javascript')

        <script>
            $(document).ready(function() {
        $('#pc_master').DataTable();
    } );
        </script>
        @endsection
