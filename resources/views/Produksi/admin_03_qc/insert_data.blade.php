@extends('layout.main')
@section('title')
    Input Panel QC
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
    Input Panel QC - {{$p3c_list->nomor_seri_panel}}
@endsection
@section('content')
    <div class="card card-shadow">

        <div class="card-body">

            <form method='post' action="{{ route('pn_03_store') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">ID PANEL</label>
                                <input name="id_panel" value="{{$p3c_list->id}}" readonly type="text" class="form-control" id="namaCustomer" placeholder="Enter Nama Customer">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">Nama Customer</label>
                                <input name="nama_customer" value="{{$p3c_list->nama_customer}}" readonly type="text" class="form-control" id="namaCustomer" placeholder="Enter Nama Customer">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">Nama Proyek</label>
                                <input name="nama_proyek" value="{{$p3c_list->nama_proyek}}" readonly type="text" class="form-control" id="namaProyek" placeholder="Enter Nama Proyek">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaPanel">Nama Panel</label>
                                <input name="nama_panel" value="{{$p3c_list->nama_panel}}" readonly type="text" class="form-control" id="namaPanel" placeholder="Enter Nama Panel">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaPanel">Tangga Manufaktur</label>
                                <input name="mfd" value="{{$p3c_list->mfd}}" readonly type="text" class="form-control" id="mdf" placeholder="Enter Nama Panel">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h2>Detail</h2>
                <hr>
                <div class="form-group">
                    <label for="actual_qc_pass" class="form-label">Tanggal terima dari Produksi <span class="text-red">*Wajib</span></label>
                    {{-- <input type="date" id="tgl_terima_dr_produksi" name="tanggal_test" class="form-control" /> --}}
                    <input required name="tgl_terima_dr_produksi" type="datetime-local" readonly value="{{$p3c_list->tgl_serah_ke_qc}}"class="form-control" id="tgl_terima_dr_produksi">
                </div>



                <div class="mb-3 row">
                    <label for="kirim_email" class="col-sm-4 form-label">Status Test QC <span class="text-red">*Wajib</span></label>
                    <div class="selectgroup w-100 col-sm-8">
                        <label class="selectgroup-item">
                            <input type="radio" required name="status_test_qc" value="On Test" class="selectgroup-input status_test_qc">
                            <span class="selectgroup-button">On Test</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" checked name="status_test_qc" value="Selesai Test" class="selectgroup-input status_test_qc">
                            <span class="selectgroup-button">Selesai Test</span>
                        </label>
                    </div>
                </div>
                <div id="actual_section">
                    <div class="form-group">
                        <label class="form-label">Aktual QC Pass <span class="text-red">*Wajib</span></label>
                        <input type="datetime-local" name="actual_qc_pass" id="actual_qc_pass" class="form-control">
                    </div>
                </div>

                <div class="form-group" id="pictest">
                    <label class="form-label">PIC Test <span class="text-red">*Wajib</span></label>
                    <input type="text" class="form-control" name="picTestQc">
                </div>
  <!-- Form group containing the textarea input field -->
                <div class="form-group">
                    <label for="catatan_test" class="form-label">Catatan Hasil QC Test <span class="text-red">*Wajib</span></label>
                    <textarea id="catatan_test" name="catatan_test" class="form-control" rows="10"></textarea>
                </div>
                  <button class="btn btn-sm btn-success btn-block" onclick="return confirm('Udah yakin semua datanya benar?')" type="submit">Submit</button>
                  <button class="btn btn-sm btn-danger shadow" id="floating" onclick="return confirm('Yakin ingin reset ulang?')" type="reset">Reset</button>
            </form>


            </div> <!-- End of card-body -->
        </div><!-- End Card -->

    @endsection
    @section('javascript')
    <script>

        $(document).ready(function() {

            $('#view_panel').select2();
        });
        </script>

        <script>
            $('#view_panel').on('change', function() {
                var selectedOption = $(this).val();

                // Send the AJAX request to the server
                $.ajax({
                    url: '{{route('pn_03_search')}}',
                    data: { term: selectedOption },
                    success: function(data) {
                    // Update the input field with the data obtained from the search
                    // $('#exampleFormControlInput1').val(data);
                    $('#namaProyek').val(data['nama_proyek']);
                    $('#namaCustomer').val(data['nama_customer']);
                    $('#namaPanel').val(data['nama_panel']);
                    // console.log(data['nama_panel']);
                    }
                });
            });
        </script>
         <script>
            $(document).ready(function() {
                var selectedValue = $('input[name=status_test_qc]:checked').val();
            if(selectedValue == "Selesai Test"){
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
                        $("#pictest").attr('required', true);
                    }else{
                        $("#actual_section").hide();
                        $("#pictest").hide();
                        $("#actual_qc_pass").attr('required', false);
                        $("#pictest").attr('required', false);
                    }
                });
            });
        </script>
    @endsection
