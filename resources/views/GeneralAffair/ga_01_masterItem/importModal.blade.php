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
            <a href="{{route('download_file', 'import_masterbarang.xlsx')}}">Template Import</a>
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
