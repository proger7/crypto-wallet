<?php
if(checkSession()) { header("Location: $settings[url]"); }
$b = protect($_GET['b']);

if($b == "reset") {
	include("password/reset.php"); 
} elseif($b == "change") {
	include("password/change.php");
} else {
	header("Location: $settings[url]");
}
?>