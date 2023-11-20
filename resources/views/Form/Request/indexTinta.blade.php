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
                        {{-- This is for Hardreq View --}}
                        @foreach ($ink as $no => $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->ink_user }}</td>
                                <td>{{ $item->ink_name }}</td>
                                <td>{{ $item->ink_printer }}</td>
                                <td>{{ ($item->ink_qty_new) - ($item->ink_qty_old)}}</td>
                                <td>{{ $item->ink_desc }}</td>
                                <td>{{ $item->ink_status }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-white" onclick="showink({{$item->id}})" title="Show Request">
                                        <i class="fas fa-desktop text-success"></i>
                                    </button>
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
                                <td>ID</td>
                                <td>
                                    <div class="col-md-12" style="padding-left: 0px !important;">
                                        <input class="form-control" name="id" id="ink_id" readonly>
                                    </div>
                                </td>
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
                           <tr class="tr-form-print-total">
                            <td>
                                Print total <span class="text-danger">*</span>
                            </td>
                            <td>
                                <div class="col-md-12" style="padding-left: 0px !important;">
                                    <input type="text" class="form-control" name="print_total" placeholder="0-9..." required>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#" id="acc_link" class="btn btn-success">Accept</a>
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

            /*INPUT PRINT TOTAL HANYA TERIMA INPUT NUMBER*/
            $("input[name=print_total]").on('input', function(e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });

        function showink(id) {
            $("#inkModal").modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

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
                    $("#ink_status").html(value.ink_status);
                    $("#ink_printer").html(value.ink_printer);
                    var dec_link="request/dec_ink/"+id_ini+"/"+ink_code+"/"+ink_total;
                    if(value.ink_status=="Request"){
                        $(".tr-form-print-total").removeClass("d-none");
                        $("input[name=print_total]").on("keyup", function() {
                            $("input[name=print_total]").val($(this).val());
                        });
                        $("#acc_link").on("click", function(e) {
                            var print_total = $("input[name=print_total]").val();
                            if(print_total!=""){
                                var acc_link="request/acc_ink/"+id_ini+"/"+print_total;
                                $("#acc_link").attr("href", acc_link);
                                $("input[name=print_total]").val("");
                                $("#inkModal").modal('hide');
                            }else if(print_total==""){
                                Swal.fire({
                                    icon: 'warning',
                                    text: "Mohon isikan Print Total pada input yang telah disediakan!"
                                });
                            }
                        });
                    }else if(value.ink_status=="add"){
                        $(".tr-form-print-total").addClass("d-none");
                        var acc_link="request/acc_ink/"+id_ini+"/0";
                        $("#acc_link").attr("href", acc_link);
                    }
                    $("#dec_link").attr("href", dec_link);
                });
            });
        }
    </script>
@endsection
