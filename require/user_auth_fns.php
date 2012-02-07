<?php
	require_once('db_fns.php');

	function register($username, $email, $password) 
	{
		// register new user with db
		// return true or false

		//connect to db
		$conn = db_connect();
		
		//check if username exists
		$sql = "select username from tblUser where username='$username'";
		$result = $conn->query($sql);
		if (!$result) {
			$error_message = 'Could not execute query to database';
			throw new Exception($error_message);
		}
		if ($result->num_rows > 0) {
			$error_message = 'Username exists, '
					. "go back and choose another one.";
			throw new Exception($error_message);
		}

		// insert data into db
		$sql = "insert into tblUser values ('$username', sha1('$password'),"
				. "'$email')";
		$result = $conn->query($sql);
		if(!$result) {
			$error_message = 'Could not register you in database - Please '
					. 'try later again.';
		} else {
			return true;
		}
	}

	function login($username, $passwd) 
	{
		// check username and passwd with db
		// if yes return true
		// else throw exception

		$conn = db_connect();
		
		$sql = "select username from tblUser where username='$username' and "
			. "passwd=sha1('$passwd')";
		$result = $conn->query($sql);
		if (!$result) {
			$error_message = 'Some thing wrong with database server, please '
				. 'try later';
			throw new Exception($error_message);
		} 

		if ($result->num_rows > 0) {
			return true;
		} else {
			$error_message = "Username does't match password, please "
				. 'try again.';
			throw new Exception($error_message);
		}
	}

	function check_valid_user() 
	{
		// if somebody log in and exit if not
		if (isset($_SESSION['valid_user'])) {
			echo 'Log in as <strong>' . $_SESSION['valid_user'] 
					. '</strong>.<br />';
		} else {
			echo '<strong>Problem:</strong> You are not logged in.<br />';
			do_html_url('login.php', 'Login');
			do_html_footer();
			exit;
		}
	}

	function change_password($username, $old_passwd, $new_passwd)
	{
		// change passwd for username:old_passwd to new_passwd
		// return true if success
		// else throw an exception
		
		// login 
		login($username, $old_passwd);

		$conn = db_connect();
		$sql = "update tblUser set passwd=sha1('$new_passwd') where "
			. "username='$username'";
		$result = $conn->query($sql);

		if (!$result) {
			$err_msg = 'Password could not be changed, Please try later.';
			throw new Exception($err_msg);
		} else {
			return true;
		}
	}

	function reset_passwd($username)
	{
		// set username a new random passwd
		// return the passwd or false on failed

		// get a chars between 6 and 16
		$new_passwd = get_random_str(6,16);

		$conn = db_connect();
		$sql = "update tblUser set passwd=sha1('$new_passwd') where "
			. "username='$username'";
		$result = $conn->query($sql);

		if (!$result) {
			$err_msg = 'Could not reset password, please try later.';
			throw new Exception($err_msg);
		} else {
			return $new_passwd;
		}
	}

	function get_random_str($min_len, $max_len)
	{
		// get a random chars length between min_len and max_len
		// return it or false on failed;
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
			. '0123456789-_';
		$chars_len = strlen($chars);

		$str_len = rand($min_len, $max_len);
		for ($i=0; $i<$str_len; $i++) {
			$str .= $chars{rand(0, $chars_len-1)};
		}

		return $str;
	}

	function notify_passwd($username, $passwd)
	{
		// notify the user that their passwd has been changed
		$conn = db_connect();
		$sql = "select email from tblUser where username='$username'";
		$result = $conn->query($sql);
		if (!$result || $result->num_rows == 0) {
			$err_msg = 'Could not find email.';
			throw new Exception($err_msg);
		} 
		$row = $result->fetch_object();

		$email = $row->{'email'};
		$from = 'From: support@phpbookmark.com \r\n';
		$msg = "Your PHPbookmark password has been changed to " . $passwd
			. ".\nPlease change it next time you log in.\n";
		$subject = 'PHPBookmark account information';

		if (!mail($email, $subject, $msg, $from)) {
			throw new Exception('Could not send mail.');
		}
	}

?>
