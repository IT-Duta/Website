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
