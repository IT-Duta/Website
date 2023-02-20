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
