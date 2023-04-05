@extends('layout.main')
@section('title')
    Daftar QC Panel
@endsection
@section('main_header')
    Daftar QC Panel
@endsection
@section('header')
    {{-- <a href="{{route('pn_03_create')}}" class="btn btn-round btn-success">Tambah Produksi Panel</a> --}}
@endsection
@section('content')
    <div class="card card-shadow">

        <div class="card-header">

        </div>
        <div class="card-body">
            <table class="table table-bordered table-stripped" id="panelData">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>No. Seri Panel</th>
                        <th>Nama Panel</th>
                        <th>Tanggal Terima</th>
                        <th>PIC Test</th>
                        <th>Catatan Test</th>
                        <th>Status</th>
                        <th>Tanggal Selesai</th>
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
                        {{-- <td>
                            @php
                            echo $nomor++;
                            @endphp
                        </td> --}}
                        <td>
                            <form method="get" action="{{route('pn_03_edit',$list->id)}}" class="form-button">
                                @csrf
                                @method('get')
                                <button type="submit" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title="Edit Task">
                                    {{-- <i class="fa fa-edit"></i> --}}
                                    EDIT
                                </button>
                            </form>
                        </td>
                        <td>
                            {{$list->nomor_seri_panel}}
                        </td>
                        <td>
                            {{$list->nama_panel}}
                        </td>
                        <td>
                            {{$list->tgl_terima_dr_produksi}}
                        </td>
                        <td>
                            {{$list->picTestQc}}
                        </td>
                        <td>
                            {{$list->catatan_test}}
                        </td>
                        <td>
                            {{$list->status_pekerjaan}}
                            {{-- {{$list->created_at}} --}}
                        </td>
                        <td>
                            {{$list->actual_qc_pass}}
                        </td>
                        <td>
                            {{$list->admin}}
                        </td>
                        <td>
                            {{$list->created_at}}
                        </td>
                        <td>
                            <div class="form-button-action">

                                <form method="POST" action="{{route('pn_03_delete',$list->id)}}"class="form-button">
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
