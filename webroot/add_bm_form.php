<?php
	require_once('../require/global_init.php');
	session_start();

	do_html_header('Add Bookmarks');
	check_valid_user();

	display_add_bm_form();

	display_user_menu();

	do_html_footer();
?>
