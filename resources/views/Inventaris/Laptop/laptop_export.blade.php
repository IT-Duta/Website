<table class="table table-striped">
    <thead class="thead-dark">
        <tr class="text-center">
            <th>#NO</th>
            <th>ID</th>
            <th>PENGGUNA</th>
            <th>NAMA_LAPTOP</th>
            <th>NOMOR</th>
            <th>SERIAL_NUMBER</th>
            <th>HARGA</th>
            <th>STATUS</th>
            <th>KONDISI</th>
            <th>CPU</th>
            <th>VGA</th>
            <th>RAM</th>
            <th>HARDDISK</th>
            <th>SSD</th>
            <th>SISTEM_OPERASI</th>
            <th>TANGGAL_PEMBELIAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($exportData as $key => $list)
        <tr>
            <td>{{ ++$key }}</td>
            <td>#{{ $list->id }}</td>
            <td>{{ $list->laptop_user }}</td>
            <td>{{ $list->laptop_name }}</td>
            <td>{{ $list->laptop_number }}</td>
            <td>{{ $list->laptop_serial_number }}</td>
            <td>{{ $list->laptop_price }}</td>
            <td>{{ $list->laptop_status }}</td>
            <td>{{ $list->laptop_condition }}</td>
            <td>{{ $list->laptop_processor }}</td>
            <td>{{ $list->laptop_vga }}</td>
            <td>{{ $list->laptop_ram }}</td>
            <td>{{ $list->laptop_hdd }}</td>
            <td>{{ $list->laptop_ssd }}</td>
            <td>{{ $list->laptop_os }}</td>
            <td>{{ $list->laptop_buy_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
