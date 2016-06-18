<?
if(!isset($_SESSION))
	session_start();

include("db_io.php");
if(validate_login($_POST['id'], $_POST['password'], $name)) {
	$_SESSION['id'] = $_POST['id'];
	$_SESSION['name'] = $name;
	header('Location: main.php');
} else {
	$_SESSION['flash'] = "ID 또는 Password를 확인해주세요.";
	header('Location: login.html');
}
?>
