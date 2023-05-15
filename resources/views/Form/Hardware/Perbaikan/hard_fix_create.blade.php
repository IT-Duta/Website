@extends('layout.main')
@section('title')
    Permintaan Perbaikan Hardware
@endsection

@section('main_header')
    Permintaan Perbaikan Hardware
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-body">

            <form method='post' action="{{ route('hard_fix_update') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div style="display: none">
                    <input name="type" value="create">
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Header</h5>
                        <br>
                        <div class="mb-3 row col-md-12">
                            <div class="form-group">
                                <label for="Tanggal">Nomor Form</label>
                                <input readonly name="hard_fix_number" type="text" value="{{ $nomorform }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="hardware_fix_tanggal">Tanggal Pengajuan</label>
                                <input required class="form-control" value="<?php echo date('Y-m-d'); ?>" name="hardware_fix_tanggal"
                                    type="date">
                            </div>
                            <div class="form-group">
                                <label for="hard_fix_user">Nama User</label>
                                <input required type="text" class="form-control" name="hard_fix_user"
                                    value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="hard_fix_divisi">Divisi</label>
                                <select name="hard_fix_divisi" id="hard_fix_divisi" id="hard_fix_divisi"
                                    class="form-control custom-select" style="width:100%">
                                    <option></option>
                                    @foreach ($divisi as $list)
                                        <option>{{ $list->div_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="hard_fix_location">Lokasi</label>
                                <select name="hard_fix_location" id="hard_fix_location" id="hard_fix_location"
                                    class="form-control custom-select" style="width:100%">
                                    <option></option>
                                    @foreach ($lokasi as $list)
                                        <option>{{ $list->loc_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <h5 class="card-title">Informasi Details</h5>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="hard_fix_hardware_name">Perangkat</label>
                                </div>
                                <div class="col-md-6">
                                    <select required name="hard_fix_hardware_name" id="hard_fix_hardware_name"
                                        style="width:100%">
                                        <option></option>
                                        @foreach ($list_laptop as $list_laptop)
                                            <option hard-id="{{ $list_laptop->laptop_unique }}"
                                                hard-number="{{ $list_laptop->laptop_number }}">
                                                Laptop - {{ $list_laptop->laptop_user }} - {{ $list_laptop->laptop_name }}
                                            </option>
                                        @endforeach
                                        @foreach ($list_pc as $list_pc)
                                            <option hard-id="{{ $list_pc->pc_unique }}"
                                                hard-number="{{ $list_pc->pc_number }}">
                                                PC -
                                                {{ $list_pc->pc_user }}</option>
                                        @endforeach
                                        @foreach ($list_printer as $list_printer)
                                            <option hard-id="{{ $list_printer->printer_unique }}"
                                                hard-number="{{ $list_printer->printer_number }}">
                                                {{ $list_printer->printer_name }} -
                                                {{ $list_printer->printer_location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="hardware_fix_perangkat_number">No Perangkat</label>
                                </div>
                                <div class="col-md-6">
                                    <input required readonly type="text" class="form-control" value="Kosong"
                                        name="hardware_fix_perangkat_number" id="hardware_fix_perangkat_number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="hard_fix_hardware_unique">Hardware ID</label>
                                </div>
                                <div class="col-md-6">
                                    <input required readonly type="text" class="form-control" value="Kosong"
                                        name="hard_fix_hardware_unique" id="hard_fix_hardware_unique">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="hard_fix_uraian">Uraian</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="hard_fix_uraian" required class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-shadow">Submit</button>
                    </div>
                    <br>
                </div>
        </div>
    @endsection
    @section('javascript')
        <script>
            $(document).ready(function() {

                // Search Box in Select
                $("#hard_fix_location").select2({
                    width: 'resolve',
                    placeholder: "Pilih Lokasi",
                    allowClear: true
                });
                $("#hard_fix_divisi").select2({
                    width: 'resolve',
                    placeholder: "Pilih Divisi",
                    allowClear: true
                });
                $("#hard_fix_hardware_name").select2({
                    width: 'resolve',
                    placeholder: "Pilih Perangkat",
                    allowClear: true
                });

                $('#hard_fix_hardware_name').on('change', function() {
                    let option = $('option:selected', this).attr("hard-number");
                    $('#hardware_fix_perangkat_number').val(option);
                    let option_id = $('option:selected', this).attr("hard-id");
                    $('#hard_fix_hardware_unique').val(option_id);
                });
            });
        </script>
    @endsection
