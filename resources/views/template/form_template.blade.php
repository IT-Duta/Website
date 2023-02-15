<form method='post' action="{{route('list_store')}}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    @if ($errors->any())
        <p class="alert alert-danger">{{ $errors->first() }}</p>
    @endif
    {{-- Input Tanggal --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="nama_input1">Tanggal Pengajuan</label>
            </div>
            <div class="col-md">
                <input required
                class="form-control"
                name="nama_input1"
                type="date">
            </div>
        </div>
    </div>
    {{-- Input Text --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="nama_input2">Nama Label2</label>
            </div>
            <div class="col-md">
                <input required
                class="form-control"
                name="nama_input2"
                type="text">
            </div>
        </div>
    </div>
    {{-- Input Number --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="nama_input3">Nama Label2</label>
            </div>
            <div class="col-md">
                <input required
                class="form-control"
                name="nama_input3"
                type="number"
                step="any">
            </div>
        </div>
    </div>
    {{-- Input Select --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="nama_input4">Nama Label2</label>
            </div>
            <div class="col-md">
                <select name="nama_input4" id="">
                    <option value="Nilai option1">Tampilan Option 1</option>
                    <option value="Nilai option2">Tampilan Option 2</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit"
        class="btn btn-primary btn-shadow">
        Submit
    </button>
</form>
