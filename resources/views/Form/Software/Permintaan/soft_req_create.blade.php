@extends('layout.main')
@section('title')
    Permintaan Software
@endsection
@section('main_header')
    Permintaan Software
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-body">
            <form method='post' action="{{ route('soft_req_update') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div style="display: none">
                    <input name="soft_req_date" value="{{ date('d/m/Y') }}">
                    <input name="type" value="create">
                </div>
                <div class="card">
                    <h3 class="card-header"> Header Information </h3>
                    <div class="card-body">
                        <div class="row col-md-12">
                            <div class=" col-md-3">
                                <div class="form-group row">
                                    <label for="nomorform">Nomor</label>
                                    <input type="text" value="{{ $nomorform }}" class="form-control"
                                        name="soft_req_number">
                                </div>
                            </div>
                            <div class=" col-md-3">
                                <div class="form-group row">
                                    <label for="soft_req_user">Nama Pengaju</label>
                                    <input type="text" value="{{ Auth::user()->name }}" class="form-control"
                                        name="soft_req_user">
                                </div>
                            </div>
                            <div class=" col-md-3">
                                <div class="form-group row">
                                    <label for="soft_req_divisi">Divisi</label>
                                    <select required name="soft_req_divisi" id="soft_req_divisi" class="form-control"
                                        style="width:100%">
                                        <option selected disabled value="">Pilih Divisi</option>
                                        @foreach ($divisi as $list)
                                            <option>{{ $list->div_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class=" col-md-3">
                                <div class="form-group row">
                                    <label for="soft_req_location">Lokasi</label>
                                    <select required name="soft_req_location" id="soft_req_location" class="form-control"
                                        style="width:100%">
                                        <option selected disabled value="">Pilih Lokasi</option>
                                        @foreach ($lokasi as $list)
                                            <option>{{ $list->loc_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h3 class="card-header"> Details Request </h3>
                    <div class="card-body">
                        <div class="row col-md-12">
                            <div class="form-group">
                                <label for="soft_req_email">Email</label>
                                <input type="email" placeholder="example@ptduta.com" class="form-control"
                                    name="soft_req_email" data-toggle="tooltip" data-placement="top"
                                    title="Biarkan kosong jika tidak perlu">
                            </div>
                            <div class="form-group">
                                <label for="soft_req_email_forward">Email Forward</label>
                                <input type="text" placeholder="example1@ptduta.com ; example2@ptduta.com"
                                    class="form-control" name="soft_req_email_forward" data-toggle="tooltip"
                                    data-placement="top" title="Biarkan kosong jika tidak perlu">
                            </div>
                            <div class="form-group">
                                <label for="soft_req_akses_fina">Akses Fina - Nama User</label>
                                <input type="text" placeholder="Example : ADMINSALES1" class="form-control"
                                    name="soft_req_akses_fina" data-toggle="tooltip" data-placement="top"
                                    title="Biarkan kosong jika tidak perlu" value="Kosong">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="soft_req_akses_server">Akses Server</label>
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="soft_req_akses_server" value="Iya"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Iya</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="soft_req_akses_server" value="Tidak"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Tidak</i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="soft_req_akses_internet">Akses Internet </label>
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="soft_req_akses_internet" value="Iya"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Iya</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="soft_req_akses_internet" value="Tidak"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Tidak</i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="soft_req_other">Permintaan Lainnya</label>
                            <textarea class="form-control" name="soft_req_other">Tidak Ada</textarea>
                        </div>
                        <div class="form-group">
                            <label for="soft_req_reason">Alasan Permintaan</label>
                            <textarea required class="form-control" name="soft_req_reason"></textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $("#soft_req_divisi").select2();
            $("#soft_req_location").select2();
        });
    </script>
@endsection
