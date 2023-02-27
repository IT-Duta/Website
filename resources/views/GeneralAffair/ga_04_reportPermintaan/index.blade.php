@extends('layout.main')
@section('title')
Daftar Permintaan Barang
@endsection
@section('main_header')
   Daftar Permintaan Barang
@endsection
@section('header')
@can('isGA')
<a href="{{route('ga.reportExport')}}"class="btn btn-success btn-sm">Export Report Permintaan</a>
@endcan
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            Daftar Permintaan Barang
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
            <table class="table table-bordered table-stripped" id="daftar_permintaan">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No</th>
                        <th>Nama Gudang</th>
                        <th>Nama Barang</th>
                        <th>Nama Pengaju</th>
                        <th>Jumlah Permintaan</th>
                        <th>Jumlah Sekarang</th>
                        <th>Status Permintaan</th>
                        <th>Waktu Permintaan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Untuk penomoran tabel --}}
                    @php
                        $nomor=1;
                    @endphp
                    {{-- Untuk penomoran tabel selesai --}}
                    {{-- Menampilkan seluruh data yang berasal dari controller --}}
                    @foreach ($list as $list)
                    <tr>
                        <td>
                            @can('isGA')
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary btn-sm edit-modal" data-toggle="modal" data-target="#edit-modal" data-id="{{ $list->uuid_permintaan }}">Ubah</button>
                            <button class="btn btn-success btn-sm diterima-modal" data-toggle="modal" data-target="#diterima-modal" data-id="{{ $list->uuid_permintaan }}">Diterima</button>
                            <button class="btn btn-danger btn-sm ditolak-modal" data-toggle="modal" data-target="#ditolak-modal" data-id="{{ $list->uuid_permintaan }}">Ditolak</button>
                            @endcan
                        </td>
                        <td>
                            {{$nomor++}}
                        </td>
                        <td>
                            {{$list->nama_gudang}}
                        </td>
                        <td>
                            {{$list->nama_barang}}
                        </td>
                        <td>
                            {{$list->pengaju}}
                        </td>
                        <td>
                            {{$list->request_qty}}
                        </td>
                        <td>
                            {{$list->current_qty}}
                        </td>
                        <td>
                            {{$list->status_permintaan}}
                        </td>
                        <td>
                            {{$list->created_at}}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
{{-- Add modal Action --}}
@include('GeneralAffair.ga_04_reportPermintaan.editModal')
{{-- End modal Action --}}
{{-- Modal Diterima --}}
@include('GeneralAffair.ga_04_reportPermintaan.diterimaModal')

@include('GeneralAffair.ga_04_reportPermintaan.ditolakModal')
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_permintaan').DataTable();
} );
</script>
{{-- Request Script --}}

<script>
        $('.edit-modal').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.reportGetData", ":id") }}'.replace(':id', id), function(data) {
                $('#edit-form input[name="uuid_permintaan"]').val(data.uuid_permintaan);
                $('#edit-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#edit-form input[name="nama_barang"]').val(data.nama_barang);
                $('#edit-form input[name="current_qty"]').val(data.current_qty);
                $('#edit-form input[name="request_qty"]').val( data.request_qty);
                $('#edit-form input[name="pengaju"]').val( data.pengaju);
                $('#edit-form #status_permintaan').val('Ditunggu');
            });
        });
</script>
{{-- Delete Modal --}}
<script>
    $('.diterima-modal').click(function() {
        var id = $(this).data('id');
        $.get('{{ route("ga.reportGetData", ":id") }}'.replace(':id', id), function(data) {
                $('#diterima-form input[name="uuid_permintaan"]').val(data.uuid_permintaan);
                $('#diterima-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#diterima-form input[name="nama_barang"]').val(data.nama_barang);
                $('#diterima-form input[name="current_qty"]').val(data.current_qty);
                $('#diterima-form input[name="request_qty"]').val( data.request_qty);
                $('#diterima-form input[name="pengaju"]').val( data.pengaju);
                $('#diterima-form #status_permintaan').val('Diterima');
            });
    });
</script>
<script>
    $('.ditolak-modal').click(function() {
        var id = $(this).data('id');
        $.get('{{ route("ga.reportGetData", ":id") }}'.replace(':id', id), function(data) {
                $('#ditolak-form input[name="uuid_permintaan"]').val(data.uuid_permintaan);
                $('#ditolak-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#ditolak-form input[name="nama_barang"]').val(data.nama_barang);
                $('#ditolak-form input[name="current_qty"]').val(data.current_qty);
                $('#ditolak-form input[name="request_qty"]').val( data.request_qty);
                $('#ditolak-form input[name="pengaju"]').val( data.pengaju);
                $('#ditolak-form #status_permintaan').val('Ditolak');
            });
    });
</script>
@endsection
