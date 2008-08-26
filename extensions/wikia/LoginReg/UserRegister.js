function create_validate(){
 
	document.userlogin.wpRealName.value = $("first_name").value + " " + $("last_name").value;
	
	if(document.userlogin.wpAge.checked == false ){
		alert(_AGE_ALERT);
		return false;
	}
	if( !$("wpName").value ){
		alert(_NOUSERNAME_ALERT);
		return false;
	}	
	if( !$("wpPassword").value ||  $("wpPassword").value !=  $("wpRetype").value ){
		alert(_PASSWORDMATCH_ALERT);
		return false;
	}	
	document.userlogin.submit();
	//validate_username()

}
	
function validate_username(){
	var url = "index.php?action=ajax";
	var params = 'rs=wfUsernameExists&rsargs[]=' + $("wpName").value;
	var callback = {
		success: function( oResponse ) {
			if( oResponse.responseText == "OK") {
				document.userlogin.submit();
				//validate_captcha()
			}else{
				alert(_USERNAME_EXISTS);
				return false;
			}
		}
			
	};

	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params)
}

function validate_captcha(){
	
	var url = "index.php?action=ajax";
	var params = 'rs=wfCaptchaCheck&rsargs[]=' + $("wpCaptchaId").value + "&rsargs[]=" + $("wpCaptchaWord").value;
	var callback = {
		success: function( oResponse ) {
			if( oResponse.responseText == "OK") {
				document.userlogin.submit();
			}else{
				alert(_CAPTCHA_FAIL);
				return false;
			}
		}
			
	};

	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params)
}

function user_name_check(){
	var url = "index.php?action=ajax";
	var params = 'rs=wfUsernameExists&rsargs[]=' + $("wpName").value;
	var callback = {
		success: function( oResponse ) {
			if( !$("wpName").value || oResponse.responseText == "exists"){
				$('wpName').style.border = '2px solid red';
				$('username_status').innerHTML = "<div class='username-unavail'>" + $("wpName").value + " " + _IS_TAKEN + "</div>";
			} else {
				$('wpName').style.border = '2px solid #6BEC4B';
				$('username_status').innerHTML = "<div class='username-avail'>" + $("wpName").value + " " + _IS_AVAILABLE + "</div>";
			}
		}
			
	};

	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params);
}