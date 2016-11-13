<?php
//setup file:
#Database Connection:
include('config/connection.php');
# Constants:
define('D_TEMPLATE', 'template');


$site_title = 'FinalProject';

# Functions:
include('functions/data.php');
include('functions/template.php');

if(isset($_GET['page'])) {
	$pageid = $_GET['page'];
}else {
	$pageid = 1;
}

# Page Setup
$page = data_page($dbc,$pageid);


?>