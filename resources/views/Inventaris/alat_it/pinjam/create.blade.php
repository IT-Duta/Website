@extends('layout.main')
@section('title')
    Pinjam Alat IT
@endsection
@section('main_header')
    Pinjam Alat IT
@endsection
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single { height: 40px; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 40px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px; }
        .select2-container--default .select2-selection--single {border-radius: 0;border-color: 1px solid #ced4da;}

        .is-invalid + .select2-container {
            border-color: #dc3545 !important; /* Ganti dengan warna is-invalid yang diinginkan */
        }
    </style>
@endsection
@section('content')

    <div class="card shadow">
        <div class="card-body">
            <form id="pinjam-ait-store" action="{{ route('pinjam_ait_store') }}" method="POST" enctype="multipart/form-data" novalidate>
                {!! csrf_field() !!}
                {{-- @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif --}}
                @if (Session::has('error'))
                    {{ Session::get('error') }}
                @endif

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user">User <span class="text-danger">*</span></label>
                            <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                            <input type="text" name="userName" class="form-control user-name disabled @error('ait_description') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly>
                            <input type="hidden" name="userEmail" value="{{ Auth::user()->email }}">
                            @error('userName') <code class="font-weight-bold">{{ $message }}</code> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pinjam_location">Lokasi <span class="text-danger">*</span></label>
                            <select name="pinjam_location" class="form-control select2 @error('pinjam_location') is-invalid @enderror">
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach ($lokasi as $list)
                                <option value="{{ $list->loc_name }}" @if(old("pinjam_location")==$list->loc_name) selected="selected" @endif>{{ $list->loc_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('pinjam_location') <code class="font-weight-bold">{{ $message }}</code> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ait" class="col-md-3 col-form-label">Alat <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        @if(request()->route()->hasParameter('ait'))
                            <select name="ait" class="form-control select2 @error('ait') is-invalid @enderror" required>
                                <option value="" disabled>Pilih AIT</option>
                                <option value="{{ $ait_list->id }}, {{ $ait_list->name }}" @if(old("ait")==$ait_list->id) selected="selected" @endif readonly>{{ $ait_list->name }}</option>
                            </select>
                        @else
                            <select name="ait" class="form-control select2 @error('ait') is-invalid @enderror" required>
                                <option value="">-- Pilih AIT --</option>
                                @foreach ($ait_list as $no => $ait)
                                    <option value="{{ $ait->id }}, {{ $ait->name }}" @if(old("ait")==$ait->id) selected="selected" @endif>{{ ++$no . ". " . $ait->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    @error('ait') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>  
                <div class="form-group row">
                    <label for="pinjam_description" class="col-md-3 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <textarea class="form-control  @error('pinjam_description') is-invalid @enderror" name="pinjam_description" placeholder="Dekripsi..." rows="3" required>{{ old('pinjam_description') }}</textarea>
                    </div>
                    @error('pinjam_description') <code class="font-weight-bold">{{ $message }}</code> @enderror
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal pinjam? <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror" value="{{ old('tanggal_pinjam') }}" required/>
                        </div>
                        @error('tanggal_pinjam') <code class="font-weight-bold">{{ $message }}</code> @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_kembali">Tanggal kembali? <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali" class="form-control @error('tanggal_kembali') is-invalid @enderror" value="{{ old('tanggal_kembali') }}" required/>
                        </div>
                        @error('tanggal_kembali') <code class="font-weight-bold">{{ $message }}</code> @enderror
                    </div>
                </div>

                <div class="row mt-4 mb-2 p-2">
                    <div class="col-md-12 col-12">
                        <button type="submit" class="btn btn-primary btn-shadow btn-block btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(function() {
            $("select").select2();

            // $("select[name=ait]").on("change", function (){
            //     var stock = ($("select[name=ait]").find(':selected').attr("data-stock"));
            //     $("input[name=stock]").val(stock);
            // });
        });
</script>
@endsection