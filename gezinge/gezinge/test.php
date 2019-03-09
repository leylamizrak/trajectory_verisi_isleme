<?php 

echo "Leyla";

//header("Refresh: 2; url=index.php");

$arabalar=array("bmw","volswagen","audi","nissan");

echo "<input type=\"hidden\" name=\"dizi_post\" value=\"<?php echo serialize($arabalar)?>\">";

?>