<?php
	require_once("../require/global_init.php");

	$email = $_POST['email'];
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	$passwd2 = $_POST['passwd2'];

	session_start();

	try {
		// check if form filled in
		if (!filled_out($_POST)) {
			$error_message = 'You have not filled the form out correctly, '
					. "please go back and try again.";
			throw new Exception($error_message);
		}
		// email address not valid
		if (!valid_email($email)) {
			$error_message = 'This is not a valid email address, '
					. "please go back and try again.";
			throw new Exception($error_message);
		}
		// username is too long
		if (strlen($username) > 16 ) {
			$error_message = 'Your username must be up to 16 characters, '
					. "please go back and try again.";
			throw new Exception($error_message);
		}
		// password length is not avaliable 
		if (strlen($passwd) > 16 || strlen($passwd) < 6) {
			$error_message = 'Your password must be between 6 and 16 characters, '
					. "please go back and try again.";
			throw new Exception($error_message);
		}
		// passwords not the same
		if ($passwd != $passwd2) {
			$error_message = 'The password you entered not match, '
					. "please go back and try again.";
			throw new Exception($error_message);
		}

		// attemp to register
		register($username, $email, $passwd);
		
		$_SESSION['valid_user'] = $username;

		do_html_header('Registration successful');
		
		echo 'Your registration was successful. Go to the members page to '
			. 'start setting up your bookmarks.';
		do_html_url('member.php', 'Go to members page');

		do_html_footer();
	} catch (Exception $e) {
		do_html_header('Problem:');
		echo $e->getMessage();
		do_html_footer();
		exit;
	}
?>
