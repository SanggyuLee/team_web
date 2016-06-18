<?
include("db_io.php");

if(!strlen($_POST['name']) | !strlen($_POST['id']) | !strlen($_POST['password'])) {
	$_SESSION['flash'] = "이름, 아이디 및 패스워드는 공백이 허용되지 않습니다.";
} else if(strlen($_POST['password']) < 6 || !ereg("[a-z0-9]", $_POST['password'])) {
	$_SESSION['flash'] = "비밀번호는 최소 6자리 이상이며, 영문자와 숫자의 조합으로 구성되어야 합니다.";
} else if(is_exist("USER",$_POST["id"])==TRUE) {
	$_SESSION['flash'] = "이미 존재하는 ID입니다.";
} else {
	insert("USER",$_POST);

	$dirname = "../uploads/".$_POST['id'];
	mkdir($dirname);

	$_SESSION['flash'] = "회원가입에 성공하였습니다.";
}

header('Location: login.html');
?>
