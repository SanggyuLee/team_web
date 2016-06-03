<?
/* DB_IO.php */
$db = new PDO("mysql:dbname=babycare;host=172.16.24.89","root","master123");

function insert($table, $data) {
	global $db;

	switch($table) {
	case "USER":
		$user_num = $db->quote(hash($data["id"]));
		$id = $db->quote($data["id"]);
		$password = $db->quote($data["password"]);
		$name = $db->quote($data["name"]);
		$age = $db->quote(date("Y") - $data["year"] + 1);
		$baby = $db->quote(date("Y") - $data["baby_year"] + 1);
		$phone = $db->quote($data["phone"]."-".$data["middle_number"]."-".$data["last_number"]);
		$location = $db->quote($data["location"]);
		$is_single = $db->quote($data["is_single"]);
		$gender = $db->quote($data["gender"]);

		$query = "insert into USER values($user_num, $id, $password, $name, $age, $baby, $phone, $location, $is_single, $gender)";
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
		$query = "select * from user where id=$id";

		$result = $db->exec($query);
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

	if($result)
		return TRUE;
	else
		return FALSE;
}
?>
