@extends('layout.main')
@section('title')
    Edit Inventaris Alat IT
@endsection
@section('main_header')
    Edit Inventaris Alat IT
@endsection
@section('content')

    <div class="card card-shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('ait_update', $ait->id) }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_name">Nama Alat <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input required type="text" class="form-control"  value="{{ $ait->name }}" name="ait_name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_serial_number">Serial Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input required type="text" class="form-control" value="{{ $ait->serial_number }}" name="ait_serial_number">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_type">Type <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                        <select name="ait_type" class="form-control @error('ait_type') is-invalid @enderror" @error('ait_type') style="border: 1px solid #ff0000 !important;" @enderror>
                            <option value="">-- Type Alat --</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @if($type->id === $ait->type_id) selected="selected" @endif>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_description">Description <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <textarea required type="text" class="form-control" name="ait_description" rows="3">{{ $ait->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_condition">Kondisi <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <select name="ait_condition" class="form-control @error('ait_condition') is-invalid @enderror" @error('ait_condition') style="border: 1px solid #ff0000 !important;" @enderror>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Performa Sempurna"  @if($ait->condition === "Performa Sempurna") selected="selected" @endif>Performa Sempurna</option>
                                <option value="Performa Bagus"  @if($ait->condition === "Performa Bagus") selected="selected" @endif>Performa Bagus</option>
                                <option value="Performa Cukup"  @if($ait->condition === "Performa Cukup") selected="selected" @endif>Performa Cukup</option>
                                <option value="Performa Kurang"  @if($ait->condition === "Performa Kurang") selected="selected" @endif>Performa Kurang</option>
                                <option value="Perlu Perbaikan"  @if($ait->condition === "Perlu Perbaikan") selected="selected" @endif>Perlu Perbaikan</option>
                                <option value="Rusak"  @if($ait->condition === "Rusak") selected="selected" @endif>Rusak</option>
                                <option value="Tidak dipakai"  @if($ait->condition === "Tidak dipakai") selected="selected" @endif>Tidak dipakai</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_number">Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input required type="text" class="form-control" value="@if(!empty($ait->number)) {{ $ait->number }} @else {{ $ait->old_number }} @endif" name="ait_number"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_location">Lokasi <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <select name="ait_location" class="form-control @error('ait_location') is-invalid @enderror" @error('ait_location') style="border: 1px solid #ff0000 !important;" @enderror>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach ($lokasi as $list)
                                <option value="{{ $list->loc_name }}" @if($list->loc_name === $ait->location) selected="selected" @endif>{{ $list->loc_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_price">Harga <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input required type="text" class="form-control" value="{{ $ait->price }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="ait_price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_buy_date">Tanggal Beli <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input class="form-control" value="{{ $ait->buy_date }}" onfocus="(this.type='text')"
                            onblur="(this.type='date')" name="ait_buy_date" type="text" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_status">Status <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                        <select name="ait_status" class="form-control @error('ait_status') is-invalid @enderror" @error('ait_status') style="border: 1px solid #ff0000 !important;" @enderror>
                            <option value="">-- Status Alat --</option>
                            <option value="0" @if($ait->status === 0) selected="selected" @endif>Not Available</option>
                            <option value="1" @if($ait->status === 1) selected="selected" @endif>Available</option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-3 mb-0">
                    <button type="submit" class="btn btn-primary btn-shadow btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
