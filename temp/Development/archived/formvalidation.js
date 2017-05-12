function validateRegister(){
	var flag = 0;
	
	var fName = document.getElementById('fName').value;
	if(fName.trim() == ""){
		document.getElementById('fName').style.borderColor = "#ff0000";
		flag = 1;
	}
	else{
		document.getElementById('fName').style.borderColor = "#CCC";
	}
	
	var lName = document.getElementById('lName').value;
	if(lName.trim() == ""){
		document.getElementById('lName').style.borderColor = "#ff0000";
		flag = 1;
	}
	else{
		document.getElementById('lName').style.borderColor = "#CCC";
	}
	
	if (flag==0){
		return true;
	}
	else{
		return false;
	}
}

function validateLogin(){
	var email = document.getElementById('email').value;
	if(email.trim() == ""){
		document.getElementById('email').style.borderColor = "#ff0000";
		return false;
	}
	else{
		document.getElementById('email').style.borderColor = "#CCC";
		return true;
	}
}