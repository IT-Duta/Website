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
