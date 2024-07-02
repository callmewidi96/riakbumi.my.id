
<script src="js/jquery-3.6.0.js"></script>
<script>


$(document).ready(function () { 
    createCookie("gfg", "GeeksforGeeks", "10"); 
}); 

</script>
<?php
   echo $_COOKIE["gfg"]; 
?>