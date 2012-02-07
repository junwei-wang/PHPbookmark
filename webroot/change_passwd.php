<?php
	require('../require/global_init.php');
	session_start();

	do_html_header('Change password');

	$old_passwd = $_POST['old_passwd'];
	$new_passwd = $_POST['new_passwd'];
	$new_passwd2 = $_POST['new_passwd2'];

	try {
		check_valid_user();

		if (!filled_out($_POST)) {
			$error_msg = 'You have not filled out the form completely. '
				. 'Please try later again.';
			throw new Exception($error_msg);
		}
		if (strlen($new_passwd) > 16 || strlen($new_passwd) < 6) {
			$error_msg = 'New password must be between 6 and 16 chars, '
				. 'Please try later again.';
			throw new Exception($error_msg);
		}
		if ($new_passwd != $new_passwd2) {
			$error_msg = 'Password entered were not the same, '
				. 'not changed.';
			throw new Exception($error_msg);
		}

		// try to update 
		change_password($_SESSION['valid_user'], $old_passwd, $new_passwd);
		echo 'Password Change';
	} catch (Exception $e){
		echo $e->getMessage();
	}

	display_user_menu();

	do_html_footer();
?>
