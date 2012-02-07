<?php
	require_once('../require/global_init.php');
	do_html_header('Resetting password');

	$username = $_POST['username'];
	
	try {
		$passwd = reset_passwd($username);
		notify_passwd($username, $passwd);
		echo 'Your password has been emailed to you.<br />';
	} catch (Exception $e) {
		echo $e->getMessage();
		echo "<br />Your password not could not be reset.<br/>";
	}

	do_html_url('login.php', 'Login');
	do_html_footer();
?>
