<?php
	require_once __DIR__ . "/../vendor/autoload.php";
	use duncan3dc\Sonos\Network;
	$cache = new \Doctrine\Common\Cache\FilesystemCache("/tmp/sonos-cache");
	$sonos = new Network($cache);
	try {
		$controller = $sonos->getControllerByRoom("Family Room");
	} catch (Exception $e){
		exit("error: unable to connect to sonos controller");
	}
	$controller = $sonos->getControllerByRoom("Family Room");
	
?>