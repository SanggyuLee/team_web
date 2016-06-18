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
	<div class=user>
		<a href="user.html?num=<?=$user['num']?>"><?=$user['name']?></a>
	</div>
<?
}
?>
