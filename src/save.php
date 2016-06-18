<?
include('db_io.php');
if(!isset($_SESSION))
	session_start();

ensure_logged_in();

function picture_check() {
	$file = $_FILES[picture][tmp_name]; 

	$fileinfo = pathinfo($_FILES[picture][name]);
	$ext = $fileinfo['extension'];
	if($ext != 'png' && $ext != 'jpg' && $ext != 'gif' && $ext != 'jpeg')
		return FALSE;

	return TRUE;
}

function picture_save($num) {
	$file = $_FILES[picture][tmp_name];

	move_uploaded_file($file, "../uploads/".$_SESSION['id']."/".$num);
}

if(empty($_POST['content']) && $_FILES[picture][size] == 0) {
	$_SESSION['flash'] = "그림 또는 글을 작성하셔야 합니다.";
} else if($_FILES[picture][size] != 0 && !picture_check()) {
	$_SESSION['flash'] = "그림은 jpg, png, gif만 가능합니다.";
} else {
	$num = insert("POST", $_POST);
	picture_save($num);
}

$board = $_POST['board'];
header("Location: main.html?board=$board");
?>
