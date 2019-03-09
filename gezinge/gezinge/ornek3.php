<script type="text/javascript">
var myvar= "hello world";
location.href="http://www.google.com/search?q=" + myvar;
</script>
OR you can do this:
<script type="text/javascript">
var myvar= "hello world";
window.location ="http://www.google.com/search?q=" + myvar;
</script>