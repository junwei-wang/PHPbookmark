<?php
	// print an HTML header
	function do_html_header($title)
	{
?>
<html>
<head>
  <title><?php echo $title ?></title>
  <style>
    body {font-family: Arial,Helvetica,sans-serif;font-size: 13px}
    li, td {font-family: Arial,Helvetica,sans-serif;font-size: 13px}
	hr {color: #3333cc; width=300; text-align=left}
	a {color: #000000}
  </style>
</head>

<body>
  <img src='/picture/bookmark.gif' alt="PHPbookmark logo" border="0"
       align="left" valign="bottom" height="55" width="57" />
  <h1>PHPbookmark</h1> 
  <hr />
<?php
		if ($title) {
			do_html_heading($title);
		}
	}

	// print an HTML footer
	function do_html_footer()
	{
?>
</body>
</html>
<?php
	}

	// print heading
	function do_html_heading($heading)
	{
?>
		<h2><?php echo $heading; ?></h2>
<?php
	}
	
	// print output URL as link and br
	function do_html_url($url, $name)
	{
?>
  <br /><a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
	}

	// display some site info
	function display_site_info()
	{
?>
  <ul>
    <li>Store your bookmarks online with us!</li>
	<li>See what other users use!</li>
	<li>Share your favourite links with others!</li>
  </ul>
<?php
	}

	function display_login_form()
	{
?>
  <p><a href="register_form.php">Not a Member?</a></p>
  <form method="post" action="member.php">
  <table bgcolor="#cccccc">
    <tr><td colspan="2">Members log in here:</td></tr>
	<tr>
	  <td>Username:</td>
	  <td><input type="text" name="username" /></td>
	</tr>
	<tr>
	  <td>Password:</td>
	  <td><input type="password" name="passwd" /></td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="submit" value="Log in" />
	  </td>
	</tr>
	<tr>
	  <td colspan="2"><a href="forgot_form.php">Forgot your Password?</a></td>
	</tr>
  </table>
  <form>
<?php
	}

	function display_registration_form()
	{
?>
  <form method="post" action="register_new.php">
  <table bgcolor="#cccccc">
    <tr>
	  <td>Email address:</td>
	  <td><input type='text' name='email' size='30' maxlength='100' /></td>
	</tr>
    <tr>
	  <td>Preferred username<br />(max 16 chars):</td>
	  <td valign="top"><input type='text' name='username' 
	      size='16' maxlength='16' /></td>
	</tr>
    <tr>
	  <td>Password<br />(between 6 and 16 chars):</td>
	  <td valign="top"><input type='password' name='passwd' 
	      size='16' maxlength='16' /></td>
	</tr>
    <tr>
	  <td>Confirm password:</td>
	  <td valign="top"><input type='password' name='passwd2' 
	      size='16' maxlength='16' /></td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="submit" value="Register" />
	  </td>
	</tr>
  </table>
  </form>
<?php
	}

	// display the table of URLs
	function display_user_urls($url_array)
	{
		//set global variable, so we can test later if this is on page
		global $bm_table;
		$bm_table = true;
?>
  <br />
  <form name="bm_table" method="post" action="delete_bms.php">
  <table width="300" cellpadding="2" cellspacing="0">
<?php
	$color = "#cccccc";
	echo "<tr bgcolor=\"$color\">"
	   . "<td><strong>Bookmark</strong></td>"
	   . "<td><strong>Delete?</strong></td></tr>";
	   if ( is_array($url_array) && count($url_array) > 0 ) {
	       foreach ($url_array as $url) {
		       if ($color == "#cccccc") {
                   $color = "#ffffff";
			   } else {
			       $color = "#cccccc";
			   }
		       echo "<tr bgcolor=\"$color\">"
                 . "<td><a href=\"$url\">" . htmlspecialchars($url) . "</a></td>"
			     . "<td><input type=\"checkbox\" name=\"del_me[]\" "
			     . "value=\"$url\"/></td></tr>";
		   }
		   // remember to call htmlspecialchars() when we are displaying
		   // user data
	   } else {
           echo "<tr><td>No bookmarks on record.</td></tr>";
	   }
?>
  </table>
  </form>
<?php
	}

	// display menu options on this page
	function display_user_menu()
	{
?>
  <hr />
  <a href="/">Home</a>&nbsp;|&nbsp;
  <a href="add_bm_form.php">Add Bookmark</a>&nbsp;|&nbsp;
<?php
	// some times there is no bookmarks
	// only offer delete option if bookmark table on this page
	global $bm_table;
	if ($bm_table == true) {
		echo "<a href=\"#\" onclick=\"bm_table.submit();\">"
			. "Delete Bookmark</a>&nbsp;|&nbsp;";
	} else {
		echo "<span style=\"color: #cccccc\">Delete BM</span>&nbsp;|&nbsp;";
	}
?>
  <a href="change_passwd_form.php">Change password</a>
  <br />
  <a href="recommend.php">Recommend URLs to me</a>&nbsp;|&nbsp;
  <a href="logout.php">Logout</a>
  <hr />
<?php
	}

	// display the form form people to add a new bookmark
	function display_add_bm_form() 
	{
?>
  <form name='bm_table' action='add_bms.php' method='post'>
  <table width='250' cellpadding='2' cellspacing='0' bgcolor='#cccccc'>
    <tr>
	  <td>New Bookmark:</td>
	  <td><input type="text" name="new_url" value="http://" size="30" 
	     maxlength="255" /></td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="submit" value="Add bookmark" /></td>
	</tr>
  </table>
  </form>
<?php
	}

	// display html change password form
	function display_password_form() 
	{
?>
  <br />
  <form action='change_passwd.php' method='post'>
  <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr>
     <td>Old password:</td>
	 <td><input type="password" name="old_passwd" size="16"
	            maxlength="16" /></td>
   </tr>
   <tr>
     <td>New password:</td>
	 <td><input type="password" name="new_passwd" size="16"
	            maxlength="16" /></td>
   </tr>
   <tr>
     <td>Repeat new password:</td>
	 <td><input type="password" name="new_passwd2" size="16"
	            maxlength="16" /></td>
   </tr>
   <tr>
     <td colspan="2" align="center">
	 <input type="submit" value="Change password" />
	 </td>
   </tr>
  </table>
  <br />
  </form>
<?php
	}

	// display HTML form to reset and email password
	function display_forgot_form()
	{
?>
  <form action="forgot_passwd.php" method="post">
  <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
    <tr>
	  <td>Enter your username</td>
	  <td><input type="text" name="username" size="16" maxlength="16" /></td>
	</tr>
   <tr>
     <td colspan="2" align="center">
	 <input type="submit" value="Change Password" />
	 </td>
  </table>
  <br />
  </form>
<?php
	}

	// similar output to display_user_urls
	// instead of displaying the users bookmarks, display recomendation
	function display_recommended_urls($url_array)
	{
?>
  <br />
  <table width="300" cellpadding="2" cellspacing="0">
<?php
	$color = "#cccccc";
	echo "<tr bgcolor=\"$color\">"
	   . "<td><strong>Recommedations</strong></td></tr>";
	if ( is_array($url_array) && count($url_array) > 0 ){
		foreach ($url_array as $url) {
			if ($color == "#cccccc") {
				$color = "#ffffff";
			} else {
				$color = "#cccccc";
			}
			echo "<tr bgcolor=\"$color\">"
			   . "<td><a href=\"$url\">" . htmlspecialchars($url) 
			   . "</a></td></tr>";
		}
	} else {
		echo "<tr><td>No recommendations for you today.</td></tr>";
	}
?>
  </table>
<?php
	}
?>
