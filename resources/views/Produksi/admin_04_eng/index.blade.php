@extends('layout.main')
@section('title')
    Daftar Engineering Panel
@endsection
@section('main_header')
    Daftar Rating Plate
@endsection
@section('header')
    {{-- <a href="{{route('pn_04_create')}}" class="btn btn-round btn-success">Tambah Eng Panel</a> --}}
@endsection
@section('content')
    <div class="card card-shadow">

        <div class="card-header">

        </div>
        <div class="card-body">
            <table class="table table-bordered table-stripped table-responsive" id="panelData">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>No. Seri Panel</th>
                        <th>Nama Panel</th>
                        <th>Tipe Panel</th>
                        <th>Capacity</th>
                        <th>Voltage</th>
                        <th>Ampere</th>
                        <th>3 Phase</th>
                        <th>IP</th>
                        <th>Frekuensi</th>
                        <th>MFD</th>
                        <th>Admin</th>
                        <th>Tanggal Input</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor=1;
                    @endphp
                    @foreach ($list as $list)

                    <tr>
                        <td>
                            <a href="{{ route('s_email', ['id' => $list->id]) }}" class="btn btn-sm btn-primary">Kirim Email</a>
                            {{-- @php
                            echo $nomor++;
                            @endphp --}}
                        </td>
                        <td>
                            {{$list->nomor_seri_panel}}
                        </td>
                        <td>
                            {{$list->nama_panel}}
                        </td>
                        <td>
                            {{$list->tipe_panel}}
                        </td>
                        <td>
                            {{$list->capacity}}
                        </td>
                        <td>
                            {{$list->voltage}}
                        </td>
                        <td>
                            {{$list->ampere}}
                        </td>
                        <td>
                            {{$list->phasa_3}}
                        </td>
                        <td>
                            {{$list->ip}}
                        </td>
                        <td>
                            {{$list->frekuensi}}
                        </td>
                        <td>
                            {{date("M Y",strtotime($list->mfd));
                            }}
                        </td>
                        <td>
                            {{$list->admin}}
                        </td>
                        <td>
                            {{$list->created_at}}
                        </td>
                        <td>
                            <div class="form-button-action">
                                <form method="get" action="{{route('pn_04_edit',$list->id)}}" class="form-button">
                                    @csrf
                                    @method('get')
                                    <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-primary form-button" data-original-title="Edit Task">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{route('pn_04_delete',$list->id)}}"class="form-button">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger delete-button form-button" data-original-title="Remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>



                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#panelData').DataTable();
} );
</script>
<script>
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        if (!confirm('Are you sure you want to delete this item?')) {
          event.preventDefault();
        }
      });
    });
    </script>
@endsection
