<?php
	function filled_out($form_vars) 
	{
		// test if all the form_vars has a valid value
		foreach ($form_vars as $var => $value) {
			if ((!isset($var)) || ($value == '')) {
					return false;
			}
		}
		return true;
	}

	function valid_email ($address) 
	{
		// check if the email address is valid
		$patterns = '/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/i';
		//$patterns = '/^[a-z0-9]+$/';
		if (preg_match($patterns, $address))
			return true;
		return false;
	}

	function valid_url ($url)
	{
		$preg = "/^(((ftp)|(https?)):\/\/)?(((www\.)?[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)?\.([a-zA-Z]+))|(([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5]))(\:\d{0,4})?)(\/[\w- .\/?%&=]*)?$/i";
		if (preg_match($preg, $url) )
			return true;
		return false;
	}
?>
