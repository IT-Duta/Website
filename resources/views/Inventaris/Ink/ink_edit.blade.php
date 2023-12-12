@extends('layout.main')
@section('title')
    Inventaris Tinta
@endsection
@section('main_header')
    Inventaris Tinta
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-body">
            <form action="{{ route('ink_update') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div class="form-group row">
                    <label for="type " class="col-md-3">Tipe</label>
                    <input required class="col-md form-control" readonly value="edit" name="type" type="text">
                </div>
                <div class="form-group row">
                    <label for="ink_code " class="col-md-3">Unique</label>
                    <input required class="col-md form-control" readonly value="{{$list->ink_unique}}" name="ink_unique" type="text">
                </div>
                <div class="form-group row">
                    <label for="ink_code " class="col-md-3">Kode Tinta</label>
                    <input required class="col-md form-control" value="{{$list->ink_code}}" name="ink_code" type="text">
                </div>
                <div class="form-group row">
                    <label for="ink_name " class="col-md-3">Nama Tinta</label>
                    <input required class="col-md form-control" value="{{$list->ink_name}}" name="ink_name" type="text">
                </div>
                <div class="form-group row">
                    <label for="ink_qty " class="col-md-3">Stock</label>
                    <input required class="col-md form-control" value="{{$list->ink_qty}}" name="ink_qty" type="number">
                </div>
                <div class="form-group row">
                    <label for="ink_qty " class="col-md-3">Minimum Stock</label>
                    <input required class="col-md form-control" value="{{$list->min_qty}}" name="min_qty" type="number">
                </div>
                <button type="submit" class="btn-block btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
