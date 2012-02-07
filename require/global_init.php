<?php
	// We can include this file in all our files.
	// This way, every file will contain all our functions
	// and exceptions.

	define("WEB_HOME", "/home/wakemecn/myweb/PHPbookmark");
	define("REQUIRE_PATH", WEB_HOME . "/require");
	define("ACTION_PATH", WEB_HOME . "../action");
	
	require_once(REQUIRE_PATH . "/data_valid_fns.php");
	require_once(REQUIRE_PATH . "/db_fns.php");
	require_once(REQUIRE_PATH . "/user_auth_fns.php");
	require_once(REQUIRE_PATH . "/output_fns.php");
	require_once(REQUIRE_PATH . "/url_fns.php");

?>
