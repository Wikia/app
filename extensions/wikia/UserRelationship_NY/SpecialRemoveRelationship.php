<?php
/**#@+
*	A special page for removing existing friends/foes for the current logged in user
*
* 	Example URL: /index.php?title=Special:RemoveRelationship&user=Awrigh01

*
* @package MediaWiki
* @subpackage SpecialPage
*
* @author David Pean <david.pean@gmail.com>
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/



	class RemoveRelationship extends UnlistedSpecialPage {
	
		function RemoveRelationship(){
			parent::__construct("RemoveRelationship");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMessageCache, $wgUploadPath, $wgUserRelationshipScripts;
		
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserRelationshipScripts}/UserRelationship.css?{$wgStyleVersion}\"/>\n");
			
			$usertitle = Title::newFromDBkey($wgRequest->getVal('user'));
			if(!$usertitle){
				$wgOut->addHTML("No user selected.  Please remove friends/foes through the correct link.");
				return false;	
			}
			
			$this->user_name_to = $usertitle->getText();
			$this->user_id_to = User::idFromName($this->user_name_to);
			$this->relationship_type = UserRelationship::getUserRelationshipByID($this->user_id_to,$wgUser->getID());
			
			if($this->relationship_type==1){
			   $label = wfMsg("ur-friend");
			} else {
			   $label = wfMsg("ur-foe");
			}
			
			if($wgUser->getID()== $this->user_id_to){
				$out .= $wgOut->setPagetitle( wfMsg("ur-error-title") );
				$out .= "<div class=\"relationship-error-message\">
					".wfMsg("ur-remove-error-message-remove-yourself")."
				</div>
				<div>
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-main-page")."\" size=\"20\" onclick='window.location=\"" . Title::newMainPage()->getLocalURL() . "\"' /> ";
			        if($wgUser->isLoggedIn())$out.="<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-your-profile")."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>";
				$out .= "</div>";
				
				$wgOut->addHTML($out);
				
			} else if ($this->relationship_type==false) {
				
				$out .= $wgOut->setPagetitle( wfMsg("ur-error-title") );
				$out .= "<div class=\"relationship-error-message\">
					".wfMsg("ur-remove-error-message-no-relationship", $this->user_name_to)."
				</div>
				<div>
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-main-page")."\" size=\"20\" onclick='window.location=\"" . Title::newMainPage()->getLocalURL() . "\"' /> ";
				 	if($wgUser->isLoggedIn())$out.="<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-your-profile")."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>";
				$out .= "</div>";
				
				$wgOut->addHTML($out);
				
			} else if (UserRelationship::userHasRequestByID($this->user_id_to,$wgUser->getID()) == true) {
				$out .= $wgOut->setPagetitle( wfMsg("ur-error-title") );
				$out .= "<div class=\"relationship-error-message\">
					".wfMsg("ur-remove-error-message-pending-request", $label, $this->user_name_to)."
				</div>
				<div>
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-main-page")."\" size=\"20\" onclick='window.location=\"" . Title::newMainPage()->getLocalURL() . "\"' /> ";
				 	if($wgUser->isLoggedIn())$out.="<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-your-profile")."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>";
				$out .= "</div>";
				
				$wgOut->addHTML($out);
				
			} else if ($wgUser->getID() == 0) {
				$out .= $wgOut->setPagetitle( wfMsg("ur-error-title") );
				$out .= "<div class=\"relationship-error-message\">
					".wfMsg("ur-remove-error-not-loggedin", $label)."
				</div>
				<div>
					<input type=\"button\" class=\"site-button\" value=".wfMsg("ur-main-page")." size=\"20\" onclick='window.location=\"" . Title::newMainPage()->getLocalURL() . "\"' /> ";
				 	if($wgUser->isLoggedIn())$out.="<input type=\"button\" class=\"site-button\" value=".wfMsg("ur-your-profile")." size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>";
				$out .= "</div>";
				
				$wgOut->addHTML($out);
				
			} else {
				$rel = new UserRelationship($wgUser->getName() );
		 		if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false){
					
					$_SESSION["alreadysubmitted"] = true;
					$rel->removeRelationshipByUserID($this->user_id_to,$wgUser->getID() );
					#$rel->sendRelationshipRemoveEmail($this->user_id_to, $wgUser->getName(), $this->relationship_type);
					$avatar = new wAvatar($this->user_id_to,"l");
					$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"\"/>";
					
					
					$out .= $wgOut->setPagetitle( wfMsg("ur-remove-relationship-title-confirm", $this->user_name_to, $label));
					
					$out .= "<div class=\"relationship-action\">
		               	{$avatar_img}
						".wfMsg("ur-remove-relationship-message-confirm", $this->user_name_to, $label)."
						<div class=\"relationship-buttons\">
							<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-main-page')."\" size=\"20\" onclick=\"window.location='" . Title::newMainPage()->getLocalURL() . "'\"/> 
							<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-your-profile')."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>
						</div>
					   <div class=\"cleared\"></div>
					</div>";				
										
					$wgOut->addHTML($out);
					
				} else {
					$_SESSION["alreadysubmitted"] = false;
					$wgOut->addHTML($this->displayForm());
					
				}
				
			}
		}
	

		function displayForm() {
			global $wgOut, $wgUploadPath;
		    
			$form =  "";
		  	$avatar = new wAvatar($this->user_id_to,"l");
		   	$avatar_img = "<img src='{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "' alt='avatar' />";
		   
		   	if ($this->relationship_type==1) {
			   	$label = wfMsg("ur-friend");
		   	} else {
			   	$label = wfMsg("ur-foe");
		   	}
		   	
			$form .= $wgOut->setPagetitle( wfMsg("ur-remove-relationship-title", $this->user_name_to, $label));
		   		   
		   	$form .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
		   		<div class=\"relationship-action\">
		   			{$avatar_img}
					".wfMsg("ur-remove-relationship-message", $this->user_name_to, $label, wfMsg("ur-remove"))."
					<div class=\"relationship-buttons\">
						<input type=\"hidden\" name=\"user\" value=\"".addslashes($this->user_name_to)."\">
						<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-remove")."\" size=\"20\" onclick=\"document.form1.submit()\" />
						<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-cancel")."\" size=\"20\" onclick=\"history.go(-1)\" />
					</div>
					<div class=\"cleared\"></div>
			 	</div>		   	
				
		  	</form>";
		  return $form;
		}
	}

?>
