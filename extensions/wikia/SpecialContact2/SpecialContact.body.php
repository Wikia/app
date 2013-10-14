<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */
class ContactForm extends SpecialPage {
	var $mUserName, $mPassword, $mRetype, $mReturnto, $mCookieCheck;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err, $errInputs;
	var $secDat;

	private $mReferral;

	var $customForms = array(
		'account-issue' => array(
			'format' => "User reports a problem with his account (%s) on this wiki:\n%s\n\nDescription of issue:\n%s",
			'vars' => array( 'wpUserName', 'wpContactWikiName', 'wpDescription' ),
			'subject' => "Account issue: %s",
		),

		'close-account' => array(
			'format' => "User requested account \"%s\" to be disabled.\n\nhttp://community.wikia.com/wiki/Special:EditAccount/%s?wpAction=closeaccount",
			'vars' => array( 'wpUserName', 'wpUrlencUserName' ),
			'subject' => 'Disable account: %s',
			'markuser' => 'requested-closure',
		),

		'rename-account' => array(
			'format' => "User requested his username to be changed from \"%s\" to \"%s\".\n\nhttp://community.wikia.com/wiki/Special:UserRenameTool?oldusername=%s&newusername=%s",
			'vars' => array( 'wpUserName', 'wpUserNameNew', 'wpUrlencUserName', 'wpUrlencUserNameNew' ),
			'subject' => 'Rename account: %s',
			'markuser' => 'requested-rename',
		),

		'bad-ad' => array(
			'format' => "User %s reports a problem with ad visible here:\n%s\n\nDescription of the problem:\n%s",
			'vars' => array( 'wpUserName', 'wpContactWikiName', 'wpDescription' ),
			'subject' => 'Bad ad report by %s at %s',
		),

		'bug' => array(
			'format' => "User %s reports a problem with feature \"%s\".\n\nURL to problem page:\n%s\n\nDescription of issue:\n\n%s",
			'vars' => array( 'wpUserName', 'wpFeature', 'wpContactWikiName', 'wpDescription' ),
			'subject' => 'Bug report by %s at %s',
		)
	);

	function  __construct() {
		parent::__construct( "Contact" , '' /*restriction*/);
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;
		global $wgUser, $wgCaptchaClass, $wgServer;

		$app = F::app();

		$isMobile = $app->checkSkin( 'wikiamobile');

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SpecialContact2/SpecialContact.scss'));
		$extPath = $app->wg->extensionsPath;
		$wgOut->addScript( "<script src=\"{$extPath}/wikia/SpecialContact2/SpecialContact.js\"></script>" );
		$this->mUserName = null;
		$this->mRealName = null;
		$this->mWhichWiki = null;
		$this->mProblem = $wgRequest->getText( 'wpContactSubject' ); //subject
		$this->mProblemDesc = null;
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mEmail = $wgRequest->getText( 'wpEmail' );
		$this->mBrowser = $wgRequest->getText( 'wpBrowser' );
		$this->mAbTestInfo = $wgRequest->getText( 'wpAbTesting' );
		$this->mCCme = $wgRequest->getCheck( 'wgCC' );
		$this->mReferral = $wgRequest->getText( 'wpReferral', ( !empty( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : null ) );

		if( $wgRequest->wasPosted() ) {

			if( $wgUser->isAnon() && class_exists( $wgCaptchaClass ) ) {
				$captchaObj = new $wgCaptchaClass();
				$info = $captchaObj->passCaptcha();
			}

			#ubrfzy note: these were moved inside to (lazy) prevent some stupid bots
			$this->mUserName = $wgRequest->getText( 'wpUserName' );
			$wgRequest->setVal( 'wpUrlencUserName', urlencode( str_replace( ' ', '_', $wgRequest->getText( 'wpUserName' ) ) ) );
			$wgRequest->setVal( 'wpUrlencUserNameNew', urlencode( str_replace( ' ', '_', $wgRequest->getText( 'wpUserNameNew' ) ) ) );

			$this->mRealName = $wgRequest->getText( 'wpContactRealName' );
			$this->mWhichWiki = $wgRequest->getText( 'wpContactWikiName', $wgServer );

			#sibject still handled outside of post check, because of existing hardcoded prefill links

			if ( $wgUser->isLoggedIn() && ( $wgUser->getName() !== $wgRequest->getText( 'wpUserName' ) ) ) {
				$wgOut->showErrorPage( 'specialcontact-error-title', 'specialcontact-error-message' );
				return;
			}

			// handle custom forms
			if ( !empty( $par ) && array_key_exists( $par, $this->customForms ) ) {
				if ( $par === 'rename-account' ) {
					$this->validateUserName( $wgRequest->getText( 'wpUserNameNew' ) );
				}

				foreach ( $this->customForms[$par]['vars'] as $var ) {
					$args[] = $wgRequest->getVal( $var );
				}

				if ( !empty( $this->customForms[$par]['markuser'] ) ) {
					// notify relevant extension that a request has been made
					$wgUser->setOption( $this->customForms[$par]['markuser'], 1 );
					$wgUser->saveSettings();
				}

				$messageText = vsprintf( $this->customForms[$par]['format'], $args );

				$this->mProblemDesc = $messageText;

				// set subject
				$this->mProblem = vsprintf( $this->customForms[$par]['subject'], array( $wgRequest->getText( 'wpUserName' ), $this->mWhichWiki ) );
			} else {
				$this->mProblemDesc = $wgRequest->getText( 'wpContactDesc' ); //body
			}

			#malformed email?
			if (!Sanitizer::validateEmail($this->mEmail)) {
				$this->err[] = wfMsg('invalidemailaddress');
				$this->errInputs['wpEmail'] = true;
			}

			#empty message text?
			if( empty($this->mProblemDesc) ) {
				$this->err[] = wfMsg('specialcontact-nomessage');
				$this->errInputs['wpContactDesc'] = true;
			}

			#captcha
			if( $wgUser->isAnon() && class_exists( $wgCaptchaClass ) && !$info ) { // logged in users don't need the captcha (RT#139647)
				$this->err[] = wfMsg('specialcontact-captchafail');
				$this->errInputs['wpCaptchaWord'] = true;
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

		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		if ( $isMobile ) {

			$wgOut->setPageTitle( wfMsg( 'contact' ) );

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			$captchaErr = !empty( $this->errInputs['wpCaptchaWord'] ) ? 'inpErr' : null;

			$oTmpl->set_vars( [
				'isLoggedIn' => $wgUser->isLoggedIn(),
				'intro' => wfMsgExt( 'specialcontact-intro-content-issue-mobile', array( 'parse' ) ),
				'encName' => $wgUser->getName(),
				'encEmail' => $wgUser->getEmail(),
				'hasEmailConf' => $wgUser->isEmailConfirmed(),
				'subject' => $this->mProblem,
				'content' => $this->mProblemDesc,
				'cc' => $this->mCCme,
				'userName' => $this->mUserName,
				'email' => $this->mEmail,
				'captchaForm' => ($wgUser->isAnon() && class_exists( $wgCaptchaClass )) ? (new $wgCaptchaClass())->getForm( $captchaErr ) : '',
				'errMessages' => $this->err,
				'errors' => $this->errInputs,
				'referral' => $this->mReferral
			] );

			$wgOut->addHTML( $oTmpl->render( "mobile-form" ) );

			foreach ( AssetsManager::getInstance()->getURL( 'special_contact_wikiamobile_scss' ) as $s ) {
				$wgOut->addStyle( $s );
			}

			foreach ( AssetsManager::getInstance()->getURL( 'special_contact_wikiamobile_js' ) as $s ) {
				$wgOut->addScript( "<script src=" . $s . ">" );
			}

		} else {
			if( $this->isAuthorizedSub( $par ) ) {
				# sub was one we know about, so use it
				$this->doSub( $par );
			}
			else {
				$this->ContactFormPicker();
			}
		}
	}

	/**
	 * @access private
	 */
	function processCreation() {
		global $wgUser, $wgOut, $wgCityId, $wgSpecialContactEmail;
		global $wgLanguageCode, $wgRequest, $wgServer;

		// If not configured, fall back to a default just in case.
		$wgSpecialContactEmail = ( empty( $wgSpecialContactEmail ) ? "community@wikia.com" : $wgSpecialContactEmail );

		$wgOut->setPageTitle( wfMsg( 'specialcontact-pagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		//build common top of both emails
		$m_shared = '';
		$m_shared .= ( !empty( $this->mRealName ) ) ? ( $this->mRealName ) : ( ( ( !empty( $this->mUserName ) ) ? ( $this->mUserName ) : ('--') ) );
		$m_shared .= " ({$this->mEmail})";
		$m_shared .= " " . ( ( !empty($this->mUserName) ) ? $wgServer . "/wiki/User:" . urlencode(str_replace(" ", "_", $this->mUserName)) : $wgServer ) . "\n";


		//start wikia debug info, sent only to the internal email, not cc'd
		$items = array();
		$items[] = 'wkID: ' . $wgCityId;
		$items[] = 'wkLang: ' . $wgLanguageCode;

		//always add the IP
		$items[] = 'IP:' . $wgRequest->getIP();

		//if they are logged in, add the ID(and name) and their lang
		$uid = $wgUser->getID();
		if( !empty($uid) ) {
			$items[] = 'uID: ' . $uid . " (User:". $wgUser->getName() .")";
			$items[] = 'uLang: ' . $wgUser->getOption('language');
		}

		if ( !empty( $this->mReferral ) ) {
			$items[] = 'referral: ' . $this->mReferral;
		}

		//smush it all together
		$info = $this->mBrowser . "\n\n";
		if ( !empty($uid) ) {
		$info .= 'http://community.wikia.com/wiki/Special:LookUpUser/'. urlencode(str_replace(" ", "_", $this->mUserName)) . "\n";
		}
		$info .= 'http://community.wikia.com/wiki/Special:LookUpUser/'. $this->mEmail . "\n\n";
		$info .= "A/B Tests: " . $this->mAbTestInfo . "\n\n"; // giving it its own line so that it stands out more
		$info .= implode("; ", $items) . "\n\n";
		//end wikia debug data

		$body = "\n{$this->mProblemDesc}\n\n----\n" . $m_shared . $info;

		if($this->mCCme) {
			$mcc = wfMsg('specialcontact-ccheader') . "\n\n";
			$mcc .= $m_shared . "\n{$this->mProblemDesc}\n";
		}

		$mail_user = new MailAddress($this->mEmail);
		$mail_community = new MailAddress( $wgSpecialContactEmail, 'Wikia Support');

		$errors = '';

		#to us, from user
		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			//We want an easy way to know that feedback comes from a mobile
			$this->mProblem = 'Mobile: ' . $this->mProblem;
		}

		$subject = wfMsg('specialcontact-mailsub') . (( !empty($this->mProblem) )? ' - ' . $this->mProblem : '');

		$screenshot = $wgRequest->getFileTempname( 'wpScreenshot' );
		$magic = MimeMagic::singleton();

		$screenshots = array();
		if ( !empty( $screenshot ) ) {
			foreach ( $screenshot as $image ) {
				if ( !empty( $image ) ) {
					$extList = '';
					$mime = $magic->guessMimeType( $image );
					if ( $mime !== 'unknown/unknown' ) {
							# Get a space separated list of extensions
							$extList = $magic->getExtensionsForType( $mime );
							$ext_file = strtok( $extList, ' ' );
					} else {
							$mime = 'application/octet-stream';
					}
					$screenshots[] = array( 'file' => $image, 'ext' => $ext_file, 'mime' => $mime );
				}
			}

			if ( !empty( $screenshots ) ) {
				$body .= "\n\nScreenshot attached.";
			}
		}

		$result = UserMailer::send( $mail_community, $mail_user, $subject, $body, $mail_user, null, 'SpecialContact', 0, $screenshots );

		if (!$result->isOK()) {
			$errors .= "\n" . $result->getMessage();
		}

		#to user, from us (but only if the first one didnt error, dont want to echo the user on an email we didnt get)
		if( empty($errors) && $this->mCCme && $wgUser->isEmailConfirmed() ) {
			$result = UserMailer::send( $mail_user, $mail_community, wfMsg('specialcontact-mailsubcc'), $mcc, $mail_user, null, 'SpecialContactCC' );
			if (!$result->isOK()) {
				$errors .= "\n" . $result->getMessage();
			}
		}

		if ( !empty($errors) ) {
			$wgOut->addHTML( $this->formatError( $this->err ) );
		}

		/********************************************************/
		#sending done, show message

		#parse this message to allow wiki links (BugId: 1048)
		$wgOut->addHTML( wfMsgExt('specialcontact-submitcomplete', array('parse')) );

		$mp = Title::newMainPage();
		$link = Xml::element('a', array('href'=>$mp->getLocalURL()), $mp->getPrefixedText());
		$wgOut->addHTML(wfMsg( 'returnto', $link ) );

		return;
	}

	/**
	 * @access private
	 */
	function ContactFormPicker() {
		global $wgOut, $SpecialContactSecMap;

		$wgOut->setPageTitle( wfMsg( 'specialcontact-pagetitle' ) );

		$uskin = RequestContext::getMain()->getSkin();

		$secDat = array();

		foreach( $SpecialContactSecMap as $section )
		{
			if( empty($section['headerMsg']) ) {
				continue;
			}

			$newsec = array(
				'header' => wfMsg('specialcontact-secheader-' . $section['headerMsg']),
				'links' => array(),
			);

			#$pages = array('bug', 'feedback', 'account', 'other');
			foreach($section['links'] as $info)
			{
				if( is_array( $info ) ) {
					$sub = $info['link'];
					#is a msg defined?
					if( !empty($info['msg']) )
					{
						#use it
						$msg = $info['msg'];
					} else {
						#no msg, so use link
						$msg = $info['link'];
					}
				} else {
					#when not array, use the value as both sub and msg
					$sub = $info;
					$msg = $info;
				}

				$title = Title::newFromText('Contact/' . $sub, NS_SPECIAL);
				$msgKey = 'specialcontact-seclink-' . $msg;
				$newsec['links'][] = $uskin->makeKnownLinkObj( $title, wfMsg( $msgKey ), '', '', '', "class={$msgKey}" );
			}
			$secDat[] = $newsec;
		}

			$local = wfMsgExt( 'specialcontact-intro-main-local', array('parse', 'content') );
		if( !wfEmptyMsg('specialcontact-intro-main-local', $local) ) {
			#ok?
		}
		else {
			$local = '';
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			'head' => wfMsg( 'specialcontact-intro-main-head' ),
			'local' => $local,
			'foot' => wfMsgExt( 'specialcontact-intro-main-foot', array('parse') ),
			'sectionData' => $secDat,
		);

		$oTmpl->set_vars( $vars );
		$wgOut->addHTML( $oTmpl->render("picker") );

		return;
	}

	/**
	 * @access private
	 */
	function doSub( $sub = null ) {
		if( !empty($this->secDat['form']) ) {
			$this->ShowContactForm($sub);
		} else {
			$this->ShowNonForm($sub);
		}
	}

	/**
	 * @access private
	 */
	function ShowContactForm( $sub = null ) {
		global $wgUser, $wgOut;
		global $wgServer, $wgCaptchaClass;

		$wgOut->setPageTitle(
			wfMsg('specialcontact-sectitle', wfMsg('specialcontact-sectitle-'.$sub))
		);

		if( $wgUser->isLoggedIn() ) {
			//user mode

			//we have user data, so use it, overriding any passed in from url
			$this->mUserName = $wgUser->getName();
			$this->mRealName = $wgUser->getRealName();
			$this->mEmail = $wgUser->getEmail();

			# since logged in, assume...
			//no box, just print
			$user_readonly = true;
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
				$this->mUserName = @$_COOKIE[$wgCookiePrefix.'UserName'];
			}

			#anon mode, no locks
			$user_readonly = false;
			$name_readonly = false;
			$mail_readonly = false;
		}

		$q = 'action=submit';

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' . '/' . $sub );
		$action = $titleObj->escapeLocalUrl( $q );

		$encName = htmlspecialchars( $this->mUserName );
		$encEmail = htmlspecialchars( $this->mEmail );
		$encRealName = htmlspecialchars( $this->mRealName );
		$encProblem = htmlspecialchars( $this->mProblem );
		$encProblemDesc = htmlspecialchars( $this->mProblemDesc );


		//global this, for use with unlocking a field
		global $wgSpecialContactUnlockURL;

		# pre calc if these fields are 'errors' or not
		$eclass = array();
		$fields = array( 'wpContactWikiName', 'wpUserName', 'wpContactRealName',
					'wpEmail', 'wpContactSubject', 'wpContactDesc', 'wpCaptchaWord' );
		foreach( $fields as $f )
		{
			$eclass[ $f ] = $this->getClass( $f );
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			'type' => $sub,
			'intro' => wfMsgExt( 'specialcontact-intro-' . $sub, array('parse') ),
			'form_action' => $action,
			'unlockURL' => (bool)$wgSpecialContactUnlockURL,
			'eclass' => $eclass,
			'wgServer' => $wgServer,
			'logoutURL' => SpecialPage::getTitleFor('UserLogout')->getFullURL( array('returnto'=>'Special:Contact') ),
			'user_readonly' => $user_readonly,
			'name_readonly' => $name_readonly,
			'mail_readonly' => $mail_readonly,
			'encName' => $encName,
			'encEmail' => $encEmail,
			'encRealName' => $encRealName,
			'encProblem' => $encProblem,
			'encProblemDesc' => $encProblemDesc,
			'isLoggedIn' => $wgUser->isLoggedIn(),
		);

		if( $wgUser->isLoggedIn() ) {
			#logged in
			$vars[ 'hasEmail' ] = $wgUser->getEmail();
			$vars[ 'hasEmailConf' ] = $wgUser->isEmailConfirmed();
		}
		elseif (class_exists($wgCaptchaClass)) {
			#anon
			$wgCaptcha = new $wgCaptchaClass();
			$vars[ 'captchaForm' ] = $wgCaptcha->getForm();
		}

		if( !empty( $this->err ) ) {
			$vars['err'] = $this->formatError( $this->err );
		}

		$oTmpl->set_vars( $vars );

		if( $this->secDat['form'] === true ) {
			$wgOut->addHTML( $oTmpl->render("form") );
		} elseif ( $wgUser->isAnon() && !empty( $this->secDat['reqlogin'] ) ) {
			$wgOut->showErrorPage( 'loginreqtitle', 'specialcontact-error-logintext' );
			return;
		} elseif ( $this->secDat['form'] === 'rename-account' && $wgUser->getOption( 'wasRenamed', 0 ) ) {
			$wgOut->showErrorPage( 'specialcontact-error-title', 'specialcontact-error-alreadyrenamed' );
			return;
		} else {
			$wgOut->addHTML( $oTmpl->render( $this->secDat['form'] ) );
		}
		return true;
	}

	/**
	 * @access private
	 */
	function ShowNonForm( $sub = null ) {
		global $wgOut;

		$wgOut->setPageTitle(
			wfMsg('specialcontact-sectitle', wfMsg('specialcontact-sectitle-'.$sub))
		);

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' . '/' . $sub );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			'type' => $sub,
			'intro' => wfMsgExt( 'specialcontact-intro-' . $sub, array('parse') ),
			'footer' => wfMsgExt( 'specialcontact-noform-footer' , array('parse') ),
		);

		$oTmpl->set_vars( $vars );

		$wgOut->addHTML( $oTmpl->render("noform") );

		return;
	}

	/* used by contact form for errors */
	function formatError($err) {
		$out = '';
		if(is_array($err)) {
			$out .= '<div class="errorbox">';
				foreach($err as $value) {
					$out .= $value . "<br/>";
				}
			$out .= '</div><br style="clear: both;">';
		} else {
			$out .= Wikia::errorbox( $err );
		}
		return $out;
	}

	/* used by contact form for errors */
	function getClass($id) {
		if(empty($this->errInputs[$id])) {
			return "";
		}
		return "class='error'";
	}

	/* used by picker to check if a subpage passed is OK */
	private function isAuthorizedSub( $par ) {
		global $SpecialContactSecMap;

		foreach( $SpecialContactSecMap as $sec ) {
			foreach($sec['links'] as $entry )
			{
				if( is_array($entry) ) {
					$link = $entry['link'];
				}
				else {
					$link = $entry;
				}

				if( $link == $par ) {
					if( is_array($entry) ) {
						$this->secDat = array();
						if( !empty($entry['link']) ) { $this->secDat['link'] = $entry['link']; }

						if( !empty($entry['msg']) ) { $this->secDat['msg'] = $entry['msg']; }
						else { $this->secDat['msg'] = $entry['link']; }

						if( !empty($entry['form']) ) { $this->secDat['form'] = $entry['form']; }
						else { $this->secDat['form'] = false; }

						$this->secDat['reqlogin'] = empty( $entry['reqlogin'] ) ? false : $entry['reqlogin'];

					} else {
						$this->secDat = array('link'=>$link, 'msg'=>$link, 'form'=>false);
					}

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Validates username user enters on rename account form
	 *
	 * @author grunny
	 */
	private function validateUserName( $userName ) {
		global $wgWikiaMaxNameChars;
		if ( $userName == '' ) {
			$this->err[] = wfMsg( 'userlogin-error-noname' );
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}

		// check if exist in tempUser
		// @TODO get rid of TempUser handling when it will be globally disabled
		if ( TempUser::getTempUserFromName( $userName ) ) {
			$this->err[] = wfMsg( 'userlogin-error-userexists' );
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}

		// check username length
		if ( !User::isNotMaxNameChars( $userName ) ) {
			$this->err[] = wfMsg( 'usersignup-error-username-length', $wgWikiaMaxNameChars );
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}

		// check valid username
		if ( !User::isCreatableName( $userName ) ) {
			$this->err[] = wfMsg( 'usersignup-error-symbols-in-username' );
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}

		$result = wfValidateUserName( $userName );
		if ( $result === true ) {
			$msgKey = '';
			if ( !wfRunHooks( 'cxValidateUserName', array( $userName, &$msgKey ) ) ) {
				$result = $msgKey;
			}
		}

		if ( $result !== true ) {
			$msg = '';
			if ( $result === 'userlogin-bad-username-taken' ) {
				$msg = wfMsg( 'userlogin-error-userexists' );
			} else if ( $result === 'userlogin-bad-username-character' ) {
				$msg = wfMsg( 'usersignup-error-symbols-in-username' );
			} else if ( $result === 'userlogin-bad-username-length' ) {
				$msg = wfMsg( 'usersignup-error-username-length', $wgWikiaMaxNameChars );
			}

			$this->err[] = empty( $msg ) ? $result : $msg;
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}
		return true;
	}
}
