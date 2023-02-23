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
