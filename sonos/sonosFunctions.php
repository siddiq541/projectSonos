<?php
	// functions written for the purpose of this application
	
	function positionToSeconds($position){
		$array = explode(":", $position);
		return ($array[1] *60) + $array[2];
	}
	
	function recordActivity($activity){
		$file = "../resources/activity.txt";
		$fp = fopen($file, "a+");
		$lines = 0;
		while (!feof($fp)){
			fgets($fp);
			$lines++;
		}
		fwrite($fp, $username.$activity."\n");
		fclose($fp);
		if ($lines > 50){
			$contents = file($file);
			$first_line = array_shift($contents);
			file_put_contents($file, implode("", $contents));
		}
	}
?>