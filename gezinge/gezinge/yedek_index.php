
<!DOCTYPE html>


<html>
<head>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyD79th6ViIKER49deSwc_bDqwkwdSR7o2w"></script>

  
  
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
  <li><a class="active" style="color:#00CED1;font-size:22px;" ><b>GEZİNGE VERİSİ  İŞLEME</b></a></li>
  <li><a href="#news">	
	<form  action="" method="post" enctype="multipart/form-data" >
   <input type="file" name="dosya"/>   <input type="submit" id="play_button"   value="Haritada Göster" />
</form>
</a></li>

<!--<li><button type="button" id="harita" class="ortak"  onclick="fonk()"	><b>Haritada Göster</b></button></li>-->

<li><button type="button" id="b1" class="ortak" onclick="indirgeme()" ><b>İndirgeme Servisi</b></button></li>
<li><button type="button" id="b2"  class="ortak" onclick="fonk()"><b>Sorgu Servisi-Ham Veri</b></button></li>
<li><button type="button" id="b3"  class="ortak" style="visibility:hidden"><b>Sorgu Servisi-İndirgenmiş Veri</b></button></li>

<div id="sbt">

</div>
</ul>


<p id="demo"></p>
 <script > 

 function  indirgeme()
 {
	
	 
 }
 
</script>




 <script type="text/javascript"> 

function fonk(){ 
      // notice the quotes around the ?php tag         
     var htmlString="<?php $dosya_name=$_FILES['dosya']['name']; 
	 
	 echo $dosya_name;
	 
	  ?>";
 if(htmlString.length!=0)
	  alert(htmlString);
  
 
 
}
</script>

<div id="map2" style="position:absolute;left:3%;top:15%;height: 500px; width: 600px;"></div>
<div id="map" style="position:absolute;left:52%;top:15%;height: 500px; width: 600px;"></div>




</body>
</html>


<?php
$link = mysqli_connect("localhost", "root", "", "konum");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_FILES['dosya'])){
   $hata = $_FILES['dosya']['error'];
   if($hata != 0) {
      $message = "Yüklenirken bir hata gerçekleşmiş.";
echo "<script type='text/javascript'>alert('$message');</script>";
   } else {
		
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
		 	
			$file = fopen($_FILES['dosya']['name'],"r");

echo "</br></br>";


   /*echo "<script type=\"text/javascript\">
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
</script >
        ";

   echo "<script type=\"text/javascript\">
  var map = new google.maps.Map(document.getElementById('map2'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
</script >
        ";*/

		$k=0;
		
		$koordinat=array();
		
		
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
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
  
   $koordinat[$k][0]=$enlem;
	 $koordinat[$k][1]=$boylam;
   $k=$k+1;

   
   
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

echo "</br>"."****************"."</br>"."</br>";

for($b=0;$b<count($koordinat);$b++)
{
	echo $koordinat[$b][0]."&nbsp"."&nbsp"."&nbsp".$koordinat[$b][1]."</br>";
}

$koordinat=json_encode($koordinat);

echo $koordinat;

echo '<script> type="text/javascript">','deneme();','</script>';

		 }
			
   }
}


?>

