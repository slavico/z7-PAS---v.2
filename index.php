<?php
session_start();
require_once 'db_connection.php';
//setcookie ("Login", ""); //, time() - 3600);
?>

WITAMY W PANELU LOGOWANIA DO PRYWATNEJ CHMURY:
<br><br>
Zaloguj się na konto:
<br>
<form method="POST" action="logowanie.php">
<b>Login:</b> <input type="text" name="login"><br>
<b>Hasło:</b> <input type="password" name="haslo"><br>
<br>
<input type="submit" value="Zaloguj się." name="loguj">
</form>
<br>
<a href='registration_z7.php'>Utwórz nowe konto!</a>