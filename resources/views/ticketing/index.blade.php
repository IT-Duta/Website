@extends('layout.main')
@section('title')
    List Ticketing
@endsection
@section('main_header')
    List Ticketing
@endsection
@section('header')
    <a href="{{ route('ticket_export') }}" class="btn btn-secondary btn-round">Report</a>
    <a href="{{ route('ticket-create') }}" class="btn btn-secondary btn-round">Add New Ticket</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">List Ticket</h3>
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
                <table class="table table-striped table-bordered display" id="ticketing">
                    <caption>List Ticket</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nomor Ticket</th>
                            <th>User Input</th>
                            <th>Nama Pengaju</th>
                            <th>Tipe</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Solver</th>
                            <th>Tanggal Input</th>
                            <th>Update Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        {{-- @can('HardFixView',$list) --}}
                        @foreach ($list as $list)
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $list->ticket_number }}</td>
                                <td>{{ $list->ticket_user }}</td>
                                <td>{{ $list->ticket_referrer }}</td>
                                <td>{{ $list->ticket_type }}</td>
                                <td>{{ $list->ticket_judul }}</td>
                                <td>{{ $list->ticket_status }}</td>
                                <td>{{ $list->ticket_solver }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>{{ $list->updated_at }}</td>
                                <td>
                                    <a href="{{ route('ticket-view', $list->id) }}" class="text-success"><i class="fas fa-print"data-toggle="tooltip" data-placement="top" title="Show Data"></i></a>
                                    @can('isAdmin')
                                    <a onclick="return confirm('Are you sure to delete {{ $list->ticket_number }} ?');" href="{{ route('ticket-delete', $list->id) }}" class="text-danger"><i class="fas fa-trash"data-toggle="tooltip" data-placement="top" title="Delete Data"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            <?php $nomor++; ?>
                        @endforeach
                        {{-- @endcan --}}
                    </tbody>

                </table>
            </div>
        </div>

    </div>

@endsection
@section('javascript')

    <script>
        $(document).ready(function() {
    $('#ticketing').DataTable();
} );
    </script>

@endsection
