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

function language_filter($content) {
	$insults = array("병신", "씨발", "개새끼", "존나", "fuck");
	foreach($insults as $insult)
		$content = str_replace($insult, "**", $content);

	return $content;
}

function shortword_filter($content) {
	$words = array("얼집", "샵지", "샵니", "윰차", "완모", "올팍", "쓰봉", "키카", "랑구", "신행", "영유", "음쓰", "#G");
	$meaning = array("어린이집", "시아버지", "시어머니", "유모차", "완전모유소유", "올림픽공원", "쓰봉", "키즈카페", "신랑", "신혼여행", "영어유치원", "음식물쓰레기", "시아버지");

	for($i = 0; $i < count($words); $i++)
		$content = str_replace($words[$i], $words[$i]."(뜻:".$meaning[$i].")", $content);

	return $content;
}

function convert_hashtags($content){
	$regex = "/#+([a-zA-Z0-9가-힇_]+)/";
	$content= preg_replace($regex, '<a href=main.html?board=hashtag&hashtag=$1>$0</a>', $content);

	return $content;
}

if(empty($_POST['content']) && $_FILES[picture][size] == 0) {
	$_SESSION['flash'] = "그림 또는 글을 작성하셔야 합니다.";
} else if($_FILES[picture][size] != 0 && !picture_check()) {
	$_SESSION['flash'] = "그림은 jpg, png, gif만 가능합니다.";
} else {
	$_POST['content'] = language_filter($_POST['content']);
	$_POST['content'] = shortword_filter($_POST['content']);
	$_POST['content'] = convert_hashtags($_POST['content']);

	if($_POST['edit'] != 1) {
		$num = insert("POST", $_POST);
		picture_save($num);
	} else {
		update_post($_POST);
	}
}

$board = $_SESSION['board'];
header("Location: main.html?board=$board");
?>
