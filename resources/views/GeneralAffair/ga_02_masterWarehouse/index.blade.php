@extends('layout.main')
@section('title')
Daftar Gudang
@endsection
@section('main_header')
   Daftar Gudang
@endsection
@section('header')
<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addWarehouseModal">
    Tambah Gudang
  </button>
   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importWarehouseModal">
    Import Gudang
  </button>
<a href="{{route('ga.masterWarehouseExport')}}"class="btn btn-success btn-sm">Export Master Item</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            Daftar Gudang
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
                        <th>Status Gudang</th>
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
                            {{$list->status_gudang}}
                        </td>
                        <td>
                            {{-- Tombol Hapus --}}
                            <button class="btn btn-danger delete-item" data-toggle="modal" data-target="#confirm-delete" data-id="{{ $list->uuid_gudang}}">Delete</button>
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-modal" data-id="{{ $list->uuid_gudang }}">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
{{-- Modal Tambah Gudang --}}
@include('GeneralAffair.ga_02_masterWarehouse.addModal')
  {{-- End Modal Tambah Gudang --}}
  {{-- Modal Import Gudang --}}
@include('GeneralAffair.ga_02_masterWarehouse.importModal')
  {{-- End Modal Import Gudang --}}
  {{-- Modal Hapus Gudang --}}
  <!-- Modal -->
@include('GeneralAffair.ga_02_masterWarehouse.deleteModal')
  {{-- End Modal Hapus Gudang --}}
@include('GeneralAffair.ga_02_masterWarehouse.editModal')

  {{-- End Modal Edit Gudang --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_gudang').DataTable();
} );
</script>
<script>
    $(document).ready(function() {
        $('.delete-item').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("ga.masterWarehouseDelete", ":id") }}';
            url = url.replace(':id', id);
            $('#delete-form').attr('action', url);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.edit-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.masterWarehouseEdit", ":id") }}'.replace(':id', id), function(data) {
                $('#edit-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#edit-form input[name="uuid_gudang"]').val(data.uuid_gudang);
                $('#edit-form input[name="uuid_gudang"]').val(data.uuid_gudang);
                $('#edit-form #status_gudang').val(data.status_gudang);

            });
        });
    });
</script>


@endsection
