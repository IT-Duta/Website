@extends('layout.main')
@section('title')
    Peminjaman Alat IT - List
@endsection
@section('main_header')
    Peminjaman Alat IT - List
@endsection
@can('isAdmin')
    @section('header')
        {{-- <a href="#" class="btn btn-primary btn-round">Export</a>
        <a href="#n-primary btn-round">Import PC</a>
        <a href="#n-secondary btn-round">Add Monitor</a>
        <button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#importModal">
            Import
        </button> --}}
    @endsection
@endcan
@section('content')
    <div class="card card-shadow">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('pinjam_ait_create') }}" class="btn btn-info font-weight-bold">
                    <i class="fas fa-plus-circle"></i> Pinjam AIT
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="pinjam_ait">
                    <caption>Peminjaman Alat IT</caption>
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Alat</th>
                            <th>User</th>
                            <th width="120">
                                <div class="row align-items-center">
                                    <div class="col-md-9 text-md-center">Tanggal Pinjam</div>
                                    <div class="col-md-3 text-md-left"><i class="fas fa-question-circle fa-lg text-warning"></i></div>
                                </div>
                            </th>
                            <th width="120">
                                <div class="row align-items-center">
                                    <div class="col-md-9 text-md-center">Tanggal Kembali</div>
                                    <div class="col-md-3 text-md-left"><i class="fas fa-question-circle fa-lg text-warning"></i></th></div>
                                </div>
                            </th>
                            <th>Status</th>
                            @can('isAdmin')<th>Aksi</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($list) > 0)
                            @php $no = 1; @endphp
                            @foreach ($list as $pinjam)
                                @can('aitPinjamView', $pinjam)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="pinjam-{{ $pinjam->id }}-ait-name">{{ $pinjam->ait_name }} <span class="d-none pinjam-{{ $pinjam->id }}-ait-id">{{ $pinjam->ait_id }}</span></td>
                                        <td class="align-middle">
                                            <span class="d-none pinjam-{{ $pinjam->id }}-user-id">{{ $pinjam->user_id }}</span>
                                            <span class="pinjam-{{ $pinjam->id }}-user-name">{{ $pinjam->user_name }}</span> 
                                            <span class="badge badge-dark text-xs text-wrap p-1 pinjam-{{ $pinjam->id }}-user-email">{{ $pinjam->user_email }}</span>
                                        </td>
                                        <td width="100" class="text-center pinjam-{{ $pinjam->id }}-tanggal-pinjam">{{ $pinjam->tanggal_pinjam ? date('d-m-Y', strtotime($pinjam->tanggal_pinjam)) : '-'}}</td>
                                        <td width="100" class="text-center pinjam-{{ $pinjam->id }}-tanggal-kembali">{{ $pinjam->tanggal_kembali ? date('d-m-Y', strtotime($pinjam->tanggal_kembali)) : '-' }}</td>
                                        <td class="text-center @if($pinjam->status==0) text-white bg-danger @elseif($pinjam->status==1) text-white bg-info @elseif($pinjam->status==2) text-white bg-warning @elseif($pinjam->status==3) text-white bg-success @endif">
                                            @php
                                                if($pinjam->status==0) echo "Declined";
                                                elseif($pinjam->status==1) echo "Requested";
                                                elseif($pinjam->status==2) echo "Approved";
                                                elseif($pinjam->status==3) echo "Returned";
                                            @endphp
                                        </td>
                                        @can('isAdmin')
                                            <td class="text-center">
                                                <a id="pinjam-{{ $pinjam->id }}-show-request" class="btn btn-sm btn-primary text-white m-1" onclick="showPinjam({{ $pinjam->id }})"
                                                    data-ait="{{ $pinjam->ait_id }}"
                                                    data-description="{{ $pinjam->description }}"
                                                    data-peminjam="{{ $pinjam->submitted_by }}"
                                                    data-penerima="{{ $pinjam->received_by ? $pinjam->received_by : '-' }}"
                                                    data-status="{{ $pinjam->status }}"
                                                >
                                                    <i class="fas fa-search-plus" data-toggle="tooltip" data-placement="top" title="Show Data"></i>
                                                </a>
                                                <form action="{{ route('pinjam_ait_destroy', $pinjam->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Are you sure want to delete {{ $pinjam->id }} ?');" class="btn btn-sm btn-danger text-white m-1"
                                                        data-id={{ $pinjam->id }}
                                                    >
                                                        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Data"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endcan
                                    </tr>
                                @endcan
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal modal-show-request fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title">Pinjam Alat IT</h3>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover table-bordered table-xs mb-0">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">#ID</td>
                                <td class="id-pinjam"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">NAMA ALAT</td>
                                <td class="nama-alat"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">PENGAJU</td>
                                <td class="pengaju"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">EMAIL</td>
                                <td class="email"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">DESKRIPSI</td>
                                <td class="deskripsi"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div> 

@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#pinjam_ait').DataTable();
        });

        function showPinjam(id){
            $(".modal-show-request").modal({
                backdrop: "static",
                keyboard: false,
                show: true,
            });

            var pinjamID = id;
            var aitID = $("#pinjam-"+pinjamID+"-show-request").attr("data-ait");
            var aitName = $(".pinjam-"+pinjamID+"-ait-name").text();
            var userId = $(".pinjam-"+pinjamID+"-user-id").text();
            var userName = $(".pinjam-"+pinjamID+"-user-name").text();
            var email = $(".pinjam-"+pinjamID+"-user-email").text();
            var description = $("#pinjam-"+pinjamID+"-show-request").attr("data-description");
            var status = parseInt($("#pinjam-"+pinjamID+"-show-request").attr("data-status"));
            $(".id-pinjam").text("#"+pinjamID);
            $(".nama-alat").text(aitName);
            $(".pengaju").text(userName);
            $(".email").text(email);
            $(".deskripsi").text(description);
            if(status===1) {
                var modalFooter = '<a id="accept" href="#" role="button" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Approve </a>'+
                    '<a id="decline" href="#" role="button" class="btn btn-sm btn-secondary"><i class="fa fa-window-close"></i> Decline</a>';
                $(".modal-footer").removeClass('d-none');
                $(".modal-footer").html(modalFooter);
                var acc_link = "/inventaris/alat-it/pinjam/accept/"+pinjamID+"/ait/"+aitID+"/user/"+userId;
                var dec_link = "/inventaris/alat-it/pinjam/decline/"+pinjamID+"/ait/"+aitID;
                $("#accept").attr("href", acc_link);
                $("#decline").attr("href", dec_link);
            } else if(status===2) {
                var modalFooter = '<a id="returned" href="#" role="button" class="btn btn-sm btn-primary"><i class="fas fa-undo-alt"></i> Dikembalikan</a>';
                $(".modal-footer").removeClass('d-none');
                $(".modal-footer").html(modalFooter);
                var returned_link = "/inventaris/alat-it/pinjam/return/"+pinjamID+"/ait/"+aitID+"/user/"+userId;
                $("#returned").attr("href", returned_link);
            } else {
                $(".modal-footer").addClass('d-none');
            }
        };
    </script>
@endsection
