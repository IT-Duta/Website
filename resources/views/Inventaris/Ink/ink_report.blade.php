@extends('layout.main')
@section('title')
    Report Tinta
@endsection
@section('main_header')
    Report Tinta
@endsection
@section('header')
<a href="{{ route('ink_list_export') }}" class="btn btn-secondary btn-round">Export Report Tinta</a>
@endsection
@section('content')
    <div class="card card-shadow">
        <div class="card-header">
            <h3 class="text-center">Report Tinta</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive text-center ">
                <table class="table table-striped table-bordered" id="laptop_master">
                    <caption>Report Tinta</caption>
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>User</th>
                            <th>Ink Name</th>
                            <th>Printer Name</th>
                            <th>Ink Request</th>
                            <th>Alasan Permintaan</th>
                            <th>Status</th>
                            <th>Tanggal Request</th>
                            <th>Total Print</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        @foreach ($list as $list)

                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td>{{ $list->ink_user }}</td>
                                <td>{{ $list->ink_name }}</td>
                                <td>{{ $list->ink_printer }}</td>
                                <td>{{ $list->ink_qty_new - $list->ink_qty_old }}</td>
                                <td>{{ $list->ink_desc }}</td>
                                <td>{{ $list->ink_status }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>{{ $list->print_total }}</td>
                                <td>
                                    @if ($list->ink_status === "Progress")

                                    @can('isAdmin')
                                    <a data-toggle="modal" onclick="myfunction('{{$list->ink_unique}}')" data-target="#exampleModal" class="text-primary"> <i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>
                                    @endcan
                                    @endif
                                </td>
                            </tr>
                            <?php $nomor++; ?>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>


    {{-- Modal Aksi --}}

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{route('ink_update')}}"enctype="multipart/form-data">
            {!! csrf_field() !!}
            @if ($errors->any())
                <p class="alert alert-danger">{{ $errors->first() }}</p>
            @endif
        <div class="modal-body">
            <div class="form-group">
                <label for="ink_unique">Ink ID</label>
                <input type="text" readonly class="form-control" id="ink_unique" name="ink_unique">
            </div>
            <div class="form-group">
                <label for="type">Tipe</label>
                <input type="text" readonly class="form-control" id="type" name="type" value="up-report">
            </div>
            <div class="form-group">
                <label for="print_total">Total Print</label>
                <input type="number" class="form-control" id="print_total" placeholder="Enter Total Print" name="print_total">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Perubahan Status</label>
                <select required name="ink_status"class="form-control" id="exampleFormControlSelect1">
                    <option selected>Done</option>
                    <option>Batal</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#laptop_master').DataTable();
        });

        function myfunction(id){
document.getElementById('ink_unique').value = id;
            // alert(id);
        }
    </script>
@endsection
