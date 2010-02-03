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

		if( $this->mPosted ) {
			if ('submit' == $this->mAction ) {
				if (!User::isValidEmailAddr($this->mEmail)) {
					$this->mainContactForm(wfMsg('contactpage-email-failed'));
					return;
				} else {
					return $this->processCreation();
				}
			}
		}
		$this->mainContactForm( '' );
	}
	/**
	 * @access private
	 */
	function processCreation() {
		global $wgUser, $wgOut, $wgCityId;

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$mp = Title::newMainPage();
		$wgOut->addHTML(wfMsg( 'contactsubmitcomplete' ));
		$wgOut->addHTML('<br/>' . wfMsgExt( 'returnto', 'parse', "[[" . $mp->getText() . "]]" ));

		$m = "$this->mRealName";
		$m .= " ({$this->mEmail}) {$this->mWhichWiki}/wiki/User:" . str_replace(" ", "_", $this->mName) . " contacted Wikia about ";
		$m .= "$this->mProblem.\n";
		$m .= "User browser data: {$this->mBrowser}; wkID: {$wgCityId}; IP: " . wfGetIP() . "\n\n";
		$m .= "$this->mProblemDesc\n";
		
		if($this->mCCme) {
			$mcc = wfMsg('contactccheader') . "\n\n";
			$mcc .= "$this->mRealName";
			$mcc .= " ({$this->mEmail}) {$this->mWhichWiki}/wiki/User:" . str_replace(" ", "_", $this->mName) . " contacted Wikia about ";
			$mcc .= "$this->mProblem.\n\n";
			$mcc .= "$this->mProblemDesc\n";
		}
		
	#	exec("/bin/echo '$m' >> /home/wikicities/contactmails.log");

		$from = $this->mEmail;
		#if (class_exists("MailAddress"))
		$from = new MailAddress($from);

		$errors = '';
		$error = UserMailer::send( new MailAddress("community@wikia.com"), $from, wfMsg('contactmailsub') . ' - ' . $this->mProblem, $m, $from, null, 'SpecialContact' );
		if (WikiError::isError($error)) {
			$errors .= "\n" . $error->getMessage();
		}

		if( $this->mCCme && $wgUser->getEmailAuthenticationTimestamp() != null ) {
			$error = UserMailer::send( $from, new MailAddress("community@wikia.com"), wfMsg('contactmailsub') . ' - ' . $this->mProblem, $mcc, $from, null, 'SpecialContactCC' );
			if (WikiError::isError($error)) {
				$errors .= "\n" . $error->getMessage();
			}
		}
		
		return htmlspecialchars($errors);
	}

	/**
	 * @access private
	 */
	function mainContactForm( $err ) {
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;
		global $wgServer, $wgSitename;

		$yn = wfMsg( 'contactusername' );
		$intro = wfMsg( 'contactintro' );
		$cwtt = wfMsg( 'contactproblem' );
		$cwn = wfMsg( 'contactproblemdesc' );
		$nvt = wfMsg( 'contactrealname' );
		$wwn = wfMsg( 'contactwikiname' );
		$rcw = wfMsg( 'contactmail' );
		$ye = wfMsg( 'contactyourmail' );

		if ( '' == $this->mName ) {
			if ( 0 != $wgUser->getID() ) {
				$this->mName = $wgUser->getName();
			} else {
				$this->mName = @$_COOKIE[$wgDBname.'UserName'];
			}
		}

		if( $wgUser->isAnon() == false ) {
			//user mode
			
			if ( $this->mRealName == '') {
				$this->mRealName = $wgUser->getRealName();
			}

			if ( $this->mEmail == '' ) {
				$this->mEmail = $wgUser->getEmail();
			}

			$user_readonly = 'readonly="readonly" ';
			$user_autofill_marker = '<span class="autofilled" style="color:blue; cursor: help;" title="'. wfMsg('contactfilledin') .'">+</span>';
		}
		else
		{
			//anon mode
			$user_readonly = ''; //dont lock
			$user_autofill_marker = ''; //no lock, no marker
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

		if ($err != '') {
			$wgOut->addHTML("$err<br/><br/>");
		}

		// add intro text
		$wgOut->addHTML( $intro );
		
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
				info += ' Flash: ' + flashVer;
				//skin and theme
				info += ' Skin: ' + skin;
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
					<td align='right'>$wwn:</td>
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
					<td align='right'>$yn:</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpName\" {$user_readonly}value=\"{$encName}\" size='40' /> {$user_autofill_marker}
					</td>
				</tr>\n");
		}

		$wgOut->addHTML( "
				<tr>
					<td align='right'>$nvt:</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpContactRealName\" {$user_readonly}value=\"{$encRealName}\" size='40' /> {$user_autofill_marker}
					</td>
				</tr>
				<tr>
					<td align='right'>$ye:</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpEmail\" {$user_readonly}value=\"{$encEmail}\" size='40' /> {$user_autofill_marker}
					</td>
				</tr>
				<tr>
					<td align='right'>$cwtt:</td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='text' name=\"wpContactProblem\" value=\"{$encProblem}\" size='80' />
					</td>
				</tr>
				<tr>
					<td align='right' valign='top'>$cwn:</td>
					<td align='left'>
						<textarea tabindex='" . ($ti++) . "' name=\"wpContactProblemDesc\" rows=\"10\" cols=\"60\">{$encProblemDesc}</textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='submit' name=\"wpContactattempt\" value=\"{$rcw}\" />
					</td>
				</tr>\n");

		if( !$wgUser->isAnon() && $wgUser->getEmail() != '') {
			if( $wgUser->getEmailAuthenticationTimestamp() != null ) {
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
				$wgOut->addHtml("
				<tr>
					<td></td>
					<td align='left'>
						<input tabindex='" . ($ti++) . "' type='checkbox' name=\"wgCC\" value=\"0\" disabled=\"disabled\" readonly=\"readonly\" />".
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

