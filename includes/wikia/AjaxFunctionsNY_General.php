<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfPageTitleExists';
function wfPageTitleExists( $page_name ){ 	
	//load mediawiki objects to check if article exists
	$page_title =  Title::newFromText( $page_name );
	$article = new Article( $page_title );
	if( $article->exists() ){ 
		return "Page exists";
	} else {
		return "OK";
	}
}

$wgAjaxExportList [] = 'wfUsernameExists';
function wfUsernameExists( $user_name ){ 	
	$user_id = User::idFromName($user_name);
	if( $user_id > 0 ){ 
		return "exists";
	} else {
		return "OK";
	}
}

$wgAjaxExportList [] = 'wfCaptchaCheck';
function wfCaptchaCheck( $captcha_id, $answer ){
	global $wgCaptchaSecret;
	$info = $_SESSION['captcha' . $captcha_id];
	
	$digest = $wgCaptchaSecret . $info['salt'] . $answer . $wgCaptchaSecret . $info['salt'];
	$answerHash = substr( md5( $digest ), 0, 16 );
		
	if( $answerHash == $info['hash'] ) {
		return "OK";
	}else{
		return "false";
	}
}


?>