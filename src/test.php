<?
if(!isset($SESSION))
	session_start();

function draw_post($data) {
?>
	<div class=post>
<?
	echo $data['name']."<br>";
	$img_file = "../uploads/".$_SESSION['id']."/".$data['num'];
	if(file_exists($img_file)) {
?>
			<img src="<?=$img_file?>" />
<?
	}
	echo $data['content']."<br>";
?>
	</div>
<?
}

function draw_user($user) {
?>
	<div class=user-list>

<? 
	echo "<br><br>";
?> 
		<label for=<?=$user['name']?>>
<?
	echo $user['name'];
?>
		</label> 
		<input id=<?=$user['name']?> type=checkbox name=tab checked/> 
		<div class=user-item>

<?
	echo "<br>";
	echo "이름 : ".$user['name']."<br>";
	echo "나이 : ".$user['age']."<br>";
	echo "baby : ".$user['baby']."<br>";
	echo "전화번호 : ".$user['phone']."<br>";
	echo "지역 : ".$user['location']."<br>";
	echo "싱글유무 : ".$user['is_single']."<br>";
	echo "성별 : ".$user['gender']."<br>";

	if($_SESSION['num'] != $user['num']) {
		if(!check_friend($_SESSION['num'], $user['num'])) {
?>
					<input type=submit name=add value="친구 추가" />
<?
		} else {
?>
					<input type=submit name=delete value="친구 해제" />
<?
		}
	}
?>

		</div>
	</div>
<?
}
?>

