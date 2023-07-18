@extends('layout.main')
@section('title')
    Inventaris Printer dan Scanner
@endsection
@section('main_header')
    Inventaris Printer dan Scanner
@endsection
@can('viewAdmin')
    @section('header')
        <a href="{{ route('printer_create') }}" class="btn btn-secondary btn-round">Add Printer</a>
    @endsection
@endcan
@section('content')

    <div class="card card-shadow">
        <div class="card-body">
            <div class="table-responsive text-center ">
                <table class="table table-striped " id="printer_master">
                    <caption>Inventaris Printer dan Scanner</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor</th>
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
                                <td><?php echo $nomor++; ?></td>
                                <td>{{ $list->printer_name }}</td>
                                <td>{{ $list->printer_number }}</td>
                                <td>{{ $list->printer_location }}</td>
                                <td>{{ $list->printer_condition }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>
                                    @can('isAdmin')
                                    <a href="{{ route('printer_edit', $list->printer_unique) }}" class="text-primary"><i class="fa fa-edit"data-toggle="tooltip" data-placement="top" title="Edit Data"></i></a>
                                    <a href="{{ route('printer_del', $list->printer_unique) }}" class="text-danger"><i class="fa fa-trash"data-toggle="tooltip" data-placement="top" title="Delete Data"></i></a>
                                    @endcan
                                    <a href="{{ route('printer_report', $list->printer_unique) }}" class="text-success"><i class="fa fa-print"data-toggle="tooltip" data-placement="top" title="Report"></i></a>
                                    <a href="{{ route('printer_qr', $list->printer_unique) }}" class="text-secondaryx`"><i class="fa fa-qrcode"data-toggle="tooltip" data-placement="top" title="QR Print"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        @endsection
        @section('javascript')

            <script>
                $(document).ready(function() {
                    $('#printer_master').DataTable();
                });
            </script>
        @endsection
