<?php

$wgExtensionFunctions[] = 'wfSpecialInviteContacts';

function wfSpecialInviteContacts(){

	global $wgUser,$IP;

	include_once("$IP/includes/SpecialPage.php");

	#---
	class InviteContacts extends UnlistedSpecialPage {

		#---
		function __construct() {
			global $wgMessageCache;

			UnlistedSpecialPage::UnlistedSpecialPage("InviteContacts");

			require_once ( dirname( __FILE__ ) . '/Invite.i18n.php' );
			foreach( efSpecialInviteContacts() as $lang => $messages ) {
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}

		function execute() {
			global $wgUser, $wgOut, $wgMessageCache;
			global $wgScriptPath, $wgStyleVersion;

			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if ($wgUser->getID() == 0) {
				$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
				$wgOut->redirect( $login->getLocalURL("returnto=Special:InviteContacts") );
				return false;
			}

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/Invite/css/invite.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			if (count($_POST) && $_SESSION["alreadysubmitted"] == false) {
				#---
				$_SESSION["alreadysubmitted"] = true;

				$html_format = "no";  //IMPORTANT: change this to "yes"  ONLY if you are sending html format email
				$title = Title::makeTitle( NS_USER , $wgUser->getName()  );
				$subject = wfMsg( 'invite_subject', $wgUser->getName() );

				$body = wfMsg( 'invite_body', $_POST['sendersemail'], $wgUser->getName(), $title->getFullURL() );

$message = <<<EOF

$body

EOF;

				$from = "community@wikia.com";
				$sendersemail = $_POST['sendersemail'];

				$confirm = "";
				$loop = 0;
				foreach($_POST['list'] as $to) {
					$loop++;
					$confirm .= "<div class=\"invite-email-sent\">".$loop.". ".$to."</div>";
					if ($html_format == "yes") {
						/* $headers = "From: $from\n";
						$headers .= "Reply-To: $from\n";
						$headers .= "Return-Path: $from\n";
						$headers .= "MIME-Version: 1.0\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
						mail($to,$subject,$message,$headers); */
						userMailer( new MailAddress( $to ), new MailAddress( $from ), $subject, $message );
					} else {
						//mail($to, $subject, $message, "From: $from\r\nReply-To:$sendersemail");
						userMailer( new MailAddress( $to ), new MailAddress( $from ), $subject, $message, new MailAddress( $sendersemail ) );
					}
				}

				$wgOut->setPagetitle( "Messages Sent!" );
				$wgOut->addHTML("<p class=\"user-message\">" . wfMsg('emailswentout') ." ". $confirm." </p>");
				$wgOut->addHTML("<div class=\"relationship-request-buttons\">
				  <input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>
				  <input type=\"button\" value=\"".wfMsg('yourprofile')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "'\"/>
				  <input type=\"button\" value=\"".wfMsg('youruserpage')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "'\"/>
				  </div>");
			}
			else
			{
				$_SESSION["alreadysubmitted"] = false;

				$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/Invite/GetContacts.js\"></script>\n");
				$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/getmycontacts/js/ahah.js\"></script>\n");

				$wgOut->setPagetitle( wfMsg('find_friends') );

				// GET NETWORK TO IMPORT FROM
				$get = (!empty($GET) && isset($_GET["domain"])) ? $_GET["domain"] : "";
				if (empty($get)) {
					$script = "mygmail.php";
					$img = "mygmail.gif";
				} else {
					$script = $get.'.php';
					$img = $get.'.gif';
				}

				$useCSV = false;
				if( $get=="myoutlook" || $get=="myexpress" || $get=="mythunderbird" )
				{
					$useCSV = true;
				}

				$formEnc = "";
				if ( $useCSV )
				{
					$formEnc = " enctype=\"multipart/form-data\" ";
				}

				$wgOut->addHTML($this->_content($useCSV, $script, $formEnc));
			}
		}

		private function _content($useCSV, $script, $formEnc) {
			global $wgMessageCache, $wgServer, $wgLanguageCode, $wgUser;
			#---
			$out = "<div class=\"invite-links\">
				<span class=\"profile-on\">
					<a href=\"/index.php?title=Special:InviteContacts\">".wfMsg('find_friends')."</a></span> - <a href=\"/index.php?title=Special:InviteEmail\">".wfMsg('invite_friends')."</a>";

			if ( $wgUser->isLoggedIn() )
			{
				$out .= " - <a href=\"".Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL()."\" /><strong>" . wfMsg('yourprofile') . "</strong></a>";
				$out .= " - <a href=\"".Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL()."\" /><strong>" . wfMsg('youruserpage') . "</strong></a>";
			}

			$out .= "</span>
			</div>
			<div class=\"invite-message\">".wfMsg('getcontactsmaintitle')."</div>
			<div id=\"target\">";

			if ( $useCSV != true ) {
				$out .= "<div class=\"invite-left\">
					<div class=\"invite-icons\">
					<img src=\"/extensions/wikia/getmycontacts/images/myyahoo.gif\" border=\"0\">
					<img src=\"/extensions/wikia/getmycontacts/images/mygmail.gif\" border=\"0\">
					<img src=\"/extensions/wikia/getmycontacts/images/myhotmail.gif\" border=\"0\">
					<img src=\"/extensions/wikia/getmycontacts/images/myaol.gif\" border=\"0\">
					</div>
					<div class=\"invite-form\">
					<form name=emailform action=\"javascript:submit('".$wgServer."/extensions/wikia/getmycontacts/{$script}', 'POST');\" {$formEnc}  method=post onSubmit=\"return getMailAccount('".$wgServer."', this.username.value, '".$wgLanguageCode."');\">
						<p class=\"invite-form-title\">".wfMsg('emailaddress')."</p>
						<p class=\"invite-form-input\"><input type=\"text\" name=\"username\" size=\"34\"></p>
						<div class=\"cleared\"></div>
						<p class=\"invite-form-title\">".wfMsg('contact_passwd')."</p>
						<p class=\"invite-form-input\"><input type=\"password\" name=\"password\" size=\"34\"></p>
						<div class=\"cleared\"></div>
						<p><input type=\"submit\" value=\"".wfMsg('find_friends')."\"></p>
					</form>
					</div>
				</div>";
/*				$out .= "<div class=\"invite-right\">
				<h1>".wfMsg('donthaveemail')."</h1>
				<p  align=\"center\">
					<a href=\"/index.php?title=Special:InviteContactsCSV\"><img src=\"/extensions/wikia/getmycontacts/images/myoutlook.gif\" border=\"0\"></a>
					<a href=\"/index.php?title=Special:InviteContactsCSV\"><img src=\"/extensions/wikia/getmycontacts/images/mythunderbird.gif\" border=\"0\"></a>
				</p>
				<div class=\"cleared\"></div>
				<p  align=\"center\"><input type=\"button\" value=\"".wfMsg('uploadyourcontacts')."\" onclick=\"window.location='/index.php?title=Special:InviteContactsCSV'\"/></p>
				</div>
				<div class=\"cleared\"></div>
				";*/
			} 
/*			else {
				$out .= "<div class=\"invite-left\">";
				$out .= "<div class=\"invite-icons\">
					<img src=\"/extensions/wikia/getmycontacts/images/myoutlook.gif\" border=\"0\">
					<img src=\"/extensions/wikia/getmycontacts/images/mythunderbird.gif\" border=\"0\">
				</div>
				<div class=\"invite-form\">
				<form name=emailform action=\"javascript:submit('".$wgServer."/extensions/wikia/getmycontacts/{$script}', 'POST');\" {$formEnc}  method=post>
				<p>".wfMsg('csvfilelimit')."</p>
				<p class=\"invite-form-title\">".wfMsg('selectcsvfile')."</p>
				<p class=\"invite-form-input\"><input name=\"ufile\" type=\"file\" id=\"ufile\" size=\"28\" /></p>
				<p><input type=\"submit\" value=\"".wfMsg('uploadyourcontacts')."\"></p>
				</div>";
				$out .= "</div>";
				$out .= "<div class=\"invite-right\">";
				$out .= "<h1>".wfMsg('queshavewebmail')."</h1>";
				$out .= "<p class=\"invite-right-image\">
					<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/myyahoo.gif\" border=\"0\"></a>
					<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/mygmail.gif\" border=\"0\"></a>
				</p>
				<p class=\"invite-right-image\">
					<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/myhotmail.gif\" border=\"0\"></a>
					<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/myaol.gif\" border=\"0\"></a>
				</p>";
				$out .= "<div class=\"cleared\"></div>";
				$out .= "<p  align=\"center\"><input type=\"button\" value=\"".wfMsg('find_friends')."\" onclick=\"window.location='/index.php?title=Special:InviteContacts'\"/></p>";
				$out .= "</div>";
				$out .= "<div class=\"cleared\"></div>";
			}*/

            $out .= "</div></form>";

            return $out;
		}
	}

	SpecialPage::addPage( new InviteContacts );
	global $wgMessageCache,$wgOut;
}

?>
