<?
include('draw.php');

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
		$posts = get_posts_list($_SESSION['num'], "private");

		foreach($posts as $post) {
			$post_list[$i++] = $post;
		}

		/* Get post of my friends*/
		$friends = get_friends_list($_SESSION['num']);
		if(!empty($friends)) {
			foreach($friends as $friend) {
				$posts = get_posts_list($friend['friend_num'], "friend");

				foreach($posts as $post) {
					$post_list[$i++] = $post;
				}
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
		$i = 0;

		/* Get post of all */
		$users = get_users("*", null);
		foreach($users as $user) {
			if($user['is_single'] == 'y') {	
				if(check_friend($_SESSION['num'], $user['num']))
					$posts = get_posts_list($user['num'], "friend");
				else
					$posts = get_posts_list($user['num'], "public");

				foreach($posts as $post) {
					$post_list[$i++] = $post;
				}
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
	} else if($board_type == 'location') {
		$i = 0;

		/* Get post of all */
		$users = get_users("*", null);
		foreach($users as $user) {
			if($user['location'] == $_SESSION['location']) {	
				if(check_friend($_SESSION['num'], $user['num']))
					$posts = get_posts_list($user['num'], "friend");
				else
					$posts = get_posts_list($user['num'], "public");

				foreach($posts as $post) {
					$post_list[$i++] = $post;
				}
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
	} else if($board_type == 'friend') {
		$i = 0;

		if($user_num == $_SESSION['num'])
			$type = "private";
		else if(check_friend($_SESSION['num'], $user_num))
			$type = "friend";
		else
			$type = "public";

		$posts = get_posts_list($user_num, $type);

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
