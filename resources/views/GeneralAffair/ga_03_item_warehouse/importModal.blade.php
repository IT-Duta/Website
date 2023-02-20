
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
            <a href="{{route('download_file', 'import_itemwarehouse.xlsx')}}">Template Import</a>
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
