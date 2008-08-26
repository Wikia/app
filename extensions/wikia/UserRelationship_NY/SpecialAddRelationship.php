<?php
/**#@+
*	A special page for adding friends/foe requests for existing users in the wiki
*
* 	Example URL: index.php?title=Special:AddRelationship&user=Pean&rel_type=1 (for adding as friend)
* 	Example URL: index.php?title=Special:AddRelationship&user=Pean&rel_type=2 (for adding as foe)
*
* @package MediaWiki
* @subpackage SpecialPage
*
* @author David Pean <david.pean@gmail.com>
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/



	class AddRelationship extends SpecialPage {
	
		function AddRelationship(){
			UnlistedSpecialPage::UnlistedSpecialPage("AddRelationship");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $wgMessageCache, $IP, $wgUploadPath, $wgUserRelationshipScripts, $wgDisableFoeing;
	
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserRelationshipScripts}/UserRelationship.css?{$wgStyleVersion}\"/>\n");
			
			$usertitle = Title::newFromDBkey($wgRequest->getVal('user'));
			$user =  Title::makeTitle( NS_USER  , $usertitle->getText()  );
			  
			if(!$usertitle){
				$wgOut->addHTML("No user selected.  Please request friends/foes through the correct link.");
				return false;	
			}
			
			$wgOut->addHTML("<script>
			function enablize(which_div, disable) {
				 
	if(disable == null) disable = true;
	var form_elements = document.getElementById(which_div).getElementsByTagName(\"input\");
	for (var i=0; i<form_elements.length; i++) form_elements[i].disabled = disable;
	var form_elements = document.getElementById(which_div).getElementsByTagName(\"select\");
	for (var i=0; i<form_elements.length; i++) form_elements[i].disabled = disable;
	var form_elements = document.getElementById(which_div).getElementsByTagName(\"textarea\");
	for (var i=0; i<form_elements.length; i++) form_elements[i].disabled = disable;
}
			</script>");
			
			$this->user_name_to = $usertitle->getText();
			$this->user_id_to = User::idFromName($this->user_name_to);
			$this->relationship_type = $wgRequest->getVal('rel_type');
			if(!$this->relationship_type || !is_numeric($this->relationship_type) || $wgDisableFoeing == true )$this->relationship_type = 1;
			
			
				
				$rel = new UserRelationship($wgUser->getName() );
		 		
				if ($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false) {
					
					$_SESSION["alreadysubmitted"] = true;
					$rel = $rel->addRelationshipRequest($this->user_name_to,$this->relationship_type,$wgRequest->getVal("message"));
					
					$avatar = new wAvatar($this->user_id_to,"l");
					$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/>";
					
					if ($this->relationship_type==1){
			          $label = wfMsg("ur-friend");
		            } else {
			          $label = wfMsg("ur-foe");
		            }
					
					$out = "";
					
					$out .= $wgOut->setPagetitle( wfMsg("ur-add-sent-title", $label, $this->user_name_to));
							
					$out .= "<div class=\"relationship-action\">
						{$avatar_img}
						".wfMsg("ur-add-sent-message", $label, $this->user_name_to)."
						<div class=\"relationship-buttons\" >
							<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-main-page')."\" size=\"20\" onclick=\"window.location='index.php?title=Main_Page'\"/> 
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
	
		function displayForm() {
		   	global $wgOut, $wgUser, $wgUploadPath;
		   
		   	$form =  "";
		   
			if ($this->relationship_type==1) {
			
			   	$label = wfMsg('ur-friend');
			   	$label1 = wfMsg('ur-friendship');
		   
			} else {
			
			   $label = wfMsg('ur-foe');
			   $label1 = wfMsg('ur-grudge');
		   	
			}
		   
		   	$avatar = new wAvatar($this->user_id_to,"l");
			$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/>";
		   
			$user_link = Title::makeTitle(NS_USER,$this->user_name_to);
		   
		   	$form .= $wgOut->setPagetitle( wfMsg("ur-add-title", $this->user_name_to, $label) );
		
		   	$form .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
		   		<div class=\"relationship-action\">
					{$avatar_img}
					".wfMsg("ur-add-message", $this->user_name_to, $label, $label1)."
					<div class=\"cleared\"></div>
		   		</div>
		   		<div class=\"relationship-textbox-title\">
					Add a Personal Message
				</div>
		   		<textarea name=\"message\" id=\"message\" rows=\"3\" cols=\"50\"></textarea>
		   		<div class=\"relationship-buttons\" id=\"rel-buttons\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-add-button', ucfirst($label))."\" size=\"20\" onclick=\"enablize('rel-buttons');document.form1.submit()\" />
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-cancel')."\" size=\"20\" onclick=\"history.go(-1)\" />
		  		</div>
		  	</form>";
		  	return $form;
		}
	}


?>
