<?
ensure_logged_in();

function load_posts($board_type) {
	if($board_type == 'news') {
		$friends = get_friends_list($_SESSION['num']);
		foreach($friends as $friend) {
			$posts = get_posts_list($friend['friend_num']);

			$i = 0;
			foreach($posts as $post) {
				$post_list[$i++] = $post;
			}

			foreach($post_list as $post) {
			}
		}
	} else if($_GET['board'] == 'single') {
	} else if($_GET['board'] == 'location') {
	} else if($_GET['board'] == 'friend_list') {
	}
}
?>
