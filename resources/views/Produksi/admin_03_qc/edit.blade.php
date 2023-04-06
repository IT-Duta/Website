@extends('layout.main')
@section('title')
    Edit Panel QC
@endsection
@section('head')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" --}}
<style>
  .form-check {
    float: left;
  }

  textarea {
    clear: both;
  }

    button#floating {
    position: fixed;
    right: 35px;
    bottom: 10px;
    border-radius: 50%;
    width: 75px;
    height: 75px;
    animation: bounce 0.8s;
  animation-direction: alternate;
  animation-iteration-count: infinite;
}

@keyframes bounce {
  0% { transform: translateY(0); }
  100% { transform: translateY(-30px); }
}
</style>
@endsection
@section('main_header')
    Edit Panel - {{$list->nomor_seri_panel}}
@endsection
@section('content')
    <div class="card card-shadow">

        <div class="card-body">

            <form method='post' action="{{ route('pn_03_update') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <input type="hidden" name="id" value="{{$list->id}}">
                <input type="hidden" name="id_panel" value="{{$list->id_panel}}">
                <hr>
                <h2>Panel</h2>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">Nama Customer</label>
                                <input name="nama_customer" readonly type="text" value="{{$list->nama_customer}}" class="form-control" id="namaCustomer" placeholder="Enter Nama Customer">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">Nama Proyek</label>
                                <input name="nama_proyek" readonly type="text" value="{{$list->nama_proyek}}" class="form-control" id="namaProyek" placeholder="Enter Nama Proyek">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaPanel">Nama Panel</label>
                                <input name="nama_panel"readonly type="text" value="{{$list->nama_panel}}" class="form-control" id="namaPanel" placeholder="Enter Nama Panel">
                            </div>
                        </div>
                    </div>
                </div>
                <button id="addTest" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addTestModal">
                    Tambah Test
                </button>
                {{-- <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#viewTestModal">
                    View Detail Test
                </button> --}}
                <hr>
                <h2>Detail</h2>
                <hr>
                <div class="form-group">
                    <label for="actual_qc_pass" class="form-label">Tanggal Terima dari Produksi<span class="text-red">*Wajib</span></label>
                    {{-- <input type="date" id="tgl_terima_dr_produksi" name="tanggal_test" class="form-control" /> --}}
                    <input required readonly name="tgl_terima_dr_produksi" type="datetime-local" value="{{$list->tgl_terima_dr_produksi}}" class="form-control" id="tgl_terima_dr_produksi">
                  </div>



                  <input type="hidden" value="{{$list->panel_status}}" id="currStats">
                  <div class="mb-3 row" id="StasWork">
                    <label for="kirim_email" class="col-sm-4 col-form-label">Status Test QC <span class="text-red">*Wajib</span></label>
                    <div class="selectgroup w-100 col-sm-8">
                        <label class="selectgroup-item">
                            <input type="radio" required name="status_test_qc" value="On Test" <?php echo ($list->status_test_qc=="On Test") ? "checked " : " " ; ?> class="selectgroup-input status_test_qc">
                            <span class="selectgroup-button">On Test</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status_test_qc" value="Selesai Test" <?php echo ($list->status_test_qc=="Selesai Test") ? "checked " : " " ; ?> class="selectgroup-input status_test_qc">
                            <span class="selectgroup-button">Selesai Test</span>
                        </label>
                    </div>
                </div>
                <div id="actual_section">
                    <div class="form-group">
                        <label class="form-label">Aktual QC Pass <span class="text-red">*Wajib</span></label>
                        <input type="datetime-local" name="actual_qc_pass" id="actual_qc_pass" class="form-control" value="{{$list->actual_qc_pass}}">
                    </div>
                </div>
                <div class="form-group" id="pictest">

                    <label class="form-label">PIC Test <span class="text-red">*Wajib</span></label>
                    <input type="text" class="form-control" name="picTestQc" value="{{$list->picTestQc}}">
                </div>
                <!-- Form group containing the textarea input field -->
                <div class="form-group">
                    <label for="catatan_test" class="form-label">Catatan Hasil QC Test <span class="text-red">*Wajib</span></label>
                    <textarea id="catatan_test" name="catatan_test" class="form-control" rows="10">{{$list->catatan_test}}</textarea>
                  </div>
                  <button class="btn btn-sm btn-success btn-block" onclick="return confirm('Udah yakin semua datanya benar?')" type="submit">Submit</button>
                  <button class="btn btn-sm btn-danger shadow" id="floating" onclick="return confirm('Yakin ingin reset ulang?')" type="reset">Reset</button>
            </form>




            </div> <!-- End of card-body -->
        </div><!-- End Card -->
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="viewTestModal" tabindex="-1" aria-labelledby="viewTestModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="viewTestModalLabel">Detail Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width:200px;">Tanggal</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor=1;?>
                            @foreach ($detail as $detail)
                            <tr>
                                <td>{{$nomor++;}}</td>
                                <td>{{$detail->tgl_test}}</td>
                                <td>{{$detail->catatan_test}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addTestModal" tabindex="-1" aria-labelledby="addTestModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addTestModalLabel">Tambah Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form method='post' action="{{ route('pn_03_store_detail') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <p class="alert alert-danger">{{ $errors->first() }}</p>
                        @endif
                        <input type="hidden" name="id_test" value="{{$list->id}}">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-5 col-form-label">Tanggal Test <span class="text-red">*wajib</span></span></label>
                            <div class="col-sm-7">
                                <input type="datetime-local" class="form-control" required name="tgl_test">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="col-sm-5 col-form-label">Catatan Test <span class="text-red">*wajib</span></label>
                            <div class="col-sm-7">
                                <textarea name="catatan_test" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                          </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    @endsection
@section('javascript')
<script>
    $(document).ready(function() {
        // const arr = ['On Test', 'Selesai Test'];
        var getVal=$('#currStats').val();
        // console.log(getVal);
        //     if (!arr.includes(getVal)) {
        //     // 👇️ this runs
        //     $("#StasWork").hide();
        //     $("#addTest").hide();
        //     $(".status_test_qc").attr('required',false);
        //     $("#actual_qc_pass").attr('readonly',true);
        // }
        var selectedValue = $('input[name=status_test_qc]:checked').val();
        if(selectedValue == "Selesai Test"){
        $("#addTest").hide();
        $("#actual_section").show();
        $("#pictest").show();
    }else{
        $("#actual_section").hide();
        $("#pictest").hide();
    }
        $(".status_test_qc").change(function() {
            if($(this).val()=="Selesai Test") {
                $("#actual_section").show();
                $("#pictest").show();
                $("#actual_qc_pass").attr('required', true);
            }else{
                $("#actual_section").hide();
                $("#pictest").hide();
                $("#actual_qc_pass").attr('required', false);
                $("#actual_qc_pass").val("");
            }
        });
    });
</script>
@endsection
