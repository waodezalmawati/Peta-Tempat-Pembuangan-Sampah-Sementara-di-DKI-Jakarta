<?php

    //membuka lib/metode
    $ch = curl_init();
    
    //setting option (set opt) untuk url yang akan dibuka
    curl_setopt($ch, CURLOPT_URL, "http://api.jakarta.go.id/v1/tps/1,2,99,79,59,39,3,4,5,12,25,30,40,50,60,65,80,90,100,120,110,200,125,130,140,150,160,250?format=geojson&page=1");
    
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
  <title>Peta Tempat Pembuangan Sampah Sementara</title> 
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
      height: 500px;
    }
    /* Ini untuk carousel */
    /* .carousel-inner img {
    width: 100%;
    height: 400px;
  } */
  </style>
</head>
  <body>

  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
  
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#map">Lihat Peta</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#myInput">Cari TPS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#myTable">Daftar TPS Jakarta</a>
      </li>    
    </ul>
  </div>  
</nav>
<br>


    <div style='text-align:center' class="container">
    <h1 >Data Tempat Pembuangan Sampah Sementara</h1>

  
    <div id='map'></div>
    <br/>
    
    <input class="form-control" id="myInput" type="text" placeholder="Cari TPS">
    <br>
  
    <table class="table table-dark table-hover">
        <thead>
            <tr>
              <th>Nama TPS</th>
              <th>Kota</th>
              <th>Kode Kecamatan</th>
              <th>Detail Peta</th>
              
            </tr>
            
          </thead>
          <tbody id="myTable">
          <?php
            foreach ($data -> features as $tps) {
              
            echo '         
              <tr>
              <td>'.$tps->properties->nama_tps.'</td>
              <td>                
              ';

              $kode = $tps->properties->kode_kota;
              if($kode == 3174){
                echo "Jakarta Barat";
              }
              elseif($kode == 3173){
                echo "Jakarta Pusat";
              }
              elseif($kode == 3171){
                echo "Jakarta Selatan";
              }
              elseif($kode == 3172){
                echo "Jakarta Timur";
              }
              else {
                echo "Jakarta Utara";
              }
              ;
             echo '
              </td>
              <td><a href=detailkec.php?id_kec='.$tps->properties->kode_kecamatan.'>              
              '.$tps->properties->kode_kecamatan.'</td>
              <td> 
                    <a href=detailpeta.php?id_peta='.$tps->properties->location->latitude.','.$tps->properties->location->longitude.'>
                    Lihat Peta</a></td> 
              </td>
            </tr>';
          }
          ?>
          </tbody>
        </table>
      
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

        $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });


  </script>
  </body>

</html>
