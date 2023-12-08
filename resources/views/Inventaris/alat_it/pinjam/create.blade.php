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
        .select2-container--default .select2-selection--single {border-radius: 0;border: 1px solid #ced4da;}
    </style>
@endsection
@section('content')

    <div class="card shadow">
        <div class="card-body">
            <form id="pinjam-ait-store" action="{{ route('pinjam_ait_store') }}" method="POST" enctype="multipart/form-data" validate>
                {!! csrf_field() !!}
                {{-- @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif --}}
                @if (Session::has('error'))
                    {{ Session::get('error') }}
                @endif
                {{-- <div class="form-row">
                    <div class="cold-md-12"> --}}
                        {{-- <img src="{{ url('public/images/image-1.png') }}" alt="background image"> --}}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ait">Alat <span class="text-danger">*</span></label>
                            @if(request()->route()->hasParameter('ait'))
                                <select name="ait" class="form-control @error('ait') is-invalid @enderror" @error('ait') style="border: 1px solid #ff0000 !important;" @enderror required>
                                    <option value="" disabled>Pilih AIT</option>
                                    <option value="{{ $ait_list->id }}" @if(old("ait") == $ait_list->id) selected="selected" @endif readonly>{{ $ait_list->name }}</option>
                                </select>
                            @else
                                <select name="ait" class="form-control @error('ait') is-invalid @enderror" @error('ait') style="border: 1px solid #ff0000 !important;" @enderror required>
                                    <option value="">Pilih AIT</option>
                                    @foreach ($ait_list as $no => $ait)
                                        <option value="{{ $ait->id }}" @if(old("ait") == $ait->id) selected="selected" @endif>{{ ++$no . ". " . $ait->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" name="userName" class="form-control disabled" value="{{ Auth::user()->name }}" readonly>
                            <input type="hidden" name="userId" class="form-control disabled" value="{{ Auth::user()->id }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" placeholder="Dekripsi..." rows="2" value="{{ old('description') }}" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal pinjam? <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="tanggal_kembali">Tanggal kembali? <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali') }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-12 col-12">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-shadow btn-block btn-submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(function() {
            $("select[name=ait]").select2();

            // $("select[name=ait]").on("change", function (){
            //     var stock = ($("select[name=ait]").find(':selected').attr("data-stock"));
            //     $("input[name=stock]").val(stock);
            // });
        });
</script>
@endsection