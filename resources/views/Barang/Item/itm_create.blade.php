@extends('layout.main')
@section('title')
    Barang Baru
@endsection
@section('main_header')
    Barang Baru
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h1>Pembuatan Barang Baru</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <form action="{{ route('itm_store') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <p class="alert alert-danger">{{ $errors->first() }}</p>
                        @endif
                        <div class="form-group">
                            <label for="type" class="form-label">Tipe</label>
                            <input required class="form-control" readonly value="inventory" name="type" type="text">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_barang " class="form-label">Tanggal Pembuatan</label>
                            <input required class="form-control" value="<?php echo date('Y-m-d')?>" name="tanggal_barang" type="date">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang " class="form-label">Nama Barang</label>
                            <input required class="form-control" value="" name="nama_barang" type="text">
                        </div>
                        {{-- <div class="form-group">
                            <label for="ink_qty " class="form-label">Jumlah</label>
                            <input required class="form-control" value="" name="ink_qty" type="number" min="0">
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="ink_code " class="form-label">Lokasi</label>
                            <input required class="form-control" value="" name="ink_code" type="text">
                        </div> --}}
                        <div class="form-group mt-3">
                            <button type="submit" class="btn-block btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
