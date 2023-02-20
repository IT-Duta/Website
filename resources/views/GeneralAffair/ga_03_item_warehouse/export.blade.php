<table>
    <thead>
        <tr>
        <th style="width: 100px;">
            No
        </th>
        <th style="width: 100px;">
            Nama Barang
        </th>
        <th style="width: 100px;">
            Nama Gudang
        </th>
        <th style="width: 100px;">
            Jumlah Barang
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
            <td>{{$list->nama_barang}}</td>
            <td>{{$list->nama_gudang}}</td>
            <td>{{$list->qty_barang}}</td>
            <td>{{$list->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
