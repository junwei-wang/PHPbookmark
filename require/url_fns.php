<?php
	require_once('db_fns.php');

	function get_user_urls($username)
	{
		$conn = db_connect();
		$sql = "select bm_url from tblBookmark where username='$username'";
		$result = $conn->query($sql);

		if (!$result)
			return false;

		$url_array = array();
		$count = 0;
		while ($row = $result->fetch_row())
			$url_array[$count++] = $row[0];
		return $url_array;
	}

	function exist_bm($username, $url)
	{
		// check new_url if exists
		$conn = db_connect();
		$sql = "select username from tblBookmark where username='$username' "
			. "and bm_url='$url'";
		$result = $conn->query($sql);
		if (!$result)
			throw new Exception('Some error happens, please try later again.');
		if ($result && ($result->num_rows > 0)) 
			return true;
		return false;
	}

	function add_bm($new_url)
	{
		// add new_url for user, 
		// ensure new_url is valid and has no malicious code
		echo "Attempting to add " . htmlspecialchars($new_url) . "<br />";
		$username = $_SESSION['valid_user'];
		if (exist_bm($username, $new_url))
			throw new Exception('Bookmark already exists.');

		$conn = db_connect();
		// insert new_url
		$sql = "insert into tblBookmark values('$username','$new_url')";
		$result = $conn->query($sql);
		if (!$result) 
			throw new Exception('Bookmark could not been added.');

		return true;
	}

	function bm_delete($username, $url)
	{
		if (!exist_bm($username, $url)) 
			throw new Exception('Bookmark not exists.');

		$conn = db_connect();
		$sql = "delete from tblBookmark where username='$username' "
			. "and bm_url='$url'";
		$result = $conn->query($sql);
		if (!$result)
			throw new Exception('Some error happens, please try later again.');
		return true;
	}

	function recommend_urls($username, $popularity = 1)
	{
		// recommend urls from other customers where both of 
		// them have at least one same url

		// only when at least $popularity number of customes 
		// have one url, we recommend it.
		$conn = db_connect();
		$sql = "select bm_url from tblBookmark where "
			. "username in "
			. "(select distinct(b2.username) from "
			. "tblBookmark b1, tblBookmark b2 where "
			. "b1.username='$username' and "
			. "b1.username!=b2.username and "
			. "b1.bm_url=b2.bm_url) "
			. "and bm_url not in "
			. "(select bm_url from tblBookmark where "
			. "username='$username') "
			. "group by bm_url "
			. "having count(bm_url)>'$popularity'";
		$result = $conn->query($sql);

		$err_msg = 'Could not find any bookmarks to recommend.';
		if (!$result || $result->num_rows == 0)
			throw new Exception($err_msg);

		$urls = array();
		$count = 0;
		while($row = $result->fetch_object()) {
			$url[$count++] = $row->{'bm_url'};
		}

		return $url;
	}
?>
