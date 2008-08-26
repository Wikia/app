<?php

$wgExtensionFunctions[] = 'wfSpecialRemoveRelationship';


function wfSpecialRemoveRelationship(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class RemoveRelationship extends SpecialPage 
	{
		function RemoveRelationship()
		{
			global $wgMessageCache;
			SpecialPage::SpecialPage("RemoveRelationship","", false);

			require_once ( dirname( __FILE__ ) . '/UserRelationship.i18n.php' );
			foreach( efSpecialUserReplationship() as $lang => $messages ) {
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP;
		
			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");
		
			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserRelationship/css/relationship.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);
			
			$usertitle = Title::newFromDBkey(htmlspecialchars($wgRequest->getVal('user')));
			if(!$usertitle)
			{
				$wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$wgOut->addHTML("<p class=\"user-profile-message\">".wfMsg('invalid_friend_foe_remove')."</p>");
				return false;	
			}
			
			$this->user_name_to = $usertitle->getText();
			$this->user_id_to = User::idFromName($this->user_name_to);
			$this->relationship_type = UserRelationship::getUserRelationshipByID($this->user_id_to,$wgUser->getID());
			
			if($this->relationship_type==1)
			{
			   $label = ucfirst(wfMsg('friend_text'));
			} else {
			   $label = ucfirst(wfMsg('foe_text'));;
			}
			
			if($wgUser->getID()== $this->user_id_to)
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= '<div class="friend-request-message">'.wfMsg('cant_remove_yourself').'</div>';
				$out .= '<div class="friend-request-buttons">';
				$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="index.php?title=Main_Page"\' /> ';
				if ( $wgUser->isLoggedIn() ) 
				{
					$out .= '<input type="button" value="'.wfMsg('yourprofile').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . '"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('your_user_page').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . '"\' /> ';
				}
				$out .= '</div>';
				
				$wgOut->addHTML($out);
				
			}
			elseif($this->relationship_type==false)
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= '<div class="friend-request-message">'.wfMsg('invalid_relationship', $this->user_name_to).'</div>';
				$out .= '<div class="friend-request-buttons">';
				$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="index.php?title=Main_Page"\' /> ';
				if ( $wgUser->isLoggedIn() ) 
				{
					$out .= '<input type="button" value="'.wfMsg('yourprofile').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . '"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('your_user_page').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . '"\' /> ';
				}
				$out .= '</div>';
				
				$wgOut->addHTML($out);
				
			}
			elseif(UserRelationship::userHasRequestByID($this->user_id_to,$wgUser->getID()) == true)
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= '<div class="friend-request-message">'.wfMsg('user_pending_request', $label, $this->user_name_to).'</div>';
				$out .= '<div class="friend-request-buttons">';
				$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="index.php?title=Main_Page"\' /> ';
				if ( $wgUser->isLoggedIn() )
				{
					$out .= '<input type="button" value="'.wfMsg('yourprofile').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . '"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('your_user_page').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . '"\' /> ';
				}
				$out .= '</div>';
				
				$wgOut->addHTML($out);
			}
			elseif($wgUser->getID() == 0)
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= '<div class="friend-request-message">'.wfMsg('user_haveto_logged_to_remove', $label).'</div>';
				$out .= '<div class="friend-request-buttons">';
				$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="index.php?title=Main_Page"\' /> ';
				if ( $wgUser->isLoggedIn() ) 
				{
					$out .= '<input type="button" value="'.wfMsg('yourprofile').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . '"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('your_user_page').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . '"\' /> ';
				}
				$out .= '</div>';
				
				$wgOut->addHTML($out);
			}
			else
			{
				$rel = new UserRelationship($wgUser->getName() );
		 		if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false)
		 		{
					$_SESSION["alreadysubmitted"] = true;
					$rel->removeRelationshipByUserID($this->user_id_to,$wgUser->getID() );
					$rel->sendRelationshipRemoveEmail($this->user_id_to, $wgUser->getName(), $this->relationship_type);
					$avatar = new WikiaAvatar($this->user_id_to,"l");
					$avatar_img = $avatar->getAvatarImageTag("l");
					
					$out .= $wgOut->setPagetitle( wfMsg('you_remove_relationship', $this->user_name_to, $label) );
					
					$out .= '<div class="friend-request">
					<span class="friend-request-image">'.$avatar_img.'</span>
					<span class="friend-request-message">'.wfMsg('you_remove_relationship', $this->user_name_to, $label).'</span>
					<div class="cleared"></div>
					<div class=\"friend-request-buttons\">				
						<input type="button" value="'.wfMsg('home').'" size="20" onclick="window.location=\'index.php?title=Main_Page\'"/> 
						<input type="button" value="'.wfMsg('yourprofile').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . '"\' /> 
						<input type="button" value="'.wfMsg('your_user_page').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . '"\' />
					</div>
					<div class="cleared"></div>
					</div>';
										
					$wgOut->addHTML($out);
				}
				else
				{
					$_SESSION["alreadysubmitted"] = false;
					$wgOut->addHTML($this->displayForm());
				}
			}
		}
	
		function displayForm()
		{
		   global $wgOut;
		   
		   $form =  "";
		   $avatar = new WikiaAvatar($this->user_id_to,"l");
		   $avatar_img = $avatar->getAvatarImageTag("l");
		   
		   if($this->relationship_type==1)
		   {
			   $label = ucfirst(wfMsg('friend_text'));
		   }
		   else
		   {
			   $label = ucfirst(wfMsg('foe_text'));
		   }
		   $form .= $wgOut->setPagetitle( wfMsg('remove_relation_question', $this->user_name_to, $label) );
		   		   
		   $form .= '<form action="" method="post" enctype="multipart/form-data" name="form1">
		   <div class="friend-request">
		   <span class="friend-request-image">'.$avatar_img.'</span>
		   <span class="friend-request-message">'. wfMsg('requested_remove', $this->user_name_to, $label).'</span>
		   <div class="cleared"></div>
		   <div class=\"friend-request-buttons\">
		   <span>
		   <input type="hidden" name="user" value="' . addslashes($this->user_name_to) . '">
		   <input type="button" value="'.wfMsg('remove_btn').'" size="20" onclick="document.form1.submit()" />
		   <input type="button" value="'.wfMsg('cancel').'" size="20" onclick="history.go(-1)" />
		   </span>
		   </div>
		   <div class="cleared"></div>
		   </div>
		   </form>';
		   
		   return $form;
		}
	}

	SpecialPage::addPage( new RemoveRelationship );
	global $wgMessageCache,$wgOut;
}

?>
