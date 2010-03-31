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
#		$this->mCookieCheck = $wgRequest->getVal( 'wpCookieCheck' );
		$this->mPosted = $wgRequest->wasPosted();
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mEmail = $wgRequest->getText( 'wpEmail' );
		$this->mBrowser = $wgRequest->getText( 'wpBrowser' );
		$this->mCCme = $wgRequest->getCheck( 'wgCC' );

		if( $this->mPosted && ('submit' == $this->mAction ) ) {
			if (!User::isValidEmailAddr($this->mEmail)) {
				$this->err .= "\n" . wfMsg('contactpage-email-failed');
			}
		
			//no message text?
			if( empty($this->err) && empty($this->mProblemDesc) ) {
				$this->err .= "\n" . wfMsg('contactnomessage');
			}

			//no errors?
			if( empty($this->err) )
			{
				return $this->processCreation();
			}
		}
		
		$this->mainContactForm();
		return htmlspecialchars($errors);
	}
	/**
	 * @access private
	 */
	function processCreation() {
		global $wgUser, $wgOut, $wgCityId;

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addHTML(wfMsg( 'contactsubmitcomplete' ));

		$mp = Title::newMainPage();
		$link = Xml::element('a', array('href'=>$mp->getLocalURL()), $mp->getPrefixedText());
		$wgOut->addHTML('<br/>' . wfMsg( 'returnto', $link ) );

		//build common top of both emails
		$m_shared = '';
		$m_shared .= $this->mName;
		$m_shared .= " ({$this->mEmail})";
		$m_shared .= " {$this->mWhichWiki}";
		$m_shared .= ( !empty($this->mName) ) ? "/wiki/User:" . urlencode(str_replace(" ", "_", $this->mName)) : '';
		$m_shared .= " contacted Wikia";
		$m_shared .= ( !empty($this->mProblem) ) ? " about {$this->mProblem}" : '';
		$m_shared .= ".\n";

		//wikia debug info
		$info = array();
		$info[] = '' . $this->mBrowser;
		$info[] = 'wkID:' . $wgCityId;
		
		$uid = $wgUser->getID();
		if( !empty($uid) ) {
			$info[] = 'uID:' . $uid;
		}
		$info[] = 'IP:' . wfGetIP();
		$info = implode("; ", $info) . "\n";
		//end wikia debug data
		
		$m = $m_shared . $info . "\n{$this->mProblemDesc}\n";
		
		if($this->mCCme) {
			$mcc = wfMsg('contactccheader') . "\n\n";
			$mcc .= $m_shared . "\n{$this->mProblemDesc}\n";
		}
		
	#	exec("/bin/echo '$m' >> /home/wikicities/contactmails.log");

		$mail_user = new MailAddress($this->mEmail);
		$mail_community = new MailAddress("community@wikia.com");

		$errors = '';

		//to us, from user
		$subject = wfMsg('contactmailsub') . (( !empty($this->mProblem) )? ' - ' . $this->mProblem : '');
		$error = UserMailer::send( $mail_community, $mail_user, $subject, $m, $mail_user, null, 'SpecialContact' );
		if (WikiError::isError($error)) {
			$errors .= "\n" . $error->getMessage();
		}

		//to user, from us
		if( empty($errors) && $this->mCCme && $wgUser->getEmailAuthenticationTimestamp() != null ) {
			$error = UserMailer::send( $mail_user, $mail_community, wfMsg('contactmailsubcc'), $mcc, $mail_user, null, 'SpecialContactCC' );
			if (WikiError::isError($error)) {
				$errors .= "\n" . $error->getMessage();
			}
		}
		
		return htmlspecialchars($errors);
	}

	/**
	 * @access private
	 */
	function mainContactForm( ) {
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;
		global $wgServer, $wgSitename;

		if ( '' == $this->mName ) {
			if ( 0 != $wgUser->getID() ) {
				$this->mName = $wgUser->getName();
			} else {
				$this->mName = @$_COOKIE[$wgDBname.'UserName'];
			}
		}

		if( $wgUser->isAnon() == false ) {
			//user mode

			//we have user data, so use it, overriding any passed in from url
			$this->mRealName = $wgUser->getRealName();
			$this->mEmail = $wgUser->getEmail();

			$user_readonly = 'readonly="readonly" ';
			$autofill_marker = '<span class="autofilled" style="color:blue; cursor: help;" title="'. wfMsg('contactfilledin') .'">+</span>';
		}
		else
		{
			//anon mode
			$user_readonly = ''; //dont lock
			$autofill_marker = ''; //no lock, no marker
		}
		
		$name_readonly = $mail_readonly = $user_readonly;  //mirror
		
		if( empty($this->mEmail) ) {
			//user has blank email, so dont lock it
			$mail_readonly = '';
		}

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$q = 'action=submit';

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' );
		$action = $titleObj->escapeLocalUrl( $q );

		$encName = htmlspecialchars( $this->mName );
		$encEmail = htmlspecialchars( $this->mEmail );
		$encRealName = htmlspecialchars( $this->mRealName );
		$encProblem = htmlspecialchars( $this->mProblem );
		$encProblemDesc = htmlspecialchars( $this->mProblemDesc );

		#$this->err = 'foo';
		if ( !empty($this->err) ) {
			$wgOut->addHTML("<div class='errorbox' style='float:none;'>" . $this->err . "</div>\n");
		}

		// add intro text
		$wgOut->addHTML( wfMsgExt( 'contactintro', array('parse')) );
		
		$ti = 1;
		//setup form and javascript
		$wgOut->addHTML( "
		<form name=\"contactform\" id=\"contactform\" method=\"post\" action=\"{$action}\">
			<input type=\"hidden\" id=\"wpBrowser\" name=\"wpBrowser\" />
			<script type=\"text/javascript\">
				//user agent
				info = 'Browser: ' + YAHOO.Tools.getBrowserEngine().ua;
				//flash
				flashVer = parseInt(YAHOO.Tools.checkFlash()) ? YAHOO.Tools.checkFlash() : 'none';
				info += '; Flash: ' + flashVer;
				//skin and theme
				info += '; Skin: ' + skin;
				if (typeof themename != 'undefined') {
					info += '-' + themename;
				}
				document.getElementById('wpBrowser').value = info;
			</script>\n");

		//do we show the url and allow change?
		global $wgSpecialContactUnlockURL;
		if($wgSpecialContactUnlockURL) {
			$wgOut->addHTML( "
			<table border='0'>
				<tr>
					<td align='right'>" . wfMsg( 'contactwikiname' ) . "</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpContactWikiName\" value=\"{$wgServer}\" size='40' />
					</td>
				</tr>\n");
		}
		else {
			//nope, hide it
			$wgOut->addHTML( "
			<input type=\"hidden\" id=\"wpContactWikiName\" name=\"wpContactWikiName\" value=\"{$wgServer}\" />
			<table border='0'>
				<tr>
					<td align='right'>". wfMsg( 'contactusername' ) .":</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpName\" value=\"{$encName}\" size='40' {$user_readonly}/> {$autofill_marker}
					</td>
				</tr>\n");
		}

		$wgOut->addHTML( "
				<tr>
					<td align='right'>". wfMsg( 'contactrealname' ) .":</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpContactRealName\" value=\"{$encRealName}\" size='40' {$name_readonly}/> {$autofill_marker}
					</td>
				</tr>
				<tr>
					<td align='right'>" . wfMsg( 'contactyourmail' ) .":</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpEmail\" value=\"{$encEmail}\" size='40' {$mail_readonly}/> {$autofill_marker}
					</td>
				</tr>
				<tr>
					<td align='right'>". wfMsg( 'contactproblem' ) .":</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpContactProblem\" value=\"{$encProblem}\" size='80' />
					</td>
				</tr>
				<tr>
					<td align='right' valign='top'>".  wfMsg( 'contactproblemdesc' ) . ":</td>
					<td align='left'>
						<textarea tabindex='" . ($ti++) . "' name=\"wpContactProblemDesc\" rows=\"10\" cols=\"60\">{$encProblemDesc}</textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='submit' name=\"wpContactattempt\" value=\"". wfMsg( 'contactmail' ) ."\" />
					</td>
				</tr>\n");

		if( !$wgUser->isAnon() && $wgUser->getEmail() != '') {
			//is user, has email, but is verified?
			if( $wgUser->getEmailAuthenticationTimestamp() != null ) {
				//yes!
				$wgOut->addHtml("
				<tr>
					<td></td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='checkbox' name=\"wgCC\" value=\"1\" />" . wfMsg('contactccme') . "
					</td>
				</tr>\n");
			}
			else
			{
				//not
				$wgOut->addHtml("
				<tr>
					<td></td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='checkbox' value=\"0\" disabled=\"disabled\" readonly=\"readonly\" />".
						"<s><i>" . wfMsg('contactccme') . "</i></s><br/> ". wfMsg('contactccdisabled'). "
					</td>
				</tr>\n");
			}
		}

		$wgOut->addHtml("
			</table>
		</form>\n");
	}

}

