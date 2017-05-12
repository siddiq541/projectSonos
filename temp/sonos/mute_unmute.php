<?php
	include 'sonosconnect.php';
	if($controller->isMuted() == FALSE){
		$controller->mute();
	}else{
		$controller->unmute();
	}
	
?>