@extends('layout.main')
@section('title')
    Permintaan Hardware
@endsection
@section('main_header')
    Permintaan Hardware
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-body">
            <form method='post' action="{{ route('hard_req_update') }}" enctype="multipart/form-data">
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
                                <input readonly name="hard_req_number" type="text" value="{{ $nomorform }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="hard_req_user">Nama Pengaju</label>
                                <input type="text" readonly value="{{ Auth::user()->name }}" class="form-control"
                                    name="hard_req_user">
                            </div>
                            <div class="form-group">
                                <label for="Tanggal">Tanggal</label>
                                <input readonly name="trDate" type="text" value="{{ date('d/m/Y') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row col-md-12">
                            <div class="form-group">
                                <label for="hard_req_referensi">Nomor Referensi</label>
                                <input name="hard_req_referensi" type="text" value="Kosong" class="form-control"
                                    data-toggle="tooltip" data-placement="top" title="Nomor Referensi Perbaikan Hardware">
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <select required name="hard_req_location" id="hard_req_location"
                                    class="form-control custom-select" style="width:100%">
                                    <option disabled selected value="">-- Pilih --</option>
                                    @foreach ($lokasi as $list)
                                        <option>{{ $list->loc_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hard_req_divisi">Divisi</label>
                                <select required name="hard_req_divisi" id="hard_req_divisi"
                                    class="form-control custom-select" style="width:100%">
                                    <option disabled selected value="">-- Pilih --</option>
                                    @foreach ($divisi as $list)
                                        <option>{{ $list->div_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_barang">Template</label>
                                <select onChange="showData(this)" id="jenis_barang" class="form-control custom-select"
                                    style="width:100%">
                                    <option selected value="">-- Pilih --</option>
                                    <option value="reset">Reset</option>
                                    @foreach ($template as $list)
                                        <option value="{{ $list->id }}">{{ $list->template_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <h5 class="card-title">Rincian Permintaan</h5>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_mainboard">Mainboard</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_mainboard" id="hard_req_mainboard">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_processor">Processor</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_processor" id="hard_req_processor">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="hard_req_memory">Memory</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_memory" id="hard_req_memory">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="hard_req_hdd">Hard Disk</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_hdd" id="hard_req_hdd">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="hard_req_ssd">SSD</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_ssd" id="hard_req_ssd">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_vga">VGA</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_vga" id="hard_req_vga">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_casing">Casing</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_casing" id="hard_req_casing">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_keyboard">Keyboard</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_keyboard" id="hard_req_keyboard">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_mouse">Mouse</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_mouse" id="hard_req_mouse">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_monitor">Monitor</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_monitor">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hard_req_printer">Printer</label>
                                    <input type="text" placeholder="Merk - Specs" class="form-control"
                                        name="hard_req_printer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Informasi Lainnya</h5>
                        <br>
                        <div class="mb-3 row col-md-12">
                            <div class="form-group col-md-6">
                                <label for="hard_req_other">Permintaan Lainnya</label>
                                <textarea class="form-control" name="hard_req_other">Tidak Ada</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hard_req_alasan">Alasan Permintaan</label>
                                <textarea required class="form-control" name="hard_req_alasan"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-shadow">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $("#hard_req_location").select2();
            $("#hard_req_divisi").select2();
        });
    </script>
    <script>
        function showData(id) {
            if (id.value === "reset") {
                $("#hard_req_name").val("");
                $("#hard_req_mainboard").val("");
                $("#hard_req_processor").val("");
                $("#hard_req_memory").val("");
                $("#hard_req_hdd").val("");
                $("#hard_req_ssd").val("");
                $("#hard_req_vga").val("");
                $("#hard_req_casing").val("");
                $("#hard_req_keyboard").val("");
                $("#hard_req_mouse").val("");
            } else {

                $.get('{{ route('template_data') }}', {
                    'id': id.value
                }, function(response) {
                    $.each($.parseJSON(response), function(key, value) {
                        $("#hard_req_name").val(value.template_name);
                        $("#hard_req_mainboard").val(value.template_mainboard);
                        $("#hard_req_processor").val(value.template_processor);
                        $("#hard_req_memory").val(value.template_memory);
                        $("#hard_req_hdd").val(value.template_hdd);
                        $("#hard_req_ssd").val(value.template_ssd);
                        $("#hard_req_vga").val(value.template_vga);
                        $("#hard_req_casing").val(value.template_casing);
                        $("#hard_req_keyboard").val(value.template_keyboard);
                        $("#hard_req_mouse").val(value.template_mouse);
                    });
                });
            }
        }
    </script>
@endsection
