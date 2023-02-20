

  <!-- Modal -->
  <div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addWarehouseModalLabel">Tambah Gudang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method='post' action="{{route('ga.masterWarehouseAdd')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                {{-- Input Tanggal --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_gudang">Nama Gudang</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="nama_gudang"
                            type="text">
                        </div>
                    </div>
                </div>
                {{-- Input Select --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="status_gudang">Status Gudang</label>
                        </div>
                        <div class="col-md">
                            <select name="status_gudang" id="" class="form-control">
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
