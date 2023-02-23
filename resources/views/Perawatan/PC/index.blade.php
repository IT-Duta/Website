@extends('layout.main')
@section('title')
Daftar Perawatan
@endsection
@section('main_header')
   Daftar Perawatan
@endsection
@section('header')
<!-- Button trigger modal -->
<a href="{{route('perawatan.pc.create')}}" class="btn btn-sm btn-primary">
    Tambah Perawatan
  </a>

   {{-- <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importperawatanModal">
    Import Perawatan
  </button>
<a href="{{route('ga.masterItemExport')}}"class="btn btn-success btn-sm">Export Master Item</a> --}}
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            Daftar Perawatan
        </div>
        <div class="card-body">
            <div class="text-center table-responsive">
            <table class="table table-bordered table-stripped" id="daftar_perawatan">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Nomor Perawatan</th>
                        <th>User</th>
                        <th>CPU</th>
                        <th>Monitor</th>
                        <th>Aksi</th>
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
                            {{$list->nomor_perawatan}}
                        </td>
                        <td>
                            {{$list->user}}
                        </td>
                        <td>
                            {{$list->nomor_cpu}}
                        </td>
                        <td>
                            {{$list->nomor_monitor}}
                        </td>
                        <td>
                            {{-- Tombol Hapus --}}
                            <button class="btn btn-danger delete-item" data-toggle="modal" data-target="#confirm-delete" data-id="{{ $list->uuid_perawatan}}">Delete</button>
                            {{-- Tombol Edit --}}
                            <button class="btn btn-primary view-item" data-toggle="modal" data-target="#view-modal" data-id="{{ $list->uuid_perawatan }}">Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
{{-- Modal Tambah perawatan --}}

@include('GeneralAffair.ga_01_masterItem.addModal')
  <!-- Modal -->

  {{-- End Modal Tambah perawatan --}}
{{-- Modal Import --}}
@include('GeneralAffair.ga_01_masterItem.importModal')
{{-- End Modal Import --}}
  {{-- Modal Hapus perawatan --}}
  <!-- Modal -->
@include('Perawatan.PC.deleteModal')
  {{-- End Modal Hapus perawatan --}}
  {{-- Modal view perawatan --}}
@include('Perawatan.PC.viewModal')
  {{-- End Modal view perawatan --}}
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#daftar_perawatan').DataTable();
} );
</script>
<script>
        $('.delete-item').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("perawatan.pc.delete", ":id") }}';
            url = url.replace(':id', id);
            $('#delete-form').attr('action', url);
            $.get('{{ route("perawatan.pc.getData", ":id") }}'.replace(':id', id), function(data) {
            $('#nomor_perawatan_del').text(data.nomor_perawatan);
            });
        });
</script>
<script>
        $('.view-item').click(function() {
            var id = $(this).data('id');
            $.get('{{ route("perawatan.pc.getData", ":id") }}'.replace(':id', id), function(data) {
                $('#view-modal #view-modal-label').text(data.nomor_perawatan);
                $('#view-modal input[name="pic"]').val(data.pic);
                $('#view-modal input[name="user"]').val(data.user);
                $('#view-modal input[name="lokasi"]').val(data.lokasi);
                $('#view-modal input[name="nomor_cpu"]').val(data.nomor_cpu);
                $('#view-modal input[name="nomor_monitor"]').val(data.nomor_monitor);
                $('#view-modal input[name="kebersihan_monitor"]').val(data.kebersihan_monitor);
                $('#view-modal input[name="kebersihan_pc"]').val(data.kebersihan_pc);
                $('#view-modal input[name="kondisi_monitor"]').val(data.kondisi_monitor);
                $('#view-modal input[name="kondisi_keyboardmouse"]').val(data.kondisi_keyboardmouse);
                $('#view-modal input[name="kondisi_mainboard"]').val(data.kondisi_mainboard);
                $('#view-modal input[name="kondisi_penyimpanan"]').val(data.kondisi_penyimpanan);
                $('#view-modal input[name="kondisi_processor"]').val(data.kondisi_processor);
                $('#view-modal input[name="kondisi_ram"]').val(data.kondisi_ram);
                $('#view-modal input[name="kondisi_jaringan"]').val(data.kondisi_jaringan);
                $('#view-modal input[name="optimasi_os"]').val(data.optimasi_os);
                $('#view-modal input[name="optimasi_antivirus"]').val(data.optimasi_antivirus);
                $('#view-modal input[name="optimasi_software"]').val(data.optimasi_software);
                $('#view-modal input[name="backup_email"]').val(data.backup_email);
                $('#view-modal .keterangan-view').val(data.keterangan);

            });
        });
</script>


@endsection
