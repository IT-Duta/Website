@extends('layout.main')
@section('title')
    Inventaris Laptop
@endsection
@section('main_header')
    Inventaris Laptop
@endsection
@can('isAdmin')
    @section('header')
        <a href="{{ route('laptop_export') }}" class="btn btn-info btn-round">Export Laptop</a>
        <a href="{{ route('laptop_import_view') }}" class="btn btn-primary btn-round">Import Laptop</a>
        <a href="{{ route('laptop_create') }}" class="btn btn-secondary btn-round">Add Laptop</a>
    @endsection
@endcan
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">Laptop</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered" id="laptop_master">
                    <caption>Inventaris LAPTOP</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>User</th>
                            <th>Nama</th>
                            <th>Number</th>
                            <th>Status</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        @foreach ($list as $list)

                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $list->laptop_user }}</td>
                                <td>{{ $list->laptop_name }}</td>
                                <td>{{ $list->laptop_number }}</td>
                                <td>{{ $list->laptop_status }}</td>
                                <td>{{ $list->laptop_condition }}</td>
                                <td>
                                    @can('isAdmin')
                                    <a href="{{ route('laptop_edit', $list->laptop_unique) }}" class="text-primary"><i class="fa fa-edit"data-toggle="tooltip" data-placement="top" title="Edit Data"></i></a>
                                    <a  onclick="return confirm('Are you sure to delete {{ $list->laptop_number }} ?');" href="{{ route('laptop_del', $list->laptop_unique) }}" class="text-danger"><i class="fa fa-trash"data-toggle="tooltip" data-placement="top" title="Delete Data"></i></a>
                                    @endcan
                                    <a href="{{ route('laptop_report', $list->laptop_unique) }}" class="text-success"><i class="fa fa-print"data-toggle="tooltip" data-placement="top" title="Report"></i></a>
                                    <a target="__blank" onclick="return confirm('Yakin ingin Print {{$list->laptop_unique}} ?')" href="{{ route('laptop_qr', ['id' => $list->laptop_unique]) }}"
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
            $('#laptop_master').DataTable();
        });
    </script>
@endsection
