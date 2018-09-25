<?php
if(checkSession()) { header("Location: $settings[url]"); }
$b = protect($_GET['b']);

if($b == "verification") {
	include("email/verification.php"); 
} else {
	header("Location: $settings[url]");
}
?>