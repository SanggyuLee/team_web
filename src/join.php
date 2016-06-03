<?
include("db_io.php");

if(is_exist("USER",$_POST["id"])==TRUE)
{
	header("Location: main.html");
}
else
{
	insert("USER",$_POST);
}
?>