@extends('layout.main')
@section('title')
    List Ticketing
@endsection
@section('main_header')
    List Ticketing
@endsection
@section('header')
    {{-- <a href="{{ route('ticket_export') }}" class="btn btn-secondary btn-round">Report</a> --}}
    <!-- Tombol Report -->
    <a href="#" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#filterModal">Report</a>
    <a href="{{ route('ticket-create') }}" class="btn btn-secondary btn-round">Add New Ticket</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">List Ticket</h3>
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
                <table class="table  table-sm table-striped table-bordered display" id="ticketing">
                    <caption>List Ticket</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nomor Ticket</th>s
                            <th>Nama Pengaju</th>
                            <th>Tipe</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Case Start</th>
                            <th>Case Finish</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        {{-- @can('HardFixView', $list) --}}
                        @foreach ($list as $list)
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $list->ticket_number }}</td>
                                <td>{{ $list->ticket_referrer }}</td>
                                <td>{{ $list->ticket_type }}</td>
                                <td>{{ $list->ticket_judul }}</td>
                                <td>{{ $list->ticket_status }}</td>
                                <td>{{ date('d M Y H:i', strtotime($list->case_start)) }}</td>
                                <td>
                                    @if ($list->case_finish)
                                        {{ date('d M Y H:i', strtotime($list->case_finish)) }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ticket-view', $list->id) }}" class="text-success"><i class="fas fa-print"data-toggle="tooltip" data-placement="top" title="Show Data"></i></a>
                                    @can('isAdmin')
                                        <a onclick="return confirm('Are you sure to delete {{ $list->ticket_number }} ?');" href="{{ route('ticket-delete', $list->id) }}" class="text-danger"><i
                                                class="fas fa-trash"data-toggle="tooltip" data-placement="top" title="Delete Data"></i></a>
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

    <!-- Modal Filter -->
    <div class="modal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Bulan dan Tahun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ticket_export') }}" method="GET">
                        <div class="form-group">
        <label for="bulan">Bulan:</label>
        <select name="bulan" id="bulan" class="form-control">
            <?php
            $bulanSekarang = date('m');
            $namaBulan = [
                'all' => ' - Semua - ',
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ];

            foreach ($namaBulan as $kodeBulan => $nama) {
                $selected = $kodeBulan == $bulanSekarang ? 'selected' : '';
                echo "<option value=\"$kodeBulan\" $selected>$nama</option>";
            }
            ?>
        </select>
    </div>

                        <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <?php
                                $tahunSekarang = date('Y');
                                for ($tahun = 2020; $tahun <= 2030; $tahun++) {
                                    $selected = $tahun == $tahunSekarang ? 'selected' : '';
                                    echo "<option value=\"$tahun\" $selected>$tahun</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#ticketing').DataTable();
        });
    </script>
    <script>
        // Saat modal ditutup, hapus nilai dari input bulan dan tahun
        $('#filterModal').on('hidden.bs.modal', function(e) {
            $(this).find('form').trigger('reset');
        });
    </script>
@endsection
