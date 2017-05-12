<?php
	require_once __DIR__ . "/../vendor/autoload.php";
	use duncan3dc\Sonos\Network;
	$cache = new \Doctrine\Common\Cache\FilesystemCache("/tmp/sonos-cache");
	$sonos = new Network($cache);
	
	// read controller name
	$file = fopen("../resources/sonossettings.txt", "r");
	// get rid of first two lines
	fgets($file);
	fgets($file);
	$controllername = rtrim(fgets($file));
	fclose($file);
	
	try {
		$controller = $sonos->getControllerByRoom($controllername);
	} catch (Exception $e){
		exit("error: unable to connect to sonos controller");
	}
?>