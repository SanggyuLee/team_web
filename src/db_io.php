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

		$query = "insert into POST values(null, $num, $name, $content,$date,$time,$public)";
		$db->exec($query);

		$row = $db->query("select num from POST where date=$date and time=$time");
		$row = $row->fetch();

		return $row['num'];

	case "REPLY":
		$reply_num = $data["post_num"].$data["date"].$data["time"];
		$post_num = $data["post_num"];
		$author = $db->quote($data["author"]);
		$content = $db->quote($data["content"]);
		$date = $db->quote($data["date"]);
		$time = $db->quote($data["time"]);

		$query = "insert into REPLY values(null, $post_num, $author, $content, $date, $time)";
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

function get_friends_list($num) {
	global $db;

	$result = $db->query("select friend_num from friend where user_num=$num");
	return $result;
}

function get_posts_list($num) {
	global $db;

	$result = $db->query("select * from post where user_num=$num");
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

function check_friend($user_num, $friend_num) {
	global $db;

	$result = $db->query("select * from friend where user_num=$user_num and friend_num=$friend_num");

	if($result->rowCount())
		return TRUE;
	else
		return FALSE;
}

function add_friend($user_num, $friend_num) {
	global $db;

	$result = $db->exec("insert into friend values($user_num, $friend_num)");
}

function remove_friend($user_num, $friend_num) {
	global $db;

	$result = $db->exec("delete from friend where user_num=$user_num and friend_num=$friend_num");
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

	$result = $db->query("select num,id,password,name from user where id=$id and password=$password");

	if($result->rowCount() == 1) {
		$result = $result->fetch();
		$name = $result['name'];
		$_SESSION['num'] = $result['num'];
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
