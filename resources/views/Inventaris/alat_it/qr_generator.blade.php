<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <div style='text-align: center;'>
        <!-- insert your custom barcode setting your data in the GET parameter "data" -->
        <img alt='Barcode Generator'
            src='https://barcode.tec-it.com/barcode.ashx?data={{ url('http://127.0.0.1:8000/inventaris/alat-it/report/' . $id) }}&code=QRCode&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0&hidehrt=False&eclevel=L' />
        <p>{{ $ait_number->number }}</p>
        <div
            style='padding-top:8px; text-align:center; font-size:15px; font-family: Source Sans Pro, Arial, sans-serif;'>
            <!-- back-linking to www.tec-it.com is required -->
            <a href='https://www.tec-it.com' title='Barcode Software by TEC-IT' target='_blank'>
                TEC-IT Barcode Generator<br />
                <!-- logos are optional -->
            </a>
        </div>
    </div>
</body>

</html>
