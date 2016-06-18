<?
include('draw.php');
ensure_logged_in();

function sorting($list) {
	for($i = 0; $i < count($list); $i++) {
		$swapped = 0;
		for($j = 0; $j < count($list) - $i - 1; $j++) {
			if($list[$j]['num'] > $list[$j + 1]['num']) {
				$temp = $list[$j];
				$list[$j] = $list[$j + 1];
				$list[$j + 1] = $list[$j];
				$swapped = 1;
			}
		}

		if(!$swapped)
			break;
	}
}

function load_posts($board_type) {
	if($board_type == 'news') {
		$i = 0;

		/* Get post of mine */
		$posts = get_posts_list($_SESSION['num']);

		foreach($posts as $post) {
			$post_list[$i++] = $post;
		}

		/* Get post of my friends*/
		$friends = get_friends_list($_SESSION['num']);
		foreach($friends as $friend) {
			$posts = get_posts_list($friend['friend_num']);

			foreach($posts as $post) {
				$post_list[$i++] = $post;
			}
		}

		$count = $i;

		/* TODO: Sorting */
		sorting($post_list);

		/* Print out */
		if(!empty($post_list)) {
			for($i = 0; $i < $count; $i++) {
				draw_post($post_list[$i]);
			}
		}
	} else if($_GET['board'] == 'single') {
	} else if($_GET['board'] == 'location') {
	} else if($_GET['board'] == 'friend_list') {
	}
}
?>
