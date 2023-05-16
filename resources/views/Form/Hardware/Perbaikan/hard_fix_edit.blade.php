@extends('layout.main')
@section('head')
    <script src="{{ asset('plugins/accountingnumber/accounting.min.js') }}"></script>
@endsection
@section('title')
    Update Perbaikan Hardware - {{ $list->hard_fix_number }}
@endsection
@section('main_header')
    Update Perbaikan Hardware - {{ $list->hard_fix_number }}
@endsection

@section('content')
    <div class="card card-shadow">
        <div class="card-body">
            <div id="accordionOne">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#hardware_general"
                                aria-expanded="false" aria-controls="hardware_general">General</button>
                        </h5>
                    </div>

                    <div id="hardware_general" class="collapse" aria-labelledby="headingOne" data-parent="#accordionOne">
                        <div class="card-body">
                            <form method='post' action="{{ route('hard_fix_update') }}" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                @if ($errors->any())
                                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                                @endif
                                <div class="d-none">
                                    <input required readonly type="text" class="form-control" value="general"
                                        name="typecase" id="typecase">
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <div class="form-group row">
                                            <label for="hardware_fix_tanggal" class="col-md">Tanggal
                                                Pengajuan</label>
                                            <input required class="col-md form-control" value="{{ $list->created_at }}"
                                                name="hardware_fix_tanggal" type="text" readonly>
                                        </div>
                                        <div class="form-group row">
                                            <label for="hard_fix_user" class="col-md">Nama User</label>
                                            <input readonly required type="text" class="col-md form-control"
                                                name="hard_fix_user" value="{{ $list->hard_fix_user }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group row">
                                            <label for="hard_fix_divisi" class="col-md">Divisi</label>
                                            <input readonly required type="text" class="col-md form-control"
                                                name="hard_fix_divisi" value="{{ $list->hard_fix_divisi }}">
                                        </div>
                                        <div class="form-group row">
                                            <label for="hard_fix_location" class="col-md">Lokasi</label>
                                            <input readonly required type="text" class="col-md form-control"
                                                name="hard_fix_location" value="{{ $list->hard_fix_location }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-md-3">Type</label>
                                    <input required readonly type="text" class="col-md form-control" name="type"
                                        value="edit">
                                </div>
                                <div class="form-group row">
                                    <label for="hard_fix_hardware_name" class="col-md-3">Perangkat</label>
                                    <input required readonly type="text" class="col-md form-control"
                                        value="{{ $list->hard_fix_hardware_name }}" name="hard_fix_hardware_name"
                                        id="hard_fix_hardware_name">
                                </div>

                                <div class="form-group row">
                                    <label for="hard_fix_hardware_unique" class="col-md-3">Hardware ID</label>
                                    <input required readonly type="text" class="col-md form-control"
                                        value="{{ $list->hard_fix_hardware_unique }}" name="hard_fix_hardware_unique"
                                        id="hard_fix_hardware_unique">
                                </div>

                                <div class="form-group row">
                                    <label for="hardware_fix_number" class="col-md-3">No Perbaikan</label>
                                    <input required readonly type="text" class="col-md form-control"
                                        value="{{ $list->hard_fix_number }}" name="hardware_fix_number"
                                        id="hardware_fix_number">
                                </div>

                                <div class="form-group row">
                                    <label for="hard_fix_general_unique" class="col-md-3">Perbaikan ID</label>
                                    <input required readonly type="text" class="col-md form-control"
                                        value="{{ $list->hard_fix_general_unique }}" name="hard_fix_general_unique"
                                        id="hard_fix_general_unique">
                                </div>

                                <div class="form-group row">
                                    <label for="hard_fix_uraian" class="col-md-3">Uraian</label>
                                    <textarea name="hard_fix_uraian" required class="col-md form-control">{{ $list->hard_fix_uraian }}</textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="hard_fix_analisa" class="col-md-3">Analisa</label>
                                    <textarea name="hard_fix_analisa" required class="col-md form-control">{{ $list->hard_fix_analisa }}</textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="hard_fix_penyelesaian" class="col-md-3">Penyelesaian</label>
                                    <textarea name="hard_fix_penyelesaian" required class="col-md form-control">{{ $list->hard_fix_penyelesaian }}</textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="hard_fix_status" class="col-md-3">Status</label>
                                    <select class="custom-select col-md" name="hard_fix_status">
                                        <option>{{ $list->hard_fix_status }}</option>
                                        <option value="Progress">Progress</option>
                                        <option value="Finish">Finish</option>
                                        <option value="Batal">Batal</option>
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <label for="Tanggal" class="col-md-3">Tanggal Progress</label>
                                    <input name="hard_fix_progress" type="text" class="form-control col-md"
                                        value="{{ $list->hard_fix_progress }}">
                                </div>

                                <div class="form-group row">
                                    <label for="Tanggal" class="col-md-3">Tanggal Finish</label>
                                    <input name="hard_fix_finish" type="text" class="form-control col-md"
                                        value="{{ $list->hard_fix_finish }}">
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="accordionTwo">
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-primary btn-block" data-toggle="collapse"
                                data-target="#hardware_detail" aria-expanded="false" aria-controls="hardware_detail">
                                Detail
                            </button>
                        </h5>
                    </div>

                    <div id="hardware_detail" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionTwo">
                        <div class="card-body">
                            <div class="d-flex justify-content-end py-1">

                                <button id="btnpass" type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    passtomodal="{{ $list->hard_fix_general_unique }}" data-target="#newData">
                                    Tambah
                                </button>
                            </div>
                            <table class=" table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th>No</th>
                                        <th>Jenis Perbaikan</th>
                                        <th>Keterangan</th>
                                        <th>Vendor</th>
                                        <th>Biaya</th>
                                        <th>Tanggal Perbaikan</th>
                                        <th>Tanggal Input</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor = 1; ?>
                                    @foreach ($detail as $detail)
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td>{{ $detail->hard_fix_kind }}</td>
                                            <td>{{ $detail->hard_fix_desc }}</td>
                                            <td>{{ $detail->hard_fix_vendor }}</td>
                                            <td name="harga">{{ $detail->hard_fix_price }}</td>
                                            <td>{{ $detail->hard_fix_date }}</td>
                                            <td>{{ $detail->created_at }}</td>
                                            <td><a class="btn btn-sm btn-danger"
                                                    href="{{ route('hard_fix_del_det', $detail->id) }}">Delete</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <hr />
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="newData" tabindex="-1" role="dialog" aria-labelledby="newDataLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newDataLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-lg">
                        <form method='post' action="{{ route('hard_fix_update') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            @if ($errors->any())
                                <p class="alert alert-danger">{{ $errors->first() }}</p>
                            @endif
                            <div class=" form-group row">
                                <label for="type" class=" col">Tipe</label>
                                <input name="type" type="text" required value="detail" readonly
                                    class="form-control col">
                            </div>
                            <div class=" form-group row">
                                <label for="hardware_fix_unique_id" class=" col">Perbaikan ID </label>
                                <input id="hard_fix_general_unique_modal" name="hard_fix_general_unique" type="text"
                                    required readonly class="form-control col">
                            </div>
                            <div class=" form-group row">
                                <label for="hard_fix_date" class=" col">Tanggal Perbaikan</label>
                                <input id="hard_fix_date" name="hard_fix_date" type="date" required
                                    class="form-control col">
                            </div>
                            <div class="form-group row">
                                <label for="hard_fix_kind" class=" col">Jenis Perbaikan</label>
                                <select required name="hard_fix_kind" class="col-md custom-select form-control">
                                    <option>Spare Part</option>
                                    <option>Jasa</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="hard_fix_desc" class=" col">Keterangan</label>
                                <input name="hard_fix_desc" type="text" placeholder="Detail" required
                                    class="form-control col">
                            </div>
                            <div class="form-group row">
                                <label for="hard_fix_vendor" class="col">Vendor</label>
                                <input name="hard_fix_vendor" type="text" placeholder="Internal/Nama Vendor" required
                                    class="form-control col">
                            </div>
                            <div class="form-group row">
                                <label for="hard_fix_price" class="col">Biaya</label>
                                <input name="hard_fix_price" type="number" required class="form-control col">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {

            // Search Box in Select
            $("#hardware_fix_location").select2();

            $("#btnpass").on("click", function() {
                let valueID = $("#btnpass").attr("passtomodal");
                $("#hard_fix_general_unique_modal").val(valueID);
            });
        });
    </script>
    <script>
        let loops = document.getElementsByName("harga").length;
        for (let i = 0; i < loops; i++) {
            let hargaid = document.getElementsByName('harga')[i].innerText;
            let
                convert = accounting.formatMoney(hargaid, {
                    symbol: "Rp. ",
                    thousand: ".",
                    decimal: ",",
                });
            document.getElementsByName('harga')[i].innerText = convert;
        }
    </script>
@endsection
