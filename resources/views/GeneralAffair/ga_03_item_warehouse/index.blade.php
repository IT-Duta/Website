@extends('layout.main')
@section('title')
Stok Barang
@endsection
@section('main_header')
   Stok Barang
@endsection
@can('isGA')
@section('header')
<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addItemWarehouseModal">
    Tambah Stok Barang
</button>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importItemWarehouseModal">
    Import Stok Barang
</button>

<a href="{{route('ga.ItemWarehouseExport')}}"class="btn btn-success btn-sm">Export Stok Barang</a>
@endsection
@endcan
@section('content')
@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if ($filename = session('filename'))
    <div class="alert alert-danger">
        Data tidak dapat diimpor sepenuhnya. Silakan unduh file error untuk rincian lebih lanjut.
        <a href="{{ route('ga.downloadErrorFile', $filename) }}">Download File Error</a>
    </div>
@endif

    <div class="card card-shadow">
        <div class="card-header">

            <button class="btn btn-sm btn-primary" id="HO"type="button">HO</button>
            <button class="btn btn-sm btn-success" id="LEGOK"type="button">LEGOK</button>
            <button class="btn btn-sm btn-danger" id="RESET"type="button">RESET</button>
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
            <table class="table table-bordered table-stripped" id="daftar_gudang">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Nama Gudang</th>
                        <th>Nama Barang</th>
                        <th>Qty Barang</th>
                        <th>Aksi</th>
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
                            {{$nomor++}}
                        </td>
                        <td>
                            {{$list->nama_gudang}}
                        </td>
                        <td>
                            {{$list->nama_barang}}
                        </td>
                        <td>
                            {{$list->qty_barang}}
                        </td>
                        <td>
                            @can('isGA')
                            {{-- Tombol Hapus --}}
                            <button class="btn btn-danger delete-item" data-toggle="modal" data-target="#confirm-delete" data-id="{{ $list->connector}}">Delete</button>
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-modal" data-id="{{ $list->connector }}">Edit</button>
                            @endcan
                            <button class="btn btn-success req-item" data-toggle="modal" data-target="#request-modal" data-id="{{ $list->connector }}">Request</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
{{-- Modal Tambah Stok Barang --}}
@include('GeneralAffair.ga_03_item_warehouse.addModal')

  {{-- End Modal Tambah Stok Barang --}}
  {{-- Modal Import Gudang --}}
@include('GeneralAffair.ga_03_item_warehouse.importModal')

  {{-- End Modal Import Gudang --}}
  {{-- Modal Hapus Data --}}
  <!-- Modal -->
@include('GeneralAffair.ga_03_item_warehouse.deleteModal')
  {{-- End Modal Hapus Data --}}
  {{-- Modal Edit Data --}}
  @include('GeneralAffair.ga_03_item_warehouse.editModal')
  {{-- End Modal Edit Data --}}
{{-- Start Modal Request Item --}}
@include('GeneralAffair.ga_03_item_warehouse.requestModal')
<!-- Modal -->


{{-- End Modal --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_gudang').DataTable();
    var table= $('#daftar_gudang').DataTable();
        $("#HO").click(function(){
            table.column(1).search("HO").draw();
            // table.column(6).search("Tunggu").draw();
        });
        $("#LEGOK").click(function(){
            table.column(1).search("LEGOK").draw();
        });
        $("#RESET").click(function(){
            table.column(1).search("").draw();
        });
} );
</script>
{{-- Delete Modal --}}
<script>
        $('.delete-item').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("ga.ItemWarehouseDelete", ":id") }}';
            url = url.replace(':id', id);
            $('#delete-form').attr('action', url);
        });
</script>
{{-- Edit Modal --}}

<script>
        $('.edit-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.ItemWarehouseEdit", ":id") }}'.replace(':id', id), function(data) {
                $('#edit-form input[name="qty_barang"]').val(data.qty_barang);
                $('#edit-form input[name="connector"]').val(data.connector);
                $('#edit-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#edit-form input[name="nama_barang"]').val(data.nama_barang);
            });
        });
</script>
{{-- Request Script --}}
<script>
        $('.req-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.reportRequest", ":id") }}'.replace(':id', id), function(data) {
                $('#req-form input[name="connector"]').val(data.connector);
                $('#req-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#req-form input[name="nama_barang"]').val(data.nama_barang);
                $('#req-form input[name="current_qty"]').val(data.qty_barang);
                $('#req-form input[name="request_qty"]').attr('max', data.qty_barang);
            });
        });

</script>


@endsection
