<?php

  $id_kec=$_GET['id_kec'];


    //membuka lib/metode
    $ch = curl_init();

    //setting option (set opt) untuk url yang akan dibuka
    
    curl_setopt($ch, CURLOPT_URL, "http://api.jakarta.go.id/v1/kecamatan/".$id_kec."?format=geojson");
    
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

<h1>
  <?php
    echo 'Kecamatan: ';
    echo $data->features[0]->properties->nama_kecamatan;
    ?>
    
</h1>