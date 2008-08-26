<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

$wgExtensionFunctions[] = 'wfSpecialContactSetup';


/**
 *
 */
require_once('UserMailer.php');

/**
 * consutrctor
 */
function wfSpecialContactSetup() {

/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */
class ContactForm extends SpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;

	function ContactForm() {
		SpecialPage::SpecialPage("Contact");
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

		$this->setupMessages();

	  if( $this->mPosted ) {
	    if (  'submit' == $this->mAction ) {
	      return $this->processCreation();
	    }
	  }
	  $this->mainContactForm( '' );
	}
	/**
	 * @access private
	 */
	function processCreation() {
		global $wgUser, $wgOut;

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addHTML(         wfMsg( 'contactsubmitcomplete' )     );



		$m = "$this->mRealName";
		$m .= " <$this->mEmail> <{$this->mWhichWiki}/wiki/User:$this->mName> contacted Wikia about ";
		$m .= "$this->mProblem.\n";
		$m .= "User browser data: $this->mBrowser\n\n";
		$m .= "$this->mProblemDesc\n";


	#	exec("/bin/echo '$m' >> /home/wikicities/contactmails.log");

		$from = $this->mEmail;
		#if (class_exists("MailAddress"))
		$from = new MailAddress($from);

		$error = userMailer( new MailAddress("community@wikia.com"),
				     $from,
				     wfMsg( 'contactmailsub') . ' - ' . $this->mProblem,
				     "$m", $from );
		$error = userMailer( new MailAddress("beesley@gmail.com"),
				     $from,
				     wfMsg( 'contactmailsub') . ' - ' . $this->mProblem,
				     "$m", $from );


		return htmlspecialchars( $error );
	}

	/**
	 * @access private
	 */
	function mainContactForm( $err ) {
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;
		global $wgServer, $wgSitename;

		$yn = wfMsg( 'yourname' );
                $cwt = wfMsg( 'contactintro' );
                $cwtt = wfMsg( 'contactproblem' );
                $cwn = wfMsg( 'contactproblemdesc' );
                $nvt = wfMsg( 'contactrealname' );
                $wwn = wfMsg( 'contactwikiname' );
                $rcw = wfMsg( 'contactmail' );
		$ye = wfMsg( 'yourmail' );

		if ( '' == $this->mName ) {
			if ( 0 != $wgUser->getID() ) {
				$this->mName = $wgUser->getName();
			} else {
				$this->mName = @$_COOKIE[$wgDBname.'UserName'];
			}
		}

		$wgOut->setPageTitle( wfMsg( 'contactpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$q = 'action=submit';

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' );
		$action = $titleObj->escapeLocalUrl( $q );

		$encName = htmlspecialchars( $this->mName );
		$encEmail = htmlspecialchars( $this->mEmail );
		$encSitename = htmlspecialchars( $wgSitename );

		$wgOut->addHTML( "
        {$cwt}
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
	</script>
	<table border='0'><tr>
	<td align='right'>$yn:</td>
	<td align='left'>
	<input tabindex='1' type='text' name=\"wpName\" value=\"{$encName}\" size='35' />
	</td>

	</tr>
	<tr>
	<td align='right'>$wwn:</td>
	<td align='left'>
	<input tabindex='2' type='text' name=\"wpContactWikiName\" value=\"{$wgServer}\" size='35' />
	</td>

	</tr>
	<tr>
	<td align='right'>$nvt:</td>
	<td align='left'>
	<input tabindex='2' type='text' name=\"wpContactRealName\" value=\"\" size='35' />
	</td>

	</tr>

<tr>
	<td align='right'>$ye:</td>
	<td align='left'>
	<input tabindex='3' type='text' name=\"wpEmail\" value=\"{$encEmail}\" size='35' />
	</td>
        </tr>
        <tr>
	<td align='right'>$cwtt:</td>
	<td align='left'>
	<input tabindex='4' type='text' name=\"wpContactProblem\" value=\"\" size='35' />
	</td>

	</tr>
        <tr>
	<td align='right'>$cwn:</td>
	<td align='left'>
	<textarea tabindex='5' name=\"wpContactProblemDesc\" value=\"\" rows=\"6\" cols=\"60\" /></textarea>
	</td>

	</tr>
<tr><td></td>
<td align='left'>
	<input tabindex='6' type='submit' name=\"wpContactattempt\" value=\"{$rcw}\" />
	</td>
</tr>");


		$wgOut->addHTML("</table></form>\n" );
	}


	function setupMessages() {
		global $wgMessageCache;
		$wgMessageCache->addMessages( array(
			'contactpagetitle' => 'Contact Wikia',
			'contactproblem' => 'Subject',
			'contactproblemdesc' => 'Message',
			'createwikidesc' => 'Description of the Wiki',
			'contactmailsub' => 'Wikia Contact Mail',
			'contactmail' => 'Send',
			'yourmail' => 'Your email address',
			'contactsubmitcomplete' => 'Thank you for contacting Wikia.',
			'contactrealname' => 'Your name',
			'contactwikiname' => 'Name of the wiki',
			'contactintro' => 'Please read the <a href=http://www.wikia.com/wiki/Report_a_problem>Report a problem</a> page for information on reporting problems and using this contact form.<p />You can contact the Wikia community at the <a href=http://www.wikia.com/wiki/Community_portal>Community portal</a> and report software bugs at <a href=http://bugs.wikia.com>bugs.wikia.com</a>. <p>If you prefer your message to <a href=http://www.wikia.com/wiki/Wikia>Wikia</a> to be private, please use the contact form below. <i>All fields are optional</i>.',
		) );
	}

}

global $wgMessageCache;

SpecialPage::addPage( new ContactForm );
$wgMessageCache->addMessage( 'contact', 'Contact Wikia' );

} // End extension function
