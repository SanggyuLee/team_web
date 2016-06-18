<?
if(!isset($SESSION))
	session_start();

function draw_post($data) {
?>
	<form method=post action="">
		<div class=post>
			<a href="main.html?board=friend&num=<?=$data['user_num']?>">
			<?=$data['name']?>
			</a>
		<?
			$id = get_id($data['user_num']);
			$img_file = "../uploads/".$id."/".$data['num'];
			if(file_exists($img_file)) {
			?>
				<img src="<?=$img_file?>" style="max-width: 650px; max-height: 500px;" />
			<?
			}
			echo $data['content']."<br>";

			if($id == $_SESSION['id']) {
		?>
		<input type=submit name=delete value=삭제 />
		<input type=submit name=edit value=수정 />
		<input type=hidden name=num value="<?=$data['num']?>" />
		<?
		}
		?>
		</div>
	</form>
<?
}

function draw_user($user) {
?>
	<div class=user-list>
	<form method=post action="main.html?board=friend&num=<?=$user['num']?>">
		<input type=hidden name=user_num value=<?=$_SESSION['num']?> />
		<input type=hidden name=friend_num value=<?=$user['num']?> />
		<? 
		echo "<br><br>";
		?> 
		<h3><label for=<?=$user['name']?>>
			<?=$user['name'];?>
		</label></h3><hr>

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
					<input type=submit name=add_friend value="친구 추가" />
					<?
				} else {
					?>
					<input type=submit name=delete_friend value="친구 해제" />
				<?
				}
			}
			?>
		</div>
		</form>
	</div>
<?
}
?>
