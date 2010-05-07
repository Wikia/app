<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */
class ContactForm extends SpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err;

	function  __construct() {
		parent::__construct( "Contact" , '' /*restriction*/);
		wfLoadExtensionMessages("ContactForm");
	}

	function execute() {
		global $wgLang, $wgAllowRealName, $wgRequest;

		$this->mName = $wgRequest->getText( 'wpName' );
		$this->mRealName = $wgRequest->getText( 'wpContactRealName' );
		$this->mWhichWiki = $wgRequest->getText( 'wpContactWikiName' );
		$this->mProblem = $wgRequest->getText( 'wpContactProblem' );
		$this->mProblemDesc = $wgRequest->getText( 'wpContactProblemDesc' );
		$this->mPosted = $wgRequest->wasPosted();
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mEmail = $wgRequest->getText( 'wpEmail' );
		$this->mBrowser = $wgRequest->getText( 'wpBrowser' );
		$this->mCCme = $wgRequest->getCheck( 'wgCC' );

		if( $this->mPosted && ('submit' == $this->mAction ) ) {
			#malformed email?
			if (!User::isValidEmailAddr($this->mEmail)) {
				$this->err .= "\n" . wfMsg('contactpage-email-failed');
			}

			#empty message text?
			if( empty($this->err) && empty($this->mProblemDesc) ) {
				$this->err .= "\n" . wfMsg('contactnomessage');
			}

			#no errors?
			if( empty($this->err) )
			{
				#send email
				$this->processCreation();
				#stop here
				return;
			}

			#if there were any ->err s, they will be displayed in ContactForm
		}
		
		$this->mainContactForm();
	}
	/**
	 * @access private
	 */
	function processCreation() {
		global $wgUser, $wgOut, $wgCityId;

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		//build common top of both emails
		$m_shared = '';
		$m_shared .= ( !empty($this->mRealName) )?( $this->mRealName ): ( (( !empty($this->mName) )?( $this->mName ): ('--')) );
		$m_shared .= " ({$this->mEmail})";
		$m_shared .= " ". (( !empty($this->mName) ) ? $this->mWhichWiki . "/wiki/User:" . urlencode(str_replace(" ", "_", $this->mName)) : $this->mWhichWiki) . "\n";
		$m_shared .= ( ( !empty($this->mProblem) ) ? "contacted Wikia about {$this->mProblem}.\n" : '' ). "";

		
		//start wikia debug info, sent only to the internal email, not cc'd
		$info = array();
		$info[] = '' . $this->mBrowser;
		$info[] = "\n" . 'IP:' . wfGetIP();
		$info[] = 'wkID: ' . $wgCityId;
		
		global $wgAdminSkin, $wgDefaultSkin, $wgDefaultTheme;
		$nominalSkin = ( !empty($wgAdminSkin) )?( $wgAdminSkin ):( ( !empty($wgDefaultTheme) )?("{$wgDefaultSkin}-{$wgDefaultTheme}"):($wgDefaultSkin) );
		$info[] = 'Skin: ' . $nominalSkin;

		$uid = $wgUser->getID();
		if( !empty($uid) ) {
			$info[] = 'uID: ' . $uid . " (User:". $wgUser->getName() .")";
		}
		$info = implode("; ", $info) . "\n";
		//end wikia debug data
		
		$m = $m_shared . $info . "\n{$this->mProblemDesc}\n";
		
		if($this->mCCme) {
			$mcc = wfMsg('contactccheader') . "\n\n";
			$mcc .= $m_shared . "\n{$this->mProblemDesc}\n";
		}
		
		$mail_user = new MailAddress($this->mEmail);
		$mail_community = new MailAddress("community@wikia.com");

		$errors = '';

		#to us, from user
		$subject = wfMsg('contactmailsub') . (( !empty($this->mProblem) )? ' - ' . $this->mProblem : '');
		$error = UserMailer::send( $mail_community, $mail_user, $subject, $m, $mail_user, null, 'SpecialContact' );
		if (WikiError::isError($error)) {
			$errors .= "\n" . $error->getMessage();
		}

		#to user, from us (but only if the first one didnt error, dont want to echo the user on an email we didnt get)
		if( empty($errors) && $this->mCCme && $wgUser->getEmailAuthenticationTimestamp() != null ) {
			$error = UserMailer::send( $mail_user, $mail_community, wfMsg('contactmailsubcc'), $mcc, $mail_user, null, 'SpecialContactCC' );
			if (WikiError::isError($error)) {
				$errors .= "\n" . $error->getMessage();
			}
		}

		if ( !empty($errors) ) {
			$wgOut->addHTML("<div class='errorbox' style='float:none;'>" . $errors . "</div><br/>\n");
		}

		/********************************************************/
		#sending done, show message

		$wgOut->addHTML(wfMsg( 'contactsubmitcomplete' ));

		$mp = Title::newMainPage();
		$link = Xml::element('a', array('href'=>$mp->getLocalURL()), $mp->getPrefixedText());
		$wgOut->addHTML('<br/>' . wfMsg( 'returnto', $link ) );

		return;
	}

	/**
	 * @access private
	 */
	function mainContactForm( ) {
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;
		global $wgServer, $wgSitename;

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		if( $wgUser->isAnon() == false ) {
			//user mode

			//we have user data, so use it, overriding any passed in from url
			$this->mName = $wgUser->getName();
			$this->mRealName = $wgUser->getRealName();
			$this->mEmail = $wgUser->getEmail();

			# since logged in, assume...
			$user_readonly = true; //no box, just print
			$name_readonly = true;
			$mail_readonly = true;

			if( empty($this->mRealName) ) {
				#user has blank 'name', so unlock
				#(i disagree, but confuses users otherwise)
				$name_readonly = false;
			}

			if( empty($this->mEmail) ) {
				#user has blank email, so unlock
				$mail_readonly = false;
			}
		}
		else
		{
			global $wgCookiePrefix;

			#try to pull a username using an ancient method
			#-if this works, will fill name, but not cause lock
			if( !empty($_COOKIE[$wgCookiePrefix.'UserName']) ) {
				$this->mName = @$_COOKIE[$wgCookiePrefix.'UserName'];
			}

			#anon mode, no locks
			$user_readonly = false;
			$name_readonly = false;
			$mail_readonly = false;
		}

		$q = 'action=submit';

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' );
		$action = $titleObj->escapeLocalUrl( $q );

		$encName = htmlspecialchars( $this->mName );
		$encEmail = htmlspecialchars( $this->mEmail );
		$encRealName = htmlspecialchars( $this->mRealName );
		$encProblem = htmlspecialchars( $this->mProblem );
		$encProblemDesc = htmlspecialchars( $this->mProblemDesc );

		if ( !empty($this->err) ) {
			$wgOut->addHTML("<div class='errorbox' style='float:none;'>" . $this->err . "</div>\n");
		}

		// add intro text
		$wgOut->addWikiText( wfMsg( 'contactintro' ) );

		$tabindex = 1;
		//setup form and javascript
		$wgOut->addHTML( "<hr/>
		<form name=\"contactform\" id=\"contactform\" method=\"post\" action=\"{$action}\">\n" );

		global $wgSpecialContactUnlockURL;
		$wgOut->addHTML( "
			<table border='0'>
				<tr>
					<td align='right'>" . wfMsg( 'contactwikiname' ) . ":</td>
					<td align='left'>" . ( ( !empty($wgSpecialContactUnlockURL) )
					?("<input tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactWikiName\" value=\"{$wgServer}\" size='40' />")
					:("{$wgServer} <input type=\"hidden\" name=\"wpContactWikiName\" value=\"{$wgServer}\" />")
					) . "</td>
				</tr>\n" );

		
		$wgOut->addHTML( "
				<tr>
					<td align='right'>". wfMsg( 'contactusername' ) .":</td>
					<td align='left'>" . ( ( empty($user_readonly) )
					?("<input tabindex='" . ($tabindex++) . "' type='text' name=\"wpName\" value=\"{$encName}\" size='40' />")
					:("{$encName} <input type=\"hidden\" name=\"wpName\" value=\"{$encName}\" />".
					" &nbsp;<span style=\"\" id='contact-not-me'><i><a href=\"/index.php?title=Special:UserLogout&amp;returnto=Special:Contact\">(". wfMsg( 'contactnotyou', $this->mName ) .")</a></i></span>")
					) . "</td>
				</tr>" );

		$wgOut->addHTML( "
				<tr>
					<td align='right'>". wfMsg( 'contactrealname' ) .":</td>
					<td align='left'>" . ( ( empty($name_readonly) )
					?("<input tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactRealName\" value=\"{$encRealName}\" size='40' />")
					:("{$encRealName} <input type=\"hidden\" name=\"wpContactRealName\" value=\"{$encRealName}\" />")
					) . "</td>
				</tr>" );

		$wgOut->addHTML( "
				<tr>
					<td align='right'>". wfMsg( 'contactyourmail' ) .":</td>
					<td align='left'>" . ( ( empty($mail_readonly) )
					?("<input tabindex='" . ($tabindex++) . "' type='text' name=\"wpEmail\" value=\"{$encEmail}\" size='40' />")
					:("{$encEmail} <input type=\"hidden\" name=\"wpEmail\" value=\"{$encEmail}\" />")
					) . "</td>
				</tr>" );

		$wgOut->addHTML( "
				<tr>
					<td align='right'>". wfMsg( 'contactproblem' ) .":</td>
					<td align='left'>".
						"<input tabindex='" . ($tabindex++) . "' type='text' name=\"wpContactProblem\" value=\"{$encProblem}\" size='80' />".
					"</td>
				</tr>" );

		$wgOut->addHTML( "
				<tr>
					<td align='right' valign='top'>".  wfMsg( 'contactproblemdesc' ) . ":</td>
					<td align='left'>".
						"<textarea tabindex='" . ($tabindex++) . "' name=\"wpContactProblemDesc\" rows=\"10\" cols=\"60\">{$encProblemDesc}</textarea>".
					"</td>
				</tr>" );
				
		$wgOut->addHTML( "
				<tr>
					<td></td>
					<td align='left'>".
						"<input tabindex='" . ($tabindex++) . "' type='submit' value=\"". wfMsg( 'contactmail' ) ."\" />".
					"</td>
				</tr>\n" );

		if( !$wgUser->isAnon() && $wgUser->getEmail() != '') {
			//is user, has email, but is verified?
			if( $wgUser->getEmailAuthenticationTimestamp() != null ) {
				//yes!
				$wgOut->addHtml("
				<tr>
					<td></td>
					<td align='left'>".
						"<input tabindex='" . ($tabindex++) . "' type='checkbox' name=\"wgCC\" value=\"1\" />" . wfMsg('contactccme') .
					"</td>
				</tr>\n");
			}
			else
			{
				//not
				$wgOut->addHtml("
				<tr>
					<td></td>
					<td align='left'>".
						"<s><i>" . wfMsg('contactccme') . "</i></s><br/> ". wfMsg('contactccdisabled') .
					"</td>
				</tr>\n");
			}
		}

		#neat trick here: we prefil the browser info in from PHP var, with note about no JS.
		$wgOut->addHtml("
			</table>
			<input type=\"hidden\" id=\"wpBrowser\" name=\"wpBrowser\" value=\"{$_SERVER['HTTP_USER_AGENT']}; JavaScript: disabled;\" />
		</form>\n");

		#then, inside a javascript block, we set it again (but browser comes from same php var), with flash version at the end
		#result: when JS=off, we still get browser, and no js message.
		#when JS=on, we get browser+flash ver. win win.
		$wgOut->addHtml("\n<script type=\"text/javascript\">/*<![CDATA[*/
				//user agent
				info = 'Browser: {$_SERVER['HTTP_USER_AGENT']}';
				//flash
				flashVer = parseInt(YAHOO.Tools.checkFlash()) ? YAHOO.Tools.checkFlash() : 'none';
				info += '; Flash: ' + flashVer;

				document.getElementById('wpBrowser').value = info;
			/*]]>*/</script>\n");
			
		return;
	}

}

