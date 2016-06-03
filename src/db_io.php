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
		break;

	case "REPLY":
		break;

	case "FRIEND":
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

function valid($id,$password) {
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
