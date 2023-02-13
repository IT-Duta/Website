@extends('layout.main')
@section('title')
{{-- Title website --}}
@endsection
@section('main_header')
    {{-- Judul halaman website--}}
@endsection
@section('header')
{{-- Button Add Data --}}
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            {{-- Judul card --}}
        </div>
        <div class="card-body">
            <form method='post' action="{{route('list_store')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="tgl_pengaju">Tanggal Pengajuan</label>
                        </div>
                        <div class="col-md">
                            <input required
                            class="form-control"
                            name="tgl_pengaju"
                            type="date">
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
                            type="text">
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
