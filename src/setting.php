<?
include('db_io.php');
ensure_logged_in();

if(!isset($_SESSION))
	session_start();

$user = get_users(null, $_SESSION['num']);
$user = $user->fetch();

if(isset($_POST['year'])) {
	update_user_info($_POST);
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['location'] = $_POST['location'];
	$_SESSION['is_single'] = $_POST['is_single'];
	header('Location: main.html?board=news');
} else if(check_password($_SESSION['num'], $_POST['password'])) {
?>

<html>
	<body>
		<div id=join-wrapper>
			<div id=main-join>
				<div class=join>
					<h1> <i> ▶ 회원정보변경 </i> </h1>
					<hr>
					<form action="" method=post>
						<table border=1 cellpadding=10px style="border-collapse:collapse;border:1px gray solid;">
							<tr>
								<td align=right>비밀번호</td>
								<td><input type=password name=password size=15 maxlength=10 value="<?=$user['password']?>"></td>
							</tr>
							<tr>
								<td align=right>이름</td>
								<td><input type=text name=name size=15 maxlength=12 value="<?=$user['name']?>"></td>
							</tr>
							<tr>
								<td align=right>연도</td>
								<td>
									<select name=year>
										<? for($i = 1970; $i <= 1999; $i++) {?>
										<option value="<?=$i?>" <?if($user['age'] == $i) { echo "selected"; }?>><?=$i?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td align=right>아이출생년도</td>
								<td>
									<select name=baby_year>
										<? for($i = 2010; $i <= date("Y"); $i++){?>
										<option value="<?=$i?>" <?if($user['baby'] == $i) { echo "selected"; }?>><?=$i?></option>
										<?}?>
									</select>
								</td>
							</tr>
							<tr>
								<td align=right>성별</td>
								<td>
									<input type=radio name=gender value=m <?if($user['gender'] == 'm') { echo "checked"; }?>>남성
									<input type=radio name=gender value=f <?if($user['gender'] == 'f') { echo "checked"; }?>>여성
								</td>
							</tr>
							<tr>
								<?
								list($first, $second, $third) = explode("-", $user['phone']);
								echo $first.".".$second.".".$third;
								?>
								<td align=right>휴대전화</td>
								<td>
									<select name=phone>
										<option value=010 <?if($first == "010") { echo "selected"; }?>>010</option>
										<option value=011 <?if($first == "011") { echo "selected"; }?>>011</option>
										<option value=016 <?if($first == "016") { echo "selected"; }?>>016</option>
										<option value=017 <?if($first == "017") { echo "selected"; }?>>017</option>
										<option value=070 <?if($first == "070") { echo "selected"; }?>>070</option>
									</select>
									-
									<input type=text name=middle_number size=4 value=<?=$second?>>
									-
									<input type=text name=last_number size=4 value=<?=$third?>>
								</td>
							</tr>
							<tr>
								<td align=right>주 소</td>
								<td>
									<select name=location value=<?=$user['location']?>>
										<option value=서울 <?if($user['location'] == "서울") { echo "selected"; }?>>서울</option>
										<option value=대전 <?if($user['location'] == "대전") { echo "selected"; }?>>대전</option>
										<option value=울산 <?if($user['location'] == "울산") { echo "selected"; }?>>울산</option>
										<option value=대구 <?if($user['location'] == "대구") { echo "selected"; }?>>대구</option>
										<option value=부산 <?if($user['location'] == "부산") { echo "selected"; }?>>부산</option>
										<option value=인천 <?if($user['location'] == "인천") { echo "selected"; }?>>인천</option>
										<option value=세종 <?if($user['location'] == "세종") { echo "selected"; }?>>세종</option>
										<option value=제주 <?if($user['location'] == "제주") { echo "selected"; }?>>제주</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align=right>싱글유무</td>
								<td>
									<input type=radio name=is_single value=y <?if($user['is_single'] == 'y') { echo "checked"; }?>>yes
									<input type="radio" name="is_single" value="n" <?if($user['is_single'] == 'n') { echo "checked"; }?>>no
								</td>
							</tr>
						</table> <br>
						<input type=submit value='저장'>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?
} else {
?>
<html>
	<style>
		fieldset {
			background-color: #ffffcc;
			margin-left: auto;
			margin-right: auto;
			width: 21em;
		}

		form { font-family: "Helvetica", sans-serif; }
		input { margin-bottom: 0.5em; }
		input[type="submit"] {
			font-weight: bold;
			margin-left: 10em;
		}

		label.heading {
			float: left;
			margin-right: 1em;
			text-align: right;
			width: 7em;
		}

		legend {
			background-color: white;
			border: 1px solid black;
			padding: 0.25em;
		}
	</style>
	<body>
		<form method=post action="">
			<fieldset>
				<legend>비밀번호를 입력하세요</legend>
				<label class=heading for=password>패스워드:</label>
				<input type=password name=password id="password"/><br>
				<input type=submit value="로그인"/>
			</fieldset>
		</form>
	</body>
</html>
<?
}
?>
