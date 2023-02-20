<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Stock Tinta</title>
        <style>
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
        <table class="table">
            <thead>
                <tr>
                    <th class="headertable">No</th>
                    <th class="headertable">Kode Tinta</th>
                    <th class="headertable">Nama Tinta</th>
                    <th class="headertable">Jumlah</th>
                    <th class="headertable">Tanggal Buat</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;?>
                @foreach ($list as $list)
                <tr style="height: 100px;">
                    <td style="text-align: center;background-color:#cff4fc;"><?php echo $nomor++;?></td>
                    <td style="text-align: center;background-color:#cff4fc;width:100px;">{{$list->ink_code}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:150px">{{$list->ink_name}}</td>
                    <td style="text-align: center;background-color:#f8d7da;width:50px;">{{$list->ink_qty}}</td>
                    <td style=" text-align: center;background-color:#e2e3e5;width:200px">{{$list->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
