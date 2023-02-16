@extends('layout.main')
@section('title')
Permohonan Pembelian Barang
@endsection
@section('main_header')
    Permohonan Pembelian Barang
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
    color: red;
    font-size:12px;
    vertical-align: super;
}
.tt-dataset {
  background-color: rgb(153, 231, 57);
}

</style>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <button class="btn btn-primary" type="button" id="headbut">Header Utama</button>
            <button class="btn btn-secondary nextButton" type="button" id="detbut" disabled >Detail</button>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" action="{{route('procurement_store')}}" onsubmit="return validateForm()" id="myForm">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
        <div id="header">
            <div class="form-group">
                <label for="type" class="form-label">Tipe</label>
                <input required class="form-control" readonly value="create" name="tipe" type="text">
            </div>
            <div class="form-group row">
                <div class="form-group col">
                    <label for="ppb_tgl_pengajuan" class="form-label">Tanggal Pengajuan <span class="text-red">* Wajib</span></label>
                    <input required class="form-control required" value="<?php echo date('Y-m-d')?>" name="ppb_tgl_pengajuan" type="date">
                </div>
                <div class="form-group col">
                    <label for="ppb_tgl_deadline" class="form-label">Tanggal Diperlukan <span class="text-red">* Wajib</span></label>
                    <input required class="form-control required" name="ppb_tgl_deadline" type="date">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group col">
                    <label for="ppb_referensi" class="form-label">No Referensi/PO  </label>
                    <input  class="form-control" value="" name="ppb_referensi" type="text">
                </div>
                <div class="form-group col">
                    <label for="ppb_tgl_po " class="form-label">Tanggal PO/OC</label>
                    <input  class="form-control"  name="ppb_tgl_po" type="date">
                </div>
            </div>
            <div class="form-group">
                <label for="ppb_alasan " class="form-label">Nama Pelanggan <span class="text-red">* Wajib</span></label>
                <input type="text" required class="form-control required" value="{{Auth::user()->name}}"name="ppb_pelanggan">
            {{-- <input required class="form-control" value="" name="procNeed" type="text"> --}}
            </div>
            <div class="row form-group">
                <div class="form-group col">
                    <label for="ppb_pengaju" class="form-label">Nama Pengaju <span class="text-red">* Wajib</span></label>
                    {{-- <input  class="form-control"  name="ppb_pengaju" type="text" required> --}}

                    <select name="ppb_pengaju" id="procNama" class="form-control required" style="width:100%">
                        <option  required selected value="" disabled>Pilih nama pengaju</option>
                        @foreach ($kr as $kr)
                            <option>{{$kr->k_nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col">
                    <label for="ppb_divisi " class="form-label">Divisi <span class="text-red">* Wajib</span></label>
                    <select name="ppb_divisi" id="procDiv" class="form-control required" style="width:100%">
                    <option selected value="" disabled>Pilih divisi pengaju</option>
                        @foreach ($dv as $dv)
                            <option>{{$dv->div_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="row form-group">
                    <div class="form-group col">
                        <label for="ppb_proyek " class="form-label">Nama Proyek</label>
                        <input class="form-control" id="Project" value="" name="ppb_proyek" type="text">
                    </div>
                    <div class="form-group col">
                        <label for="ppb_nrp " class="form-label">NRP <span class="text-red">* Wajib</span></label>
                        <input class="form-control required" required value="" id="NRP" name="ppb_nrp" type="text">
                    </div>
                    <div class="form-group col">
                        <label for="ppb_npp " class="form-label">NPP</label>
                        <input class="form-control ppb_npp" value="" name="ppb_npp" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ppb_alasan " class="form-label">Keperluan <span class="text-red">* Wajib</span></label>
                    <textarea class="form-control required" name="ppb_alasan" id="procNeed" required></textarea>
                {{-- <input required class="form-control" value="" name="procNeed" type="text"> --}}
                </div>
                <div class="form-group">
                    <label for="ppb_catatan " class="form-label">Catatan/alamat</label>
                    <textarea class="form-control" name="ppb_catatan" id="procNeed"></textarea>
                {{-- <input required class="form-control" value="" name="procNeed" type="text"> --}}
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe <span class="text-red">* Wajib</span></label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                        <input type="radio" name="ppb_tipe" value="Inventory" class="selectgroup-input">
                        <span class="selectgroup-button">Inventory</span>
                        </label>
                        <label class="selectgroup-item">
                        <input checked type="radio" name="ppb_tipe" value="Non Inventory" class="selectgroup-input">
                        <span class="selectgroup-button">Non Inventory</span>
                        </label>
                        <label class="selectgroup-item">
                        <input type="radio" name="ppb_tipe" value="Inventory & Non" class="selectgroup-input">
                        <span class="selectgroup-button">Inventory & Non</span>
                        </label>
                    </div>
                </div>
                <h3>Tombol Next akan aktif ketika mengisi semua yang wajib </h3>
                <button class="btn btn-secondary btn-block nextButton"  disabled type="button" id="next">Next</button>
        </div>

        <div id="detail" style="display: none">
            <h1>Tambahkan barang disini</h1>
            <div class="form-group">
                <label for="">Link Template</label>
                <a href="{{route('download_file','import_ppb.xlsx')}}" class="btn btn-sm btn-primary">Disini</a>
            </div>
            <div class="form-group">
                    <label for="" class="form-label">Import (Masih percobaan)</label>
                    <div class="row">
                        <input type="file" name="import" class="form-control col-6" id="importFile">
                        <button type="button" id="removeFile" class="btn btn-warning col-6">Cancel</button>
                    </div>
            </div>
            <div class="nonimport">
                <div class=" form-group">
                    <button class="btn btn-block btn-primary"id="addrow" type="button"> Add row</button>
                </div>
                <table class="table" id="insert">
                    <thead>
                        <tr>
                            <th>Qty <span class="text-red">* Wajib</span></th>
                            <th>Satuan <span class="text-red">* Wajib</span></th>
                            <th>Deskripsi <span class="text-red">* Wajib</span></th>
                            <th>Tipe <span class="text-red">* Wajib</span></th>
                            <th>Merek <span class="text-red">* Wajib</span></th>
                            <th>Pemasok\Panel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="errorMessage" style="display: none;">Kolom deskripsi tidak boleh menggunakan titik koma ; </div>
                        <tr>
                            <td><input class="must_fill" required type="number" min=0 value="1" name="ppb_qty[]"></td>
                            <td><input class="must_fill" required type="text" value="Pcs"name="ppb_satuan[]">Pcs</td>
                            <td><textarea required type="text"class="must_fill form-control descriptions requireds" placeholder="Deskripsi"  pattern="^[^;]*$" name="ppb_deskripsi[]"></textarea></td>
                            <td><input required type="text" placeholder="Tipe"class="must_fill form-control ppb_tipe_barang" name="ppb_tipe_barang[]"></td>
                            <td><input required type="text" placeholder="Merek" class="must_fill form-control ppb_merek" name="ppb_merek[]"></td>
                            <td><input  type="text" placeholder="Referensi/Panel"name="ppb_pemasok_panel[]"></td>
                            <td><input type="button" placeholder="Delete" value="Del" onclick="del()">Delete</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn-block btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
@section('javascript')
<script>
  function del(){
    $('table').on('click', 'input[type="button"]', function(e){
   $(this).closest('tr').remove()
})
    }
    function here(){

        $text = '<tr><td><input required type="number" class="must_fill" min=0 placeholder="1"name="ppb_qty[]"></td>'+
         '<td><input class="must_fill" required type="text" placeholder="Pcs"name="ppb_satuan[]">Pcs</td>'+
         '<td><textarea required type="text" class="must_fill form-control descriptions requireds" placeholder="Deskripsi"name="ppb_deskripsi[]"></textarea></td>'+
         '<td><input required type="text" class="must_fill ppb_tipe_barang" placeholder="Tipe"name="ppb_tipe_barang[]"></td>'+
         '<td><input required type="text" placeholder="Merek" class="must_fill form-control ppb_merek" name="ppb_merek[]"></td>'+
         '<td><input type="text" placeholder="Referensi/Panel" name="ppb_pemasok_panel[]"></td>'+
         '<td><input  type="button" onclick="del()" value="Del"></td></tr>';
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
    {{-- Pada script dibawah digunakan untuk memastikan habwa NRP tidak boleh kosong atau
        diisi dengan tanda minus (-) --}}
    <script>
        function validateForm() {
          var NRP = document.getElementById("NRP").value;
          if (NRP[0] === '-' || NRP[0] === ' ') {
            alert("NRP atau Project tidak boleh menggunakan strip - ");
            return false;
          }
          return true;
        }
        </script>
        {{-- Pada script ini digunakan untuk membuat tombol detail barang tidak bisa digunakan,
            Jika data header tidak diisi terlebih dahulu --}}
    <script>
        const form = document.getElementById('myForm');
        const buttons = document.querySelectorAll('button[type="button"]');

        form.addEventListener('input', () => {
          let isDisabled = false;
          const requiredFields = document.getElementsByClassName('required');
          for (let i = 0; i < requiredFields.length; i++) {
            if (!requiredFields[i].value) {
              isDisabled = true;
              break;
            }
          }
          buttons.forEach((button) => {
            button.disabled = isDisabled;
          });
        });

      </script>

      {{-- Script ini bertujuan untuk melakukan cek apakah yang di input menggunakan simbol ;
        Jika menggunakan simbol tersebut maka akan memunculkan pesan error
        --}}
      <script>

        const form_1 = document.getElementById('myForm');
        const textareas = document.querySelectorAll('textarea.requireds');
        const errorMessage = document.getElementById('errorMessage');

        form_1.addEventListener('submit', (event) => {
          let hasError = false;
          textareas.forEach((textarea) => {
            if (textarea.value.includes(';')) {
              hasError = true;
            }
          });
          if (hasError) {
            event.preventDefault();
            errorMessage.style.display = 'block';
          }
        });

        textareas.forEach((textarea) => {
          textarea.addEventListener('input', () => {
            let hasError = false;
            textareas.forEach((textarea) => {
              if (textarea.value.includes(';')) {
                hasError = true;
              }
            });
            if (!hasError) {
              errorMessage.style.display = 'none';
            }
          });
        });
      </script>
{{-- Script ini berguna untuk menghapus kolom detail barang jika menggunakan file import --}}
      <script>
        $(document).ready(function() {
            $('#removeFile').on('click', function() {
                $('#importFile').val('');
                $('.nonimport').show();
                $('.must_fill').attr('required', true);
            });
            $('#importFile').on('change', function() {
                if ($(this).val()) {
                    $('.nonimport').hide();
                    $('.must_fill').removeAttr('required');
                } else {
                    $('.nonimport').show();
                    $('.must_fill').attr('required', true);
                }
            });
        });
      </script>
@endsection
