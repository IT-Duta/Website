{{-- Memilih template dari file layout/main.blade.php --}}
@extends('layout.main')

@section('title')
Edit Data
@endsection


@section('content')
<div class="card card-shadow">
    <div class="card-header">
        <h1>
            Edit Data - {{$list->id}}
        </h1>
    </div>
    <div class="card-body">
        <form method='post' action="#" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <input type="hidden" name="id" value="{{$list->id}}">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="tgl_pengaju">Tanggal Pengajuan</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="tgl_pengaju"
                            type="date"
                            value="{{$list->tgl_pengaju}}"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama_pengaju">Nama Pengaju</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="nama_pengaju"
                            type="text"
                            value="{{$list->nama_pengaju}}"
                            >
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="btn btn-primary btn-shadow">
                    Submit
                </button>
            </form>
    </div>
</div>
@endsection

@section('javascript')
{{-- Isi dengan javascript tambahan untuk penambahan fitur-fitur tersendiri --}}
@endsection
