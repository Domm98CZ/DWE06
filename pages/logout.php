<?php
$opt = array_keys($_SESSION);
for($i = 0;$i < count($opt);$i++) unset($_SESSION[$opt[$i]]);
header("Location: http://".Web_GetOption("URL")."");  
?>