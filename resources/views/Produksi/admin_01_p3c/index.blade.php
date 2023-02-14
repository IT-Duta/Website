@extends('layout.main')
@section('title')
    Daftar Panel
@endsection
@section('header')
<a href="{{route('pn_01_create')}}" class="btn btn-round btn-success">Tambah Panel</a>
<a href="{{route('pn_01_export')}}" class="btn btn-round btn-success">Export Panel</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h1>Daftar Panel</h1>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-responsive" id="panelData">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">No. Seri Panel</th>
                        <th rowspan="2">Nama Customer</th>
                        <th rowspan="2">Nama Proyek</th>
                        <th rowspan="2">Nama Panel</th>
                        <th rowspan="2">Nomor WO</th>
                        <th rowspan="2">Status Panel</th>
                        <th rowspan="2">Status Pekerjaan</th>
                        <th colspan="2" class="text-center">Deadline</th>
                        <th rowspan="2">Admin</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th>
                            Produksi
                        </th>
                        <th>QC Pass</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor=1;
                    @endphp
                    @foreach ($list as $list)

                    <tr>
                        {{-- <td>{{$nomor++}}</td> --}}
                        <td>
                            <form method="get" action="{{route('pn_01_edit',$list->id)}}" class="form-button">
                            @csrf
                            @method('get')
                            <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary btn-sm" data-original-title="Edit Task">
                                {{-- <i class="fa fa-edit"></i> --}}
                                EDIT
                            </button>
                        </form>
                    </td>
                        <td>{{$list->nomor_seri_panel}}</td>
                        <td>{{$list->nama_customer}}</td>
                        <td>{{$list->nama_proyek}}</td>
                        <td>{{$list->nama_panel}}</td>
                        <td>{{$list->nomor_wo}}</td>
                        <td>{{$list->panel_status}}</td>
                        <td>{{$list->status_pekerjaan}}</td>
                        <td>{{$list->deadline_produksi}}</td>
                        <td>{{$list->deadline_qc_pass}}</td>
                        <td>{{$list->admin}}</td>
                        <td>
                            <div class="form-button-action">

                                <form method="POST" action="{{route('pn_01_delete',$list->id)}}"class="form-button">
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

