<?
include('db_io.php');
include('draw.php');
ensure_logged_in();

$users = get_users("*", null);
foreach($users as $user) {
	if(strstr($user['name'], $_POST['search'])) {
		draw_user($user);
	}
}
?>
