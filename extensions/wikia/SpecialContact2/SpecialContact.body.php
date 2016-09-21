<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */
class ContactForm extends SpecialPage {
	const WIKIA_SUPPORT_EMAIL = 'support@wikia-inc.com';

	var $mUserName, $mPassword, $mRetype, $mReturnto, $mCookieCheck;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err, $errInputs;
	var $secDat;

	private $mReferral;

	private $securityIssueTypes = [
		1 => 'specialcontact-security-issue-type-xss',
		2 => 'specialcontact-security-issue-type-csrf',
		3 => 'specialcontact-security-issue-type-sqli',
		4 => 'specialcontact-security-issue-type-auth',
		5 => 'specialcontact-security-issue-type-leak',
		6 => 'specialcontact-security-issue-type-redirect',
		7 => 'specialcontact-security-issue-type-other',
	];

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
			'format' => "User %s reports a problem with ad visible here:\n%s\nThe URL the ad links to:\n%s\n\nDescription of the problem:\n%s",
			'vars' => array( 'wpUserName', 'wpContactWikiName', 'wpContactAdUrl', 'wpDescription' ),
			'subject' => 'Bad ad report by %s at %s',
		),

		'bug' => array(
			'format' => "User %s reports a problem with feature \"%s\".\n\nURL to problem page:\n%s\n\nDescription of issue:\n\n%s",
			'vars' => array( 'wpUserName', 'wpFeature', 'wpContactWikiName', 'wpDescription' ),
			'subject' => 'Bug report by %s at %s',
		),

		'security' => [
			'format' => "User %s reports a security issue on Wikia.\n\nType of issue: %s\n\nURL to example of bug:\n%s\n\nDescription of the issue:\n\n%s",
			'vars' => [ 'wpUserName', 'wpIssueType', 'wpUrl', 'wpDescription' ],
			'subject' => 'Security report by %s at %s',
		],
	);

	function  __construct() {
		parent::__construct( "Contact" , '' /*restriction*/);
	}

	function execute( $par ) {
		global $wgCaptchaClass, $wgServer;

		$app = F::app();
		$isMobile = $app->checkSkin( 'wikiamobile');
		$out = $this->getOutput();
		$user = $this->getUser();
		$request = $this->getRequest();

		// Disable user JS
		$out->disallowUserJs();

		if ( $par === 'close-account' && $this->isCloseMyAccountSupported() ) {
			$closeAccountTitle = SpecialPage::getTitleFor( 'CloseMyAccount' );
			$out->redirect( $closeAccountTitle->getFullURL() );
		}

		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SpecialContact2/SpecialContact.scss'));

		$extPath = $app->wg->extensionsPath;
		$out->addScript( "<script src=\"{$extPath}/wikia/SpecialContact2/SpecialContact.js\"></script>" );
		$this->mUserName = null;
		$this->mRealName = null;
		$this->mWhichWiki = null;
		$this->mProblem = $request->getText( 'wpContactSubject' ); //subject
		$this->mProblemDesc = null;
		$this->mAction = $request->getVal( 'action' );
		$this->mEmail = $request->getText( 'wpEmail' );
		$this->mBrowser = $request->getText( 'wpBrowser' );
		$this->mAbTestInfo = $request->getText( 'wpAbTesting' );
		$this->mCCme = $request->getCheck( 'wgCC' );
		$this->mReferral = $request->getText( 'wpReferral', ( !empty( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : null ) );

		if ( $request->wasPosted() ) {
			if ( !$user->matchEditToken( $request->getVal( 'wpEditToken' ) ) ) {
				$this->err[] = $this->msg( 'sessionfailure' )->escaped();
			}

			if( $user->isAnon() && class_exists( $wgCaptchaClass ) ) {
				$captchaObj = new $wgCaptchaClass();
				$info = $captchaObj->passCaptcha();
			}

			#ubrfzy note: these were moved inside to (lazy) prevent some stupid bots
			$this->mUserName = $request->getText( 'wpUserName' );
			$request->setVal( 'wpUrlencUserName', urlencode( str_replace( ' ', '_', $request->getText( 'wpUserName' ) ) ) );
			$request->setVal( 'wpUrlencUserNameNew', urlencode( str_replace( ' ', '_', $request->getText( 'wpUserNameNew' ) ) ) );

			$this->mRealName = $request->getText( 'wpContactRealName' );
			$this->mWhichWiki = $request->getText( 'wpContactWikiName', $wgServer );

			#sibject still handled outside of post check, because of existing hardcoded prefill links

			if ( $user->isLoggedIn() && ( $user->getName() !== $request->getText( 'wpUserName' ) ) ) {
				$out->showErrorPage( 'specialcontact-error-title', 'specialcontact-error-message' );
				return;
			}

			// handle custom forms
			if ( !empty( $par ) && array_key_exists( $par, $this->customForms ) ) {
				if ( $par === 'rename-account' ) {
					$this->validateUserName( $request->getText( 'wpUserNameNew' ) );
				}

				foreach ( $this->customForms[$par]['vars'] as $var ) {
					if ( $par === 'security' && $var === 'wpIssueType' ) {
						$issueType = $request->getInt( $var );
						// We want the email to always be in English
						if ( isset( $this->securityIssueTypes[$issueType] ) ) {
							$args[] = wfMessage( $this->securityIssueTypes[$issueType] )->inLanguage( 'en' )->escaped();
						} else {
							// Default to 'other'
							$args[] = wfMessage( 'specialcontact-security-issue-type-other' )->inLanguage( 'en' )->escaped();
						}
					} else {
						$args[] = $request->getVal( $var );
					}
				}

				if ( !empty( $this->customForms[$par]['markuser'] ) ) {
					// notify relevant extension that a request has been made
					$user->setGlobalFlag( $this->customForms[$par]['markuser'], 1 );
					$user->saveSettings();
				}

				$messageText = vsprintf( $this->customForms[$par]['format'], $args );

				$this->mProblemDesc = $messageText;

				// set subject
				$this->mProblem = vsprintf( $this->customForms[$par]['subject'], array( $request->getText( 'wpUserName' ), $this->mWhichWiki ) );
			} else {
				$this->mProblemDesc = $request->getText( 'wpContactDesc' ); //body
			}

			#malformed email?
			if (!Sanitizer::validateEmail($this->mEmail)) {
				$this->err[] = $this->msg( 'invalidemailaddress' )->escaped();
				$this->errInputs['wpEmail'] = true;
			}

			#empty message text?
			if( empty($this->mProblemDesc) ) {
				$this->err[] = $this->msg( 'specialcontact-nomessage' )->escaped();
				$this->errInputs['wpContactDesc'] = true;
			}

			#captcha
			if( $user->isAnon() && class_exists( $wgCaptchaClass ) && !$info ) { // logged in users don't need the captcha (RT#139647)
				$this->err[] = $this->msg('specialcontact-captchafail' )->escaped();
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

		$out->setRobotPolicy( 'noindex,nofollow' );
		$out->setArticleRelated( false );

		if ( $isMobile ) {

			$out->setPageTitle( $this->msg( 'contact' )->text() );

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			$captchaErr = !empty( $this->errInputs['wpCaptchaWord'] ) ? 'inpErr' : null;

			$oTmpl->set_vars( [
				'isLoggedIn' => $user->isLoggedIn(),
				'intro' => $this->msg( 'specialcontact-intro-content-issue-mobile' )->parse(),
				'encName' => $user->getName(),
				'encEmail' => $user->getEmail(),
				'hasEmailConf' => $user->isEmailConfirmed(),
				'subject' => $this->mProblem,
				'content' => $this->mProblemDesc,
				'cc' => $this->mCCme,
				'userName' => $this->mUserName,
				'email' => $this->mEmail,
				'captchaForm' => ($user->isAnon() && class_exists( $wgCaptchaClass )) ? (new $wgCaptchaClass())->getForm( $captchaErr ) : '',
				'errMessages' => $this->err,
				'errors' => $this->errInputs,
				'referral' => $this->mReferral,
				'editToken' => $user->getEditToken(),
			] );

			$out->addHTML( $oTmpl->render( "mobile-form" ) );

			foreach ( AssetsManager::getInstance()->getURL( 'special_contact_wikiamobile_scss' ) as $s ) {
				$out->addStyle( $s );
			}

			foreach ( AssetsManager::getInstance()->getURL( 'special_contact_wikiamobile_js' ) as $s ) {
				$out->addScript( "<script src=" . $s . ">" );
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
		global $wgCityId, $wgSpecialContactEmail;
		global $wgLanguageCode, $wgServer;

		// If not configured, fall back to a default just in case.
		$wgSpecialContactEmail = ( empty( $wgSpecialContactEmail ) ? "community@wikia.com" : $wgSpecialContactEmail );

		$user = $this->getUser();
		$output = $this->getOutput();
		$request = $this->getRequest();

		$output->setPageTitle( $this->msg( 'specialcontact-pagetitle' )->text() );
		$output->setRobotPolicy( 'noindex,nofollow' );
		$output->setArticleRelated( false );

		//build common top of both emails
		$uid = $user->getId();
		$m_shared = '';
		if ( empty($uid) ) {
			$m_shared .= "USER IS NOT LOGGED IN\n";
		}
		$m_shared .= ( !empty( $this->mRealName ) ) ? ( $this->mRealName ) : ( ( ( !empty( $this->mUserName ) ) ? ( $this->mUserName ) : ('--') ) );
		$m_shared .= " ({$this->mEmail})";
		$m_shared .= " " . ( ( !empty($this->mUserName) ) ? $wgServer . "/wiki/User:" . urlencode(str_replace(" ", "_", $this->mUserName)) : $wgServer ) . "\n";


		//start wikia debug info, sent only to the internal email, not cc'd
		$items = array();
		$items[] = 'wkID: ' . $wgCityId;
		$items[] = 'wkLang: ' . $wgLanguageCode;

		//always add the IP
		$items[] = 'IP:' . $request->getIP();

		//if they are logged in, add the ID(and name) and their lang
		if( !empty($uid) ) {
			$items[] = 'uID: ' . $uid . " (User:". $user->getName() .")";
			$items[] = 'uLang: ' . $user->getGlobalPreference( 'language' );
		}

		if ( !empty( $this->mReferral ) ) {
			$items[] = 'referral: ' . $this->mReferral;
		}

		//smush it all together
		$info = $this->mBrowser . "\n\n";
		if ( !empty($uid) ) {
			$info .= 'http://community.wikia.com/wiki/Special:LookUpUser/'. urlencode(str_replace(" ", "_", $this->mUserName)) . "_\n";
		}
		$info .= 'http://community.wikia.com/wiki/Special:LookUpUser/'. $this->mEmail . "\n\n";
		$info .= "A/B Tests: " . $this->mAbTestInfo . "\n\n"; // giving it its own line so that it stands out more
		$info .= implode("; ", $items) . "\n\n";
		//end wikia debug data

		$body = "\n{$this->mProblemDesc}\n\n----\n" . $m_shared . $info;

		if ( $this->mCCme ) {
			$mcc = $this->msg( 'specialcontact-ccheader' )->text() . "\n\n";
			$mcc .= $m_shared . "\n{$this->mProblemDesc}\n";
		}

		$mail_user = new MailAddress($this->mEmail);
		$mail_support_service = new MailAddress( $wgSpecialContactEmail, 'Wikia Support');
		$mail_support_from = new MailAddress( self::WIKIA_SUPPORT_EMAIL, 'Wikia Support' );

		$errors = '';

		#to us, from user
		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			//We want an easy way to know that feedback comes from a mobile
			$this->mProblem = 'Mobile: ' . $this->mProblem;
		}

		$subject = $this->msg( 'specialcontact-mailsub' )->text() . (( !empty($this->mProblem) )? ' - ' . $this->mProblem : '');

		$screenshot = $request->getFileTempname( 'wpScreenshot' );
		$magic = MimeMagic::singleton();

		$screenshots = array();
		if ( !empty( $screenshot ) ) {
			foreach ( $screenshot as $image ) {
				if ( !empty( $image ) ) {
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

		# send mail to wgSpecialContactEmail
		# PLATFORM-212 -> To: and From: fields are set to wgSpecialContactEmail, ReplyTo: field is the user email
		$result = UserMailer::send(
			$mail_support_service,
			$mail_support_from,
			$subject,
			$body,
			$mail_user,
			null,
			'SpecialContact',
			0,
			$screenshots
		);

		if (!$result->isOK()) {
			$errors .= "\n" . $result->getMessage();
		}

		#to user, from us (but only if the first one didnt error, dont want to echo the user on an email we didnt get)
		if ( empty( $errors ) && $this->mCCme && $user->isEmailConfirmed() ) {
			$result = UserMailer::send(
				$mail_user,
				$mail_support_from,
				$this->msg( 'specialcontact-mailsubcc' )->text(),
				$mcc,
				$mail_user,
				null,
				'SpecialContactCC'
			);
			if ( !$result->isOK() ) {
				$errors .= "\n" . $result->getMessage();
			}
		}

		if ( !empty( $errors ) ) {
			$output->addHTML( $this->formatError( $this->err ) );
		}

		/********************************************************/
		#sending done, show message

		#parse this message to allow wiki links (BugId: 1048)
		$output->addHTML( $this->msg( 'specialcontact-submitcomplete' )->parseAsBlock() );

		$mp = Title::newMainPage();
		$output->addReturnTo( $mp );

		return;
	}

	/**
	 * @access private
	 */
	function ContactFormPicker() {
		global $SpecialContactSecMap;

		$out = $this->getOutput();
		$out->setPageTitle( $this->msg( 'specialcontact-pagetitle' )->text() );

		$uskin = $this->getSkin();

		$secDat = array();

		$closeMyAccountSupported = $this->isCloseMyAccountSupported();

		foreach ( $SpecialContactSecMap as $section ) {
			if( empty($section['headerMsg']) ) {
				continue;
			}

			$newsec = array(
				'header' => $this->msg( 'specialcontact-secheader-' . $section['headerMsg'] )->escaped(),
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

				if ( $sub === 'close-account' && $closeMyAccountSupported ) {
					$title = SpecialPage::getTitleFor( 'CloseMyAccount' );
				} elseif ( $sub === 'dmca-request' ) {
					$title = GlobalTitle::newFromText( 'DMCARequest', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID );
				} else {
					$title = SpecialPage::getTitleFor( 'Contact', $sub );
				}

				$msgKey = 'specialcontact-seclink-' . $msg;
				$newsec['links'][] = $uskin->makeKnownLinkObj( $title, $this->msg( $msgKey )->escaped(), '', '', '', "class={$msgKey}" );
			}
			$secDat[] = $newsec;
		}

		$local = $this->msg( 'specialcontact-intro-main-local' )->inContentLanguage()->parse();
		if( !wfEmptyMsg('specialcontact-intro-main-local', $local) ) {
			#ok?
		}
		else {
			$local = '';
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			'head' => $this->msg( 'specialcontact-intro-main-head' )->parse(),
			'local' => $local,
			'foot' => $this->msg( 'specialcontact-intro-main-foot' )->parse(),
			'sectionData' => $secDat,
		);

		$oTmpl->set_vars( $vars );
		$out->addHTML( $oTmpl->render("picker") );

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
		global $wgServer, $wgCaptchaClass;

		$out = $this->getOutput();
		$user = $this->getUser();

		$out->setPageTitle(
			$this->msg( 'specialcontact-sectitle', $this->msg( 'specialcontact-sectitle-'.$sub )->text() )->text()
		);

		if( $user->isLoggedIn() ) {
			//user mode

			//we have user data, so use it, overriding any passed in from url
			$this->mUserName = $user->getName();
			$this->mRealName = $user->getRealName();
			$this->mEmail = $user->getEmail();

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

		$encName = Sanitizer::encodeAttribute( $this->mUserName );
		$encEmail = Sanitizer::encodeAttribute( $this->mEmail );
		$encRealName = Sanitizer::encodeAttribute( $this->mRealName );
		$encProblem = Sanitizer::encodeAttribute( $this->mProblem );
		$encProblemDesc = htmlspecialchars( $this->mProblemDesc, ENT_QUOTES );


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
			'intro' => $this->msg( 'specialcontact-intro-' . $sub )->parse(),
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
			'isLoggedIn' => $user->isLoggedIn(),
			'editToken' => $user->getEditToken(),
		);

		if( $user->isLoggedIn() ) {
			#logged in
			$vars[ 'hasEmail' ] = $user->getEmail();
			$vars[ 'hasEmailConf' ] = $user->isEmailConfirmed();
		}
		elseif (class_exists($wgCaptchaClass)) {
			#anon
			$wgCaptcha = new $wgCaptchaClass();
			$vars[ 'captchaForm' ] = $wgCaptcha->getForm();
		}

		if ( $sub === 'security' ) {
			$vars['issueTypes'] = $this->securityIssueTypes;
		}

		if( !empty( $this->err ) ) {
			$vars['err'] = $this->formatError( $this->err );
		}

		$oTmpl->set_vars( $vars );

		if( $this->secDat['form'] === true ) {
			$out->addHTML( $oTmpl->render("form") );
		} elseif ( $user->isAnon() && !empty( $this->secDat['reqlogin'] ) ) {
			$out->showErrorPage( 'loginreqtitle', 'specialcontact-error-logintext' );
			return;
		} elseif ( $this->secDat['form'] === 'rename-account' && $user->getGlobalFlag( 'wasRenamed', 0 ) ) {
			$out->showErrorPage( 'specialcontact-error-title', 'specialcontact-error-alreadyrenamed' );
			return;
		} else {
			$out->addHTML( $oTmpl->render( $this->secDat['form'] ) );
		}
		return true;
	}

	/**
	 * @access private
	 */
	function ShowNonForm( $sub = null ) {

		$out = $this->getOutput();
		$out->setPageTitle(
			$this->msg( 'specialcontact-sectitle', $this->msg( 'specialcontact-sectitle-'.$sub )->text() )->text()
		);

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' . '/' . $sub );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			'type' => $sub,
			'intro' => $this->msg( 'specialcontact-intro-' . $sub )->parse(),
			'footer' => $this->msg( 'specialcontact-noform-footer' )->parse(),
		);

		$oTmpl->set_vars( $vars );

		$out->addHTML( $oTmpl->render("noform") );

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
			$this->err[] = $this->msg( 'userlogin-error-noname' )->escaped();
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}

		// check username length
		if ( !User::isNotMaxNameChars( $userName ) ) {
			$this->err[] = $this->msg( 'usersignup-error-username-length', $wgWikiaMaxNameChars )->escaped();
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}

		// check valid username
		if ( !User::isCreatableName( $userName ) ) {
			$this->err[] = $this->msg( 'usersignup-error-symbols-in-username' )->escaped();
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
				$msg = $this->msg( 'userlogin-error-userexists' )->escaped();
			} else if ( $result === 'userlogin-bad-username-character' ) {
				$msg = $this->msg( 'usersignup-error-symbols-in-username' )->escaped();
			} else if ( $result === 'userlogin-bad-username-length' ) {
				$msg = $this->msg( 'usersignup-error-username-length', $wgWikiaMaxNameChars )->escaped();
			}

			$this->err[] = empty( $msg ) ? $result : $msg;
			$this->errInputs['wpUserNameNew'] = true;
			return false;
		}
		return true;
	}

	/**
	 * Check if the CloseMyAccount extension is enabled and supported in the
	 * current language.
	 *
	 * @return boolean True if CloseMyAccount is enabled and supported in the
	 *                 current language, false otherwise
	 */
	private function isCloseMyAccountSupported() {
		global $wgContLang, $wgEnableCloseMyAccountExt, $wgSupportedCloseMyAccountLang;
		return !empty( $wgEnableCloseMyAccountExt )
				&& in_array( $wgContLang->getCode(), $wgSupportedCloseMyAccountLang );
	}
}
