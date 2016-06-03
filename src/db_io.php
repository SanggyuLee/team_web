<?
/* DB_IO.php */
$db = new PDO("mysql:dbname=babycare;host=172.16.24.89","root","master123");

function insert($table, $data) {
	switch($table) {
	case "USER":
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
?>
