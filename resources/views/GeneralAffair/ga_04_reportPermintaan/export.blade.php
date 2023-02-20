<table>
    <thead>
        <tr>
        <th style="width: 100px;">
            No
        </th>
        <th style="width: 100px;">
            Nama Pengaju
        </th>
        <th style="width: 100px;">
            Nama Barang
        </th>
        <th style="width: 100px;">
            Nama Gudang
        </th>
        <th style="width: 100px;">
            Jumlah Permintaan
        </th>
        <th style="width: 100px;">
            Jumlah Sekarang
        </th>
        <th style="width: 100px;">
            Status Permintaan
        </th>
        <th style="width: 100px;">
            Tanggal Permintaan
        </th>
        <th style="width: 100px;">
            Terakhir Update
        </th>
    </tr>
    </thead>
    <tbody>
        @php
            $nomor=1;
        @endphp
        @foreach ($list as $list)
        <tr>
            <td>{{$nomor++}}</td>
            <td>{{$list->pengaju}}</td>
            <td>{{$list->nama_barang}}</td>
            <td>{{$list->nama_gudang}}</td>
            <td>{{$list->request_qty}}</td>
            <td>{{$list->current_qty}}</td>
            <td>{{$list->status_permintaan}}</td>
            <td>{{$list->created_at}}</td>
            <td>{{$list->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
