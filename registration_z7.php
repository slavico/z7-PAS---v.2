<form method="POST">
<br>
Podaj login usera:
<input type="text"  name="login" maxlength="20" size="20"><br>
Podaj haslo usera:
<input type="password" name="password" maxlength="20" size="20"><br><br>
<input type="submit" value="Dokonaj rejestracji." name="Check"/>
</form>

<?php
require_once 'db_connection.php'; //Łączenie z bazą.

$nowy_user = $_POST['login']; //Przypisanie danych z formularza.
$password = $_POST['password'];

$sql = mysql_query("SELECT * FROM z7_users WHERE user_login='$nowy_user'");
$licz = mysql_num_rows($sql); //Zliczenie ilości wierszy w tabeli users.

if(isset($_POST['Check']))
{
if($licz>0){ //Jeśli użytkownik już isnieje.
  echo 'Przepraszamy, podany login jest zajęty';
} else {
	$nowy_user = mysql_real_escape_string($nowy_user);
	$password = mysql_real_escape_string($password);
	$sql = "INSERT INTO z7_users SET user_login='$nowy_user', user_pass='$password', proby = 0";
	mysql_query($sql);
  
  echo "Użytkownik o loginie: ".$nowy_user.", został dodany.";
  
  
	$folder = $_POST['login'];
	mkdir ("../LAB7/$folder", 0777); echo "<br><br>";
	echo "<b>Folder o nazwie: <i>$folder</i> został stworzony na serwerze!</b>";
  
  //ftp://reins%2540102651.panda5.pl@serwer1670817.home.pl/LAB7
//  http://102651.panda5.pl/LAB7/
  
}}

?>
<br>
<a href='index.php'>Zaloguj się!</a>