<?php
	require_once('../require/global_init.php');
	session_start();

	$del_me = $_POST['del_me'];
	$valid_user = $_SESSION['valid_user'];

	do_html_header('Delete bookmarks');
	check_valid_user();

	if (!isset($del_me) || count($del_me) <= 0) {
		$err_msg = '<p>You have not choose any bookmarks to delete.<br />'
			. 'Please try again.</p>';
		echo $err_msg;
		display_user_menu();
		do_html_footer();
		exit;
	}
	
	try{
		foreach ($del_me as $url) {
			if (bm_delete($valid_user, $url)) {
				echo 'Deleted ' . htmlspecialchars($url) . '.<br />';
			} else {
				echo 'Could not delete ' . htmlspecialchars($url) . '.<br />';
			}
		}

		if ($url_array = get_user_urls($valid_user))
			display_user_urls($url_array);
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	display_user_menu();
	do_html_footer();
?>
