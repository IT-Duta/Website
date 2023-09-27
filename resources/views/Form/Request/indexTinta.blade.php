@extends('layout.main')
@section('title')
    List Request
@endsection
@section('main_header')
    List Request
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">List Request</h3>
        </div>
        <div class="card-body">
            <div class="text-center ">
                <table class="table table-striped table-bordered display table-responsive" id="list_request">
                    <caption>List Request</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>ID</th>
                            <th>Pengaju</th>
                            <th>Tinta</th>
                            <th>Printer</th>
                            <th>Jumlah</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Tanggal Aju</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $nomor = 1; ?>
                        {{-- This is for Hardreq View --}}
                        @foreach ($ink as $ink)
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td>{{ $ink->id }}</td>
                                <td>{{ $ink->ink_user }}</td>
                                <td>{{ $ink->ink_name }}</td>
                                <td>{{ $ink->ink_printer }}</td>
                                <td>{{ ($ink->ink_qty_new) - ($ink->ink_qty_old)}}</td>
                                <td>{{ $ink->ink_desc }}</td>
                                <td>{{ $ink->ink_status }}</td>
                                <td>{{ $ink->created_at }}</td>
                                <td>
                                    <a onclick="showink({{$ink->id}})" data-toggle="modal" data-target="#inkModal" class="text-success">
                                        <i class="fas fa-desktop" data-toggle="tooltip"
                                        data-placement="top" title="Show Request"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>


    <div class="modal fade" id="inkModal" tabindex="-1" aria-labelledby="inkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inkModalLabel">Show Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <table class="table table-stripped">
                       <thead>
                           <th>#</th>
                           <th>Keterangan</th>
                       </thead>
                       <tbody>
                           <tr>
                               <td>Id</td>
                               <td><input class="form-control" name="id" id="ink_id" readonly></td>
                           </tr>
                           <tr>
                               <td>Pengaju</td>
                               <td><span id="ink_user"></span></td>
                           </tr>
                           <tr>
                               <td>Kode Tinta</td>
                               <td><span id="ink_code"></span></td>
                           </tr>
                           <tr>
                               <td>Nama Tinta</td>
                               <td><span id="ink_name"></span></td>
                           </tr>
                           <tr>
                               <td>Jumlah Permintaan</td>
                               <td><span id="ink_total"></span></td>
                           </tr>
                           <tr>
                               <td>Nama Printer</td>
                               <td><span id="ink_printer"></span></td>
                           </tr>
                           <tr>
                                <form action="" id="acc_link" enctype="multipart/form-data" validate>
                                <td>
                                    Print total <span class="text-danger">*</span>
                                </td>
                                    <td>
                                        <div class="col-md-12" style="padding-left: 0px !important;">
                                            <input id="print_total" type="number" class="form-control" name="print_total" value="{{ old('print_total') }}" placeholder="0-999,999..." required>
                                        </div>
                                    </td>
                                </div>
                           </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Accept</button>
                    </form>
                    <a href="#" id="dec_link" class="btn btn-danger">Decline</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- End Modal Ink--}}
@endsection

@section('javascript')
    <script id="dataTables">
        $(document).ready(function() {
            $('#list_request').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        });
    </script>
    <script>
        function showink(id) {
            $.get('{{ route('ink_data') }}', {
                'id': id
            }, function(response) {
                $.each($.parseJSON(response), function(key, value) {
                    var id_ini = value.id;
                    $("#ink_id").val(id_ini);
                    $("#ink_user").html(value.ink_user);
                    var ink_code=value.ink_code;
                    $("#ink_code").html(ink_code);
                    $("#ink_name").html(value.ink_name);
                    var ink_total=value.ink_qty_old - value.ink_qty_new;
                    $("#ink_total").html(ink_total);
                    $("#ink_printer").html(value.ink_printer);
                    var link="request/acc_ink/"+id_ini;
                    var link2="request/dec_ink/"+id_ini+"/"+ink_code+"/"+ink_total;
                    $("#acc_link").attr("action",link);
                    $("#dec_link").attr("href",link2);
                });
            });
        }

    </script>

@endsection
