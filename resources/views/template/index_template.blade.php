@extends('layout.main')
@section('title')
{{-- Title website --}}
@endsection
@section('main_header')
    {{-- Judul halaman website--}}
@endsection
@section('header')
{{-- Button Add Data --}}
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            {{-- Judul card --}}
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
            <table class="table table-bordered table-stripped table-responsive" id="id_table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>No. Seri Panel</th>
                        <th>Nama Panel</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Untuk penomoran tabel --}}
                    @php
                        $nomor=1;
                    @endphp
                    {{-- Untuk penomoran tabel selesai --}}
                    {{-- Menampilkan seluruh data yang berasal dari controller --}}
                    @foreach ($list as $list)
                    <tr>
                        <td>
                            {{$nomor}}
                        </td>
                        <td>
                            {{$list->nomor_seri_panel}}
                        </td>
                        <td>
                            {{$list->nama_panel}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#id_table').DataTable();
} );
</script>
@endsection
