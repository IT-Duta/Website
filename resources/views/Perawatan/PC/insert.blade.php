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

        </div>
        <div class="card-body">
                <form method="POST" action="{{route('perawatan.pc.store')}}"  enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    @if ($errors->any())
                        <p class="alert alert-danger">{{ $errors->first() }}</p>
                    @endif
                    <hr>
                    <h2>General</h2>
                    <hr>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" id="pic" name="pic" required class="form-control"value="{{ Auth::user()->name }}">
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="user">User</label>
                                <select name="user" class="form-control" id="user">
                                    @foreach ($user as $user)
                                    <option>{{$user->k_nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col">
                         <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                            <select name="lokasi" class="form-control" id="lokasi">
                                @foreach ($lokasi as $lokasi)
                                    <option>{{$lokasi->loc_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                    <hr>
                    <h2>Monitor</h2>
                    <hr>
                    <div class="row my-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="nomor_monitor">Nomor Monitor</label>
                                <select name="nomor_monitor" class="form-control" id="nomor_monitor">
                                    <option value="" selected disabled></option>
                                    <option value="Kosong">Kosong</option>
                                    @foreach ($nomor_monitor as $nomor_monitor)
                                    <option value="{{$nomor_monitor->monitor_number}}">{{$nomor_monitor->monitor_number.'N: '.$nomor_monitor->monitor_name.' U:'.$nomor_monitor->monitor_user  .' L:'. $nomor_monitor->monitor_location}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col" id="kebersihan_monitor">
                            <div class="form-group">
                                <label class="form-label">Kebersihan Monitor</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kebersihan_monitor" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kebersihan_monitor" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col" id="kondisi_monitor">
                            <div class="form-group">
                                <label class="form-label">Kondisi Monitor</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_monitor" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_monitor" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h2>CPU</h2>
                    <hr>
                    <div class="row my-2">
                         <div class="col">
                            <div class="form-group">
                                <label for="nomor_cpu">Nomor CPU</label>
                                <select name="nomor_cpu" class="form-control" id="nomor_cpu">
                                    @foreach ($nomor_cpu as $nomor_cpu)
                                        <option value="{{$nomor_cpu->pc_number}}">{{$nomor_cpu->pc_number.' U:'.$nomor_cpu->pc_user  .' L:'. $nomor_cpu->pc_location}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kebersihan PC</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kebersihan_pc" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kebersihan_pc" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kondisi Keyboard/Mouse</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_keyboardmouse" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_keyboardmouse" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Batas Satu Baris --}}
                    <div class="row my-2">


                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kondisi Mainboard</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_mainboard" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_mainboard" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kondisi Processor</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_processor" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_processor" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kondisi RAM</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_ram" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_ram" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Satu Baris --}}
                    {{-- Batas Satu Baris --}}
                    <div class="row my-2">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kondisi Penyimpanan</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_penyimpanan" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_penyimpanan" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Kondisi Jaringan</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_jaringan" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="kondisi_jaringan" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Satu Baris --}}
                    {{-- Batas Satu Baris --}}
                    <hr>
                    <h2>Software</h2>
                    <hr>
                    <div class="row my-2">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Optimasi OS</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="optimasi_os" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="optimasi_os" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Optimasi Antivirus</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="optimasi_antivirus" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="optimasi_antivirus" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Optimasi Software</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="optimasi_software" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="optimasi_software" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Backup Email</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="backup_email" value="OK" class="selectgroup-input" >
                                        <span class="selectgroup-button">OK</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="backup_email" value="NOT" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Satu Baris --}}
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea name="keterangan" id="" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary btn-block">Done</button>
                    </div>
                </form>
        </div>
    </div>
    <div class="wizard-container wizard-round col-md-9">
        <div class="wizard-header text-center">
            <h3 class="wizard-title"><b>Register</b> New Account</h3>
            <small>This information will let us know more about you.</small>
        </div>
        <form novalidate="novalidate">
            <div class="wizard-body">
                <div class="row">

                    <ul class="wizard-menu nav nav-pills nav-primary">
                        <li class="step" style="width: 33.3333%;">
                            <a class="nav-link active" href="#about" data-toggle="tab" aria-expanded="true"><i class="fa fa-user mr-0"></i> About</a>
                        </li>
                        <li class="step" style="width: 33.3333%;">
                            <a class="nav-link" href="#account" data-toggle="tab"><i class="fa fa-file mr-2"></i> Account</a>
                        </li>
                        <li class="step" style="width: 33.3333%;">
                            <a class="nav-link" href="#address" data-toggle="tab"><i class="fa fa-map-signs mr-2"></i> Address</a>
                        </li>
                    <div class="moving-tab" style="width: 265.583px; transform: translate3d(0px, 0px, 0px); transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;"><i class="fa fa-user mr-0"></i> About</div></ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="about">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="info-text">Tell us who you are.</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label>First Name :</label>
                                    <input name="firstname" type="text" class="form-control" required=""><label id="firstname-error" class="error" for="firstname">This field is required.</label>
                                </div>

                                <div class="form-group has-error">
                                    <label>About :</label>
                                    <textarea name="about" class="form-control" rows="5" required=""></textarea><label id="about-error" class="error" for="about">This field is required.</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label>Last Name :</label>
                                    <input name="lastname" type="text" class="form-control" required=""><label id="lastname-error" class="error" for="lastname">This field is required.</label>
                                </div>

                                <div class="form-group has-error">
                                    <label>Picture :</label>
                                    <div class="input-file input-file-image">
                                        <img class="img-upload-preview img-circle" width="100" height="100" src="http://placehold.it/100x100" alt="preview">
                                        <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" required=""><label id="uploadImg-error" class="error" for="uploadImg">This field is required.</label>
                                        <label for="uploadImg" class=" label-input-file btn btn-primary">Upload a Image</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="account">
                        <h4 class="info-text">Set up your account </h4>
                        <div class="row">
                            <div class="col-md-8 ml-auto mr-auto">
                                <div class="form-group">
                                    <label>Email :</label>
                                    <input type="email" name="email" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Password :</label>
                                    <input type="password" name="password" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password :</label>
                                    <input type="password" name="confirmpassword" class="form-control" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="address">
                        <h4 class="info-text">Tell us where you live.</h4>
                        <div class="row">
                            <div class="col-sm-8 ml-auto mr-auto">
                                <div class="form-group">
                                    <label>Country :</label>

                                    <select name="country" class="form-control" required="">
                                        <option value="">&nbsp;</option>
                                        <option value="id">Indonesia</option>
                                        <option value="my">Malaysia</option>
                                        <option value="th">Thailand</option>
                                        <option value="sg">Singapore</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>

                                    <textarea name="address" rows="3" class="form-control" required=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wizard-action">
                <div class="pull-left">
                    <input type="button" class="btn btn-previous btn-fill btn-black disabled" name="previous" value="Previous">
                </div>
                <div class="pull-right">
                    <input type="button" class="btn btn-next btn-danger" name="next" value="Next">
                    <input type="button" class="btn btn-finish btn-danger" name="finish" value="Finish" style="display: none;">
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
@endsection


@section('javascript')
<script>
    $(document).ready(function() {
    // get reference to the select element
    var select = $('#nomor_monitor');

    // add event listener for when the select element changes
    select.change(function() {
        // get the selected option value
        var selectedValue = $(this).val();

        // check if the selected option is "Kosong"
        if (selectedValue === 'Kosong') {
        // hide the desired DIV elements
        $('#kondisi_monitor').hide();
        $('#kebersihan_monitor').hide();
        // add more lines if you need to hide more DIVs
        } else {
        // show the desired DIV elements
        $('#kondisi_monitor').show();
        $('#kebersihan_monitor').show();
        // add more lines if you need to show more DIVs
        }
    });
    });

</script>
@endsection
