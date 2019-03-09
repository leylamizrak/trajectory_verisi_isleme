<?php



$link = mysqli_connect("localhost", "root", "", "konum");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else echo "success";

$str="";

$sql = "SELECT * FROM koordinat";
$result = $link->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
		$st=$row["enlem"].",". $row["boylam"];
		$domain = strstr($row["enlem"], '-');
		if($domain==$row["enlem"])
	$en1=floatval(substr($domain,1));
	echo $en1;
		
	}
	
}


?>