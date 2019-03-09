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
  
<li><button type="button" id="b1" class="ortak"  onClick="document.location.href='ham.php'"><b>Sorgu Servisi-Ham Veri</b></button></li>
<li><button type="button" id="b2"  class="ortak" onClick="document.location.href='indirgenmis.php'" ><b>Sorgu Servisi-İndirgenmiş Veri</b></button></li>

</ul>



<div id="map" style="position:absolute;left:3%;top:15%;height: 500px; width: 600px;"></div>


<div id="map2"  style="position:absolute;left:52%;top:15%;height: 500px; width: 600px;"></div>



</body>
</html>


<?php




echo "<script type=\"text/javascript\">
  var map = new google.maps.Map(document.getElementById('map'), {
       zoom: 1,
      center: new google.maps.LatLng(0,0),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
</script >
        ";


		
echo "<script type=\"text/javascript\">
  var map2 = new google.maps.Map(document.getElementById('map2'), {
       zoom: 1,
      center: new google.maps.LatLng(0,0),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
</script >
        ";
		
		$sayac=0;
 $en1;
  $en2;
  $boy1;
  $boy2;

$link = mysqli_connect("localhost", "root", "", "konum");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//else echo "success";

$str="";

$sql = "SELECT * FROM koordinat";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
		$st=$row["enlem"].",". $row["boylam"];
		$str=$str.",".$row["enlem"].",". $row["boylam"];
		
		
		$domain = strstr($row["enlem"], '-');
		if($domain==$row["enlem"]){
	$en1=floatval(substr($domain,1));
	 $en1=$en1*-1;
		}
		else 	$en1=floatval($row["enlem"]);

	$domain = strstr($row["boylam"], '-');
		if($domain==$row["boylam"]){
	$boy1=floatval(substr($domain,1));
	 $boy1=$boy1*-1;
		}
		else $boy1=floatval($row["boylam"]);

			
	
		//echo "noktaaaaaaa".$en1." ".$boy1;
		
		echo "<script type=\"text/javascript\">
 var marker;
   marker = new google.maps.Marker({
        position: new google.maps.LatLng($en1 ,$boy1),
        map: map,
		icon:\"marker.png\",
		title: '($en1,$boy1)'
      });
	  
</script>";
//echo $sayac;
	if($sayac==1) {
	 echo "<script type=\"text/javascript\">
	 
     
        var flightPlanCoordinates = [
          {lat: $en2,lng: $boy2},
			  {lat:$en1,lng:$boy1}
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

	 $en2=$en1;
	 $boy2=$boy1;
		
		//echo "id: " . $row["enlem"]. " - Name: " . $row["boylam"];
    }
} else {
    echo "0 results";
}


//echo "************"."</br>";

//echo $str;

//echo "***********";


$tablo_sil;


$sql = "SELECT * FROM indirgenmis";
$result = $link->query($sql);

$reply="";

if ($result->num_rows > 0) {

 while($row = $result->fetch_assoc()) {

$reply=$reply.$row['enlem2'].",".$row['boylam2'].",";
 
 }
 $zamanoran_komut = "SELECT * FROM zamanoran";
$result2 = $link->query($zamanoran_komut);

if ($result2->num_rows > 0) {

$row = $result2->fetch_assoc();

$reply=$reply.$row['zaman'].",".$row['oran'];
 
 
}
 
 $tablo_sil=0;
 
}
else {

$tablo_sil=1;

$PORT = 20222; //the port on which we are connecting to the "remote" machine
$HOST = "localhost"; //the ip of the remote machine (in this case it's the same machine)

$sock = socket_create(AF_INET, SOCK_STREAM, 0) //Creating a TCP socket
		or die("error: could not create socket\n");

$succ = socket_connect($sock, $HOST, $PORT) //Connecting to to server using that socket
		or die("error: could not connect to host\n");

//$text = "Hello, Java!"; //the text we want to send to the server

socket_write($sock, $str . "\n", strlen($str) + 1) //Writing the text to the socket
		or die("error: failed to write to socket\n");

$reply = socket_read($sock, 10000, PHP_NORMAL_READ) //Reading the reply from socket
		or die("error: failed to read from socket\n");

}
		
		
		
//echo $reply;


  $dizi = explode(",", $reply);


  $k=0;
  
  $p;
  
  $sayac=0;
  
  //echo "SONUUUUUUUUUUUUUUUUUC:";
  
for($k=0;$k<count($dizi)-3;$k=$k+2)

{
	$enlem=$dizi[$k];
	$boylam=$dizi[$k+1];
	
	
	$en1=floatval($enlem);
	$boy1=floatval($boylam);
	
	//echo $en1."******".$boy1;
	
	echo "<script type=\"text/javascript\">
 var marker;
   marker = new google.maps.Marker({
        position: new google.maps.LatLng($en1 ,$boy1),
        map: map2,
		icon:\"marker.png\",
		title: '($en1,$boy1)'
      });
	  
</script>";

//echo $sayac;
	if($sayac==1) {
	 echo "<script type=\"text/javascript\">
	 
     
        var flightPlanCoordinates = [
          {lat: $en2,lng: $boy2},
			  {lat:$en1,lng:$boy1}
        ];
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 1.5
        });

        flightPath.setMap(map2);
      
	 </script>";
	}
	 $sayac=1;

	 $en2=$en1;
	 $boy2=$boy1;
	
	
	
$zaman=$dizi[count($dizi)-2];

$oran=$dizi[count($dizi)-1];

echo "<input type=\"text\"  style=\"position:absolute;left:25%;top:10%;height:15px; width:600px;\" name=\"lastname\" value=\"                  İndirgeme Oranı:$oran               İndirgeme süresi:$zaman\" readonly >";
	

	if($tablo_sil==1){

				$zamanoran_sil = "DELETE FROM zamanoran";
	
		if ($link->query($zamanoran_sil) === TRUE) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $link->error;
}

 $sql = "INSERT INTO zamanoran (zaman,oran) VALUES ('$zaman','$oran')";

  if(mysqli_query($link, $sql)){
    //echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

	
 $sql = "INSERT INTO indirgenmis (enlem2,boylam2) VALUES ('$enlem','$boylam')";

  if(mysqli_query($link, $sql)){
    //echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

	}



}


$sqlbound = "SELECT * FROM koordinat";
$resultbound = $link->query($sqlbound);
if ($resultbound->num_rows >0) {
	$row = $resultbound->fetch_assoc();
	$enlembound=$row["enlem"];
	$boylambound=$row["boylam"];
}
	 
	 	 echo "<script type=\"text/javascript\">
	 
     
		map.setCenter(new google.maps.LatLng($enlembound,$boylambound));
		map.setZoom(5);
		
		map2.setCenter(new google.maps.LatLng($enlembound,$boylambound));
		map2.setZoom(5);
      
	 </script>";



$link->close();

?>