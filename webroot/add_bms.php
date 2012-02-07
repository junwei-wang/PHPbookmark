<?php
	require_once('../require/global_init.php');
	session_start();

	$new_url = $_POST['new_url'];
	do_html_header('Adding bookmarks');
	
	try{
		check_valid_user();
		if (!filled_out($_POST)) {
			$err_msg = 'Form not completely filled out';
			throw new Exception($err_msg);
		}
		
		// check if a valid url
		if (!valid_url($new_url)) {
			$err_msg = 'Not a valid URL';
			throw new Exception($err_msg);
		}

		add_bm($new_url);
		echo 'Bookmark added.<br/>';

		if ($url_arr = get_user_urls($_SESSION['valid_user']))
			display_user_urls($url_arr);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
	display_user_menu();
	do_html_footer();
?>
