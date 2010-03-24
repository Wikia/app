<?php

// FIXME: Document what this extension does.

#$wgHooks['UserLoginComplete'][] = 'fnLoginRedirect';

$wgHooks['AddNewAccount'][] = 'fnRegisterTrack';
$wgHooks['AddNewAccount'][] = 'fnCreateUserPage';
$wgHooks['AddNewAccount'][] = 'fnRegisterAutoAddFriend';
$wgHooks['AddNewAccount'][] = 'fnRegisterRedirect';
#$wgHooks['UserCreateForm'][] = 'fnRedirectCreateForm';

function fnLoginRedirect() {
        global $wgOut, $wgUser, $wgRequest, $wgSiteView,  $wgDefaultSkin;
	$wgUser->setOption( 'skin', $wgDefaultSkin );
	
	$from  = $wgRequest->getVal( 'title_from' );
	$return_to = $wgRequest->getVal( 'returnto' );

	if(!$from){
		$return_title = Title::newFromDBkey($return_to);
		if(is_object($return_title)){
			$from = $return_title->getFullURL();
		}
	}
	
	//hack to prevent going back to logout after registering
	$pos = strpos($from,"Special:Userlogout");
	if($pos !== false || $pos2!==false){
		//if($wgSiteView->getDomainName()!=""){
		//	$from= str_replace("Special:Userlogout","My_Openserve",$from);
		//}else{
			$from = str_replace("Special:Userlogout","Main_Page",$from);
		//}
	}
	//another hack to prevent going back to register after registering
	$pos = strpos($from,"Special:UserRegister");
	if($pos !== false || $pos2!==false){
		$from = str_replace("Special:UserRegister","Main_Page",$from);
	}
	if($from != ""){
		$wgOut->redirect( $from );
	}
	return true;
	
}

function fnCreateUserPage($user) {
	$title = Title::newFromUrl( "User:" . $user->getName() );
	$article = new Article( $title );
	$article->doEdit( "", "New user" );
	return true;
}

function fnRegisterRedirect($user) {
	global $wgOut, $wgRegisterRedirect;
	
	//Always default to redirect to the User Page if nothing is set locally
	if(!$wgRegisterRedirect){
		$user =  Title::makeTitle( NS_USER  , $user->getName()  );
		$from = $user->getFullURL();
	}else{
		$redirect =  Title::makeTitle( NS_MAIN  , $wgRegisterRedirect  );
		$from = $redirect->getFullURL("from=register");
	}
	$wgOut->redirect( $from );
	return true;
}

function fnRegisterAutoAddFriend($user) {
	global $wgRequest, $IP, $wgAutoAddFriendOnInvite;
	
	if($wgAutoAddFriendOnInvite){

		$referral_user = $wgRequest->getVal( 'referral' );
		if($referral_user){
			$user_id_referral = User::idFromName($referral_user);
			if($user_id_referral){
				//need to create fake request first
				$rel = new UserRelationship($referral_user);
				$request_id = $rel->addRelationshipRequest($user->getName(),1,"",false);
				
				//clear the status
				$rel->updateRelationshipRequestStatus($request_id,1);
				
				//automatically add relationships
				$rel = new UserRelationship($user->getName());
				$rel->addRelationship($request_id,true);
			}
		}
	}
	return true;
}



function fnRegisterTrack($user) {
	global $wgRequest, $wgRegisterTrack, $IP, $wgMemc;
	
	
	if($wgRegisterTrack){
		$wgMemc->delete( wfMemcKey( 'users', 'new', "1" ) );
		
		$dbr =& wfGetDB( DB_MASTER );
		
		//How the user registered (via email from friend, just on the site etc)
		$from  = $wgRequest->getVal( 'from' );
		if(!$from)$from = 0;
		
		//track if the user clicked on email from friend
		$user_id_referral = 0;
		$user_name_referral = '';
		$referral_user = $wgRequest->getVal( 'referral' );
		if($referral_user){
			$user_registering_title = Title::makeTitle( NS_USER  , $user->getName()  );
			$user_title = Title::newFromDBkey($referral_user);
			$user_id_referral = User::idFromName($user_title->getText());
			if($user_id_referral)$user_name_referral = $user_title->getText();
			
			$stats = new UserStatsTrack($user_id_referral, $user_title->getText());
			$stats->incStatField("referral_complete");
			
			$m = new UserSystemMessage();
			$message = "recruited <a href=\"{$user_registering_title->getFullURL()}\">{$user->getName()}</a>";
			$m->addMessage($user_title->getText(),1,$message);
		}

		//track registration
		$fname = 'user_register_track::addToDatabase';
		$dbr->insert( '`user_register_track`',
		array(
			'ur_user_id' => $user->getID(),
			'ur_user_name' => $user->getName(),
			'ur_user_id_referral' => $user_id_referral,
			'ur_user_name_referral' => $user_name_referral,
			'ur_from' => $from,
			'ur_date' => date("Y-m-d H:i:s")
			), $fname
		);
	}
	return true;
}

function fnRedirectCreateForm( $template ){
	global $wgOut;
	$register =  Title::makeTitle( NS_SPECIAL  , "UserRegister"  );
	$wgOut->redirect( $register->getFullURL(  ) );
	return true;
}
?>