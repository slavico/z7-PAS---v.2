<?php
session_start();
require_once 'db_connection.php';

//czas logowania
$time=time();
global $time2;
$time2=date("r",$time);

//ip z którego logowanie zostalo zainicjowane
	$ip = $_SERVER["REMOTE_ADDR"];
	//setcookie ("$user_login", "");
	$user_login=$_POST['login'];
	$user_pass=$_POST['haslo'];
	setcookie ('Login', '', time() - 3600);
	setcookie('Login', $user_login, time() + 3600, "/"); //ustawienie ciasteczka
	//ECHO $_COOKIE['Login'];
    $login = mysql_real_escape_string($login);
	$haslo = mysql_real_escape_string($haslo);
	$proby = mysql_query ("SELECT * FROM z7_users WHERE user_login = '$user_login'");
	$row = mysql_fetch_array($proby);
	$proby = $row['proby'];
	
	// sprawdzamy czy login i hasło są dobre
	$sql = mysql_query("SELECT user_login, user_pass FROM z7_users WHERE user_login = '$user_login' AND user_pass = '$user_pass'");
	if ((mysql_num_rows($sql) > 0) && ($proby<3))
	{
		
		$sql = mysql_query("UPDATE z7_users SET proby = 0 WHERE user_login = '$user_login'");
		$sql2 = mysql_query("INSERT INTO logi SET log_ip='$ip', log_godz='$time2', log_status='OK', log_user='$user_login'");
				
		$ostatnie_logowanie = mysql_query("SELECT log_id FROM logi WHERE log_user='$user_login' ORDER BY log_id DESC LIMIT 1,1");
		$row = mysql_fetch_array($ostatnie_logowanie);
		$ostatnie_logowanie = $row[0];
		//print_r($row[0]); // zwraca log_id ostaniego/poprzedniego (poprzedzajacego poprawne logowanie) błędnego logowania
		//$ostatnie_logowanie--;
		// echo $ostatnie_logowanie; 
		
		$sql5 = mysql_query("SELECT log_status FROM logi WHERE log_user='$user_login' AND log_id='$ostatnie_logowanie'"); // status poprzedniego logowania (jednego przed obecnym)
		$row2 = mysql_fetch_array($sql5);
		$sql5 = $row2[0];
		// print_r($row2[0]); // status poprzedniego logowania
		
			if ($sql5=='OK')
			{
				ECHO "Witaj "; ECHO $_COOKIE['$user_login']."! "; echo " Logowanie przebiegło pomyślnie!";
				echo "<br><br><a href='index_z7.php'>Przejdz do chumry!</a><br><br>";
				echo "<a href='index.php'>Wyloguj się!</a>";
			}
			else
			{
				ECHO "Witaj "; ECHO $_COOKIE['$user_login']."! "; echo " Logowanie przebiegło pomyślnie!"; echo "<br>";  echo "<br>";
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
				
				echo "<br><br><a href='index_z7.php'>Przejdz do chumry!</a><br><br>";
				echo "<a href='index.php'>Wyloguj się!</a>";
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
		echo "<a href='index.php'>Wróć.</a>";
	}

?>
