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


  <!-- Modal -->
  <div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="addBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method='post' action="{{route('ga.masterItemAdd')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                {{-- Input Tanggal --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_barang">Nama Barang</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="nama_barang"
                            type="text">
                        </div>
                    </div>
                </div>
                {{-- Input Select --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="status_barang">Status Barang</label>
                        </div>
                        <div class="col-md">
                            <select name="status_barang" id="" class="form-control">
                                <option value="Aktif">Aktif</option>
                                <option value="Non Aktif">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit"
                    class="btn btn-primary btn-shadow">
                    Submit
                </button>
            </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
  {{-- End Modal Tambah Barang --}}
  {{-- Modal Import Barang --}}


  <!-- Modal -->
  <div class="modal fade" id="importBarangModal" tabindex="-1" aria-labelledby="importBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importBarangModalLabel">Import Modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('ga.masterItemImport')}}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <input type="file" class="form-control" name="file">


        </div>
        <div class="modal-footer">
            <button type="submit"  class="btn btn-primary">Import Data</button>
            </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
  {{-- End Modal Import Barang --}}
  {{-- Modal Hapus Barang --}}
  <!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <form id="delete-form" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </div>
        </div>
    </div>
</div>

  {{-- End Modal Hapus Barang --}}
  {{-- Modal Edit Barang --}}
  <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-label">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="POST" action="{{route('ga.masterItemUpdate')}}">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <input type="hidden" class="form-control" id="uuid_barang" name="uuid_barang">
                    <div class="form-group">
                        <label for="name">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                    </div>
                    <div class="form-group">
                        <label for="status_barang">Status Barang</label>
                        <select name="status_barang" id="status_barang" class="form-control">
                            <option value="Aktif">Aktif</option>
                            <option value="Non Aktif">Non Aktif</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="edit-form" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

  {{-- End Modal Edit Barang --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_barang').DataTable();
} );
</script>
<script>
    $(document).ready(function() {
        $('.delete-item').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("ga.masterItemDelete", ":id") }}';
            url = url.replace(':id', id);
            $('#delete-form').attr('action', url);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.edit-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.masterItemEdit", ":id") }}'.replace(':id', id), function(data) {
                $('#edit-form input[name="nama_barang"]').val(data.nama_barang);
                $('#edit-form input[name="uuid_barang"]').val(data.uuid_barang);
                $('#edit-form input[name="uuid_barang"]').val(data.uuid_barang);
                $('#edit-form #status_barang').val(data.status_barang);

            });
        });
    });
</script>


@endsection
