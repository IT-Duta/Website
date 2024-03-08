@extends('layout.main')
@section('main_header')
    Ticket {{ $list->ticket_number }}
@endsection
@section('title')
    Ticket {{ $list->ticket_number }}
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Magnific.css') }}">
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            Ticket {{ $list->ticket_number }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md ">
                    <p class="card-title">We will do to all the best we can to solve all your problems. </p>
                    <form action="{{ route('ticket-update') }}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <p class="alert alert-danger">{{ $errors->first() }}</p>
                        @endif
                        <input type="hidden" class="form-control" id="id" name="id" readonly value="{{ $list->id }}">
                        <div class="form-group">
                            <label for="ticket_user">Nama User</label>
                            <input type="text" class="form-control" id="ticket_user" name="ticket_user" readonly value="{{ $list->ticket_user }}">
                        </div>
                        <div class="form-group">
                            <label for="ticket_referrer">Nama Pengaju</label>
                            <input type="text" class="form-control" id="ticket_referrer" name="ticket_referrer" value="{{ $list->ticket_referrer }}">
                        </div>
                        <div class="form-group">
                            <label for="ticket_type">Tipe Error</label>
                            {{-- <input type="text" class="form-control" id="ticket_type" name="ticket_type" id="ticket_type"
                                value="{{ $list->ticket_type }}"> --}}
                            <select class="custom-select" name="ticket_type" style="width: 100%" required id="ticket_type">
                                <option value="{{ $list->ticket_type }}" selected>{{ $list->ticket_type }}</option>
                                <option value="" disabled>-Pilih Case-</option>
                                <option value="Jaringan">Jaringan</option>
                                <option value="Program">Program</option>
                                <option value="Hardware">Hardware</option>
                                <option value="Fina">Fina</option>
                                <option value="Email">Email</option>
                                <option value="Excel">Excel</option>
                                <option value="Duta Apps">Duta Apps</option>
                                <option value="GForm">Google Form</option>
                                <option value="Other">Other</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="ticket_judul">Judul</label>
                            <input type="text" class="form-control" name="ticket_judul" placeholder="Nama Program/Hardware + Keluhan -> Fina + Error Tarik Report" value="{{ $list->ticket_judul }}">
                        </div>
                        <div class="form-group">
                            <label for="ticket_detail">Detail</label>
                            <textarea class="form-control" name="ticket_detail" placeholder="Kode Error atau Kendala" rows="10">{{ $list->ticket_detail }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="ticket_solver">Nama Solver</label>
                            <input type="text" class="form-control" id="ticket_solver" name="ticket_solver"
                                value="@if (empty($list->ticket_solver)) {{ Auth::user()->name }}
                                @else{{ $list->ticket_solver }} @endif">
                        </div>
                        {{-- <div class="form-group">
                            <label for="ticket_status">Status</label>
                            <select name="ticket_status" class="form-control">
                                <option selected value="{{$list->ticket_status}}">{{$list->ticket_status}}</option>
                                <option disabled>------</option>
                                <option value="Done">Done</option>
                                <option value="Waiting">Waiting</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Cancel">Cancel</option>
                            </select>

                        </div> --}}
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="selectgroup w-100">
                                {{-- <label class="selectgroup-item">
                                    <input type="radio" name="ticket_status" value="{{$list->ticket_status}}" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">{{$list->ticket_status}}</span>
                                </label> --}}
                                <label class="selectgroup-item">
                                    <input type="radio" name="ticket_status" <?php echo $list->ticket_status === 'Done' ? 'checked' : ''; ?> value="Done" class="selectgroup-input">
                                    <span class="selectgroup-button">Done</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="ticket_status" <?php echo $list->ticket_status === 'Waiting' ? 'checked' : ''; ?> value="Waiting" class="selectgroup-input">
                                    <span class="selectgroup-button">Waiting</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="ticket_status" <?php echo $list->ticket_status === 'On Progress' ? 'checked' : ''; ?> value="On Progress" class="selectgroup-input">
                                    <span class="selectgroup-button">On Progress</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="ticket_status" <?php echo $list->ticket_status === 'Cancel' ? 'checked' : ''; ?> value="Cancel" class="selectgroup-input">
                                    <span class="selectgroup-button">Cancel</span>
                                </label>

                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> Submit</button>
                        </div>

                </div>
                {{-- <div class="col-md"><img src="{{ $url }}" class="img-thumbnail card-shadow"> --}}
                <div class="col-md card-shadow">
                    @if (!empty($list->ticket_filename))
                        <div class="form-group">
                            <a class="image-link" href="{{ asset('storage/images/' . $list->ticket_filename . '') }}">
                                <img src="{{ asset('storage/images/' . $list->ticket_filename . '') }}" class="img-thumbnail">
                            </a>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleFormControlFile1">File Solve</label>
                        <input type="file" name="ticket_file_solve" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    @if (!empty($list->ticket_file_solve))
                        <div class="form-group">
                            <h5>Download File</h5>
                            <a href="{{ route('ticket-download', $list->id) }}">Here</a>
                        </div>
                    @endif
                    <div class="form-group ">
                        <label for="ticket_solve">Solve</label>
                        <textarea class="form-control" name="ticket_solve" rows='10' placeholder="Kode Error atau Kendala ">{{ $list->ticket_solve }}</textarea>
                    </div>

                    <div class="row col-12">
                        <div class="form-group col-6">
                            <label for="case_start" class="form-label">Case Start</label>
                            <input class="form-control" id="case_start" value="{{ $list->case_start }}" name="case_start" type="datetime-local">
                        </div>
                        <div class="form-group col-6">
                            <label for="case_finish" class="form-label">Case Finish</label>
                            <input class="form-control" id="case_finish" value="{{ $list->case_finish }}" name="case_finish" type="datetime-local">
                        </div>
                    </div>

                </div>



                </form>
            </div>

        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/magnific-popup.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.image-link').magnificPopup({
                type: 'image'
            });
        });
        $("#ticket_type").select2({
            width: 'resolve',
            placeholder: "Pilih Case",
            allowClear: true
        });
    </script>
@endsection
