<?
if(!isset($_SESSION))
	session_start();

session_destroy();
session_regenerate_id();
session_start();

header('Location: login.html');
?>
