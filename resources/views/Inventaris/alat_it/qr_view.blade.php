<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR VIEW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/accounting.min.js') }}"></script>
</head>

<body class="bg-light bg-gradient">
    <section class="container">
        <div class="shadow mt-5 p-3 mb-5 bg-body rounded">
            <h1 class="text-center">Laptop Detail - {{ $list->laptop_name }} </h1>
            <div class="row-5 mb-2 pt-5 px-4">
                <div class="col">
                    <label for="laptop_number" class="form-label">No Laptop</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_number }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_name" class="form-label">Merk</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_name }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_user" class="form-label">User</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_user }}">
                </div>
            </div>

            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_tanggal" class="form-label">Tanggal Beli</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_tanggal }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_location" class="form-label">Lokasi</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_location }}">
                </div>
            </div>

            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_processor" class="form-label">Processor</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_processor }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_vga" class="form-label">VGA</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_vga }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_ram" class="form-label">RAM</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_ram }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_hdd" class="form-label">HDD</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_hdd }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_ssd" class="form-label">SSD</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_ssd }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_os" class="form-label">OS</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_os }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_sn" class="form-label">SN</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_sn }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_harga" class="form-label">Harga</label>
                </div>
                <div class="col">
                    <input readonly id="harga" class="form-control" type="text" value="{{ $list->laptop_harga }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_status" class="form-label">Status</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_status }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="laptop_condition" class="form-label">Kondisi</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->laptop_condition }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="created_at" class="form-label">Data Awal</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->created_at }}">
                </div>
            </div>
            <div class="row mb-2 px-4">
                <div class="col">
                    <label for="updated_at" class="form-label">Update Terakhir</label>
                </div>
                <div class="col">
                    <input readonly class="form-control" type="text" value="{{ $list->updated_at }}">
                </div>
            </div>

        </div>
    </section>
    <footer>

    </footer>
    <script>
        let hargaid = document.getElementById('harga').value;
        // let harga = $('#harga').val();
        let convert = accounting.formatMoney(hargaid, {
            symbol: "Rp. ",
            thousand: ".",
            decimal: ",",
        });
        document.getElementById('harga').value=convert;
    </script>
</body>

</html>
