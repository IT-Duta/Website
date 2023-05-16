@extends('layout.main')
@section('title')
    Permintaan Software - {{ $softReq->soft_req_number }}
@endsection
@section('main_header')
    Permintaan Software - {{ $softReq->soft_req_number }}
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
                    <input name="soft_req_unique" value="{{ $softReq->soft_req_unique }}">
                    <input name="type" value="edit">
                </div>

                <div class="row col-md-12">
                    <div class="form-group">
                        <label for="Tanggal">Tanggal Pengajuan</label>
                        <input name="soft_req_date" type="text" class="form-control"
                            value="{{ $softReq->soft_req_date }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="soft_req_user">Nama Pengaju</label>
                        <input type="text" value="{{ $softReq->soft_req_user }}" class="form-control"
                            name="soft_req_user" readonly>
                    </div>
                    <div class="form-group">
                        <label for="soft_req_divisi">Divisi</label>
                        <input type="text" value="{{ $softReq->soft_req_divisi }}" class="form-control"
                            name="soft_req_divisi" readonly>
                    </div>
                    <div class="form-group">
                        <label for="soft_req_location">Lokasi</label>
                        <input type="text" value="{{ $softReq->soft_req_location }}" class="form-control"
                            name="soft_req_location" readonly>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="form-group">
                        <label for="soft_req_email">Email</label>
                        <input type="email" value="{{ $softReq->soft_req_email }}" placeholder="example@ptduta.com"
                            class="form-control" name="soft_req_email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="soft_req_email_forward">Email Forward</label>
                        <input value="{{ $softReq->soft_req_email_forward }}" type="text"
                            placeholder="example1@ptduta.com ; example2@ptduta.com" class="form-control"
                            name="soft_req_email_forward" readonly>
                    </div>
                    <div class="form-group">
                        <label for="soft_req_akses_fina">Akses Fina - Nama User</label>
                        <input value="{{ $softReq->soft_req_akses_fina }}" type="text" class="form-control"
                            name="soft_req_akses_fina" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="soft_req_akses_server">Akses Server</label>
                        <input value="{{ $softReq->soft_req_akses_server }}" readonly type="text" class="form-control"
                            name="soft_req_akses_server">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="soft_req_akses_internet">Akses Internet</label>
                        <input value="{{ $softReq->soft_req_akses_internet }}" readonly type="text" class="form-control"
                            name="soft_req_akses_internet">
                    </div>
                </div>

                <div class="form-group">
                    <label for="soft_req_other">Permintaan Lainnya</label>
                    <textarea class="form-control" name="soft_req_other" readonly>{{ $softReq->soft_req_other }} </textarea>
                </div>
                <div class="form-group">
                    <label for="soft_req_reason">Alasan Permintaan</label>
                    <textarea required class="form-control" name="soft_req_reason" readonly>{{ $softReq->soft_req_reason }} </textarea>
                </div>

                <div class="row col-md-12">
                    <div class="form-group">
                        <label for="Tanggal">Tanggal Progress</label>
                        <input name="soft_req_progress" type="date" class="form-control"
                            value="{{ $softReq->soft_req_progress }}">
                    </div>
                    <div class="form-group">
                        <label for="Tanggal">Tanggal Finish</label>
                        <input name="soft_req_finish" type="date" class="form-control"
                            value="{{ $softReq->soft_req_finish }}">
                    </div>
                    <div class="form-group">
                        <label for="soft_req_status">Status</label>
                        <select required name="soft_req_status" id="soft_req_status" class="form-control custom-select"
                            style="width:100%">
                            <option value="{{ $softReq->soft_req_status }}">{{ $softReq->soft_req_status }}</option>
                            <option value="Progress">Progress</option>
                            <option value="Finish">Finish</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
