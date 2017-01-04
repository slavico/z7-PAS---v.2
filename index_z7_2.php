<?php
require_once '/LAB8/db_connection.php';
$time=time();
global $time2;
$time2=date("r",$time);

//ip z którego logowanie zostalo zainicjowane
$ip = $_SERVER["REMOTE_ADDR"];
	
	$user_login=$_POST['login'];
	$user_pass=$_POST['haslo'];
	setcookie("Login", $user_login, time() + 3600, "/");
    
		
		
?>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>FIRMA, ŻE TAKIEJ NI MA!</title>
	<meta charset="UTF-8">
	<script src="/LAB8/ckeditor/ckeditor.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<style>
	#container
	{
		width: 1000px;
		margin-left: auto;
		margin-right: auto;
	}
	#logo
	{
		background-color: grey;
		color: white;
		text-align: center;
		padding: 15px;
	}
	#nav
	{
		float: left;
		background-color: lightgray;
		width: 170px;
		min-height: 500px;
		padding: 10px;
	}
	#content
	{
		float: left;
		padding: 20px;
		width: 590px;
	}
	#ad
	{
		float: left;
		width: 160px;
		min-height: 500px;
		padding: 10px;
		background-color: lightgray;
	}
	#footer
	{
		clear: both;
		background-color: black;
		color: white;
		text-align: center;
		padding: 20px;
	}	
	</style>

</head>

<body>

	<div id="container">
	
		<div id="logo">
<?php
	$login = mysql_real_escape_string($login);
	$haslo = mysql_real_escape_string($haslo);
	$proby = mysql_query ("SELECT * FROM z7_users WHERE user_login = '$user_login'");
	$row = mysql_fetch_array($proby);
	$proby = $row['proby'];
	
	// sprawdzamy czy login i hasło są dobre
	$sql = mysql_query("SELECT user_login, user_pass FROM z7_users WHERE user_login = '$user_login' AND user_pass = '$user_pass'");
	if ((mysql_num_rows($sql) > 0) && ($proby<3))
	{
	 //ustawienie ciasteczka
	$sql = mysql_query("UPDATE z7_users SET proby = 0 WHERE user_login = '$user_login'");
		$sql2 = mysql_query("INSERT INTO logi SET log_ip='$ip', log_godz='$time2', log_status='OK', log_user='$user_login'");
				
		$ostatnie_logowanie = mysql_query("SELECT MAX(log_id) FROM logi WHERE log_user='$user_login'");
		$row = mysql_fetch_array($ostatnie_logowanie);
		$ostatnie_logowanie = $row[0];
		// print_r($row[0]); // log_id obecnego logowania
		$ostatnie_logowanie--;
		// echo $ostatnie_logowanie; // zwraca log_id ostaniego/poprzedniego (poprzedzajacego poprawne logowanie) błędnego logowania
		
		$sql5 = mysql_query("SELECT log_status FROM logi WHERE log_user='$user_login' AND log_id='$ostatnie_logowanie'"); // status poprzedniego logowania (jednego przed obecnym)
		$row2 = mysql_fetch_array($sql5);
		$sql5 = $row2[0];

		
			 //czas logowania

		
		// print_r($row2[0]); // status poprzedniego logowania
		
			if ($sql5=='OK')
			{
				ECHO "Witaj "; ECHO $_COOKIE['Login']."! "; echo " Logowanie przebiegło pomyślnie!";
			}
			else
			{
				ECHO "Witaj "; ECHO $_COOKIE['Login']."! "; echo " Logowanie przebiegło pomyślnie!"; echo "<br>";  echo "<br>";
				echo "Ale ostatnie było błędne! Poniżej znajdziesz szczegóły.";
				$blad = mysql_query("SELECT * FROM logi WHERE log_user='$user_login' AND log_id='$ostatnie_logowanie'");
				
				if(mysql_num_rows($blad) > 0) { 
   
				echo "<table cellpadding=\"3\" border=1> 
				<tr>
				<th>log_ip</th>
				<th>log_godz</th>
				<th>log_status</th>
				<th>log_user</th>
				</tr>";
				
				while($r = mysql_fetch_assoc($blad)) { 
					echo "<tr>"; 
					echo "<td>".$r['log_ip']."</td>"; 
					echo "<td>".$r['log_godz']."</td>"; 
					echo "<td>".$r['log_status']."</td>";
					echo "<td>".$r['log_user']."</td>";      
				}
				echo "</table>";
					}
						}
		
		
		
	// historia wszystkich logowań danego usera
	/*
	$sql4 = mysql_query("SELECT * FROM logi WHERE log_user='$user_login' ORDER BY log_id DESC");
	if(mysql_num_rows($sql4) > 0) { 
   
    echo "<table cellpadding=\"3\" border=1> 
	<tr>
	<th>log_ip</th>
	<th>log_godz</th>
	<th>log_status</th>
	<th>log_user</th>
	</tr>";
	
    while($r = mysql_fetch_assoc($sql4)) { 
        echo "<tr>"; 
        echo "<td>".$r['log_ip']."</td>"; 
        echo "<td>".$r['log_godz']."</td>"; 
		echo "<td>".$r['log_status']."</td>";
		echo "<td>".$r['log_user']."</td>";      
    }
	echo "</table>";
		}
		*/
		//header("Location:index_z7.php");
	}
	else if ($proby == 3)
	{
		echo "Konto zosało zablokowane. Proszę skontaktować się z administratorem.";
		//exit;
	}
	else
	{
		$temp=$proby;
		$temp++;
		$sql = mysql_query("UPDATE z7_users SET proby = '$temp' WHERE user_login = '$user_login'");
		$sql2 = mysql_query("INSERT INTO logi SET log_ip='$ip', log_godz='$time2', log_status='NOT OK', log_user='$user_login'");
		ECHO "Wpisano złe dane."; echo "<br>";
		echo "Nieudanych prób:  ".$temp.",   (Konto blokowane po 3 nieudanych logowaniach).";
		
			if ($temp == 3)
			{
				echo "<br>";  echo "<br>";
				echo "UWAGA!"; echo "<br>";
				echo "Konto zostało zablokowane po 3 nieudanych próbach logowania. Proszę skontaktować się z administratorem.";
			}
	}

?>
		</div>
		
		<div id="nav">
			<a href="http://translate.google.com/translate?hl=pl&amp;ie=UTF8&amp;sl=pl&amp;tl=en&amp;u=http://102651.panda5.pl/LAB8/index.php" target="_blank">tłumaczenie</a><br>
			<a href='/LAB8/subpages/user/main.php'>Strona główna.</a><br>
			<a href='/LAB8/subpages/user/historia.php'>Historia firmy.</a><br>
			<a href='/LAB8/subpages/user/lokalizacja.php'>Lokalizacja.</a><br>
			<a href='/LAB8/subpages/user/oferta.php'>Oferta.</a><br>
			<a href='/LAB8/subpages/user/referencje.php'>Referencje.</a><br>
			<a href='/LAB8/subpages/user/kontakt.php'>Kontakt.</a><br>
			<a href='/LAB8/subpages/user/chatbox.php'>Chatbox.</a><br>
			
			<br>
			<br>
			<?php
			
			?>
			
			<h2>Logowanie</h2>
			<br>
			<a href='index.php'>Zaloguj się jako administrator.</a><br>
			
			<?php
		
			
			
			
			?>
			
		</div>
		
		<div id="content">
			
			
			
			<?php
	
	$sql = "SELECT * FROM Z8 WHERE NAZWA='HISTORIA'";
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_array($result))
	{
		echo $row['ZAWARTOSC']; 
      
	}




?>
			
			
			
</div>
				
		<div id="ad">
		
		</div>
	
		<div id="footer">
			Najlepsza firma w okolicy. &copy; Wszelkie prawa zastrzeżone
		</div>
	
	</div>

</body>
</html>