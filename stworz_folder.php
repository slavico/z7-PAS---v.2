

<form method="POST">
<br>
Podaj nazwę:
<input type="text"  name="nazwa" maxlength="20" size="20"><br>
<input type="submit" value="Stworz katalog." name="Check"/>
</form>



<?php
	
	if(isset($_POST['Check']))
	{
	$folder = $_POST['nazwa'];
	mkdir ("../LAB7/$user_login/$folder", 0777); echo "<br><br>";
	echo "<b>Folder o nazwie: <i>$folder</i> został stworzony na serwerze!</b>";
	echo "<meta http-equiv='refresh' content='0'>";
	}
?>

<a href='index_z7.php'>Wróć.</a><br>






