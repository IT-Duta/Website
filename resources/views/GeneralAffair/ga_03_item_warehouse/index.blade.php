@extends('layout.main')
@section('title')
Daftar Gudang
@endsection
@section('main_header')
   Daftar Gudang
@endsection
@section('header')
<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addItemWarehouseModal">
    Tambah Stok Barang
  </button>
   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importItemWarehouseModal">
    Import Gudang
  </button>
<a href="{{route('ga.ItemWarehouseExport')}}"class="btn btn-success btn-sm">Export Master Item</a>
@endsection
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
                            {{-- Tombol Hapus --}}
                            <button class="btn btn-danger delete-item" data-toggle="modal" data-target="#confirm-delete" data-id="{{ $list->connector}}">Delete</button>
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-modal" data-id="{{ $list->connector }}">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
{{-- Modal Tambah Gudang --}}


  <!-- Modal -->
  <div class="modal fade" id="addItemWarehouseModal" tabindex="-1" aria-labelledby="addItemWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addItemWarehouseModalLabel">Tambah Stok Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method='post' action="{{route('ga.ItemWarehouseAdd')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_gudang">Nama Barang</label>
                        </div>
                        <div class="col-md">
                           <select class="form-control" name="uuid_barang" id="">
                            @for ($i = 0; $i < count($items); $i++)
                            <option value="{{$items[$i]->uuid_barang}}">{{$items[$i]->nama_barang}}</option>
                            @endfor
                           </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="qty_barang">Jumlah Barang</label>
                        </div>
                        <div class="col-md">
                            <input type="number" step="any" name="qty_barang" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_gudang">Nama Gudang</label>
                        </div>
                        <div class="col-md">
                            <select class="form-control" name="uuid_gudang" id="">
                                @for ($i = 0; $i < count($warehouses); $i++)
                            <option value="{{$warehouses[$i]->uuid_gudang}}">{{$warehouses[$i]->nama_gudang}}</option>
                            @endfor
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
  {{-- End Modal Tambah Gudang --}}
  {{-- Modal Import Gudang --}}


  <!-- Modal -->
  <div class="modal fade" id="importItemWarehouseModal" tabindex="-1" aria-labelledby="importItemWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importItemWarehouseModalLabel">Import Modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <a href="{{route('download_file', 'import_mastergudang.xlsx')}}">Template Import</a>
            <form action="{{route('ga.ItemWarehouseImport')}}" method="post" enctype="multipart/form-data">
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
  {{-- End Modal Import Gudang --}}
  {{-- Modal Hapus Gudang --}}
  <!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this quantity?
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

  {{-- End Modal Hapus Gudang --}}
  {{-- Modal Edit Gudang --}}
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
                <form id="edit-form" method="POST" action="{{route('ga.ItemWarehouseUpdate')}}">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <input type="hidden" class="form-control" id="connector" name="connector">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="nama_gudang">Nama Barang</label>
                            </div>
                            <div class="col-md">
                                <input type="text" readonly name="nama_barang" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="qty_barang">Jumlah Barang</label>
                            </div>
                            <div class="col-md">
                                <input type="number" step="any" name="qty_barang" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="nama_gudang">Nama Gudang</label>
                            </div>
                            <div class="col-md">
                                <input type="text" readonly name="nama_gudang" class="form-control">
                            </div>
                        </div>
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

  {{-- End Modal Edit Gudang --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_gudang').DataTable();
} );
</script>
{{-- Delete Modal --}}
<script>
    $(document).ready(function() {
        $('.delete-item').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("ga.ItemWarehouseDelete", ":id") }}';
            url = url.replace(':id', id);
            $('#delete-form').attr('action', url);
        });
    });
</script>
{{-- Edit Modal --}}
<script>
    $(document).ready(function() {
        $('.edit-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("ga.ItemWarehouseEdit", ":id") }}'.replace(':id', id), function(data) {
                $('#edit-form input[name="qty_barang"]').val(data.qty_barang);
                $('#edit-form input[name="connector"]').val(data.connector);
                $('#edit-form input[name="nama_gudang"]').val(data.nama_gudang);
                $('#edit-form input[name="nama_barang"]').val(data.nama_barang);
            });
        });
    });
</script>


@endsection
