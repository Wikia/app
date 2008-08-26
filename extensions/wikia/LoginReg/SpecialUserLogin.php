<?php

$wgExtensionFunctions[] = 'wfSpecialLogin';

function wfSpecialLogin(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class Login extends UnlistedSpecialPage {
	
		function Login(){
			UnlistedSpecialPage::UnlistedSpecialPage("Login");
		}
	
		function execute(){
			
			global $IP, $wgUser, $wgOut, $wgRequest, $wgSitename, $wgMessageCache, $wgFriendingEnabled; 
			
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/LoginReg/LoginReg.css?{$wgStyleVersion}\"/>\n");

			//language messages
			require_once ( "$IP/extensions/wikia/LoginReg/LoginReg.i18n.php" );
			foreach( efWikiaLoginReg() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
	
			//safe titles
			$user_register_link = Title::makeTitle(NS_SPECIAL, "UserRegister");
			$user_login_link = Title::makeTitle(NS_SPECIAL,"UserLogin");
	
			$wgOut->setPageTitle(wfMsgExt('l-title', 'parsemag'));
			
			if($wgUser->isLoggedIn()){
				$wgOut->addHTML(wfMsg('l-title-logged-in'));
				return true;	
			}
			
			$output .= "<div class=\"lr-left\">
				<div class=\"lr-top-link\"><span class=\"link-highlight\">".wfMsg('l-no-account', $user_register_link->escapeFullURL())."</span></div>
				<form name=\"userlogin\" id=\"userlogin\" method=\"post\" action=\"".$user_login_link->escapeFullURL('action=submitlogin'.$from_qs . $referral_qs)."\">
					<p>	
						<label for=\"wpName\">".wfMsg('l-username')."</label>
					</p>
					<input tabindex=\"1\" class=\"lr-input\" type=\"text\" name=\"wpName\" id=\"wpName\" value=\"\"/>
					<p>
						<label for=\"wpPassword\">".wfMsg('l-password')."</label>
					</p>
					<input tabindex=\"2\" class=\"lr-input\" type=\"password\" name=\"wpPassword\" id=\"wpPassword\" value=\"\"/>
		 			<div class=\"remember-me\">
						<input tabindex=\"3\" type=\"checkbox\" name=\"wpRemember\" value=\"1\" id=\"wpRemember\"/>
	       				".wfMsg('l-remember-me')."
					</div>
					<div>
						<input tabindex=\"4\" class=\"site-button\" type=\"submit\" name=\"wpLoginattempt\" id=\"wpLoginattempt\" value=\"".wfMsg('l-login-button')."\"/>
						<input type=\"submit\" class=\"site-button\" name=\"wpMailmypassword\" id=\"wpMailmypassword\" tabindex=\"5\" value=\"".wfMsg('l-password-button')."\" />
						<input type=\"hidden\" name=\"title_from\" value=\"".$_SERVER['HTTP_REFERER']."\"/>
					</div>
				</form>
			</div>";
			
			$output .= "<div class=\"lr-right\">
				".wfMsgExt("user_Register_Text","parse")."
			</div>
			<div class=\"cleared\"></div>";
			
			$wgOut->addHTML($output);
			
		}
	
	}
	
	SpecialPage::addPage( new Login );
}

?>