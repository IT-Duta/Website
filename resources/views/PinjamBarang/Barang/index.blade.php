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
            <table class="table table-bordered table-stripped table-responsive" id="id_barang">
                <thead>
                    <tr>
                        <th>
                            nomor
                        </th>
                        <th>
                            kode_barang
                        </th>
                        <th>nama_barang
                        </th>
                        <th>status_barang</th>
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
                            {{$nomor++}}
                        </td>
                        <td>
                            {{$list->d_kode_barang}}
                        </td>
                        <td>
                            {{$list->d_nama_barang}}
                        </td>
                        <td>
                            {{$list->d_status_barang}}
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
    $('#id_barang').DataTable();
} );
</script>
@endsection
