<?php

$wgExtensionFunctions[] = 'wfUserRelationshipAction';


function wfUserRelationshipAction(){
	global $wgUser,$IP;
	include_once("$IP/includes/SpecialPage.php");

	class UserRelationshipAction extends SpecialPage 
	{

	  function UserRelationshipAction()
	  {
		global $wgMessageCache;
		UnlistedSpecialPage::UnlistedSpecialPage("UserRelationshipAction");
		
		require_once ( dirname( __FILE__ ) . '/UserRelationship.i18n.php' );
		foreach( efSpecialUserReplationship() as $lang => $messages ) 
		{
			$wgMessageCache->addMessages( $messages, $lang );
		}
	  }

	  function execute(){
		global $wgUser, $wgOut, $IP; 
		global $wgMessageCache;
		
		require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");
		#---
		$rel = new UserRelationship($wgUser->getName() );
		
		if ($_GET["action"] == 1 && $rel->verifyRelationshipRequest($_POST["id"]) == true ) 
		{
			$request = $rel->getRequest(htmlspecialchars($_POST["id"]));
			$user_name_from = $request[0]["user_name_from"];
			$rel_type = strtolower($request[0]["type"]);

			$rel->updateRelationshipRequestStatus(htmlspecialchars($_POST["id"]),htmlspecialchars($_POST["response"]));
			if ( $_POST["response"]==1 )
			{
				$rel->addRelationship(htmlspecialchars($_POST["id"]));
			}
			if ($_POST["response"]==1 )
			{
				echo "<div class=\"relationship-request-confirm\">".wfMsg('user_add_relationship', $user_name_from, $rel_type)."</div>";
				echo "<div class=\"relationship-request-buttons\">
				  <input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>
				  <input type=\"button\" value=\"".wfMsg('yourprofile')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "'\"/>
				  <input type=\"button\" value=\"".wfMsg('your_user_page')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "'\"/>
				  </div>";
			} else {
				echo "<div class=\"relationship-request-confirm\">".wfMsg('user_reject_relationship', $user_name_from, $rel_type)."</div>";
				echo "<div class=\"relationship-request-buttons\">
				  <input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>
				  <input type=\"button\" value=\"".wfMsg('yourprofile')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "'\"/>
				  <input type=\"button\" value=\"".wfMsg('your_user_page')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "'\"/>
				  </div>";
			}
			$rel->deleteRequest(htmlspecialchars($_POST["id"]));
		} 
		$wgOut->setArticleBodyOnly(true);
	  }

	}

	SpecialPage::addPage( new UserRelationshipAction );
	global $wgMessageCache,$wgOut;
	//$wgMessageCache->addMessage( 'userrelationshipaction', 'action for user relationships' );
}

?>
