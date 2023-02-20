@extends('layout.main')
@section('title')
Daftar Permintaan Barang
@endsection
@section('main_header')
   Daftar Permintaan Barang
@endsection
@section('header')
@can('isGA')
<a href="{{route('ga.masterWarehouseExport')}}"class="btn btn-success btn-sm">Export Master Item</a>
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
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary action-modal" data-toggle="modal" data-target="#action-modal" data-id="{{ $list->uuid_permintaan }}">Ubah</button>
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
                            {{$list->current_qty}}
                        </td>
                        <td>
                            {{$list->request_qty}}
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
@include('GeneralAffair.ga_04_reportPermintaan.actionModal')
{{-- End modal Action --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_permintaan').DataTable();
} );
</script>
{{-- Request Script --}}
<script>
    $(document).ready(function() {
        $('.action-modal').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.permintaanGetData", ":id") }}'.replace(':id', id), function(data) {
                $('#action-form input[name="uuid_permintaan"]').val(data.uuid_permintaan);
                $('#action-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#action-form input[name="nama_barang"]').val(data.nama_barang);
                $('#action-form input[name="current_qty"]').val(data.current_qty);
                $('#action-form input[name="request_qty"]').val( data.request_qty);
                $('#action-form input[name="pengaju"]').val( data.pengaju);
                $('#action-form #status_permintaan').val( data.status_permintaan);
            });
        });
    });
</script>
@endsection
