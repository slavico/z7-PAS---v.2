<?php
session_start();
require_once '/LAB8/db_connection.php';

	//setcookie("Login", "");
	//echo $_COOKIE['Login'];
?>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Chmura prywatna.</title>
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
		width: 570px;
	}
	#ad
	{
		float: left;
		width: 180px;
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

		</div>
		
		<div id="nav">
			
			
			
			
		
			
		</div>
		
		<div id="content">
			
			<?
// echo $_COOKIE['Login'];
 ECHO "FOLDERY i PLIKI w KATALOGU  ".$_COOKIE['Login'];
 ECHO "<br><br>";
 

$path='../LAB7/'.$_COOKIE['Login'].'/';
$dir = array_diff(scandir($path), array('.', '..'));
foreach($dir as $x)
{
	$x1=rawurlencode($x);
	if(is_dir('../LAB7/'.$_COOKIE['Login'].'/'.$x))
	{
		 echo '<li><b><a href='.'../LAB7/'.$_COOKIE['Login'].'/'.$x1.' target=_blank>'.$x.'(folder)</a></b></li>';
		 $directory='../LAB7/'.$_COOKIE['Login'].'/'.$x;
		 $dir1=array_diff(scandir($directory), array('.', '..'));
		 echo "<ul>";
		 foreach($dir1 as $y)
		 {
			 $y1=rawurlencode($y);
			 $directory1=$directory.'/'.$y1;
			 if(is_dir($directory1))
			 {
			 echo '<li><b><a href="'.$directory1.'" target=_blank>'.$y.'(folder)</a></b></li>';
			 }
			 else
			 {
			 echo '<li><a href="'.$directory1.'" target=_blank>'.$y.'(plik)</a></li>';
			 }
		 }
		 echo "</ul>";
	}
	else
	{
		echo '<li><a href='.'../LAB7/'.$_COOKIE['Login'].'/'.$x1.' target=_blank>'.$x.'(plik)</a></li>';
	}
}
 
 

 /*
function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ol>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li>'.$ff;        
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</li>';
        }
    }
    echo '</ol>';
}

listFolderFiles('../LAB7/'.$user_login);
 */
?>
</div>
				
<div id="ad">
		
		<form method="POST">
		<br>
		Podaj nazwę:
		<input type="text"  name="nazwa" maxlength="20" size="20"><br>
		<input type="submit" value="Stwórz katalog." name="Check"/>
		</form>

<?php
    $tmp=$_COOKIE['Login'];
	if(isset($_POST['Check']))
	{
	$folder = $_POST['nazwa'];
	mkdir ("../LAB7/$tmp/$folder", 0777); echo "<br><br>";
	echo "<b>Folder o nazwie: <i>$folder</i> został stworzony na serwerze!</b>";
	echo "<meta http-equiv='refresh' content='2'>";
	}
?>
</div>
	
		<div id="footer">
			Chmura. &copy; Wszelkie prawa zastrzeżone
			<a href='index.php'>Wyloguj się.</a><br>
		</div>
	
	</div>

</body>
</html>