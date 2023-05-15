@extends('layout.main')
@section('title')
    Permintaan Perbaikan Hardware
@endsection
@section('main_header')
    Permintaan Perbaikan Hardware
@endsection
@section('header')
    <a href="{{ route('hard_fix_report') }}" class="btn btn-secondary btn-round">Report</a>
    <a href="{{ route('hard_fix_create') }}" class="btn btn-secondary btn-round">Add Perintaan Perbaikan</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">Perbaikan Hardware</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered display" id="perbaikan_master">
                    <caption>Perbaikan Hardware</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nomor Perbaikan</th>
                            <th>User Pengaju</th>
                            <th>Divisi</th>
                            <th>Lokasi</th>
                            <th>Nama Hardware</th>
                            <th>Uraian</th>
                            <th>Penyelesaian</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        {{-- @can('HardFixView', $hardFixG) --}}
                        @foreach ($hardFixG as $hardFixG)
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $hardFixG->hard_fix_number }}</td>
                                <td>{{ $hardFixG->hard_fix_user }}</td>
                                <td>{{ $hardFixG->hard_fix_divisi }}</td>
                                <td>{{ $hardFixG->hard_fix_location }}</td>
                                <td>{{ $hardFixG->hard_fix_hardware_name }}</td>
                                <td>{{ $hardFixG->hard_fix_uraian }}</td>
                                <td>{{ $hardFixG->hard_fix_penyelesaian }}</td>
                                <td>{{ $hardFixG->hard_fix_status }}</td>
                                <td>
                                    {{-- @if ($hardFixG->hard_fix_status === 'Progress') --}}
                                    @can('isAdmin', $hardFixG)
                                        <a href="{{ route('hard_fix_edit', $hardFixG->hard_fix_general_unique) }}"
                                            class="text-primary"><i class="fa fa-edit"data-toggle="tooltip" data-placement="top"
                                                title="Edit Data"></i></a>
                                    @endcan
                                    {{-- @endif --}}
                                    <a target="_BLANK"
                                        href="{{ route('hard_fix_print', $hardFixG->hard_fix_general_unique) }}"
                                        class="text-success"><i class="fas fa-print"data-toggle="tooltip"
                                            data-placement="top" title="Print Data"></i></a>
                                    @can('isAdmin')
                                        <a onclick="return confirm('Are you sure to delete {{ $hardFixG->hard_fix_number }} ?');"
                                            href="{{ route('hard_fix_delete', $hardFixG->hard_fix_general_unique) }}"
                                            class="text-danger"><i class="fas fa-trash"data-toggle="tooltip"
                                                data-placement="top" title="Delete Data"></i></a>
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
            $('#perbaikan_master').DataTable();
        });
    </script>
@endsection
