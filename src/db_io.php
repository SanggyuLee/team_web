<?
/* DB_IO.php */
$db = new PDO("mysql:dbname=babycare;host=localhost","root","apmsetup");

function insert($table, $data) {
	global $db;

	switch($table) {
	case "USER":
		$user_num = $db->quote(hash("md5", $data["id"]));
		$id = $db->quote($data["id"]);
		$password = $db->quote($data["password"]);
		$name = $db->quote($data["name"]);
		$age = date(Y) - $data["year"] + 1;
		$baby = date(Y) - $data["baby_year"] + 1;
		$phone = $db->quote($data["phone"]."-".$data["middle_number"]."-".$data["last_number"]);
		$location = $db->quote($data["location"]);
		$is_single = $db->quote($data["is_single"]);
		$gender = $db->quote($data["gender"]);

		$query = "insert into USER values($user_num, $id, $password, $name, $age, $baby, $phone, $location, 'y', 'm')";
		$db->exec($query);
		break;

	case "POST":
		$post_num = hash("md5", $data["id"].$data["date"].$data["time"]);
		$author = $db->quote($data["name"]);
		$content = $db->quote($data["content"]);
		$date = $db->quote($data["date"]);
		$time = $db->quote($data["time"]);
		$public = $db->quote($data["public"]);
		$picture = $db->quote($data["picture"]);

		$query = "insert into POST values($post_num, $author,$content,$date,$time,$public,$picture)";
		$db->exec($query);
		break;

	case "REPLY":
		$reply_num = $data["post_num"].$data["date"].$data["time"];
		$post_num = $data["post_num"];
		$author = $db->quote($data["author"]);
		$content = $db->quote($data["content"]);
		$date = $db->quote($data["date"]);
		$time = $db->quote($data["time"]);

		$query = "insert into REPLY values($reply_num, $post_num, $author, $content, $date, $time)";
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

function valid($id, $password) {
	global $db;
	$id = $db->quote($id);
	$password = $db->quote($password);
	$query = "select count(*) from user where id=$id and password=$password";

	$result = $db->query($query);

	if($result->fetchColumn() == 1) {
		return TRUE;
	} else {
		return FALSE;

	}
}

?>
