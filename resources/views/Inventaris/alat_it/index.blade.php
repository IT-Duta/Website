@extends('layout.main')
@section('title')
    Alat IT
@endsection
@section('main_header')
    Alat IT
@endsection
@can('isAdmin')
    @section('header')
        <a href="#" class="btn btn-primary btn-round">Export</a>
        {{-- <a href="{{ route('pc_import_view') }}" class="btn btn-primary btn-round">Import PC</a> --}}
        <a href="{{ route('ait_create') }}" class="btn btn-secondary btn-round">Add Alat</a>
        <button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#importModal">
            Import
        </button>
    @endsection
@endcan
@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered" id="ait_master">
                    <caption>List Alat IT</caption>
                    <thead class="text-center">
                        <tr class="table-primary">
                            <th>No</th>
<<<<<<< HEAD
                            <th class="w-100">Nama Alat</th>
                            @can('isAdmin')
                                <th class="d-sm-none d-md-none d-lg-table-cell">Serial No.</th>
                            @endcan
=======
                            <th >Nama Alat</th>
                            <th>Serial No.</th>
>>>>>>> 89322402a445f9dbf1dc001c1ea51c4efb15ca6b
                            <th>Type</th>
                            @can('isAdmin')
                                <th class="d-sm-none d-md-none d-lg-table-cell">Harga</th>
                            @endcan
                            <th>Kondisi</th>
                            <th>Lokasi</th>
<<<<<<< HEAD
                            <th>Stok (Item)</th>
                            <th>Aksi</th>
=======
                            <th width=140>Aksi</th>
>>>>>>> 89322402a445f9dbf1dc001c1ea51c4efb15ca6b
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($list) > 0)
                            @foreach ($list as $no => $item)
                                <tr>
                                    <td class="text-center">{{ ++$no }}</td>
<<<<<<< HEAD
                                    <td>{{ $item->name }}</td>
                                    @can('isAdmin')<td class="text-center d-sm-none d-md-none d-lg-table-cell">{{ $item->serial_number }}</td>@endcan
=======
                                    <td >{{ $item->name }}</td>
                                    <td>{{ $item->serial_number }}</td>
>>>>>>> 89322402a445f9dbf1dc001c1ea51c4efb15ca6b
                                    <td>{{ $item->ait_type_name }}</td>
                                    @can('isAdmin')<td class="text-right d-sm-none d-md-none d-lg-table-cell">Rp. {!! number_format($item->price, 0, '.', ',') !!}</td>@endcan
                                    <td>{{ $item->condition }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td class="text-center">
                                        <button id="confirm-pinjam-{{ $item->id }}"
                                            onclick="aitPinjam({{ $item->id }})"
                                            class="btn btn-xs @if($item->status===0) btn-dark disabled @elseif($item->status===1) btn-info @endif text-white"
                                            data-toggle="tooltip" data-placement="left"
                                            @if($item->status===0) title="Sorry, this item isn't available right now." disabled @else title="Pinjam" @endif
                                            data-number={{ $item->number }}
                                        >
                                            <i class="fas fa-file-export"></i>
                                        </button>
                                        @can('isAdmin')
                                        <a href="{{ route('ait_edit', $item->id) }}" class="btn btn-xs btn-primary text-white" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Yakin ingin hapus Alat IT dengan Nomor {{ $item->number }}?');"
                                            href="{{ route('ait_destroy', $item->id) }}" class="btn btn-xs btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a target="__blank" onclick="return confirm('Yakin ingin Print QR Alat IT dengan Nomor {{$item->number}} ?')" href="{{ route('ait_qr_generator', ['id' => $item->unique]) }}"
                                            class="btn btn-xs btn-success text-white" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fas fa-qrcode" data-toggle="tooltip" data-placement="top" title="Print QR"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-ait-pinjam">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body text-center pt-5 pl-5 pr-5 pb-3">
                        <i class="fas fa-exclamation-circle fa-9x text-warning"></i>
                        <h1 class="aitNumber font-weight-bold mt-4"></h1>
                        <h2 class="mt-3 mb-4">Yakin ingin pinjam alat ini?</h2>
                        <div class="d-inline mt-5">
                            <a href="#" class="btn btn-primary btn-ait-pinjam font-weight-bold">Ya</a>
                            <button class="btn btn-danger font-weight-bold" data-dismiss="modal">Tidak</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(function() {
            $('#ait_master').DataTable();
        });

        function aitPinjam(id){
            $("#modal-ait-pinjam").modal({
                backdrop: "static",
                keyboard: false,
                show: true,
            });

            var aitId = id;
            var aitNumber = $("#confirm-pinjam-"+id).attr("data-number");
            $(".aitNumber").text(aitNumber);
            var link = "/inventaris/alat-it/pinjam/create/"+aitId;
            $(".btn-ait-pinjam").attr("href", link);
        };
</script>
@endsection
