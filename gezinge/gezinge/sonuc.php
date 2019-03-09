<!DOCTYPE html>

<html>
<title>Google Maps Multiple Markers</title>
  <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

<form action="" method="post" enctype="multipart/form-data">
   <input type="file" name="dosya" />
   <input type="submit" value="Gönder" />
</form>
<div id="map" style="height: 400px; width: 500px;">
</div>
</html>

<?php

if(isset($_FILES['dosya'])){
   $hata = $_FILES['dosya']['error'];
   if($hata != 0) {
      echo 'Yüklenirken bir hata gerçekleşmiş.';
   } else {
      
         $isim = $_FILES['dosya']['name'];
         $uzanti = explode('.', $isim);
         if($uzanti[1] != 'txt') {
            echo 'Yanlızca .txt dosyaları gönderebilirsiniz.';
         } else {
            $dosya = $_FILES['dosya']['tmp_name'];
            
			if(move_uploaded_file($dosya,''. $_FILES['dosya']['name']))
			
			//copy($dosya, 'deneme/' . $_FILES['dosya']['name']);
            echo 'Dosyanız yüklendi.';
			
			$file = fopen($_FILES['dosya']['name'],"r");

echo "</br></br>";

   echo "<script type=\"text/javascript\">
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
</script >
        ";

	 $sayac=0;
	 $enlem1;
  $enlem2;
  $boylam1;
  $boylam2;
while(! feof($file))
  {
  $dizgi=fgets($file);
 
	
  $dizi = explode(",", $dizgi);
  
	 
	 
  $enlem=floatval($dizi[0]);
  $boylam=floatval($dizi[1]);
  
   
    $enlem2=$enlem;
	$boylam2=$boylam;
  
  
  
echo "<script type=\"text/javascript\">
 var marker;
   marker = new google.maps.Marker({
        position: new google.maps.LatLng($enlem ,$boylam),
        map: map,
		icon:\"yuvarlak.png\"
      });
	  
</script>";

	echo $sayac;
	if($sayac==1) {
	 echo "<script type=\"text/javascript\">
	 
     
        var flightPlanCoordinates = [
          {lat: $enlem1,lng: $boylam1},
			  {lat:$enlem2,lng:$boylam2}
        ];
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        flightPath.setMap(map);
      
	 </script>";
	}
	 $sayac=1;
	 
	 
$enlem1=$enlem;
$boylam1=$boylam;
	  
  echo $enlem."&nbsp"."&nbsp"."&nbsp".$boylam."</br>";



  
  }

fclose($file);
	
         }      
   }
}
 else {
  
}


 


?>