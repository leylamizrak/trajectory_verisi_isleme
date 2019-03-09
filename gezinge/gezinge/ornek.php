
<script> 

var myJavascriptVar="Kocaeli";

document.cookie = "myJavascriptVar = " + myJavascriptVar </script>



<?php
     $myPhpVar= $_COOKIE['myJavascriptVar'];
	 
	 echo $myPhpVar;
?>

