<?php
	session_start();
	//setcookie ("Login", ""); //, time() - 3600);
	
	echo "Zostałeś wylogowany.";

	$_SESSION = array();

?>
<a href='index.php'>Przejdź do panelu logowania.!</a>