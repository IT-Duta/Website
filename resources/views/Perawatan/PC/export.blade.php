<html>
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  </head>
  <body>
    <table class="table table-bordered">
  <thead>
    <tr>
      <th rowspan="2" style="text-align:center;vertical-align:middle">#</th>
      <th colspan="4" style="text-align:center"> General</th>
      <th colspan="3" style="text-align:center"> Monitor</th>
      <th colspan="8" style="text-align:center"> CPU</th>
      <th colspan="4" style="text-align:center"> Software</th>
      <th rowspan="2" style="text-align:center;vertical-align:middle"> Keterangan</th>
      <th rowspan="2" style="text-align:center;vertical-align:middle"> Tanggal Input</th>
    </tr>
    <tr>
        {{-- General --}}
        <th>nomor_perawatan</th>
        <th>pic</th>
        <th>user</th>
        <th>lokasi</th>
        {{-- Monitor --}}
        <th>nomor_monitor</th>
        <th>kebersihan_monitor</th>
        <th>kondisi_monitor</th>
        {{-- CPU --}}
        <th>nomor_cpu</th>
        <th>kebersihan_pc</th>
        <th>kondisi_keyboardmouse</th>
        <th>kondisi_mainboard</th>
        <th>kondisi_penyimpanan</th>
        <th>kondisi_processor</th>
        <th>kondisi_ram</th>
        <th>kondisi_jaringan</th>
        {{-- Software --}}
        <th>optimasi_software</th>
        <th>optimasi_os</th>
        <th>optimasi_antivirus</th>
        <th>backup_email</th>
    </tr>
  </thead>
  <tbody>
    <?php $nomor=1?>
    @foreach ($list as $list)
        <tr>
            <td>{{$nomor++}}</td>
            <td>{{$list->nomor_perawatan}}</td>
            <td>{{$list->pic}}</td>
            <td>{{$list->user}}</td>
            <td>{{$list->lokasi}}</td>
            <td>{{$list->nomor_monitor}}</td>
            <td>{{$list->kebersihan_monitor}}</td>
            <td>{{$list->kondisi_monitor}}</td>
            <td>{{$list->nomor_cpu}}</td>
            <td>{{$list->kebersihan_pc}}</td>
            <td>{{$list->kondisi_keyboardmouse}}</td>
            <td>{{$list->kondisi_mainboard}}</td>
            <td>{{$list->kondisi_penyimpanan}}</td>
            <td>{{$list->kondisi_processor}}</td>
            <td>{{$list->kondisi_ram}}</td>
            <td>{{$list->kondisi_jaringan}}</td>
            <td>{{$list->optimasi_software}}</td>
            <td>{{$list->optimasi_os}}</td>
            <td>{{$list->optimasi_antivirus}}</td>
            <td>{{$list->backup_email}}</td>
            <td>{{$list->keterangan}}</td>
            <td>{{$list->created_at}}</td>
        </tr>
    @endforeach
  </tbody>
</table>

  </body>
</html>
