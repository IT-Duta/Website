@extends('layout.main')
@section('title')
    List PPB
@endsection
@section('main_header')
    List PPB
@endsection
@section('head')
    <style>
        .selesai{
background-color: greenyellow;
        }
        .batal{
background-color: rgb(75, 74, 74);
color: white;
}
.menunggu{
    background-color: rgb(83, 83, 195);
    color: white;
        }
        .diterima{
background-color: yellow;
        }
        td.selesai,td.diterima{
            color: black;
        }
    </style>
@endsection
@section('header')
      {{-- <button type="button" class="btn btn-success btn-round" data-toggle="modal" data-target="#importKaryawan">
        Import Karyawan
      </button>
      --}}
      <a href="{{route('procurement_create')}}" class="btn btn-primary btn-round" >
        Buat PPB Baru
      </a>
      {{-- @if (Auth::user()->divisi =="PROCUREMENT") --}}
      <a href="{{route('procurement_export')}}" class="btn btn-primary btn-round" >
        Export PPB
    </a>
    {{-- @endif --}}
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">List PPB</h3>
            <button id="tunggu" type="button" class="btn btn-sm menunggu">Tunggu</button>
            <button id="diterima" type="button" class="btn btn-sm selesai">Diterima</button>
            <button id="selesai" type="button" class="btn btn-sm diterima">Selesai</button>
            <button id="batal" type="button" class="btn btn-sm batal">Batal</button>
            <button id="coa" type="button" class="btn btn-sm btn-danger">COA Belum diisi</button>
            <button id="all" type="button" class="btn btn-sm btn-success">Reset</button>

            {{-- <button type="button" class="menunggu btn" id="menunggu">PPB Menunggu</button>
            <button type="button" class="diterima btn " id="diterima">PPB Diterima</button> --}}
            {{-- <button type="button" class="bg-danger btn text-white" id="belum_coa">COA belum di input</button> --}}
        </div>
        <div class="card-body">

            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered display" id="list_ppb">
                    <caption>List Karyawan</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>#</th>
                            <th>No</th>
                            <th>Status</th>
                            <th>NO PPB</th>
                            <th>Tgl PPB</th>
                            <th>Tgl Diperlukan</th>
                            <th>Nama</th>
                            <th>Inventory/Non Inventory</th>
                            <th>Keperluan</th>
                            <th>Divisi</th>
                            <th>Project</th>
                            <th>NRP</th>
                            <th>NPP</th>
                            <th>Aksi</th>
                            <th>COA</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $nomor = 1; ?>

                        @foreach ($list as $list)
                            @php
                                if ($list->ppb_status =="Batal") {
                                    $button = "disabled";
                                }
                                else {
                                    $button = "";
                                }
                                switch ($list->ppb_status) {
                                    case 'Batal':
                                        $stats_row='batal';
                                        break;
                                    case 'Selesai':
                                    $stats_row='selesai';
                                        break;
                                    case 'Diterima':
                                    $stats_row='diterima';
                                        break;
                                    case 'Menunggu':
                                    $stats_row='menunggu';
                                        break;
                                    default:
                                    $stats_row='';
                                        break;
                                }
                                switch ($list->ppb_tipe) {
                                    case 'Non Inventory':
                                        if ($list->ppb_coa == "") {
                                            $rowCol="bg-danger text-white need_coa";
                                            $statsCoa="Butuh";
                                        }else {
                                            $rowCol="udah_coa";
                                            $statsCoa="";
                                        }
                                        break;
                                    case 'Inventory & Non':
                                    if ($list->ppb_coa == "") {
                                            $rowCol="bg-danger text-white need_coa";
                                            $statsCoa="Butuh";
                                        }else {
                                            $rowCol="udah_coa";
                                            $statsCoa="";
                                        }
                                        break;
                                    break;
                                    default:
                                        $rowCol="udah_coa";
                                        $statsCoa="";
                                        break;
                                }

                            @endphp
                        <tr class="{{$rowCol}}" data-status="{{$stats_row}}">
                            <td>
                                <button type="button" {{$button}} class="btn btn-primary btn-sm" data-toggle="modal" data-target="#daftarBarangModal" onClick="request_data('{{ $list->id_pengajuan }}')">
                                    PRINT
                                </button>
                                @can('isPROCUREMENT')
                                <a class="btn btn-primary btn-sm" href="{{route('procurement_exportIndv',['id' =>$list->id_pengajuan])}}">
                                    Export
                                </a>
                                @endcan
                            </td>
                            <td><?php echo $nomor++; ?></td>
                            <td class="{{$stats_row}}">{{ $list->ppb_status }}</td>
                            <td>{{ $list->ppb_no }}</td>
                            <td>{{ $list->ppb_tgl_pengajuan }}</td>
                            <td>{{ $list->ppb_tgl_deadline }}</td>
                            <td>{{ $list->ppb_pengaju }}</td>
                            <td>{{ $list->ppb_tipe }}</td>
                            <td>{{ $list->ppb_alasan }}</td>
                            <td>{{ $list->ppb_divisi }}</td>
                            <td>{{ $list->ppb_proyek }}</td>
                            <td>{{ $list->ppb_nrp }}</td>
                            <td>{{ $list->ppb_npp }}</td>
                            <td>
                                {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#daftarBarangModal" onClick="request_data('{{ $list->id_pengajuan }}')">
                                    Detail
                                  </button> --}}
                                  <a href="{{route('procurement_edit',$list->id_pengajuan)}}" onclick="return confirm('Edit PPB No {{ $list->ppb_no }} ?');"
                                    class="btn btn-success btn-sm">Edit</a>
                                    @can('isPROCUREMENT')
                                    <button type="button" class="btn btn-primary btn-sm" onclick="givedata('{{$list->id_pengajuan}}')"data-toggle="modal" data-target="#changeStatusModal">
                                        Status
                                      </button>
                                    @endcan
                            </td>
                            <td>
                                {{$statsCoa}}
                            </td>
                            </tr>
                            @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

{{-- Modal Detail Barang--}}
<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="daftarBarangModal" tabindex="-1" aria-labelledby="daftarBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="daftarBarangModalLabel">Detail Barang</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <a href="#" id="linkprint" class="btn btn-sm btn-block btn-primary" target="_blank" rel="noopener noreferrer">Print</a>
            <table id="showdata" class="table">
                <thead>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Detail</th>
                    <th>Tipe</th>
                    <th>Merek</th>
                </thead>
                <tbody>
                    <div id="addhere"></div>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <div class="link-here">

            </div>
            {{-- <a href="#" class="btn btn-primary">Terima</a> --}}
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
  <div>
    {{-- {{Auth::user();}} --}}
  </div>

{{-- Modal change status --}}

<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('ppb_status') }}">
                @csrf
                <div class="form-group">
                  <label for="Change">Status</label>
                  <input type="text" class="form-control" id="modalPengajuan" name="id_pengajuan" readonly ">
                  <input type="text" class="form-control" name="status" readonly value="Diterima">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- End modal change Status --}}
  @endsection
@section('javascript')
<script>
    $(document).ready(function() {
        let table = $('#list_ppb').DataTable({
            dom: 'lpftrip'
        });



        $("#tunggu").click(function(){
            table.column(14).search("").draw();
            table.column(2).search("Menunggu").draw();
        });
        $("#selesai").click(function(){
            table.column(14).search("").draw();
            table.column(2).search("Selesai").draw();
        });
        $("#diterima").click(function(){
            table.column(14).search("").draw();
            table.column(2).search("Diterima").draw();
        });
        $("#batal").click(function(){
            table.column(14).search("").draw();
            table.column(2).search("Batal").draw();
        });
        $("#coa").click(function(){
            table.column(2).search("").draw();
            table.column(14).search("Butuh").draw();
        });
        $("#all").click(function(){
            table.column(2).search("").draw();
            table.column(14).search("").draw();
        });
    });
</script>
<script>
    function request_data(clicked_id) {
        $("#linkprint").attr("href", "/procurement/ppb/form/"+clicked_id)

        $.get('{{ route('procurement_getData') }}', {
            'passdata': clicked_id
        }, function(response) {
                $("#showdata tbody tr").remove();
                htmldata='';
                // id='';
            $.each($.parseJSON(response), function(key, value) {
                htmldata += '<tr><td>' + value.ppb_qty + '</td>'+
                    '<td>'+value.ppb_satuan+'</td>'+
                    '<td>'+value.ppb_deskripsi+'</td>'+
                    '<td>'+value.ppb_tipe_barang+'</td>'+
                    '<td>'+value.ppb_merek+'</td>'+
                    '</tr>';
            });
            $("#showdata").append(htmldata);
        });
    }
</script>
<script>
   function givedata(id){
    $("#modalPengajuan").val(id);
   }
</script>
@endsection
