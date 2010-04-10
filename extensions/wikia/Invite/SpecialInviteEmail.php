<?php

$wgExtensionFunctions[] = 'wfSpecialInviteEmail';
$wgExtensionMessagesFiles['SpecialInviteContacts'] = dirname(__FILE__).'/SpecialInviteContacts.i18n.php';

function wfSpecialInviteEmail(){
	global $IP;
	include_once("includes/SpecialPage.php");
	if (!class_exists( 'UserEmailTrack' )) {
		require_once( "$IP/extensions/wikia/UserStats/UserStatsClass.php" );
 	}

	wfLoadExtensionMessages('SpecialInviteContacts');

class InviteEmail extends UnlistedSpecialPage {

	function InviteEmail(){
		parent::__construct("InviteEmail");
	}
	
	function execute(){
		global $wgUser, $wgOut, $wgRequest;
		global $wgEmailFrom, $wgSitename, $wgStyleVersion;

		# Check blocks
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		global $wgMessageCache;
		$wgMessageCache->addMessages( array("inviteemailanontext" => 'Please $1 to send out invite emails.'), "en" );
		
		if ( $wgUser->isAnon() ) {
			$skin = $wgUser->getSkin();
			$wgOut->setPageTitle( "Not logged in" );
			$llink = $skin->makeKnownLinkObj( SpecialPage::getTitleFor( 'Userlogin' ), wfMsgHtml( 'loginreqlink' ) );
			$wgOut->addWikiMsg( 'inviteemailanontext', $llink );
			return;
		}

		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/Invite/invite.css?{$wgStyleVersion}\"/>\n");
		
		if($wgEmailFrom) {
			$this->from = $wgEmailFrom;
		}else{
			$this->from = wfMsgForContent( 'invite_email_from');
		}
		
		if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false){
			$_SESSION["alreadysubmitted"] = true;
			$message = $wgRequest->getVal("body");
			$subject = $wgRequest->getVal("subject");
			$addresses = explode(",",$wgRequest->getVal("email_to"));
			foreach($addresses as $address){
				$to = trim($address);
				if ( User::isValidEmailAddr( $to ) ) {
					UserMailer::send( new MailAddress( $to ), $this->from, $subject, $message, null, null, 'InviteEmail');
				}
			}
			$mail = new UserEmailTrack($wgUser->getID(),$wgUser->getName());
			$mail->track_email($wgRequest->getVal("track"),count($addresses), $wgRequest->getVal("page_title") );
			
			$wgOut->setPagetitle( wfMsgForContent( 'invite_sent') );
			
			$out = "";
			
			if ( $wgUser->isLoggedIn() ) {
				$out .= "<div class=\"invite-links\">
					<a href=\"" . $wgUser->getUserPage()->escapeFullUrl() . "\">" . wfMsgForContent( 'invite_back_to_userpage' ) ."</a>
				</div>";	
			}
			if($wgSitename=="ArmchairGM"){
				$out .= wfMsgForContent( 'invite_sent_thanks', $wgSitename );
			}else{
				$out .= wfMsgForContent( 'invite_sent_thanks', 'Wikia' );
			}
			$out .= "<p>";
				$out .= "<input type=\"button\" class=\"invite-form-button\" value=\"" . wfMsgForContent( 'invite_more_friends' ) ."\" onclick=\"window.location='" . Title::makeTitle(NS_SPECIAL,"InviteEmail")->escapeFullURL() . "'\"/> ";
			$out .= "</p>";
			
			$wgOut->addHTML($out);
		}else{
			$_SESSION["alreadysubmitted"] = false;
			$wgOut->addHTML($this->displayForm());
		}
	}	
	
	function getInviteEmailContent($type){
		global $wgUser;
		$title = Title::makeTitle( NS_USER , $wgUser->getName()  );		
		$user_label = $wgUser->getRealName();
		if(!trim($user_label))$user_label = $wgUser->getName();
				
		switch ($type) {
			case "rate":
				$this->track = 6;
				$rate_title = Title::makeTitle( NS_MAIN , $this->page  );
				$email["subject"] = wfMsg( 'invite_rate_subject',
							$user_label,
							$rate_title->getText()
							);
				$email["body"] = wfMsg( 'invite_rate_body',
							$user_label,
							$user_label,
							$title->getFullURL(),
							$rate_title->getText(),
							$rate_title->getFullURL()
							);	
				break;
			case "edit":
				$this->track = 5;
				$rate_title = Title::makeTitle( NS_MAIN , $this->page  );
				$email["subject"] = wfMsg( 'invite_edit_subject',
							$user_label,
							$rate_title->getText()
							);
				$email["body"] = wfMsg( 'invite_edit_body',
							$user_label,
							$user_label,
							$title->getFullURL(),
							$rate_title->getText(),
							$rate_title->getFullURL()
							);	
				break;
			case "view":
				$this->track = 4;
				$rate_title = Title::makeTitle( NS_MAIN , $this->page  );
				$email["subject"] = wfMsg( 'invite_view_subject',
							$user_label,
							$rate_title->getText()
							);
				$email["body"] = wfMsg( 'invite_view_body',
							$user_label,
							$user_label,
							$title->getFullURL(),
							$rate_title->getText(),
							$rate_title->getFullURL()
							);	
				break;
			default:
				$this->track = 3;
				$register =  Title::makeTitle( NS_SPECIAL  , "Signup"  );
				$user_title = Title::makeTitle( NS_USER , $wgUser->getName()  );
				$email["subject"] = wfMsgExt( 'invite_subject', "parsemag", 
							$user_label
							);
				
				$email["body"] = wfMsgExt( 'invite_body', "parsemag", 
							$user_label,
							$user_label,
							$title->getFullURL(),
							$register->getFullURL()
							);
				break;
		}
		return $email;
	}
	
	function displayForm(){
		global $wgUser, $wgOut, $wgRequest, $wgSitename;
		$wgOut->setPagetitle( wfMsgForContent( 'invite_your_friends' ) );
			
		
		$this->email_type =  $wgRequest->getVal('email_type');
		$this->page =  $wgRequest->getVal('page');
		
		$email = $this->getInviteEmailContent($this->email_type);
		$skip = "";
				
		$out = "";
		/*
		$out .= "<div class=\"invite-links\">
				<a href=\"index.php?title=Special:InviteContacts\">Find Your Friends</a>
				- <span class=\"profile-on\"><a href=\"index.php?title=Special:InviteEmail\">Invite Your Friends</a></span>
			</div>";
		*/
		//$out .= "<div class=\"invite-links\"><a href=\"index.php?title=Special:InviteContacts\">< Back to Invite</a></div>";
		
		if($wgRequest->getVal("from") == "register"){
			$out .= "<div style=\"margin-top:10px;\"><a href=\"" . $wgUser->getUserPage()->getFullURL() . "\" style=\"font-size:10px;\">" . wfMsgForContent( 'invite_skip_step' ) . "</a></div>";
		}
				
		//$out .= "<p class=\"invite-message\">ArmchairGM is more fun with your friends.  Invite your friends to join ArmchairGM by simply entering email addresses and an invitiation message and clicking \"Send Email\".</p>";
		$out .= "<p class=\"invite-message\">" . wfMsgForContent( 'invite_message', $wgSitename) ."</p>
			{$skip}
			<form name=\"email\" action=\"\" method=\"post\" style=\"margin:0px\">
			<input type=\"hidden\" value=\"{$this->track}\" name=\"track\">
			
			<div class=\"invite-form-enter-email\">
				<p class=\"invite-email-title\">" . wfMsgForContent( 'invite_enter_emails' ) . "</p>
				<p class=\"invite-email-submessage\">" . wfMsgForContent( 'invite_comma_separated' ) . "</p>
				<p>
					<textarea name=\"email_to\" id=\"email_to\" rows=\"15\" cols=\"42s\"></textarea>
				</p>
			</div>
			<div class=\"invite-email-content\">
				<p class=\"invite-email-title\">" . wfMsgForContent( 'invite_customize_email' ) . "</p>
				<p class=\"email-field\">" . wfMsgForContent( 'invite_customize_subject' ) . "</p>
				<p class=\"email-field\"><input type=\"text\" name=\"subject\" id=\"subject\" value=\"{$email["subject"]}\" size=\"40\"></p>
				<p class=\"email-field\">" . wfMsgForContent( 'invite_customize_body' ) . "</p>
				<p class=\"email-field\"><textarea name=\"body\" id=\"body\" rows=\"15\" cols=\"45\" wrap=\"hard\">{$email["body"]}</textarea></p>
				<div class=\"email-buttons\"><input type=\"button\" class=\"site-button\" onclick=\"document.email.submit()\" value=\"" . wfMsgForContent( 'invite_customize_send' ) . "\"></div>
				
			</div>
			<div class=\"cleared\"></div>
			<input type=\"hidden\" value=\"{$this->page}\" name=\"page_title\">
		</form>	";
		return $out;
	}

}

 SpecialPage::addPage( new InviteEmail );
}
