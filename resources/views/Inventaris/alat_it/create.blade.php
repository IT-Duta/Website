@extends('layout.main')
@section('title')
    Tambah Inventaris Alat IT
@endsection
@section('main_header')
    Tambah Inventaris Alat IT
@endsection
@section('content')

    <div class="card card-shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('ait_store') }}" enctype="multipart/form-data" novalidate>
                @csrf
                @if (Session::has('error'))
                    {{ Session::get('error') }}
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_name">Nama Alat <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control @error('ait_name') is-invalid @enderror" name="ait_name" value="{{ old('ait_name') }}" placeholder="Nama alat ..." required>
                        </div>
                        @error('ait_name')
                        <div class="invalid-feedback"></div>
                        @enderror
                    </div>
                    @error('ait_name') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_serial_number">Serial Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control @error('ait_serial_number') is-invalid @enderror" name="ait_serial_number" value="{{ old('ait_serial_number') }}" placeholder="Nomor SN alat ..." required>
                        </div>
                    </div>
                    @error('ait_serial_number') <code class="font-weight-bold">{{ $message }}</code> @enderror
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
                                    <option value="{{ $type->id }}" @if(old("ait_type") == $type->id) selected="selected" @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('ait_type') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_description">Description <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <textarea type="text" class="form-control @error('ait_description') is-invalid @enderror" name="ait_description" rows="3"
                                placeholder="Deskripsi alat ...">{{ old('ait_description') }}</textarea>
                        </div>
                    </div>
                    @error('ait_description') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_condition">Kondisi <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <select name="ait_condition" class="form-control @error('ait_condition') is-invalid @enderror" @error('ait_condition') style="border: 1px solid #ff0000 !important;" @enderror>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Performa Sempurna"  @if(old("ait_condition") == "Performa Sempurna") selected="selected" @endif>Performa Sempurna</option>
                                <option value="Performa Bagus"  @if(old("ait_condition") == "Performa Bagus") selected="selected" @endif>Performa Bagus</option>
                                <option value="Performa Cukup"  @if(old("ait_condition") == "Performa Cukup") selected="selected" @endif>Performa Cukup</option>
                                <option value="Performa Kurang"  @if(old("ait_condition") == "Performa Kurang") selected="selected" @endif>Performa Kurang</option>
                                <option value="Perlu Perbaikan"  @if(old("ait_condition") == "Perlu Perbaikan") selected="selected" @endif>Perlu Perbaikan</option>
                                <option value="Rusak"  @if(old("ait_condition") == "Rusak") selected="selected" @endif>Rusak</option>
                                <option value="Tidak dipakai"  @if(old("ait_condition") == "Tidak dipakai") selected="selected" @endif>Tidak dipakai</option>
                            </select>
                        </div>
                    </div>
                    @error('ait_condition') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="laptop_old_number">No Lama <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control @error('ait_old_number') is-invalid @enderror" value="Kosong" name="ait_old_number" value="{{ old('ait_old_number') }}" required>
                        </div>
                    </div>
                    @error('ait_old_number') <code class="font-weight-bold">{{ $message }}</code> @enderror
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
                                <option value="{{ $list->loc_name }}" @if(old("ait_location") == $list->loc_name) selected="selected" @endif>{{ $list->loc_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('ait_location') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_price">Harga <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">RP.</span>
                                </div>
                                <input type="text" class="form-control @error('ait_price') is-invalid @enderror" name="ait_price" value="{{ old('ait_price') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Harga beli alat ..." required>
                            </div>
                        </div>
                    </div>
                    @error('ait_price') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ait_buy_date">Tanggal Beli <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md">
                            <input class="form-control @error('ait_buy_date') is-invalid @enderror" value="{!! date('Y-m-d'); !!}" name="ait_buy_date" required
                                type="date">
                        </div>
                    </div>
                    @error('ait_buy_date') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>

                <div class="mt-3 mb-0">
                    <button type="submit" class="btn btn-primary btn-shadow btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
