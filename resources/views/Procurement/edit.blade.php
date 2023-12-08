@extends('layout.main')
@section('title')
PPB: {{$pph->ppb_no}}
@endsection
@section('main_header')
    {{$pph->ppb_no}}
@endsection
@section('head')
<style>
    table td {
  position: relative;
}

table td input {
  position: absolute;
  display: block;
  top:0;
  left:0;
  margin: 0;
  height: 100%;
  width: 100%;
  border: none;
  padding: 10px;
  box-sizing: border-box;
}
.text-red{
    color:red;
    font-size:12px;
    vertical-align: super;
}
</style>
@endsection
@section('content')
    <div class="card card-shadow">

        <div class="card-header">
            <button class="btn btn-primary" type="button" id="headbut">Header Utama</button>
            <button class="btn btn-secondary" type="button" id="detbut">Detail</button>
            {{-- <button class="btn btn-secondary" type="button" id="coabut">COA</button> --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coaModal">
                COA
              </button>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" action="{{route('procurement_store')}}">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
        <div id="header">
            <div class="form-group row">
                <div class="form-group col">
                    <label for="type" class="form-label">Tanggal Selesai</label>
                    <input class="form-control" value="{{$pph->ppb_tgl_selesai}}" name="ppb_tgl_selesai" type="date">
                </div>
                <div class="form-group col">
                    <?php $status = $pph->ppb_status;
                    if ($status=="Menunggu") {
                        $wstatus="checked";
                    }else {
                        $wstatus="";
                    }
                    if ($status=="Diterima") {
                        $dstatus="checked";
                    }else {
                        $dstatus="";
                    }
                    if ($status=="Selesai") {
                        $sstatus="checked";
                    }else {
                        $sstatus="";
                    }
                    if ($status=="Batal") {
                        $bstatus="checked";
                    }else {
                        $bstatus="";
                    }
                    ?>
                    <input type="hidden" id="stats" value="{{$status}}">
                    <label class="form-label">Status</label>

                    @cannot("isPROCUREMENT")
                    <input type="text" class="form-control" name="ppb_status" readonly value="{{$status}}">
                    @endcannot

                    @can('isPROCUREMENT')
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="ppb_status" value="Menunggu" <?php echo $wstatus;?> class="selectgroup-input">
                            <span class="selectgroup-button">Menunggu</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="ppb_status" value="Diterima" <?php echo $dstatus;?>  class="selectgroup-input">
                            <span class="selectgroup-button">Diterima</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="ppb_status" value="Selesai" <?php echo $sstatus;?>  class="selectgroup-input">
                            <span class="selectgroup-button">Selesai</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="ppb_status" value="Batal" <?php echo $bstatus;?>  class="selectgroup-input">
                            <span class="selectgroup-button">Batal</span>
                        </label>
                    </div>
                    @endcan
                    {{-- @endcan --}}
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group col">
                    <label for="type" class="form-label">Tipe</label>
                    <input required class="form-control" readonly value="edit" name="tipe" type="text">
                </div>
                <div class="form-group col">
                    <label for="type" class="form-label">Id</label>
                    <input required class="form-control" readonly value="{{$pph->id_pengajuan}}" name="id_pengajuan" type="text">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group col">
                    <label for="ppb_tgl_pengajuan" class="form-label">Tanggal Pengajuan <span class="text-red">* Wajib</span></label>
                    <input required class="form-control"  value="{{$pph->ppb_tgl_pengajuan}}" name="ppb_tgl_pengajuan" type="date">
                </div>
                <div class="form-group col">
                    <label for="ppb_tgl_deadline" class="form-label">Tanggal Diperlukan <span class="text-red">* Wajib</span></label>
                    <input required class="form-control" value="{{$pph->ppb_tgl_deadline}}" name="ppb_tgl_deadline" type="date">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group col">
                    <label for="ppb_referensi" class="form-label">No Referensi/PO  </label>
                    <input  class="form-control" value="{{$pph->ppb_referensi}}" name="ppb_referensi" type="text">
                </div>
                <div class="form-group col">
                    <label for="ppb_tgl_po " class="form-label">Tanggal PO/OC</label>
                    <input  class="form-control" value="{{$pph->ppb_tgl_po}}" name="ppb_tgl_po" type="date">
                </div>
            </div>
            <div class="form-group">
                <label for="ppb_alasan " class="form-label">Nama Pelanggan <span class="text-red">* Wajib</span></label>
                <input type="text" required class="form-control" value="{{$pph->ppb_pelanggan}}" name="ppb_pelanggan">
            {{-- <input required class="form-control" value="" name="procNeed" type="text"> --}}
            </div>
            <div class="row form-group">
                <div class="form-group col">
                    <label for="ppb_pengaju" class="form-label">Nama Pengaju <span class="text-red">* Wajib</span></label>
                    <select name="ppb_pengaju" id="procNama" class="form-control" style="width:100%">
                        @foreach ($kr as $kr)
                        {{-- <option >{{$pph->ppb_pengaju}}</option> --}}
                            <option <?php echo ($pph->ppb_pengaju == $kr->k_nama) ? "selected" :  "" ; ?>>{{$kr->k_nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col">
                    <label for="ppb_divisi " class="form-label">Divisi <span class="text-red">* Wajib</span></label>
                    <select name="ppb_divisi" id="procDiv" class="form-control" style="width:100%">
                    <option selected>{{$pph->ppb_divisi}}</option>
                        @foreach ($dv as $dv)
                            <option>{{$dv->div_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="row form-group">
                    <div class="form-group col">
                        <label for="ppb_proyek " class="form-label">Nama Proyek</label>
                        <input class="form-control" value="{{$pph->ppb_proyek}}" name="ppb_proyek" type="text">
                    </div>
                    <div class="form-group col">
                        <label for="ppb_nrp " class="form-label">NRP <span class="text-red">* Wajib</span></label>
                        <input class="form-control" value="{{$pph->ppb_nrp}}" name="ppb_nrp" type="text">
                    </div>
                    <div class="form-group col">
                        <label for="ppb_npp " class="form-label">NPP</label>
                        <input class="form-control" value="{{$pph->ppb_npp}}" name="ppb_npp" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ppb_alasan " class="form-label">Keperluan <span class="text-red">* Wajib</span></label>
                    <textarea class="form-control" name="ppb_alasan" required id="procNeed">{{$pph->ppb_alasan}}</textarea>
                {{-- <input required class="form-control" value="" name="procNeed" type="text"> --}}
                </div>
                <div class="form-group">
                    <label for="ppb_catatan " class="form-label">Catatan/alamat</label>
                    <textarea class="form-control" name="ppb_catatan" id="procNeed">{{$pph->ppb_catatan}}</textarea>
                {{-- <input required class="form-control" value="" name="procNeed" type="text"> --}}
                </div>
                <div class="form-group">
                    <?php $tipe = $pph->ppb_tipe;
                    if ($tipe=="Inventory") {
                        $inv="checked";
                    }else {
                        $inv="";
                    }
                    if ($tipe=="Non Inventory") {
                        $ninv="checked";
                    }else {
                        $ninv="";
                    }
                    if ($tipe=="Inventory & Non") {
                        $nninv="checked";
                    }else {
                        $nninv="";
                    }
                    ?>
                    <label class="form-label">Tipe  <span class="text-red">* Wajib</span></label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                        <input type="radio" name="ppb_tipe" value="Inventory" <?php echo $inv;?> class="selectgroup-input">
                        <span class="selectgroup-button">Inventory</span>
                        </label>
                        <label class="selectgroup-item">
                        <input type="radio" name="ppb_tipe" value="Non Inventory" <?php echo $ninv;?>  class="selectgroup-input">
                        <span class="selectgroup-button">Non Inventory</span>
                        </label>
                        <label class="selectgroup-item">
                        <input type="radio" name="ppb_tipe" value="Inventory & Non" <?php echo $nninv;?>  class="selectgroup-input">
                        <span class="selectgroup-button">Inventory & Non</span>
                        </label>
                    </div>
                </div>
                <button class="btn btn-secondary btn-block" type="button" id="next">Next</button>
        </div>

        <div id="detail" style="display: none">
            <h1>Tambahkan barang disini</h1>
            <div class=" form-group">
                <button class="btn btn-block btn-primary"id="addrow" type="button" onclick="return confirm('Yakin ingin menambahkan Baris?')"> Add row</button>
            </div>
            <table class="table" id="insert">
                <thead>
                    <tr>
                        <th>Qty <span class="text-red">* Wajib</span></th>
                        <th>Satuan <span class="text-red">* Wajib</span></th>
                        <th>Deskripsi <span class="text-red">* Wajib</span></th>
                        <th>Tipe <span class="text-red">* Wajib</span></th>
                        <th>Merek <span class="text-red">* Wajib</span></th>
                        <th>Referensi/Panel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ppd as $ppd)

                    <tr>
                        <td>
                            <input type="hidden"value="{{$ppd->id}}" name="ppb_id[]">
                            <input required type="number" step="any" min=0 value="{{$ppd->ppb_qty}}" name="ppb_qty[]"></td>
                        <td><input required type="text" value="{{$ppd->ppb_satuan}}"name="ppb_satuan[]">Pcs</td>
                        <td><textarea required type="text" class="form-control" placeholder="Deskripsi"name="ppb_deskripsi[]">{{$ppd->ppb_deskripsi}}</textarea></td>
                        <td><input required type="text" value="{{$ppd->ppb_tipe_barang}}" placeholder="Tipe"name="ppb_tipe_barang[]"></td>
                        <td><input required type="text" value="{{$ppd->ppb_merek}}" placeholder="Merek"name="ppb_merek[]"></td>
                        <td><input type="text" value="{{$ppd->ppb_pemasok_panel}}" placeholder="Refernsi/Panel"name="ppb_pemasok_panel[]"></td>
                        <td>
                            {{-- <input type="button" placeholder="Delete" value="Del" onclick="del()">Delete --}}
                            <a href="{{route('procurement_delbarang',$ppd->id)}}" name="" class="del_but btn btn-danger"
                                onclick="return confirm('Jika dihapus tidak akan kembali, yakin ingin hapus {{ $ppd->ppb_deskripsi}} ?');">
                                Del</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group mt-3">
                <button id="SubmitBut"type="submit" class="btn-block btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="coaModal" tabindex="-1" aria-labelledby="coaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="coaModalLabel">Masukkan COA</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" enctype="multipart/form-data" action="{{route('procurement_store')}}">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <div class="form-group row">

                    <label for="ppb_tgl_pengajuan" class="col-3 col-form-label">Tanggal COA</label>
                    <input required class="form-control col-9" value="<?php echo date('Y-m-d')?>" name="ppb_tgl_coa" type="date" id="tgl_coa">
                </div>
            <div class="form-group row">
                <label for="COA" class="col-3 col-form-label">No. COA</label>

                    <input class="form-control" value="{{$pph->id_pengajuan}}" name="id_pengajuan" type="hidden">
                  <input type="hidden" name="tipe" class="form-control-plaintext" required value="coa">
                  <input type="text" name="ppb_coa"class="form-control col-9" required value="{{$pph->ppb_coa}}"placeholder="Masukkan COA" id="ppb_coa">
              </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="but_coa">Save changes</button>
        </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
<script>
  function del(){
    $('table').on('click', 'input[type="button"]', function(e){
   $(this).closest('tr').remove()
})
    }
    function here(){

        $text = '<tr><td>'+
         '<input type="hidden" name=ppb_id[]>'+
        '<input type="number" required min=0 placeholder="1"name="ppb_qty[]"></td>'+
         '<td><input required type="text" placeholder="Pcs"name="ppb_satuan[]">Pcs</td>'+
         '<td><input required type="text" placeholder="Deskripsi"name="ppb_deskripsi[]"></td>'+
         '<td><input required type="text" placeholder="Tipe"name="ppb_tipe_barang[]"></td>'+
         '<td><input required type="text" placeholder="Merek"name="ppb_merek[]"></td>'+
         '<td><input type="text" placeholder="Referensi/Panel"name="ppb_pemasok_panel[]"></td>'+
         '<td><input type="button" onclick="del()" value="Del"></td></tr>';
         // '<input type="button" value="Add" onclick="return here()">
         $('#insert > tbody:last-child').append($text);
    };
       $('#addrow').on('click', function(e){
            here();
        });
</script>
<script>
    $(document).ready(function() {
        $("#procDiv").select2();
        $("#procNama").select2();
        // $("#hard_req_divisi").select2();
    });
</script>
  <script>
    $('#headbut').on('click', function(e){
        $("#header").css({display:"block"});
        $("#detail").css({display:"none"});
});
    $('#detbut').on('click', function(e){
        $("#header").css({display:"none"});
        $("#detail").css({display:"block"});
});
    $('#next').on('click', function(e){
        $("#header").css({display:"none"});
        $("#detail").css({display:"block"});
});
  </script>
<script>
    $(document).ready(function(){
        var current=$("#stats").val();
        if (current =="Selesai") {
            $("input[type='text']").attr("readonly", true);
            $("input[type='date']").attr("readonly", true);
            $("input[type='number']").attr("readonly", true);
            $("input[name='ppb_tipe']").attr("disabled", true);
            $("a.del_but").hide();
            $("textarea").attr("readonly", true);
            $("#addrow").attr("disabled", true);
            $("#procDiv").attr("disabled", true);
            $("#procNama").attr("disabled", true);
            $("#SubmitBut").attr("disabled", true);
            $("#tgl_coa").attr("readonly", false);
            $("#ppb_coa").attr("readonly", false);
        }
    })
</script>
@endsection
