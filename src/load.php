<?
include('draw.php');
ensure_logged_in();

function sorting($list) {
	for($i = 0; $i < count($list); $i++) {
		$swapped = 0;
		for($j = 0; $j < count($list) - $i - 1; $j++) {
			if($list[$j]['num'] < $list[$j + 1]['num']) {
				$temp = $list[$j];
				$list[$j] = $list[$j + 1];
				$list[$j + 1] = $temp;
				$swapped = 1;
			}
		}

		if(!$swapped)
			break;
	}

	return $list;
}

function load_posts($board_type, $user_num) {
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
		$post_list = sorting($post_list);

		/* Print out */
		if(!empty($post_list)) {
			for($i = 0; $i < $count; $i++) {
				draw_post($post_list[$i]);
			}
		}
	} else if($board_type == 'single') {
	} else if($board_type == 'location') {
	} else if($board_type == 'friend_list') {
	} else if($board_type == 'friend') {
		$i = 0;

		$posts = get_posts_list($user_num);

		foreach($posts as $post) {
			$post_list[$i++] = $post;
		}

		$count = $i;

		$post_list = sorting($post_list);

		if(!empty($post_list)) {
			for($i = 0; $i < $count; $i++) {
				draw_post($post_list[$i]);
			}
		}
	}
}
?>
