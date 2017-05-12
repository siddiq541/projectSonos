<?php
	include 'sonosconnect.php';
	$state = $controller->getState();
	// state 201 = stopped -> rare but can happen after update or if sonos has been unplugged
	if ($state == 201){
		$controller->useQueue();
	}
	//state 202 = playing
	if($controller->getState() == 202){
		$controller->pause();
	}else{
		$controller->play();
	}
	
?>