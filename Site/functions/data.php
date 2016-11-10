<?php

function data_page($dbc, $id) {
	$query = "SELECT * FROM pages WHERE pageid = $id";
	$result = mysqli_query($dbc, $query);
	$data = mysqli_fetch_assoc($result);
	$data['body_nohtml'] = strip_tags($data['body']);
	if($data['body_nohtml'] == $data['body']) {
		$data['body_formatted'] = '<p>'.$data['body'].'</p>';
	} else {
		$date['body_formatted'] = $data['body'];
	}
	
	return $data;	
}


?>