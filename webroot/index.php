<?php
	require_once('../require/global_init.php');
	session_start();

	if (isset($_SESSION['valid_user'])) {
		require_once('member.php');
	} else {
		require_once('login.php');
	}

?>
