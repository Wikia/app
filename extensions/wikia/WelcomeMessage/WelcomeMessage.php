<?php
function wgGetWelcomeMessage(){
	global $wgWelcomeMessages, $wgUser;
	if($wgWelcomeMessages){
		$msg = $wgWelcomeMessages[rand(0,count($wgWelcomeMessages)-1)];
		$msg = str_replace("#username#",$wgUser->mName,$msg);
		return $msg;
	}else{
		return "Hello " . $wgUser->mName;
	}
}
?>