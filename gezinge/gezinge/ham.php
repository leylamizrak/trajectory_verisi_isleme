<!DOCTYPE html>


<html>
<head>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyD79th6ViIKER49deSwc_bDqwkwdSR7o2w"></script>
<title>TRAJECTORY</title>	<link rel="icon" href="icon.png">

  
  
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
	background-color:#00b02c;
	border-color:#00b02c;
	
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
<li><button type="button" id="b1" class="ortak"  onClick="document.location.href='indirge.php'"><b>İndirgeme Ekranı</b></button></li>


</ul>



<div id="map" style="position:absolute;left:3%;top:20%;height: 500px; width: 600px;"></div>


<div id="map2"  style="position:absolute;left:52%;top:20%;height: 500px; width: 600px;"></div>


<div style="position:absolute;left:3%;top:12%; width:1200px;">

<form action="" method="post">
  &nbsp;&nbsp;&nbsp;&nbsp;<b>north-east corner (lat,lng):<b>
  <input type="text" name="ilkLat"  placeholder="-33.87544676874397" required>  <input type="text" name="ilkLong" placeholder="151.3235354423523" required>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>south-west corner (lat,lng):<b>
  <input type="text" name="sonLat" placeholder="-33.96445817920601" required>  <input type="text" name="sonLong" placeholder="151.22353544235227" required>&nbsp;&nbsp;<input type="submit" name="gonder" value="Ara">

</form> 

</div>




</body>
</html>






<?php

$sokete_gonder="";
$str="";


//echo "******".$sokete_gonder;

echo "<script type=\"text/javascript\">
  var map = new google.maps.Map(document.getElementById('map'), {
       zoom:1,
      center: new google.maps.LatLng(0,0),
      mapTypeId:google.maps.MapTypeId.ROADMAP
    });
</script >
        ";


		
echo "<script type=\"text/javascript\">
  var map2 = new google.maps.Map(document.getElementById('map2'), {
      zoom:1,
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



$sqlbound = "SELECT * FROM koordinat";
$resultbound = $link->query($sqlbound);
if ($resultbound->num_rows >0) {
	$row = $resultbound->fetch_assoc();
	$enlembound=$row["enlem"];
	$boylambound=$row["boylam"];
}
	


 
 echo "<script>   

 var bounds = {
          north:0,
            south:-50,
            east: 0,
            west: -30
        };
		
		bounds.north=$enlembound;
		bounds.east=$boylambound;
		bounds.south=$enlembound-1;
		bounds.west=$boylambound-1
		
	
		
		
		
		map.setCenter(new google.maps.LatLng($enlembound,$boylambound));
		map.setZoom(5);
		
		map2.setCenter(new google.maps.LatLng($enlembound,$boylambound));
		map2.setZoom(5);
 
 	 dikdortgen = new google.maps.Rectangle({
          bounds: bounds,
          editable: true,
          draggable: true
        });
		
		var coor=\".\";
        dikdortgen.setMap(map);	
		
		 dikdortgen.addListener('bounds_changed', showNewRect);
		 dikdortgen.addListener('bounds_changed', showNewRect);

        // Define an info window on the map.
        infoWindow = new google.maps.InfoWindow();
		
		
	
	var e;
	
		function showNewRect(event) {
			
			
			
        var ne = dikdortgen.getBounds().getNorthEast();
        var sw = dikdortgen.getBounds().getSouthWest();

        var contentString = '<b>Rectangle moved.</b><br>' +
            'New north-east corner (lat,lng): ' + ne.lat() + ', ' + ne.lng() + '<br>' +
            'New south-west corner (lat,lng): ' + sw.lat() + ', ' + sw.lng();

        
		// Set the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(ne);

        infoWindow.open(map);
		
      }
	  
 </script>";
 
 
 if(isset($_POST['gonder']))
{
	//echo $_POST['ilkLat'];
	//echo $_POST['ilkLong'];
	//echo $_POST['sonLong'];
	//echo $_POST['sonLat'];
	

$sokete_gonder=$_POST['ilkLat'].",".$_POST['ilkLong'].",".$_POST['sonLat'].",".$_POST['sonLong'].",";
	//echo "******".$sokete_gonder;
	
	//echo $sokete_gonder.$str;
	
	$sql = "SELECT * FROM file";
$result = $link->query($sql);
if ($result->num_rows >0) {
	$row = $result->fetch_assoc();
	$kontrol=$row["kontrol"];
}
	
	
	$sokete_gonder=$sokete_gonder.$str.",".$kontrol.","."1";
	
	
$PORT = 20224; //the port on which we are connecting to the "remote" machine
$HOST = "localhost"; //the ip of the remote machine (in this case it's the same machine)

$sock = socket_create(AF_INET, SOCK_STREAM, 0) //Creating a TCP socket
		or die("error: could not create socket\n");

$succ = socket_connect($sock, $HOST, $PORT) //Connecting to to server using that socket
		or die("error: could not connect to host\n");

//$text = "Hello, Java!"; //the text we want to send to the server

socket_write($sock, $sokete_gonder . "\n", strlen($sokete_gonder) + 1) //Writing the text to the socket
		or die("error: failed to write to socket\n");

$reply = socket_read($sock, 10000, PHP_NORMAL_READ) //Reading the reply from socket
		or die("error: failed to read from socket\n");


//echo "Sonuç: ".$reply;


$dizi = explode(",", $reply);


  $k=0;
  
  $p;
  
  
  //echo "SONUUUUUUUUUUUUUUUUUC:";
  
for($k=0;$k<count($dizi)-1;$k=$k+2)

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
		icon:\"kirmizi.png\",
		title: '($en1,$boy1)'
      });
	  
</script>";







}






}
 
 
 
$link->close();

?>