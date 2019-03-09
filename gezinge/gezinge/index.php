<!DOCTYPE html>
<html>
<head>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyD79th6ViIKER49deSwc_bDqwkwdSR7o2w"></script>

	<title>TRAJECTORY</title>
	
	<link rel="icon" href="icon.png">

	
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}

input[type=file]{
  color:transparent;
}

#play_button {
    position:absolute;
    top:3.5%;
    left:31%;
}

#harita{
	
	
	left:45%;
	background-color:#6495ed;
	border-color:#6495ed;
	
}

.ortak{
	height:33px;
	width:150px;
	position:absolute;
    top:3%;
	font-size:12px;
	
}

#b1{
	
	left:58%;
	background-color:#bf62b8;
	border-color:#bf62b8;
	
}


#b2{
	
	left:70%;
	background-color:#FFA07A;
	border-color:#FFA07A;
	
}

#b3{
	
	left:82%;
	background-color:#4d915d;
	border-color:#4d915d;
	
}

</style>
</head>
<body>

<ul>
  <li><a href="index.php" class="active" style="color:#00CED1;font-size:22px;" ><b>GEZİNGE VERİSİ  İŞLEME</b></a></li>
  <li><a href="index.php">	
	<form  action="" method="post" enctype="multipart/form-data" >
   <input type="file" name="dosya"/>   <input type="submit" id="play_button"  name="gndr" value="Haritada Göster" />
</form>
</a></li>

<!--<li><button type="button" id="harita" class="ortak"  onclick="fonk()"	><b>Haritada Göster</b></button></li>-->

<li><button type="button" id="b1" class="ortak"  onClick="document.location.href='indirge.php'"><b>İndirgeme Servisi</b></button></li>
<li><button type="button" id="b2"  class="ortak" onClick="document.location.href='sorgu.php'"><b>Sorgu Servisi-Ham Veri</b></button></li>

<div id="sbt">

</div>
</ul>



<div id="map" style="position:absolute;left:6%;top:12%;height:550px; width:1200px;"></div>





</body>
</html>


<?php
$link = mysqli_connect("localhost", "root", "", "konum");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


 if (!isset($_POST["gndr"])){
  // "Save Changes" clicked
$sql = "SELECT * FROM file";
$result = $link->query($sql);
if ($result->num_rows >0) {
	$row = $result->fetch_assoc();
	$_FILES['dosya']['name']=$row["dosya"];
	$_FILES['dosya']['tmp_name']=$row["temp"];

}
 }

if(isset($_FILES['dosya'])){
//$hata = $_FILES['dosya']['error'];
   /*if($hata != 0) {
      $message = "Yüklenirken bir hata gerçekleşmiş.";
echo "<script type='text/javascript'>alert('$message');</script>";
   } else {*/
		 
         $isim = $_FILES['dosya']['name'];
         $uzanti = explode('.', $isim);
         if($uzanti[1] != 'txt') {
            
			
			
      $message = 'Yanlızca .txt dosyaları gönderebilirsiniz.';
echo "<script type='text/javascript'>alert('$message');</script>";
			
         } else {
            $dosya = $_FILES['dosya']['tmp_name'];
            
			if(move_uploaded_file($dosya,''. $_FILES['dosya']['name']))
			{			
			//copy($dosya, 'deneme/' . $_FILES['dosya']['name']);
			
  //          $message = $isim." başarıyla yüklendi.";
//echo "<script type='text/javascript'>alert('$message');</script>";
		 }
		 	
			$sql = "DELETE FROM koordinat";
		$sql2 = "DELETE FROM indirgenmis";

				$zamanoran_sil = "DELETE FROM zamanoran";

		
if ($link->query($sql) === TRUE) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $link->error;
}

if ($link->query($sql2) === TRUE) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $link->error;
}


if ($link->query($zamanoran_sil) === TRUE) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $link->error;
}


			$silindi=0;
			$kontrol;
if (isset($_POST["gndr"])){
  // "Save Changes" clicked

			
			
$sql = "SELECT * FROM file";
$result = $link->query($sql);
if ($result->num_rows >0) {
	$silindi=1;
	$row = $result->fetch_assoc();
	$kontrol=$row["kontrol"];
}

			  $sqlsil = "DELETE FROM file";
if ($link->query($sqlsil) === TRUE) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $link->error;
}
  
   
if ($silindi ==0) {
	 $sql5 = "INSERT INTO file (dosya,temp,kontrol) VALUES ('$isim','$dosya','0')";
}
else 
{
	$kontrol=$kontrol+1;
		$sql5 = "INSERT INTO file (dosya,temp,kontrol) VALUES ('$isim','$dosya','$kontrol')";
  
}

 
 if(mysqli_query($link, $sql5)){
    //echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}			
 }


			
			
			$file = fopen($_FILES['dosya']['name'],"r");

echo "</br></br>";

	

   echo "<script type=\"text/javascript\">
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 2,
      center: new google.maps.LatLng(0,0),
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
  
  $sql = "INSERT INTO koordinat (enlem,boylam) VALUES ('$enlem','$boylam')";

  if(mysqli_query($link, $sql)){
    //echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


   
   
    $enlem2=$enlem;
	$boylam2=$boylam;
  
  
  
echo "<script type=\"text/javascript\">
 var marker;
   marker = new google.maps.Marker({
        position: new google.maps.LatLng($enlem ,$boylam),
        map: map,
		icon:\"marker.png\",
		title: '($enlem,$boylam)'
      });
	  
</script>";

	//echo $sayac;
	if($sayac==1) {
	 echo "<script type=\"text/javascript\">
	 
     
        var flightPlanCoordinates = [
          {lat: $enlem1,lng: $boylam1},
			  {lat:$enlem2,lng:$boylam2}
        ];
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 1.5
        });

        flightPath.setMap(map);
      
	 </script>";
	}
	 $sayac=1;
	 
	 
	 
$sqlbound = "SELECT * FROM koordinat";
$resultbound = $link->query($sqlbound);
if ($resultbound->num_rows >0) {
	$row = $resultbound->fetch_assoc();
	$enlembound=$row["enlem"];
	$boylambound=$row["boylam"];
}
	 
	 echo "<script type=\"text/javascript\">
		map.setCenter(new google.maps.LatLng($enlembound,$boylambound));
		map.setZoom(6);
		
</script>";
	 

	 
$enlem1=$enlem;
$boylam1=$boylam;
	  
  //echo $enlem."&nbsp"."&nbsp"."&nbsp".$boylam."</br>";
  }

fclose($file);

 



		//ty}
			
   }
}

$link->close();

?>
