<?
if(!isset($SESSION))
	session_start();

function draw_post($data) {
?>
	<form method=post action="">
		<input type=hidden name=num value="<?=$data['num']?>" />
		<input type=hidden name=date value="<?=date("Y-m-d")?>" />
		<input type=hidden name=time value="<?=date("h:ia")?>" />
		<div class=post>
			<?
			if($_SESSION['board'] != "anonymous") {
			?>
			<h3> <a href="main.html?board=friend&num=<?=$data['user_num']?>">
			<?=$data['name']?>
			</a> </h3>
			<?
			}
			?>
			<hr>
			<?
			$id = get_id($data['user_num']);
			$img_file = "../uploads/".$id."/".$data['num'];
			if(file_exists($img_file)) {
			?>
				<img src="<?=$img_file?>" style="max-width: 650px; max-height: 500px;" />
				<hr>
			<?
			}
			echo $data['content']."<br>";

			if($id == $_SESSION['id']) {
			?>

			<div class=control>
				<input type=submit name=delete value=삭제 />
				<input type=submit name=edit value=수정 />
			</div>

			<?
			}
			?>

			<div class=reply>
			<br> <br> <br>

			<?
			$replys = get_replys($data['num']);
			foreach($replys as $reply) {
				echo $reply['name']." : ".$reply['content']."<br>";
			}
			?> <br>
				<label for=content><?=$_SESSION['name']?></label>
				<input type=text name=content size=80>
				<input type=submit name=reply value=작성>
			</div>
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
		echo "";
		?> 
		<h3><label for=<?=$user['name']?>>
			<?=$user['name'];?>님의 정보
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
			echo "성별 : ".$user['gender']."<br><br>";
			if($_SESSION['num'] != $user['num']) {
				if(!check_applied_friend($_SESSION['num'], $user['num'])) {
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

function draw_friend_alarm($num) {
?>
	<div class=friend-request-list>
		<form action="" method=post>
		<?
		$requests = get_friend_request($num);
		if($requests->rowCount()) {
		?>
			<h3>친구 요청 목록</h3> <hr>
			<?
			foreach($requests as $request) {
				$user = get_users(null, $request['user_num']);
				$user = $user->fetch();
?>
				<h3><a href="main.html?board=friend&num=<?=$request['user_num']?>">
					<?=$user['name']?>
				</a></h3>
				<input type=hidden name=friend_num value="<?=$request['user_num']?>" />
				<input type=submit name=friend_admit value=수락 />
				<input type=submit name=friend_decline value=거절 />
				<?
			}
		}
		?>
		</form>
	</div>
<?
}

function draw_friend_list($num) {
?>
	<div class=friend-list>
		<form action="" method=post>
		<?
			$friends = get_friends_list($num);
		?>
			<h3>친구 목록(총 <?=$friends->rowCount()?> 명)</h3> <hr>
		<?
			foreach($friends as $friend) {
				$friend = get_users(null, $friend['friend_num']);
				$friend = $friend->fetch();
		?>
				<h4><a href="main.html?board=friend&num=<?=$friend['num']?>">
				<?=$friend['name']?>
				</a></h4>
		<?
			}
		?>
		</form>
	</div>
<?
}

function draw_recommend($friend_count) {
?>
	<div class=friend-list>
		<form action="" method=post>
			<h3>친구 추천 목록</h3> <hr>
	<?
	foreach($friend_count as $key => $result) {
		if($result >= 2 && !check_friend($_SESSION['num'], $key) && $_SESSION['num'] != $key) {
			$user = get_users(null, $key);
			$user = $user->fetch();
			?>
			<h4><a href="main.html?board=friend&num=<?=$user['num']?>">
			<?=$user['name']?>
			</a></h4>
			<?
			}
			?>
		</form>
	</div>
<?
	}
}
?>
