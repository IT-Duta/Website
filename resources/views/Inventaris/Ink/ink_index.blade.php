@extends('layout.main')
@section('title')
    Inventaris Tinta
@endsection
@section('main_header')
    Inventaris Tinta
@endsection
@can('isIT')
    @section('header')
        <a href="{{ route('ink_create') }}" class="btn btn-secondary btn-round">Add Ink</a>
        <a href="{{ route('ink_export') }}" class="btn btn-secondary btn-round">Export Ink</a>
    @endsection
@endcan
@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-pills-icons" id="pills-tab-with-icon" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon"
                        role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                        <i class="fas fa-print"></i>
                        Printer
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab"
                        aria-controls="pills-home-icon" aria-selected="true">
                        <i class="fas fa-pen-nib"></i>
                        Tinta
                    </a>
                </li>
            </ul>
            {{-- Isi dari Nav Pills --}}
            <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                {{-- Isi dari Nav Tinta --}}
                <div class="tab-pane fade" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                    <div class="table-responsive text-center ">
                        <table class="table table-striped table-bordered" id="ink_master">
                            <caption>Inventaris Tinta</caption>
                            <thead>
                                <tr class="table-primary">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $nomor = 1; ?>

                                @foreach ($ink as $list)
                                    <tr class="{{ $list->ink_qty == 0 ? 'bg-warning' : '' }}">

                                        <td><?php echo $nomor; ?></td>
                                        <td>{{ $list->ink_code }}</td>
                                        <td>{{ $list->ink_name }}</td>
                                        <td>{{ $list->ink_qty }}</td>
                                        <td>
                                            <button id="{{ $list->ink_unique }}req" ink_code="{{ $list->ink_code }}"
                                                ink_name="{{ $list->ink_name }}" ink_qty="{{ $list->ink_qty }}"
                                                ink_type="Request" onClick="request_data('{{ $list->ink_unique }}')"
                                                ink_unique={{ $list->ink_unique }} type="button"
                                                class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#request_modal">
                                                Request
                                            </button>
                                            @can('isAdmin')
                                                <button id="{{ $list->ink_unique }}add" ink_code="{{ $list->ink_code }}"
                                                    ink_name="{{ $list->ink_name }}" ink_qty="{{ $list->ink_qty }}"
                                                    ink_type="Add" ink_printer="-" ink_unique={{ $list->ink_unique }}
                                                    onClick="add_data('{{ $list->ink_unique }}')" type="button"
                                                    class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#addition_modal">
                                                    Add
                                                </button>
                                                <a href="{{ route('ink_edit', $list->ink_unique) }}"
                                                    class="btn btn-sm btn-danger">Edit</a>
                                                <a href="{{ route('ink_del', $list->ink_unique) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            @endcan
                                        </td>
                                    </tr>
                                    <?php $nomor++; ?>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                {{-- Isi dari Nav Printer --}}
                <div class="tab-pane fade  show active" id="pills-profile-icon" role="tabpanel"
                    aria-labelledby="pills-profile-tab-icon">
                    <div class="table-responsive text-center ">
                        <table class="table table-striped table-bordered" id="printer_master">
                            <thead>
                                <tr class="table-primary">
                                    <th>No</th>
                                    <th>Printer Number</th>
                                    <th>Printer Name</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor = 1; ?>
                                @foreach ($printer as $printer)
                                    <tr>
                                        <td><?php echo $nomor++; ?></td>
                                        <td>{{ $printer->printer_number }}</td>
                                        <td>{{ $printer->printer_name }}</td>
                                        <td>{{ $printer->printer_location }}</td>
                                        <td>
                                            <button id="{{ $printer->printer_unique }}req" type="button"
                                                class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#request_modal_print"
                                                onClick="request_ink('{{ $printer->printer_unique }}')">
                                                Request
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Ajukan Tinta by Tinta-->


    <div class="modal fade" id="request_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="header"></div>
                <div class="modal-body">
                    <form action="{{ route('ink_update') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <p class="alert alert-danger">{{ $errors->first() }}</p>
                        @endif
                        <div class="form-group row">
                            <div class="col">
                                <label for="type" class="form-label">Input Type</label>
                                <input type="text" name="type" id="edit" value="update" readonly
                                    class="form-control" />
                            </div>
                            <div class="col">
                                <label for="process" class="form-label">Input Process</label>
                                <input type="text" name="process" id="process" value="" readonly
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="ink_unique" class="form-label">Ink Unique</label>
                                <input type="text" name="ink_unique" id="ink_unique" value="" readonly
                                    class="form-control" />
                            </div>
                            <div class="col">
                                <label for="ink_user" class="form-label col-md-3">Pengaju</label>
                                <input type="text" name="ink_user" id="ink_user" value="{{ Auth::user()->name }}"
                                    readonly class="form-control col-md" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="ink_code" class="form-label">Kode Tinta</label>
                                <input type="text" name="ink_code" id="ink_code" readonly class="form-control" />
                            </div>
                            <div class="col">
                                <label for="ink_name" class="form-label col-md-3">Nama Tinta</label>
                                <input type="text" name="ink_name" id="ink_name" readonly
                                    class="form-control col-md" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="ink_qty_old" class="form-label">Saat Ini</label>
                                <input type="text" name="ink_qty_old" id="ink_qty_old" readonly
                                    class="form-control col-md" />
                            </div>
                            <div class="col">
                                <label for="ink_qty_new" class="form-label">Permintaan</label>
                                <input type="number" required name="ink_qty_new" id="ink_qty_new"
                                    class="form-control col-md" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-label" for="lokasi">Printer</label>
                            <div id="ink_printer_unique"></div>
                        </div>
                        <div class="form-group row">
                            <label for="ink_desc" class="form-label col-md-3">Alasan Permintaan</label>
                            <input type="text"required name="ink_desc" class="form-control col-md" />
                        </div>
                        <div class="form-group row">
                            <label for="ink_status" class="form-label col-md-3"> Ink Status</label>
                            <input type="text" name="ink_status" id="ink_status" readonly
                                class="form-control col-md" />
                        </div>
                        <div id="btntype">
                            <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->

    <!-- Modal for Penambahan Stock Tinta-->


    <div class="modal fade" id="addition_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="header">
                    <h2>Tambah Stock</h2>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ink_update') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <p class="alert alert-danger">{{ $errors->first() }}</p>
                        @endif
                        <div style="display: none">
                            <input name="ink_status" value="add" />
                            <input name="type" value="update" />
                            <input name="process" value="add" />
                            <input name="ink_unique" id="add_unique" />
                            <input name="ink_user" value="{{ Auth::user()->name }}" />
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">
                                <label for="ink_code" class="form-label">Kode Tinta</label>
                                <input type="text" name="ink_code" id="add_code" readonly class="form-control" />
                            </div>
                            <div class="col-md-5">
                                <label for="ink_name" class="form-label">Nama Tinta</label>
                                <input type="text" name="ink_name" id="add_name" readonly
                                    class="form-control col-md" />
                            </div>
                            <div class="col-md-2">
                                <label for="ink_qty_old" class="form-label">Qty Sekarang</label>
                                <input type="text" name="ink_qty_old" id="add_qty_old" readonly
                                    class="form-control col-md" />
                            </div>
                            <div class="col-md-2">
                                <label for="ink_qty_new" class="form-label">Tambah Qty</label>
                                <input type="number" required name="ink_qty_new" id="ink_qty_new"
                                    class="form-control col-md" />
                            </div>
                        </div>
                        <div class="form-group row col-md-12">
                            <label for="ink_desc" class="form-label col-md-2">Catatan</label>
                            <input type="text"required name="ink_desc" class="form-control col-md-10" />
                        </div>
                        <br>
                        <div id="btntype">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->

    <!-- Modal for Ajukan Tinta by Tinta-->
    <div class="modal fade" id="request_modal_print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="header_print"></div>
                <div class="modal-body">
                    <form action="{{ route('ink_update') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <p class="alert alert-danger">{{ $errors->first() }}</p>
                        @endif
                        <div class="form-group row">
                            <div class="col">
                                <label for="type" class="form-label">Input Type</label>
                                <input type="text" name="type" value="update" readonly class="form-control" />
                            </div>
                            <div class="col">
                                <label for="process" class="form-label">Input Process</label>
                                <input type="text" name="process" value="min" readonly class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="form-label col-md-3" for="ink_printer_unique_print">Printer</label>
                                <input type="text" name="ink_printer_unique" id="ink_printer_unique_print" readonly
                                    class="form-control" />
                            </div>
                            <div class="col">
                                <label for="ink_status" class="form-label col-md-3"> Ink Status</label>
                                <input type="text" name="ink_status" value="Request" readonly class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="ink_unique" class="form-label">Ink Unique</label>
                                <input type="text" name="ink_unique" id="ink_unique_print" value="" readonly
                                    class="form-control" />
                            </div>
                            <div class="col">
                                <label for="ink_user" class="form-label col-md-3">Pengaju</label>
                                <input type="text" readonly name="ink_user" value="{{ Auth::user()->name }}" required
                                    class="form-control col-md" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="ink_code" class="form-label">Kode Tinta</label>
                                <div id='ink_code_print'></div>

                            </div>
                            <div class="col">
                                <label for="ink_name" class="form-label col-md-3">Nama Tinta</label>
                                <input type="text" name="ink_name" id="ink_name_print" readonly
                                    class="form-control col-md" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="ink_qty_old" class="form-label">Saat Ini</label>
                                <input type="text" name="ink_qty_old" id="ink_qty_old_print" readonly
                                    class="form-control col-md" />
                            </div>
                            <div class="col">
                                <label for="ink_qty_new" class="form-label">Permintaan</label>
                                <input type="number" required name="ink_qty_new" id="ink_qty_new_print" min="1"
                                    class="form-control col-md" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ink_desc" class="form-label col-md-3">Alasan Permintaan</label>
                            <input type="text" required name="ink_desc" class="form-control col-md" />
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('javascript')
    <script id="dataTables">
        $(document).ready(function() {

            $('#ink_master').DataTable();
            $('#printer_master').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        });
    </script>
    <script id="forModalData">
        function request_data(clicked_id) {
            $.get('{{ route('ink_getData') }}', {
                'passdata': clicked_id
            }, function(response) {
                htmldata = '<select name="ink_printer_unique" class="form-control col-md" required>';
                $.each($.parseJSON(response), function(key, value) {
                    htmldata += '<option value="' + value.printer_unique + '">' + value.printer_name +
                        '</option>';
                });
                htmldata += '</select>';
                $("#ink_printer_unique").html(htmldata);
            });
            let clicked = clicked_id + "req";
            let ink_unique = document.getElementById(clicked).getAttribute("ink_unique");
            let ink_code = document.getElementById(clicked).getAttribute("ink_code");
            let ink_name = document.getElementById(clicked).getAttribute("ink_name");
            let ink_qty = document.getElementById(clicked).getAttribute("ink_qty");
            let ink_type = document.getElementById(clicked).getAttribute("ink_type");
            $("#ink_unique").val(ink_unique);
            $("#ink_code").val(ink_code);
            $("#ink_name").val(ink_name);
            $("#ink_qty_old").val(ink_qty);
            $("#ink_type").val(ink_type);
            $("#ink_status").val("Request");
            $("#process").val("min");
            $("#header").html("<h3>Request</h3>");
            $("#ink_qty_new").attr({
                max: ink_qty
            });
        }

        function add_data(clicked_id) {
            let clicked = clicked_id + "add";
            let add_unique = document.getElementById(clicked).getAttribute("ink_unique");
            let add_code = document.getElementById(clicked).getAttribute("ink_code");
            let add_name = document.getElementById(clicked).getAttribute("ink_name");
            let add_qty = document.getElementById(clicked).getAttribute("ink_qty");
            let add_type = document.getElementById(clicked).getAttribute("ink_type");
            $("#add_unique").val(add_unique);
            $("#ink_printer_unique").html(
                "<input type='text' name='ink_printer_unique' readonly required class='form-control  col-md' value='Kosong'> "
            )
            $("#add_code").val(add_code);
            $("#add_name").val(add_name);
            $("#add_qty_old").val(add_qty);
            $("#ink_type").val(ink_type);
            $("#ink_status").val("Add");
            $("#process").val("add");
            $("#header").html("<h3>Add</h3>");
            $("#ink_printer_unique").html("<option selected>Kosong</option>");
        }

        function request_ink(clicked_id) {
            $("#header_print").html("<h3>Request by Printer</h3>");
            $("#ink_printer_unique_print").val(clicked_id);

            $.get('{{ route('ink_getData') }}', {
                'passdata': clicked_id
            }, function(response) {
                htmldata =
                    '<select name="ink_code" onchange="getCodeInk()" id="ink_code_search" class="form-control" required><option></option>';
                $.each($.parseJSON(response), function(key, value) {
                    htmldata += '<option>' + value.ink_code + '</option>';
                });
                htmldata += '</select>';
                $("#ink_code_print").html(htmldata);
            });

        }

        function getCodeInk() {
            let x = document.getElementById("ink_code_search").value;
            $.get('{{ route('ink_getData') }}', {
                'passdata': x
            }, function(response) {
                $.each($.parseJSON(response), function(key, value) {
                    $("#ink_unique_print").val(value.ink_unique);
                    $("#ink_name_print").val(value.ink_name);
                    $("#ink_qty_old_print").val(value.ink_qty);
                    $("#ink_qty_new_print").attr({
                        max: value.ink_qty
                    });
                });
            });
        }
    </script>
@endsection
