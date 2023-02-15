<table>
    <thead>
        <tr>
        <th style="width: 100px;">
            No
        </th>
        <th style="width: 100px;">
            Kode Unik
        </th>
        <th style="width: 100px;">
            Nama Gudang
        </th>
        <th style="width: 100px;">
            Status Gudang
        </th>
        <th style="width: 100px;">
            Pertama Input
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
            <td>{{$list->uuid_gudang}}</td>
            <td>{{$list->nama_gudang}}</td>
            <td>{{$list->status_gudang}}</td>
            <td>{{$list->created_at}}</td>
            <td>{{$list->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
