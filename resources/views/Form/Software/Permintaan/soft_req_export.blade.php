<html>

<head>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            width: 100%;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Pengajuan</th>
                <th>Pengaju</th>
                <th>Divisi</th>
                <th>Lokasi</th>
                <th>Alasan Pengajuan</th>
                <th>Ajuan Lain</th>
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
                    <td>{{ $list->soft_req_number }}</td>
                    <td>{{ $list->soft_req_user }}</td>
                    <td>{{ $list->soft_req_divisi }}</td>
                    <td>{{ $list->soft_req_location }}</td>
                    <td>{{ $list->soft_req_reason }}</td>
                    <td>{{ $list->soft_req_other }}</td>
                    <td>{{ $list->soft_req_status }}</td>
                    <td>{{ $list->soft_req_progress }}</td>
                    <td>{{ $list->soft_req_finish }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
