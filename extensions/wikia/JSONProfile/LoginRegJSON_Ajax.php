<?php

$wgAjaxExportList [] = 'wfCheckUserLoginJSONnew';
function wfCheckUserLoginJSONnew($callback_function="handle_user_logged_in("){ 
	global $wgUser, $wgSearchKTKeyAnon, $wgSearchKTKeyUser, $wgSearchKTKeyAdmin;
	
	$utc_str = gmdate("M d Y H:i:s", time());
	$utc = strval(intval(strtotime($utc_str))*1000);
  
	$logged_in_info = array();
	if (!$wgUser->isLoggedIn() || $wgUser->isAnon()) {
		$logged_in_info["is_logged_in"] = false;
		$logged_in_info["user_name"] = "";
		$logged_in_info["user_id"] = "";
		$logged_in_info["hash"] = md5($wgUser->getName().$wgSearchKTKeyAnon.$utc);
		$logged_in_info["IP"] = $wgUser->getName();
		$logged_in_info["time"] = $utc;
	}else {
		$logged_in_info["is_logged_in"] = true;
		$logged_in_info["user_name"] = $wgUser->getName();
		$logged_in_info["user_id"] = $wgUser->getId();
		$user_groups = $wgUser->getGroups();
		$user_groups = array_flip($user_groups);
		if (isset($user_groups['staff'])||isset($user_groups['bureaucrat'])||isset($user_groups['sysop'])) {
			$logged_in_info["adminhash"] = md5($wgUser->getName()."HasAdminRights");
			$logged_in_info["hash"] = md5($wgUser->getName().$wgSearchKTKeyAdmin.$utc);
		}
		else $logged_in_info["hash"] = md5($wgUser->getName().$wgSearchKTKeyUser.$utc);
		$logged_in_info["time"] = $utc;
	}

	
	if( strpos( $callback_function, "(" ) === false ){
		$callback_function .= "(";
	}
	return "var user_logged_in = " . 
		jsonify($logged_in_info) . 
		";\n\n" . 
		"setLoginCookie(user_logged_in);\n\n" . 
		"set_header_loggedin();\n\n" . 
		"{$callback_function}user_logged_in);";
}

//we are keeping this function so the API to the Wikia Search Toolbar doesn't break :)
$wgAjaxExportList [] = 'wfCheckUserLoginJSON';
function wfCheckUserLoginJSON($callback_function="handle_user_logged_in"){ 
	global $wgUser;
	
	$logged_in_info = array();
	if (!$wgUser->isLoggedIn() || $wgUser->isAnon()) {
		$logged_in_info["is_logged_in"] = false;
		$logged_in_info["user_name"] = "";
		$logged_in_info["user_id"] = "";
		$logged_in_info["hash"] = "";
		$logged_in_info["IP"] = $wgUser->getName();
		
	}
	else {
		$logged_in_info["is_logged_in"] = true;
		$logged_in_info["user_name"] = $wgUser->getName();
		$logged_in_info["user_id"] = $wgUser->getId();
		$logged_in_info["hash"] = md5($wgUser->getName()."OurSecretKey");
		$user_groups = $wgUser->getGroups();
		$user_groups = array_flip($user_groups);
		if (isset($user_groups['staff'])||isset($user_groups['bureaucrat'])||isset($user_groups['sysop'])) $logged_in_info["adminhash"] = md5($wgUser->getName()."HasAdminRights"); 
	}

	return "var user_logged_in = " . 
		jsonify($logged_in_info) . 
		";\n\n" . 
		"setLoginCookie(user_logged_in);\n\n" . 
		"set_header_loggedin();\n\n" . 
		"{$callback_function}(user_logged_in);";

}

$wgAjaxExportList [] = 'wfDoLogoutJSON';
function wfDoLogoutJSON($callback_function=false){ 
	global $wgUser;
	
	$wgUser->logout();

	if ($callback_function) {
		return wfCheckUserLoginJSONnew($callback_function);
	}
	else {
		return wfCheckUserLoginJSONnew();
	}

}

$wgAjaxExportList [] = 'wfDoEmailPassword';
function wfDoEmailPassword($username, $returnto){
	global $IP, $wgOut,$wgRequest, $wgUser, $wgServer,$wgArticlePath,  $wgScriptPath;

	require_once ( $IP.'/includes/specials/SpecialUserlogin.php');
	
	// need to make sure it falls into the if switch
	$_SERVER['REQUEST_METHOD'] = 'POST';
	
	$_REQUEST['wpName'] = $username;
	$_REQUEST['wpMailmypassword'] = "true";
	
	wfSpecialUserlogin();
	 
	// see if something bombed
	$ret = $wgOut->getHTML();
	if(strpos($ret, 'class="errorbox"') === false){
		$msg = "A new password has been emailed to you!";
	}else{
		$start = strpos($ret, 'class="errorbox">')+17;
		$length = strpos($ret, '</div>') - $start;
		$msg = trim(substr($ret, $start, $length));
		
		$msg = str_replace("<h2>", "", $msg);
		$msg = str_replace("</h2>", "", $msg);
		$msg = str_replace("\t", "", $msg);
		$msg = str_replace("Login error:", "", $msg);
	}
	
	return "var msg=" . jsonify($msg) . "; alert(msg);";
}

$wgAjaxExportList [] = 'wfDoLoginJSONPost';
function wfDoLoginJSONPost(){
	
	if(!isset($_POST['wpName']) || !isset($_POST['wpPassword']) || !isset($_POST['wpSourceForm'])) {
		return "no";
	}
	
	$wpName = $_POST['wpName'];
	$wpPassword = $_POST['wpPassword'];
	$wpSourceForm = $_POST['wpSourceForm'];
	$wpRemember = (isset($_POST['wpRemember']) ? $_POST['wpRemember'] : 0);

	
	global $IP, $wgOut,$wgRequest, $wgUser, $wgServer,$wgArticlePath,  $wgScriptPath;

	require_once ( $IP.'/includes/specials/SpecialUserlogin.php');

	$_REQUEST['wpName'] = $wpName;
	$_REQUEST['wpPassword'] = $wpPassword;
	if ($wpRemember) {
		$_REQUEST['wpRemember'] = 1;
	}
	$_REQUEST['wpLoginattempt']="Log in";
	$_REQUEST['action']="submitlogin";
	$_REQUEST['type']="login";

	if( session_id() == '' ) {
		wfSetupSession();
	}
	$l_form = new LoginForm($wgRequest);
	$l_form->processLogin();
	
	$temp_out=$wgOut->getHTML();
	
	if ($wgUser->isLoggedIn()) {
		$name = urlencode($wpName);
		$output = "<script type=\"text/javascript\">
				location.href='{$wpSourceForm}?loggedinas={$name}';
			</script>";
	}
	else {
		$re_pattern = "/<div class=\"errorbox\"\>[^<]*<h2\>Login error\:<\/h2\>([^<]*)<\/div\>/iU";
		preg_match($re_pattern, $temp_out, $matches);
		if (sizeof($matches)) {
			$message = str_replace("\"", "\\\"", trim($matches[1]));
			$output = "<script type=\"text/javascript\">alert(\"{$message}\"); location.href='{$wpSourceForm}';</script>";
		}
		else {
			$message = "not logged in";
			$output = "<script type=\"text/javascript\">alert(\"{$message}\"); location.href='{$wpSourceForm}';</script>";
		}
	}
	return $output;
	
}

$wgAjaxExportList [] = 'wfGetRegCaptchaJSON';
function wfGetRegCaptchaJSON($callback_function="process_captcha"){
	
	global $wgOut, $wgCaptchaTriggers, $IP, $recaptcha_public_key;
	$res = array();
	$res["public_key"] = $recaptcha_public_key;
	return "var captcha_stuff = ". jsonify($res) . ";\n\n{$callback_function}(captcha_stuff);";
	
}
//"
$wgAjaxExportList [] = 'wfDoRegisterJSONPost';
function wfDoRegisterJSONPost(){
	
	global $IP, $wgOut,$wgRequest, $wgUser, $wgServer,$wgArticlePath,  $wgScriptPath, $recaptcha_private_key, $wgCaptchaTriggers;
	
	$wpSourceForm = $_POST['wpSourceForm'];
	$wpName = $_POST['wpName'];
	
	require_once ( $IP.'/includes/specials/SpecialUserlogin.php');
	require_once($IP . "/extensions/wikia/JSONProfile/recaptchalib.php");

	$wgCaptchaTriggers['createaccount'] = false;
	
	// before we do anything - check the reCaptcha
	$ip = wfGetIP();
	$resp = recaptcha_check_answer ($recaptcha_private_key, $ip, $wgRequest->getVal("wpCaptchaId"), $wgRequest->getVal("wpCaptchaWord"));
	
	// if it failed just bail
	if (!$resp->is_valid) {
		return "<script type=\"text/javascript\">
				alert(\"CAPTCHA check failed! Please try again.\"); 
				location.href='{$wpSourceForm}?error=true';
			</script>";
	}
	
	$_REQUEST['action']="submitlogin";
	$_REQUEST['type']="signup";

	wfSpecialUserlogin();
	
	$temp_out=$wgOut->getHTML();
	
	if ($wgUser->isLoggedIn()) {
		
		$birthday = $wgRequest->getVal("birthyear") . "-" . $wgRequest->getVal("birthmonth") . "-" . $wgRequest->getVal("birthdate");
		$gender = $wgRequest->getVal("gender");
		
		registerSetBdayGender($birthday, $gender);
		
		$real_name = $wgRequest->getVal("first_name") . " " . $wgRequest->getVal("last_name");
		if (trim($real_name) != "") {
			$wgUser->setRealName($real_name);
			$wgUser->saveSettings();
		}
		
		$name = urlencode($wpName);
		$output = "<script type=\"text/javascript\">
				location.href='" . $wpSourceForm . "?registeredas={$name}';
			  </script>";
		
	}else if (strpos($temp_out, "Login error")) {
		$re_pattern = "/<div class=\"errorbox\"\>[^<]*<h2\>Login error\:<\/h2\>([^<]*)<\/div\>/iU";
		preg_match($re_pattern, $temp_out, $matches);
		if (sizeof($matches)) {
			$output = str_replace("\"", "\\\"", trim($matches[1]));
			$output = "<script type=\"text/javascript\">
					alert(\"{$output}\"); 
					location.href='{$wpSourceForm}?error=true';
				   </script>";
		}
	}
	else {
		$output = "<script type=\"text/javascript\">
				alert(\"There was a problem processing your registration. Please try again.\"); 
				location.href='{$wpSourceForm}?error=true';
			 </script>";
	}
	
	return $output;
	
	
}

function registerSetBdayGender($birthday, $gender) {
	global $wgUser;
	
	if ($wgUser->isLoggedIn()) {
		UpdateProfile::initProfile();
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`user_profile`',
		array( /* SET */
			'up_birthday' => $birthday,
			'up_gender' => $gender,
		), array( /* WHERE */
			'up_user_id' => $wgUser->getID()
		), ""
		);
	
	}
	
}

$wgAjaxExportList [] = 'wfInitializeEmail';
function wfInitializeEmail($callback="get_invite_email"){
	global $wgUser, $IP;
	$return_name = "";
	if ($wgUser->isLoggedIn()) {
		if ($wgUser->getRealName() != "") {
			$return_name = $wgUser->getRealName();
		}
		else {
			$return_name = $wgUser->getName();
		}
	}
	
	$email_array = array("name"=>$return_name,"url"=>"http://search.wikia.com");
	
	
	
	return "var email_array = ". jsonify($email_array) . ";\n\n{$callback}(email_array);";
}

$wgAjaxExportList [] = 'wfSendInviteEmail';
function wfSendInviteEmail(){
	global $wgRequest, $wgUser, $wgEmailFrom;
	if ($wgRequest->wasPosted()) {
		$message = $wgRequest->getVal("invite_email_text");
		$list = $wgRequest->getVal("invite_email_list");
		$subject = $wgRequest->getVal("invite_email_subject");
		$wpSourceForm = $wgRequest->getVal("wpSourceForm");
		
		$emails = explode(",",$list);
		
		foreach($emails as $email) {
			if (trim($email) != "") {
				mail(trim($email), $subject, $message, "From: $wgEmailFrom");
			}
		}
		
		$output = "<script type=\"text/javascript\">location.href='{$wpSourceForm}?emailsent=1';</script>";
	}
	else {
		$output = "<script type=\"text/javascript\">location.href='{$wpSourceForm}?emailsent=0';</script>";
	}
	return $output;
}

$wgAjaxExportList [] = 'wfcheckBlocksJSON';
function wfcheckBlocksJSON($callback_function="handle_block_check"){ 
	global $wgUser;
	
	$logged_in_blocked = array();
	if (!$wgUser->isLoggedIn() || $wgUser->isAnon()) {
		$logged_in_blocked["is_anon"] = true;
		$logged_in_blocked["ip"] = $wgUser->getName();
		$logged_in_blocked["UTC"] = time();
		
		$b = Block::newFromDB($logged_in_blocked["ip"]);
		if ($b && $b!=null) $logged_in_blocked["hash"] = "";
		else $logged_in_blocked["hash"] = md5($logged_in_blocked["ip"] + $logged_in_blocked["UTC"] + "Rhymenocerous");
		
	}
	else {
		$logged_in_blocked["is_anon"] = false;
		$logged_in_blocked["name"] = $wgUser->getName();
		$logged_in_blocked["UTC"] = time();
		$b = $wgUser->isBlocked();
		if ($b) $logged_in_blocked["hash"] = "";
		else $logged_in_blocked["hash"] = md5($logged_in_blocked["name"] + $logged_in_blocked["UTC"] + "Rhymenocerous");
	}

	return "var user_blocked = " . 
		jsonify($logged_in_blocked) . 
		";\n\n" . 
		"{$callback_function}(user_blocked);";

}

?>
