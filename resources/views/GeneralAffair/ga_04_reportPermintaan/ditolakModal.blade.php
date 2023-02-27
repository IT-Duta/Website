<div class="modal fade" id="ditolak-modal" tabindex="-1" aria-labelledby="ditolak-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ditolak-modalLabel">Pengajuan Barang General Affair</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method='post' action="{{route('ga.reportUpdate')}}" id="ditolak-form" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                {{-- Input Text --}}
                <input type="hidden" name="uuid_permintaan">
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
                            readonly>
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
                            <label for="request_qty">Jumlah Permintaan</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="request_qty"
                            id="request_qty"
                            type="number"
                            readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="current_qty">Jumlah Saat Ini</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="current_qty"
                            id="current_qty"
                            type="number"
                            readonly>
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
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="status_permintaan">Status Permintaan</label>
                        </div>
                        <div class="col-md">

                            <input required
                            class="form-control"
                            name="status_permintaan"
                            id="status_permintaan"
                            readonly
                            type="text">
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="submit"
                class="btn btn-primary btn-shadow btn-block" form="ditolak-form">
                Submit
            </button>
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
