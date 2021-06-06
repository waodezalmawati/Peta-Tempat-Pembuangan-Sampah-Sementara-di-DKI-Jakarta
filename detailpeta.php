<?php

  $id_peta=$_GET['id_peta'];

    //membuka lib/metode
    $ch = curl_init();

    //setting option (set opt) untuk url yang akan dibuka
    curl_setopt($ch, CURLOPT_URL, "http://api.jakarta.go.id/v1/tps/".$id_peta."?format=geojson&page=1");
    
    //setting header
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: zDmi3FTLsQieQ8msSap/ZtrvL9kuSTb0u+fXBZ20rWJtiVRFasnMpn+8c30qeHtt'));

    //setting option (set opt) untuk menerima hasil hit url bisa ada kembalian (return)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    //eksekusi curl
    $output = curl_exec($ch);

    //putuskan/close curl
    //setiap kali melakukan exec, di close dulu curlnya
    curl_close($ch);

    $data = json_decode($output);
    // echo "<pre>"; print_r($data); echo "</pre>"
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Detail Peta</title> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Ini bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Ini maps -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

  <!-- css canvas map -->
  <style type="text/css">
    #map {
      width: 100%;
      height: 520px;
    }
  </style>
</head>
  <body>
    <div class="container">
      <h1>Detail Peta Lokasi </h1>

      <div id='map'></div>
    </div>

    </div>
  </div>
  <br/>

  <script type="text/javascript">
      var locations = [
        <?php

        foreach ($data -> features as $tps) {
          echo '["'.$tps->properties->nama_tps.'", '.$tps->properties->location->latitude.',
          '.$tps->properties->location->longitude.'],';
        }
    ?>
    ];

    var map = L.map('map').setView([-6.196597719175522, 106.83844097263238], 11);
    mapLink =
      '<a href="http://openstreetmap.org">OpenStreetMap</a>';
      L.tileLayer(
      'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; ' + mapLink + ' Contributors',
        maxZoom: 18,
      }).addTo(map);

   
    for (var i = 0; i < locations.length; i++) {
      marker = new L.marker([locations[i][1], locations[i][2]])
        .bindPopup(locations[i][0])
        .addTo(map);
    }
   
  </script>
  </body>

</html>
