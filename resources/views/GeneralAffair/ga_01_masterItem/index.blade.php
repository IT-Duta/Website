@extends('layout.main')
@section('title')
Daftar Barang
@endsection
@section('main_header')
   Daftar Barang
@endsection
@section('header')
<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addBarangModal">
    Tambah Barang
  </button>
   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importBarangModal">
    Import Barang
  </button>
<a href="{{route('ga.masterItemExport')}}"class="btn btn-success btn-sm">Export Master Item</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            Daftar Barang
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
            <table class="table table-bordered table-stripped" id="daftar_barang">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Nama Barang</th>
                        <th>Status Barang</th>
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
                            {{$list->nama_barang}}
                        </td>
                        <td>
                            {{$list->status_barang}}
                        </td>
                        <td>
                            {{-- Tombol Hapus --}}
                            <button class="btn btn-danger delete-item" data-toggle="modal" data-target="#confirm-delete" data-id="{{ $list->uuid_barang}}">Delete</button>
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-modal" data-id="{{ $list->uuid_barang }}">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
{{-- Modal Tambah Barang --}}

@include('GeneralAffair.ga_01_masterItem.addModal')
  <!-- Modal -->

  {{-- End Modal Tambah Barang --}}
{{-- Modal Import --}}
@include('GeneralAffair.ga_01_masterItem.importModal')
{{-- End Modal Import --}}
  {{-- Modal Hapus Barang --}}
  <!-- Modal -->
@include('GeneralAffair.ga_01_masterItem.deleteModal')
  {{-- End Modal Hapus Barang --}}
  {{-- Modal Edit Barang --}}

@include('GeneralAffair.ga_01_masterItem.editModal')
  {{-- End Modal Edit Barang --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_barang').DataTable();
} );
</script>
<script>
        $('.delete-item').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("ga.masterItemDelete", ":id") }}';
            url = url.replace(':id', id);
            $('#delete-form').attr('action', url);
        });
</script>
<script>
        $('.edit-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.masterItemEdit", ":id") }}'.replace(':id', id), function(data) {
                $('#edit-form input[name="nama_barang"]').val(data.nama_barang);
                $('#edit-form input[name="uuid_barang"]').val(data.uuid_barang);
                $('#edit-form input[name="uuid_barang"]').val(data.uuid_barang);
                $('#edit-form #status_barang').val(data.status_barang);

            });
        });
</script>


@endsection
