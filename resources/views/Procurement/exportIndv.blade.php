<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            .procurement{
                text-align: center;background-color:#d1e7dd;
            }
            .pengaju{
                text-align: center;background-color:#f8d7da;
            }
            .acc{
                text-align: center;background-color:#e2e3e5;
            }
            .headertable{
                vertical-align: middle;height:50px;text-align:center;background-color:#fff3cd;
                white-space: normal;
            }
            .nomor{
                text-align: center;background-color:#cff4fc;
            }
        </style>
    </head>
    <body>

        <h1>PPB - {{$header->ppb_no}}</h1>
        <table class="table">
            <thead>
                <tr>
                    <th class="headertable">No</th>
                    <th class="headertable">Qty</th>
                    <th class="headertable">Satuan</th>
                    <th class="headertable">Deskripsi</th>
                    <th class="headertable">Tipe Barang</th>
                    <th class="headertable">Merek</th>
                    <th class="headertable">Pemasok</th>
                </tr>
            </thead>
            {{-- {{dd($items)}} --}}
            <tbody>
                @php $nomor=1; @endphp
                {{-- {{dd($items)}} --}}
                @foreach ($items as $item)
                <tr style="height: 100px;">
                    <td style="text-align: center;background-color:#cff4fc;">{{ $nomor++ }}</td>
                    <td style="text-align: center;background-color:#cff4fc;width:50px;">{{$item->ppb_qty}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:50px;">{{$item->ppb_satuan}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:300px;">{{$item->ppb_deskripsi}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:150px;">{{$item->ppb_tipe_barang}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:200px;">{{$item->ppb_merek}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:150px;">{{$item->ppb_pemasok_panel}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
