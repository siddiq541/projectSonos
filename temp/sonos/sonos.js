// decides when the dashboard needs to be refreshed
function refreshDashboard(number) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
		   if (this.responseText == true){
			   window.location.reload();
		   }
       }
    };
    xmlhttp.open("GET", "refreshDashboard.php?number=" + number, true);
    xmlhttp.send();
}

// decides when the queue needs to be refreshed	
function refreshQueue(count) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
		   if (this.responseText == true){
			   window.location.reload();
		   }
       }
    };
    xmlhttp.open("GET", "refreshQueue.php?count=" + count, true);
    xmlhttp.send();
}

// updates several elements on dashboard that need constant updating
function updateRegularly() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
		   var array = this.responseText.split(',');
		   setTimes(array[0], array[1])
		   document.getElementById("seekBar").value = positionToSeconds(array[0]);
		   document.getElementById("volumeBar").value = array[2];
		   document.getElementById("play_pause").value = array[3];
		   document.getElementById("mute_unmute").value = array[4];
       }
    };
    xmlhttp.open("GET", "updateRegularly.php", true);
    xmlhttp.send();
}

function play_pause() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "play_pause.php", true);
    xmlhttp.send();
}

function skip() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "skip.php", true);
    xmlhttp.send();
}

function mute_unmute() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "mute_unmute.php", true);
    xmlhttp.send();
}

function adjustVolume(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "adjustVolume.php?val=" + val, true);
    xmlhttp.send();
}

// sets position in current song
function setPosition(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "setPosition.php?val=" + val, true);
    xmlhttp.send();
}

// converts current position in song from format given by sonos to seconds (int)
function positionToSeconds(val){
	var array = val.split(':');
	return ((parseInt(array[1]*60) + parseInt(array[2])));
}

// converts position in song form seconds to format given by sonos (string)
function secondsToPosition(val){
	var seconds = val % 60;
    var minutes = (val - seconds) / 60;
	// need seconds to always show 2 digits
	if (seconds > 9){
		return '' + minutes.toString() + ':' + seconds.toString();
	}
	else{
		return '' + minutes.toString() + ':0' + seconds.toString();
	}
}

// removes displaying the hours for position in song which is by default returned by the sonos
function removeHours(val){
	var array = val.split(':');
	// parsing minutes to dynamically change between 1 and 2 digits
	array[1] = parseInt(array[1]);
	return '' + array[1].toString() + ':' + array[2];
}
	
//updates position and duration on dashboard
function setTimes(position, duration){
	duration = positionToSeconds(duration) - positionToSeconds(position);
	document.getElementById("position").innerHTML = removeHours(position);
	document.getElementById("duration").innerHTML = '-' + secondsToPosition(duration);	
}

// sets position and max value for seek bar on dashboard
function updateSeekBar(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
		   var array = this.responseText.split(',');
		   document.getElementById("seekBar").max = positionToSeconds(array[0]);
		   document.getElementById("seekBar").value = positionToSeconds(array[1]);
       }
    };
    xmlhttp.open("GET", "updateSeekBar.php", true);
    xmlhttp.send();
}

// sets album artwork on dashboard
function setImage(albumArt){
	document.getElementById('albumArt').src =  albumArt;
}