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