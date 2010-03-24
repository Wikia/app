<?php

$wgExtensionFunctions[] = 'wfSpecialUserRegister';

function wfSpecialUserRegister(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class UserRegister extends UnlistedSpecialPage {
	
		function UserRegister(){
			parent::__construct("UserRegister");
		}
	
		function execute(){
			
			global $IP, $wgUser, $wgOut, $wgRequest, $wgSitename, $wgFriendingEnabled, $wgMessageCache, $wgStyleVersion; 
			
			$register =  Title::makeTitle( NS_SPECIAL  , "Userlogin"  );
			$wgOut->redirect( $register->getFullURL( "type=signup" ) );
	
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/LoginReg/LoginReg.css?{$wgStyleVersion}\"/>\n");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/LoginReg/UserRegister.js?{$wgStyleVersion}\"></script>\n");
			
			if( session_id() == '' ) {
				wfSetupSession();
			}
			
			//language messages
			require_once ( "$IP/extensions/wikia/LoginReg/LoginReg.i18n.php" );
			foreach( efWikiaLoginReg() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
			
			$output = "";

			$output .= "<script type=\"text/javascript\">
				 var _AGE_ALERT = \"" . wfMsg("r-age-alert", $wgSitename ) . "\";
				 var _IS_TAKEN = \"" . wfMsg("r-is-taken") . "\";
				 var _IS_AVAILABLE = \"" . wfMsg("r-is-available") . "\";
				 var _NOUSERNAME_ALERT = \"" . wfMsg("noname") . "\";
				 var _PASSWORDMATCH_ALERT = \"" . wfMsg("badretype") . "\"; 
				 var _USERNAME_EXISTS = \"" . wfMsg("userexists") . "\";
				 var _CAPTCHA_FAIL = \"" . wfMsg("captcha-createaccount-fail") . "\";
				 </script>";
			
			$from = $wgRequest->getVal("from");
			if($from)$from_qs = "&from={$from}";
			
			$referral = $wgRequest->getVal("referral");
			if($referral)$referral_qs = "&referral={$referral}";
			
			$referral_title = Title::makeTitle(NS_USER,$referral);
			$user_id_referral = User::idFromName($referral);
	
			if ($user_id_referral) {
				$wgOut->setPageTitle(wfMsgExt("r-title-referral", "parsemag", $referral));
			} else {
				$wgOut->setPageTitle(wfMsg("r-title"));
			}
			
			//referring user is Valid, and the current user is logged in, so we need to make an
			//automatic friend request, and redirect to the View Friend requests page
			
			if ($user_id_referral!=0 && $user_id_referral!=$wgUser->getID() && $wgUser->isLoggedIn()) {
				
				if ($wgFriendingEnabled) {
					
					require_once("$IP/extensions/wikia/UserRelationship_NY/UserRelationshipClass.php");
					
					//need to create request first
					$rel = new UserRelationship($referral_title->getText());
					
					//check if not already friend/foe and there isnt already a request
					if ($rel->getUserRelationshipByID($user_id_referral,$wgUser->getID())==false) {
						if ($rel->userHasRequestByID($wgUser->getID(),$user_id_referral)  == false) {
							$request_id = $rel->addRelationshipRequest($wgUser->getName(),1,"",false);
						}
						//redirect to request page
						$view_requests_title =  Title::makeTitle(NS_SPECIAL,"ViewRelationshipRequests");
						$to = $view_requests_title->getFullURL();
						
					} else {
						$wgOut->addHTML(wfMsg("r-request-relationship-title", $referral_title->escapeFullURL(), $referral_title->getText()));
						return true;	
					}
					$wgOut->redirect($to);
				
				}
				
			}
			
			if ($wgUser->isLoggedIn()) {
				$wgOut->addHTML(wfMsg("r-title-registered"));
				return true;	
			}
			
			//safe titles
			$login_link = Title::makeTitle(NS_SPECIAL, "Userlogin");
			$user_login_link = Title::makeTitle(NS_SPECIAL, "Userlogin");
			
			$output .= "<div class=\"lr-left\">
			<div class=\"lr-top-link\">
				<span class=\"link-highlight\">".wfMsg("r-already-account", $login_link->escapeFullURL())."</span>
			</div>
			<form name=\"userlogin\" id=\"userlogin\" method=\"post\" action=\"".$user_login_link->escapeFullURL('action=submitlogin&type=signup'.$from_qs.$referral_qs)."\">
			<p>
				<label for=\"first_name\">".wfMsg("r-first-name")."</label>
			</p>
			<input tabindex=\"1\" class=\"lr-input\" type=\"text\" name=\"first_name\" id=\"first_name\" value=\"\" />
			<p>
				<label for=\"last_name\">".wfMsg("r-last-name")."</label>
			</p>
			<input tabindex=\"2\" class=\"lr-input\" type=\"text\" name=\"last_name\" id=\"last_name\" value=\"\" />
			<input type=\"hidden\" name=\"wpRealName\"/>
			<p>
				<label for=\"wpName\">".wfMsg("r-username")."</label>
			</p>
			<input tabindex=\"3\" class=\"lr-input\" type=\"text\" name=\"wpName\" id=\"wpName\" value=\"\" />
			<a href=\"javascript:user_name_check()\">" . wfMsg("r-check-availability") . "</a>
			<span id=\"username_status\"></span>
			<p>
				<label for=\"wpEmail\">".wfMsg("r-email")."</label>
			</p>
			<input tabindex=\"4\" class=\"lr-input\" type=\"text\" name=\"wpEmail\" id=\"wpEmail\" value=\"\" />
			<p>
				<label for=\"wpPassword\">".wfMsg("r-password")."</label>
			</p>
			<input tabindex=\"5\" class=\"lr-input\" type=\"password\" name=\"wpPassword\" id=\"wpPassword\" value=\"\" />
			<p>
				<label for=\"wpPassword\">".wfMsg("r-retype-password")."</label>
			</p>
			<input tabindex=\"6\" class=\"lr-input\" type=\"password\" name=\"wpRetype\" id=\"wpRetype\" value=\"\" />
			<p>
				<input tabindex=\"7\" type=\"checkbox\" name=\"wpAge\" value=\"1\" id=\"wpAge\"/>
	       			<label for=\"wpage\">".wfMsg("r-age-check" )."</label>
			</p>";
			if($wgSitename=="ArmchairGM") {
				$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/DoubleCombo/DoubleCombo.js?{$wgStyleVersion}\"></script>\n");
				
				$output .= "<div class=\"favorite-container\">
					<p>
						Select your Favorite Team or Sport
					</p>
					<div id=\"fav_1\" class=\"favorite-input\" >
						<span class=\"favorite-input-title\">Sport</span>
						<select name=\"sport_1\" id=\"sport_1\" onchange=\"document.cookie='sports_sid='+this.value;update_combo('team_1','index.php?action=ajax&rs=wfGetSportTeams&rsargs[]='+this.value)\" />
						<option value=\"0\">-</option>";
			
						//Build Sport Option HTML
						$sports = SportsTeams::getSports();
						foreach ($sports as $sport) {
							$output .= "<option value=\"{$sport["id"]}\" "  . (($sport["id"] == $selected_sport_id)?"selected":"") . " >{$sport["name"]}</option>\n";
						}
						$output .= "</select>
					</div>
					<div class=\"favorite-input\"> 
						<span class=\"favorite-input-title\">Team</span>
						<select name=\"team_1\" id=\"team_1\" onchange=\"document.cookie='sports_tid='+this.value;\" />
						<option value=\"0\">-</option>
						</select>
					</div>
					<p>
						".wfMsg('r-thought')."
					</p>
					<input tabindex=\"6\" class=\"lr-input\" type=\"text\" id=\"thought\" name=\"thought\" onchange=\"document.cookie='thought='+this.value;\"  />
				</div>";
				
			}
		 
				global $wgOut, $wgCaptchaTriggers;
				//if($wgCaptchaTriggers['createaccount'] == true){
					$f = new FancyCaptcha();
					$output .= ( "<div class='captcha'>" .
						$wgOut->parse( $f->getMessage( 'createaccount' ) ) .
						$f->getForm() .
				"</div>\n" );
			//}
			 
				$output .= "<div class=\"remember-me\">
					<input tabindex=\"7\" type=\"checkbox\" name=\"wpRemember\" value=\"1\" id=\"wpRemember\"/>
	       				remember me
				</div>
				<input type=\"hidden\" name=\"wpCreateaccount\" value=\"1\"/>
				<input tabindex=\"8\" class=\"site-button\" type=\"button\" onclick=\"create_validate()\"  name=\"register\" id=\"register\" value=\"".wfMsg("r-sign-up")."\" class=\"registersubmit\" />
			</form>
			</div>";
			
			$output .= "<div class=\"lr-right\">"
				.wfMsgExt("User_Register_Text","parse").
			"</div>
			<div class=\"cleared\"></div>";
			
			$wgOut->addHTML($output);
			
		}
	
	}
	
	SpecialPage::addPage( new UserRegister );
}

?>
