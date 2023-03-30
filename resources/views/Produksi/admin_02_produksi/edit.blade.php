@extends('layout.main')
@section('title')
    Edit Produksi Panel - {{$list->nomor_seri_panel}}
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
.text-red{
    color: red;
    font-size:12px;
    vertical-align: super;
}
</style>
@endsection
@section('main_header')
    Edit Produksi Panel - {{$list->nomor_seri_panel}}
@endsection
@section('content')
    <div class="card card-shadow">

        <div class="card-body">

            <form method='post' action="{{ route('pn_02_update') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
                <input type="hidden" value="{{$list->id}}" name="id">
                <input type="hidden" value="{{$list->id_panel}}" name="id_panel">
                <hr>
                <h2>Detail</h2>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">Nama Customer</label>
                                <input name="nama_customer" value="{{$list->nama_customer}}" readonly type="text" class="form-control" id="namaCustomer" placeholder="Enter Nama Customer">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaProyek">Nama Proyek</label>
                                <input name="nama_proyek" value="{{$list->nama_proyek}}" readonly type="text" class="form-control" id="namaProyek" placeholder="Enter Nama Proyek">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="namaPanel">Nama Panel</label>
                                <input name="nama_panel" value="{{$list->nama_panel}}" readonly type="text" class="form-control" id="namaPanel" placeholder="Enter Nama Panel">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h2>Detail</h2>
                <hr>
                <div class="form-group">
                    <label class="form-label">SPV</label>
                    <div class="selectgroup w-100">
                        <select required name="spv" id="spv" class="form-control" style="width: 100%">
                            @for ($i = 0; $i < count($teams); $i++)
                            <option value="{{ $teams[$i]->id }}"
                             @php echo ($teams[$i]->id===$list->spv ) ? "selected" : ''; @endphp >{{ $teams[$i]->Nickname }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Tim Wiring</label>
                            <div class="selectgroup selectgroup-pills" style="overflow: scroll; height: 200px;">
                                <?php
                                $wiring = explode(',',$list->wiring);
                                ?>
                                @for ($i = 0; $i < count($teams); $i++)
                                    <label class="selectgroup-item">
                                        <input
                                        <?php
                                            if (in_array( $teams[$i]->Nickname, $wiring)) {
                                            echo ' checked';
                                            }
                                        ?>
                                        type="checkbox" name="wiring[]" value="{{ $teams[$i]->Nickname }}" class="selectgroup-input">
                                        <span class="selectgroup-button">{{ $teams[$i]->Nickname }}</span>
                                    </label>
                                    @endfor
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Tim Mekanik</label>
                            <div class="selectgroup selectgroup-pills" style="overflow: scroll; height: 200px;">
                                <?php
                                $mekanik = explode(',',$list->mekanik);
                                ?>
                                @for ($i = 0; $i < count($teams); $i++)
                                    <label class="selectgroup-item">

                                        <input type="checkbox" name="mekanik[]"
                                        <?php
                                        if (in_array( $teams[$i]->Nickname, $mekanik)) {
                                        echo ' checked';
                                        }
                                    ?>
                                        value="{{ $teams[$i]->Nickname }}" class="selectgroup-input">
                                        <span class="selectgroup-button">{{ $teams[$i]->Nickname }}</span>
                                    </label>
                                    @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="form-label">Status Komponen</label>
                            <!-- Radio buttons with labels "Komplit" and "Belum" -->
                            <div class="form-group">

                                <label class="form-check">
                                    <input type="radio" name="status_komponen" value="Lengkap" id="komplit" <?php echo ($list->status_komponen==="Lengkap") ? "checked" : "" ; ?> /> Lengkap
                                </label>
                                <label class="form-check">
                                    <input type="radio" name="status_komponen" value="Kurang" id="belum" <?php echo ($list->status_komponen==="Kurang") ? "checked" : "" ; ?> /> Kurang
                                </label>
                                <!-- Textarea input field, initially hidden -->
                                <textarea id="belum-text" class="form-control" height="50px" name="status_komponen_text">{{$list->status_komponen_text}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{$list->status_pekerjaan}}" id="currStats">
                    <div class="col-6" id="StasWork">
                        <div class="form-group">
                            <label for="" class="form-label">Status Pekerjaan</label>
                                <!-- Radio buttons with labels "Komplit" and "Belum" -->
                                <div class="form-group">
                                    <label class="form-check">
                                        <input type="radio" name="status_pekerjaan" class="status_pekerjaan" <?php echo ($list->status_pekerjaan =="Test-QC") ? "checked " : " " ; ?> value="Test-QC" id="Test-QC" /> Test QC
                                    </label>
                                    <label class="form-check">
                                        <input type="radio" name="status_pekerjaan" class="status_pekerjaan"  <?php echo ($list->status_pekerjaan =="Progress") ? "checked " : " " ; ?> value="Progress" id="Progress" /> Progress
                                    </label>
                                    <label class="form-check">
                                        <input type="radio" name="status_pekerjaan" class="status_pekerjaan"  <?php echo ($list->status_pekerjaan =="Tunda") ? "checked " : " " ; ?>value="Tunda" id="Tunda" /> Tunda
                                    </label>
                                    <!-- Textarea input field, initially hidden -->
                                    <textarea id="status_pekerjaan_txt" class="form-control" height="50px" name="status_pekerjaan_txt">{{$list->status_pekerjaan_txt}}</textarea>
                                </div>
                        </div>
                    </div>
                </div>

                <div id="QC_DONE">
                    <hr>
                    <div class="form-group">
                        <label for="">Tgl Serah produksi ke QC <span class="text-red">*Wajib</span></label>
                        <input class="form-control" type="datetime-local" name="tgl_serah_ke_qc" id="tgl_serah_ke_qc"
                        <?php
                        $current_datetime_1 = (new DateTime())->format('Y-m-d H:i:s');

                        $current_datetime_2 = ($list->tgl_serah_ke_qc == null) ? $current_datetime_1 : $list->tgl_serah_ke_qc ;
                        ?>
                        value="{{$current_datetime_2}}"
                        {{-- value="{{$list->tgl_serah_ke_qc}}" --}}
                        >
                        {{-- {{$current_datetime_1}}
                        {{$list->tgl_serah_ke_qc}} --}}
                    </div>

                </div>


                    <button class="btn btn-sm btn-success btn-block mt-3" type="submit">Submit</button>
                    <button class="btn btn-sm btn-danger shadow" id="floating" type="reset">Reset</button>
            </form>


            </div> <!-- End of card-body -->
        </div><!-- End Card -->

    @endsection
    @section('javascript')
    <script>

        $(document).ready(function() {
            $("#spv").select2({
                minimumInputLength: 3
            });
            $('#view_panel').select2({
                // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
            });
        });
        </script>
  <script>
    $(document).ready(function() {
        const arr = ['Test-QC', 'Progress', 'Tunda'];
        var getVal=$('#currStats').val();
            if (!arr.includes(getVal)) {
            // 👇️ this runs
            $("#StasWork").hide();
            $(".status_pekerjaan").attr('required',false);
            }
        const arrNot=['Progress','Tunda'];
        if(!arrNot.includes(getVal)) {
            $("#QC_DONE").show();
            $("#tgl_serah_ke_qc").attr('readonly', true);
            $(".kirim_email").attr('required', true);
        } else{
            $("#QC_DONE").hide();
        }

        $(".status_pekerjaan").change(function() {
            if($(this).val()=="Test-QC") {
                $("#QC_DONE").show();
                $("#tgl_serah_ke_qc").attr('required', true);
                // $(".kirim_email").attr('required', true);
            }else{
                $("#QC_DONE").hide();
                $("#tgl_serah_ke_qc").attr('required', false);
                // $(".kirim_email").attr('required', false);
            }
        });
    });
</script>
    @endsection
