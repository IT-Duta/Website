@extends('layout.main')
@section('title')
    Permintaan Software
@endsection
@section('main_header')
    Permintaan Software
@endsection
@section('header')
    <a href="{{ route('soft_req_create') }}" class="btn btn-secondary btn-round">Add Permintaan Software</a>
    <a href="{{ route('soft_req_export') }}" class="btn btn-secondary btn-round">Export Permintaan Software</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">Permintaan Software</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered display" id="permintaan_master">
                    <caption>Permintaan Software</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nomor Pengajuan</th>
                            <th>User Pengaju</th>
                            <th>Divisi</th>
                            <th>Lokasi</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        @foreach ($softReq as $softReq)
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $softReq->soft_req_number }}</td>
                                <td>{{ $softReq->soft_req_user }}</td>
                                <td>{{ $softReq->soft_req_divisi }}</td>
                                <td>{{ $softReq->soft_req_location }}</td>
                                <td>{{ $softReq->soft_req_reason }}</td>
                                <td>{{ $softReq->soft_req_status }}</td>
                                <td>{{ $softReq->soft_req_date }}</td>
                                <td>
                                    @can('softReqView', $softReq)
                                        {{-- @if ($softReq->soft_req_status === 'Progress') --}}

                                        {{-- @endif --}}
                                        <a target="_BLANK" href="{{ route('soft_req_print', $softReq->soft_req_unique) }}"
                                            class="text-primary"><i class="fas fa-print"data-toggle="tooltip"
                                                data-placement="top" title="Print Data"></i></a>
                                    @endcan
                                    @can('isAdmin')
                                        <a href="{{ route('soft_req_edit', $softReq->soft_req_unique) }}"
                                            class="text-primary"><i class="fa fa-edit"data-toggle="tooltip" data-placement="top"
                                                title="Edit Data"></i></a>
                                        <a onclick="return confirm('Are you sure to delete {{ $softReq->soft_req_number }} ?');"
                                            href="{{ route('soft_req_delete', $softReq->soft_req_unique) }}"
                                            class="text-danger"><i class="fas fa-trash"data-toggle="tooltip"
                                                data-placement="top" title="Delete Data"></i></a>
                                    @endcan
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
            $('#permintaan_master').DataTable();
        });
    </script>
@endsection
