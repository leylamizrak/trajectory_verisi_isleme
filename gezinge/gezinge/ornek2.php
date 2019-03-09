<SCRIPT >
var number=100;
document.write('<a href="?number='+number+'"></a>');
</SCRIPT>

<?php

$sonuc=$_GET['number'];

echo $sonuc;

?>