@extends('layout.main')
@section('title')
    Daftar Panel
@endsection
@section('head')
<link rel="stylesheet" href="{{asset('css/panel-index.css')}}">
<style>
    .time{
        width: 100px;
        border: 0px transparent;
    }
    .timeline-row.selected {
    background-color: lightblue;
}
.show{
 display: revert;
}
.hidden{
    display: none;
}
.highlight{
    background-color: gray;
}
</style>
@endsection
@section('header')
<a href="{{route('pn_01_create')}}" target="_BLANK" rel="noopener" class="btn btn-round btn-success">Tambah Panel</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body">

        <a href="{{route('pn_00_index')}}" class="btn btn-sm btn-secondary mx-3">Team</a>
        <a href="{{route('pn_01_index')}}" class="btn btn-sm btn-secondary mx-3">P3C</a>
        <a href="{{route('pn_02_index')}}" class="btn btn-sm btn-secondary mx-3">Produksi</a>
        <a href="{{route('pn_03_index')}}" class="btn btn-sm btn-secondary mx-3">QC</a>
        <a href="{{route('pn_05_index')}}" class="btn btn-sm btn-secondary mx-3">Logistik</a>
        <a href="{{route('pn_04_index')}}" class="btn btn-sm btn-secondary mx-3">Engineer</a>
    </div>
</div>
<div class="row">
    <div class="col-8">
            <div class="card mx-0 px-0">
                <div class="card-body">
                    <button id="Tunggu" type="button" class="btn btn-sm btn-primary">Tunggu</button>
                    <button id="Progress" type="button" class="btn btn-sm btn-primary">Progress</button>
                    <button id="Test-QC" type="button" class="btn btn-sm btn-primary">Test QC</button>
                    <button id="On_Test" type="button" class="btn btn-sm btn-primary">On Test</button>
                    <button id="Selesai_Test" type="button" class="btn btn-sm btn-primary">Selesai Test</button>
                    <button id="Tunda" type="button" class="btn btn-sm btn-primary">Tunda</button>
                    <button id="eng" type="button" class="btn btn-sm btn-primary">Rating Plate</button>
                    <button id="all" type="button" class="btn btn-sm btn-primary">Reset</button>

                    <table class="table table-stripped table-responsive px-0 mx-0" id="list_panel">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>No. WO</th>
                                <th>Proyek</th>
                                <th>Nama Panel</th>
                                <th>Nomor Seri</th>
                                <th>Customer</th>
                                <th>Status Panel</th>
                                <th>Rating Plate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $list)
                            <tr  class="timeline-row">
                                <td>
                                    {{-- <button class="btn btn-sm btn-primary btn-round" onclick="timelineView({{$list->id}})">
                                        View
                                    </button> --}}
                                    <button class="btn btn-sm btn-primary btn-round" onclick="timelineView(this, {{$list->id}})">
                                        View
                                    </button>
                                </td>
                                <td>
                                    {{$list->nomor_wo}}
                                </td>
                                <td>
                                    {{$list->nama_proyek}}
                                </td>
                                <td>
                                    {{$list->nama_panel}}
                                </td>
                                <td>
                                    {{$list->nomor_seri_panel}}
                                </td>
                                <td>
                                    {{$list->nama_customer}}
                                </td>
                                <td>
                                    {{$list->status_pekerjaan}}
                                </td>
                                <td>
                                    {{$list->det_engineering}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="col-4">
        <h3 id="show_status"></h3>
            <div class="">
                <div class="">
                    <div class="page">
                        {{-- New Timeline 1 --}}
                        <div class="timeline">
                            <div class="timeline__group">
                                <button class="timeline__year time" aria-hidden="true">P3c</button>
                                <a class="btn btn-primary btn-sm" target="_BLANK" rel="noopener" id="p3c_edit">Edit</a>
                                <div class="timeline__cards">
                                    <div class="timeline__card card">
                                        <div class="card__content">
                                                    <p id="nomor_seri_panel"></p>
                                                    <p id="nama_customer"></p>
                                                    <p id="nomor_wo"></p>
                                                    <p id="jenis_panel"></p>
                                                    <p id="tipe_panel"></p>
                                                    <p id="deadline_produksi"></p>
                                                    <p id="nama_panel"></p>
                                                    <p id="nama_proyek"></p>
                                                    <p id="cell"></p>
                                                    <p id="jenis_tegangan"></p>
                                                    <p id="mfd"></p>
                                                    <p id="deadline_qc_pass"></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End TImeline 1 --}}
                        {{-- New Timeline 2 --}}
                        <div class="timeline">
                            <div class="timeline__group">
                                <button class="timeline__year time" aria-hidden="true">Produksi</button>
                                {{-- <a class="hidden btn btn-primary" id="produksi_create" >Create</a> --}}
                                <a class="btn btn-sm btn-primary" target="_BLANK" rel="noopener" id="produksi_create" >Create</a>
                                <div class="timeline__cards">
                                    <div class="timeline__card card">
                                        <div class="card__content">
                                            <p id="spv"></p>
                                                    <p id="wiring"></p>
                                                    <p id="tgl_serah_ke_qc"></p>
                                                    <p id="mekanik"></p>
                                                    <p id="status_komponen"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End TImeline 2 --}}
                        {{-- New Timeline 3 --}}
                        <div class="timeline">
                            <div class="timeline__group">
                                <button class="timeline__year time" aria-hidden="true">QC</button>
                                {{-- <a class="hidden btn btn-primary" id="qc_create" >Create</a> --}}
                                <a class="btn btn-sm btn-primary" target="_BLANK" rel="noopener" id="qc_create" >Create</a>
                                <div class="timeline__cards">
                                    <div class="timeline__card card">
                                        <div class="card__content">
                                            <p id="tgl_terima_dr_produksi"></p>
                                            <p id="catatan_test"></p>
                                            <p id="test_tgl_awal"></p>
                                            <p id="picTestQc"></p>
                                            <p id="status_test_qc"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End TImeline 3 --}}
                        {{-- New Timeline 3 --}}
                        <div class="timeline">
                            <div class="timeline__group">
                                <button class="timeline__year time" aria-hidden="true">Logistik</button>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" id="logistik_create" data-target="#LogistikModal">
                                    Create
                                </button>
                                <div class="timeline__cards">
                                    <div class="timeline__card card">
                                        <div class="card__content">
                                                    <p id="tgl_dari_qc"></p>
                                                    <p id="tgl_kirim"></p>
                                                    <p id="surat_jalan"></p>
                                                    <p id="keterangan"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End TImeline 3 --}}
                        {{-- New Timeline 3 --}}
                        <div class="timeline">
                            <div class="timeline__group">
                                <button class="timeline__year time" aria-hidden="true">Eng</button>
                                <a class="btn btn-sm btn-primary"  target="_BLANK" rel="noopener" id="eng_create" >Create</a>
                                <a class="btn btn-sm btn-primary" target="_BLANK" rel="noopener" id="eng_edit" >Edit</a>

                                <div class="timeline__cards">
                                    <div class="timeline__card card">
                                        <div class="card__content">
                                                    <p id="capacity"></p>
                                                    <p id="ampere"></p>
                                                    <p id="ip"></p>
                                                    <p id="voltage"></p>
                                                    <p id="phasa_3"></p>
                                                    <p id="frekuensi"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End TImeline 3 --}}
                    </div>
                </div> {{-- End Card-body--}}
            </div>{{-- End Card --}}
    </div>
</div>

{{-- Modal Terkirim --}}
  <!-- Modal -->
  <div class="modal fade" id="LogistikModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Logistik</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method='post' action="{{ route('pn_05_store') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <input type="hidden" readonly class="form-control" name="id_panel" id="panel_logistik">
                <div class="form-group">
                    <label for="">Nama Panel</label>
                    <input type="text" readonly class="form-control" id="nama_panel_logistik">
                </div>
                <div class="form-group">
                    <label for="">Nomor Panel</label>
                    <input type="text" readonly class="form-control" id="nomor_panel_logistik">
                </div>
                <div class="form-group">
                    <label for="">Tanggal dari QC</label>
                    <input type="datetime-local" name="tgl_dari_qc" readonly class="form-control" id="tgl_dari_qc">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Kirim <span class="text-red">*Wajib</span></label>
                    <input type="date" required class="form-control" name="tgl_kirim" id="tgl_panel_logistik">
                </div>
                <div class="form-group">
                    <label for="">Nomor Surat Jalan <span class="text-red">*Wajib</span></label>
                    <input type="text" required class="form-control" name="surat_jalan" id="sj_panel_logistik">
                </div>
                <div class="form-group">
                    <label for="">BAKK <span class="text-red">*Optional</span> </label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan_panel_logistik">
                    {{-- <textarea name="keterangan" id="keterangan_panel_logistik" class="form-control" cols="30" rows="10"></textarea> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
      </div>
    </div>
  </div>
{{-- End Modal Terkirim --}}
@endsection
@section('javascript')
<script>
    $(document).ready(function() {
        $('#list_panel').DataTable({
            autoWidth: true
        });
        $('#p3c_edit').hide();
        $('#qc_create').hide();
        $('#produksi_create').hide();
        $('#eng_create').hide();
        $('#eng_edit').hide();
        $('#logistik_create').hide();
        // Load Page every 10 Minutes
        setInterval(function(){
        location.reload();
        }, 600000);

        var table= $('#list_panel').DataTable();
        $("#Tunggu").click(function(){
            table.column(7).search("").draw();
            table.column(6).search("Tunggu").draw();
        });
        $("#Progress").click(function(){
            table.column(7).search("").draw();
            table.column(6).search("Progress").draw();
        });
        $("#Test-QC").click(function(){
            table.column(7).search("").draw();
            table.column(6).search("Test-QC").draw();
        });
        $("#On_Test").click(function(){
            table.column(7).search("").draw();
            table.column(6).search("On Test").draw();
        });
        $("#Selesai_Test").click(function(){
            table.column(7).search("").draw();
            table.column(6).search("Selesai Test").draw();
        });
        $("#Tunda").click(function(){
            table.column(7).search("").draw();
            table.column(6).search("Tunda").draw();
        });
        $("#eng").click(function(){
            table.column(6).search("").draw();
            table.column(7).search("done").draw();
    });
    $("#all").click(function(){
            table.column(6).search("").draw();
            table.column(7).search("").draw();
        });
    });
</script>
<script>
    function timelineView(element, data){
    // Remove the selected class from all rows
        const rows = document.querySelectorAll('.timeline-row');
        rows.forEach(row => row.classList.remove('selected'));
        // Add the selected class to the clicked row
        element.closest('.timeline-row').classList.add('selected');
        $.get("{{route('pn_00_timeline')}}",
            {'data' : data},
            function(hasil){
                console.log(hasil);
                    // console.log(hasil.id_pp,hasil.id_qc);
                $("#show_status").text("Lokasi : "+hasil.panel_status.toUpperCase()+" - " +capitalizeAndReplace(hasil.status_pekerjaan))
                switch (hasil.status_pekerjaan) {
                    case 'Tunggu':
                        // Ini untuk cek apakah masuk Progress Produksi
                        $('#produksi_create').attr('href', '/panel/produksi/create/'+hasil.id_pp).text("Create").show();
                        $('#qc_create').hide();
                        $('#p3c_edit').hide();
                        $('#logistik_create').hide();
                    break;
                    case 'Progress':
                        $('#produksi_create').attr('href', '/panel/produksi/edit-'+hasil.id_pd).text("Edit").show();
                        $('#qc_create').hide();
                        $('#p3c_edit').hide();
                        $('#logistik_create').hide();
                    break;
                    case 'Test-QC':
                        $('#qc_create').attr('href', '/panel/qc/create/'+hasil.id_pp).text("Create").show();
                        $('#produksi_create').hide();
                        $('#p3c_edit').hide();
                        $('#logistik_create').hide();
                    break;
                    case 'On Test':
                        $('#qc_create').attr('href', '/panel/qc/edit-'+hasil.id_qc).text("Edit").show();
                        $('#produksi_create').hide();
                        $('#p3c_edit').hide();
                        $('#logistik_create').hide();
                    break;
                    case 'Selesai Test':
                        $('#logistik_create').show();
                        $('#panel_logistik').val(hasil.id_pp);
                        $('#nama_panel_logistik').val(hasil.nama_panel);
                        $('#nomor_panel_logistik').val(hasil.nomor_seri_panel);
                        $('#tgl_dari_qc').val(hasil.actual_qc_pass);
                        $('#p3c_edit').hide();
                        $('#produksi_create').hide();
                        $('#qc_create').hide();
                        $('#eng_edit').hide();
                    break;
                    default:
                        $('#qc_create').hide();
                        $('#produksi_create').hide();
                        $('#p3c_edit').hide();
                        $('#logistik_create').hide();
                    break;
                }
                if(hasil.det_engineering =="done"){
                    $('#eng_create').hide();
                    $('#eng_edit').attr('href', '/panel/eng/edit_data-'+hasil.id_pp).show();
                }
                else{
                        $('#eng_create').attr('href', '/panel/eng/create/'+hasil.id_pp).show();
                        $('#eng_edit').hide();
                }
                    // '/panel/eng/create/{id}'
                $.each(hasil, function(key, value) {
                    $('#'+ key).text(capitalizeAndReplace(key) + ' : '+value);
                });
            }
        );
    }
</script>
<script>
    function capitalizeAndReplace(string) {
    string = string.replace(/_/g, ' ');
        return string.replace(/\b\w/g, function(l) { return l.toUpperCase() });
    }
</script>
<script>
    // get the buttons and the timeline divs
    const buttons = document.querySelectorAll('.time');
    const timelineDivs = document.querySelectorAll('.timeline__cards');
    // loop through the buttons and add a click event listener to each one
    buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
        // toggle the .show class on the corresponding timeline div
            timelineDivs[index].classList.toggle('show');
        });
    });
</script>
@endsection
