<?php
// sets position in current song
	include 'sonosconnect.php';
	$controller->seek($_REQUEST['val']);
?>