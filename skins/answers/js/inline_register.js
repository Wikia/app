var errorEmail = errorPass = errorRetype = errorDate = true;

function usernameCheck() {
	jQuery.get( wgServer + wgScriptPath + '/?action=ajax&rs=cxValidateUserName&rsargs[]='+document.getElementById("wpName2").value, 
			"", function( responseText ){
				
				if( responseText == "OK" ){
					document.getElementById("username_check").innerHTML = "<img src='" + stylepath  + "/wikia/img/ok.png'>" ;
				}
				if( responseText == "INVALID" || responseText == "EXISTS" ){
					document.getElementById("username_check").innerHTML = "<img src='" + stylepath  + "/wikia/img/error.png'>" ;
				}
					
	});
}
$("#wpName2").ready(function() {
	$("#wpName2").blur( usernameCheck );
});	

/*
function checkForm(){
	checkEmail();
	checkPass();
	//checkRetype();
	return false;
	return !( errorEmail ); // || errorPass || errorRetype  );
}

function registerFormError( id, clear ){
	if( !clear ) {
		$("#"+id).addClass("mw-input-error").removeClass("mw-input-ok")
	}else{
		$("#"+id).removeClass("mw-input-error").addClass("mw-input-ok")
	}
}



function checkEmail() {
	var email_elem = document.getElementById('wpEmail') ;
	
	if (email_elem) {
		var email = email_elem.value;
		if (email == '') {
			errorEmail = false;
		} else if (email.match(/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/mi)) {
			errorEmail = false;
		} else {
			errorEmail = true;
		}
	} else {
		errorEmail = false ;
	}

	if( errorEmail ){
		registerFormError("wpEmailTD",0)
	}else{
		registerFormError("wpEmailTD",1)
	}
		
		
}
function checkPass() {
	var passLen = document.getElementById('wpPassword2').value.length;
	if (passLen >= wgMinimalPasswordLength ) {
		registerFormError("wpPassword2",1)
		errorPass = false;
	} else {
		registerFormError("wpPassword2",0)
		errorPass = true;
	}
}
function checkUsernamePass() {
	var pass = document.getElementById('wpPassword2').value;
	var name = document.getElementById('wpName2').value;
	if (pass != '') {
		if (pass == name) {
			registerFormError("wpPassword2",0)
			errorPass = true;
		} else {
			registerFormError("wpPassword2",1)
			errorPass = false;
		}
	}
}

function checkRetype() {
	var pass = document.getElementById('wpPassword2').value;
	var pass2= document.getElementById('wpRetype').value;
	if (pass == pass2) {
		if ('' == pass2) {
			registerFormError("wpRetype",0)
			errorRetype = true;
		} else {
			registerFormError("wpRetype",1)
			errorRetype = false;
		}
		
	} else {
		registerFormError("wpRetype",0)
		errorRetype = true;
	}
}
*/
