<table>
    <thead>
        <tr>
            <th>#</th>
            <th>No Pengajuan</th>
            <th>Nama Pengaju</th>
            <th>Divisi</th>
            <th>Lokasi</th>
            <th>Referensi</th>
            <th>Alasan</th>
            <th>Status</th>
            <th>Tanggal Progress</th>
            <th>Tanggal Finish</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        @foreach ($exportData as $list)
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td>{{ $list->hard_req_number }}</td>
                <td>{{ $list->hard_req_user }}</td>
                <td>{{ $list->hard_req_divisi }}</td>
                <td>{{ $list->hard_req_location }}</td>
                <td>{{ $list->hard_req_referensi }}</td>
                <td>{{ $list->hard_req_alasan }}</td>
                <td>{{ $list->hard_req_status }}</td>
                <td>{{ $list->hard_req_progress }}</td>
                <td>{{ $list->hard_req_finish }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
