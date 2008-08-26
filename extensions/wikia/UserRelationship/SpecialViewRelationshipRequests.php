<?php

$wgExtensionFunctions[] = 'wfSpecialViewRelationshipRequests';


function wfSpecialViewRelationshipRequests(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ViewRelationshipRequests extends SpecialPage 
	{
	
		function ViewRelationshipRequests()
		{
			global $wgMessageCache;

			SpecialPage::SpecialPage("ViewRelationshipRequests","",false);

			require_once ( dirname( __FILE__ ) . '/UserRelationship.i18n.php' );
			foreach( efSpecialUserReplationship() as $lang => $messages ) {
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}
		
		function execute(){
			global $wgMessageCache, $wgScriptPath, $wgStyleVersion;
			global $wgUser, $wgOut, $wgRequest, $IP, $wgImageCommonPath;
		
			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewRelationshipRequests page
			/*/
			if ( $wgUser->getID() == 0 ) {
				$wgOut->setPagetitle( wfMsg('woopserror') );
				$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
				$wgOut->redirect( $login->getLocalURL("returnto=Special:ViewRelationshipRequests") );
				return false;
			}
			
			$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/UserRelationship/UserRelationship.js\"></script>\n");
			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserRelationship/css/relationship.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);
			
			$rel = new UserRelationship($wgUser->getName() );
			$friend_request_count = $rel->getOpenRequestCount($wgUser->getID(),1);
			$foe_request_count = $rel->getOpenRequestCount($wgUser->getID(),2);

			if ( count($_POST) && $_SESSION["alreadysubmitted"] == false ) {
				$_SESSION["alreadysubmitted"] = true;
				$rel->addRelationshipRequest($this->user_name_to,$this->relationship_type,htmlspecialchars($_POST["message"]));
				$out = "<br><span class=title>".wfMsg('request_sent')."</span><br><br>";
				$wgOut->addHTML($out);
			} 
			else 
			{
				$_SESSION["alreadysubmitted"] = false;
				$output = "";
				$plural="";
				
				$friend_label = $foe_label = $the_label = "";
				
				if ($friend_request_count)
				{
					if ($friend_request_count>1)
						$friend_label = wfMsg('friend_text');
					else
						$friend_label = wfMsg('plural_friends');
				}
				if ($foe_request_count)
				{
					if ($foe_request_count>1)
						$foe_label = wfMsg('foe_text');
					else
						$foe_label = wfMsg('plural_foes');
				}

				$the_label = $friend_label . ( ($foe_label && $friend_label) ? wfMsg('and') : "" ) . $foe_label;
				$plural = (($friend_request_count + $foe_request_count > 2)? wfMsg('request_text') : wfMsg('plural_request'));
				
				$output .= $wgOut->setPagetitle( wfMsg('your_with_two_params', $the_label, $plural) );
				$requests = $rel->getRequestList(0); 
				if ($requests) 
				{
					$loop = 0;
					foreach ($requests as $request) 
					{
						$loop++;
						$user_from =  Title::makeTitle( NS_USER  , $request["user_name_from"]  );
						$avatar = new WikiaAvatar($request["user_id_from"],"l");
						$avatar_img = $avatar->getAvatarImageTag("l");
						$class = (count($requests) == $loop) ? "relationship-request" : "relationship-request-border";
						$output .= "<div class=\"{$class}\">\n";
						$output .= "<span class=\"relationship-request-image\">{$avatar_img}</span>\n";
						$output .= "<span class=\"relationship-request-info\">\n";
						$output .= "<p class=\"relationship-request-title\">".wfMsg('request_new_relationship', "<a href=\"/index.php?title=User:{$request["user_name_from"]}\">{$request["user_name_from"]}</a>", $request["type"])."</p>\n";
						if ($request["message"])
						{
							$output .= "<p class=\"relationship-request-message\"><img src=\"".$wgImageCommonPath."/quoteIcon.png\" border=\"0\" alt=\"quotes\"> " . htmlspecialchars($request["message"])." <img src=\"".$wgImageCommonPath."/endQuoteIcon.png\" border=\"0\" alt=\"quotes\"></p>";
						}
						$output .= "<p class=\"relationship-request-message\" style=\"font-weight:normal;\">".wfMsg('accept_relationship', htmlspecialchars($request["user_name_from"]), htmlspecialchars($request["type"]))."</p>";
						$output .= "</span>\n";
						$output .= "<div class=\"cleared\"></div>\n";
						$output .= "<div class=\"relationship-request-buttons\" id=\"request_action_{$request["id"]}\">\n";
						$output .= "<input type=\"button\" value=\"".wfMsg('accept_btn')."\" onclick=\"javascript:requestResponse(1,{$request["id"]})\">
						<input type=\"button\" value=\"".wfMsg('reject_btn')."\" onclick=\"javascript:requestResponse(-1,{$request["id"]})\"></div>\n";
						$output .= "</div>\n";
						$output .= "<div class=\"cleared\"></div>";
					}
				} 
				else 
				{
					$output .= $wgOut->setPagetitle( wfMsg('no_new_friends_request') );
					$output = "<p class=\"user-profile-message\">".wfMsg('no_friends_foes')."  <a href=\"/index.php?title=Special:InviteContacts\">".wfMsg('invitethem')."</a> </p>";
				}
				$wgOut->addHTML($output);				
			}
		}
	}

	SpecialPage::addPage( new ViewRelationshipRequests );
	global $wgMessageCache,$wgOut;
	//$wgMessageCache->addMessage( 'viewrelationship', 'view relationship requests' );
}

?>
