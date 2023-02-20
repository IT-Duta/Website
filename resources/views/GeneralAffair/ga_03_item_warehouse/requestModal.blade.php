<div class="modal fade" id="request-modal" tabindex="-1" aria-labelledby="request-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="request-modalLabel">Pengajuan Barang General Affair</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method='post' action="{{route('ga.permintaanStore')}}" id="req-form" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <input type="hidden" name="connector">
                <input type="hidden" name="current_qty">
                {{-- Input Text --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="pengaju">Nama Pengaju</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="pengaju"
                            type="text"
                            value="{{Auth::user()->name}}">
                        </div>
                    </div>
                </div>
                {{-- Input Text --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_barang">Nama Barang</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="nama_barang"
                            id="nama_barang"
                            readonly
                            type="text">
                        </div>
                    </div>
                </div>
                {{-- Input Number --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="request_qty">Jumlah Barang</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="request_qty"
                            id="request_qty"
                            type="number"
                            min="0"
                            step="any">
                        </div>
                    </div>
                </div>
                {{-- Input Select --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_gudang">Nama Gudang</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="nama_gudang"
                            id="nama_gudang"
                            readonly
                            type="text">
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="submit"
                class="btn btn-primary btn-shadow btn-block" form="req-form">
                Submit
            </button>
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
