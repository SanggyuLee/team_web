<?
if(!isset($_SESSION))
	session_start();

/* DB_IO.php */
$db = new PDO("mysql:dbname=babycare;host=localhost", "root", "master123");

function insert($table, $data) {
	global $db;

	switch($table) {
	case "USER":
		$id = $db->quote($data["id"]);
		$password = $db->quote($data["password"]);
		$name = $db->quote($data["name"]);
		$age = $data["year"] + 1;
		$baby = $data["baby_year"] + 1;
		$phone = $db->quote($data["phone"]."-".$data["middle_number"]."-".$data["last_number"]);
		$location = $db->quote($data["location"]);
		$is_single = $db->quote($data["is_single"]);
		$gender = $db->quote($data["gender"]);

		$query = "insert into USER values(null, $id, $password, $name, $age, $baby, $phone, $location, 'y', 'm')";
		$db->exec($query);
		break;

	case "POST":
		$num = $data["num"];
		$name = $db->quote($data["name"]);
		$author = $db->quote($data["name"]);
		$content = $db->quote($data["content"]);
		$date = $db->quote($data["date"]);
		$time = $db->quote($data["time"]);
		$public = $db->quote($data["public"]);

		if($_POST['board'] != "anonymous")
			$type = $db->quote("personal");
		else
			$type = $db->quote("anonymous");

		$query = "insert into POST values(null, $num, $name, $content, $date, $time, $public, $type)";
		$db->exec($query);

		$row = $db->query("select num from POST where num=(select max(num) from POST)");
		$row = $row->fetch();

		return $row['num'];

	case "REPLY":
		$post_num = $data['num'];
		$name = $db->quote($_SESSION['name']);
		$content = $db->quote($data['content']);
		$date = $db->quote($data['date']);
		$time = $db->quote($data['time']);

		$query = "insert into REPLY values(null, $post_num, $name, $content, $date, $time)";
		$db->exec($query);
		break;

	case "FRIEND":
		$user_num = $data["user_num"];
		$friend_num = $data["friend_num"];

		$query = "insert into FRIEND values($user_num,$friend_num)";
		$db->exec($query);
		break;

	default:
		break;
	}
}

function update_post($data) {
	global $db;

	$content = $db->quote($data['content']);
	$public = $db->quote($data['public']);
	$result = $db->exec("update post set content=$content, public=$public where num=$num");
}

function get_friends_list($num) {
	global $db;

	$result = $db->query("select friend_num from friend where user_num=$num and status='confirm'");

	return $result;
}

function get_posts_list($num, $public, $type) {
	global $db;

	if($type == "anonymous") {
		$result = $db->query("select * from post where type='anonymous'");
	} else if($public == "public") {
		$result = $db->query("select * from post where user_num=$num and public='public' and type='personal'");
	} else if($public == "friend") {
		$result = $db->query("select * from post where user_num=$num and (public='public' or public='friend') and type='personal'");
	} else if($public == "private") {
		$result = $db->query("select * from post where user_num=$num and type='personal'");
	}

	return $result;
}

function get_replys($num) {
	global $db;

	$result = $db->query("select * from reply where post_num=$num");
	return $result;
}

function get_users($type, $num) {
	global $db;

	if($type == "*")
		$result = $db->query("select * from user");
	else
		$result = $db->query("select * from user where num=$num");

	return $result;
}

function get_id($num) {
	global $db;

	$result = $db->query("select id from user where num=$num");
	$result = $result->fetch();

	return $result['id'];
}

function get_friend_request($num) {
	global $db;

	$result = $db->query("select * from friend where friend_num=$num and status='request'");
	return $result;
}

function get_post($num) {
	global $db;

	$result = $db->query("select * from post where num=$num");
	$result = $result->fetch();

	return $result;
}

function delete_post($num) {
	global $db;

	$result = $db->exec("delete from post where num=$num");
}

function check_password($num, $password) {
	global $db;

	$password = $db->quote($password);
	$result = $db->query("select * from user where num=$num and password=$password");

	if($result->rowCount())
		return TRUE;
	else
		return FALSE;
}

function check_friend($user_num, $friend_num) {
	global $db;

	$result = $db->query("select * from friend where user_num=$user_num and friend_num=$friend_num");
	$result2 = $db->query("select * from friend where friend_num=$user_num and user_num=$friend_num");

	if($result->rowCount() && $result2->rowCount())
		return TRUE;
	else
		return FALSE;
}

function check_applied_friend($user_num, $friend_num) {
	global $db;

	$result = $db->query("select * from friend where user_num=$user_num and friend_num=$friend_num");

	if($result->rowCount())
		return TRUE;
	else
		return FALSE;
}

function check_single($num) {
	global $db;

	$row = $db->query("select is_single from user where num=$num");
	$row = $row->fetch();

	if($row['is_single'] == 'y')
		return TRUE;

	return FALSE;
}

function update_user_info($data) {
	global $db;

	$num = $_SESSION['num'];
	$year = $data['year'];
	$baby = $data['baby_year'];
	$password = $db->quote($data['password']);
	$name = $db->quote($data['name']);
	$gender = $db->quote($data['gender']);
	$phone = $db->quote($data["phone"]."-".$data["middle_number"]."-".$data["last_number"]);
	$location = $db->quote($data['location']);
	$is_single = $db->quote($data['is_single']);

	$query = "update user set age=$year, baby=$baby, password=$password, name=$name, gender=$gender, phone=$phone, location=$location, is_single=$is_single where num=$num";
	$result = $db->exec($query);
}

function add_friend($user_num, $friend_num) {
	global $db;

	$result = $db->query("select * from friend where user_num=$friend_num and friend_num=$user_num");
	if($result->rowCount()) {
		$result = $db->exec("update friend set status='confirm' where user_num=$friend_num and friend_num=$user_num");
		$result = $db->exec("insert into friend values($user_num, $friend_num, 'confirm')");
	} else {
		$result = $db->exec("insert into friend values($user_num, $friend_num, 'request')");
	}
}

function remove_friend($user_num, $friend_num) {
	global $db;

	$result = $db->exec("delete from friend where user_num=$user_num and friend_num=$friend_num");
	$result = $db->exec("delete from friend where user_num=$friend_num and friend_num=$user_num");
}

function is_exist($table, $id) {
	global $db;

	switch($table) {
	case "USER":
		$id = $db->quote($id);
		$query = "select count(*) from user where id=$id";

		$result = $db->query($query);
		break;

	case "POST":
		break;

	case "REPLY":
		break;

	case "FRIEND":
		break;

	default:
		break;
	}

	if($result->fetchColumn() > 0)
		return TRUE;
	else
		return FALSE;
}

function validate_login($id, $password, &$name) {
	global $db;
	$id = $db->quote($id);
	$password = $db->quote($password);

	$result = $db->query("select * from user where id=$id and password=$password");

	if($result->rowCount() == 1) {
		$result = $result->fetch();
		$name = $result['name'];
		$_SESSION['num'] = $result['num'];
		$_SESSION['location'] = $result['location'];
		$_SESSION['is_single'] = $result['is_single'];
		return TRUE;
	} else {
		return FALSE;
	}
}

function ensure_logged_in() {
	if(!isset($_SESSION['id'])) {
		header('Location: login.html');
	}

	return TRUE;
}

?>
