<?
include("db_io.php");
if(valid($_POST["id"],$_POST["password"]))
	header('Location: main.php');
else
	echo "Failed";
?>
