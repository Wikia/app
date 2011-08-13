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
	var $err, $errInputs;
	var $secDat;

	function  __construct() {
		parent::__construct( "Contact" , '' /*restriction*/);
		wfLoadExtensionMessages("ContactForm");
	}

	function execute( $par ) {
		global $wgLang, $wgAllowRealName, $wgRequest;
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		global $wgUser;

		//$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/SpecialContact/SpecialContact.css?{$wgStyleVersion}");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SpecialContact/SpecialContact.scss'));
		$this->mName = null;
		$this->mRealName = null;
		$this->mWhichWiki = null;
		$this->mProblem = $wgRequest->getText( 'wpContactSubject' ); //subject
		$this->mProblemDesc = null;
		$this->mPosted = $wgRequest->wasPosted();
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mEmail = $wgRequest->getText( 'wpEmail' );
		$this->mBrowser = $wgRequest->getText( 'wpBrowser' );
		$this->mCCme = $wgRequest->getCheck( 'wgCC' );

		if( $this->mPosted && ('submit' == $this->mAction ) ) {
			
			if( !$wgUser->isLoggedIn() ){
				$captchaObj = new FancyCaptcha();
				$captchaObj->retrieveCaptcha();
				$info = $captchaObj->retrieveCaptcha();
			}
			
			#ubrfzy note: these were moved inside to (lazy) prevent some stupid bots
			$this->mName = $wgRequest->getText( 'wpName' );
			$this->mRealName = $wgRequest->getText( 'wpContactRealName' );
			$this->mWhichWiki = $wgRequest->getText( 'wpContactWikiName' );
			#sibject still handled outside of post check, because of existing hardcoded prefill links
			$this->mProblemDesc = $wgRequest->getText( 'wpContactDesc' ); //body

			#malformed email?
			if (!User::isValidEmailAddr($this->mEmail)) {
				$this->err[].= wfMsg('invalidemailaddress');
				$this->errInputs['wpEmail'] = true;
			}

			#empty message text?
			if( empty($this->mProblemDesc) ) {
				$this->err[].= wfMsg('specialcontact-nomessage');
				$this->errInputs['wpContactDesc'] = true;
			}
			
			#captcha
			if(!$wgUser->isLoggedIn()){ // logged in users don't need the captcha (RT#139647)
				if(!( !empty($info) &&  $captchaObj->keyMatch( $wgRequest->getVal('wpCaptchaWord'), $info )))  {
					$this->err[].= wfMsg('specialcontact-captchafail');
					$this->errInputs['wpCaptchaWord'] = true; 
				}
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

		if( $this->isAuthorizedSub( $par ) ) {
			# sub was one we know about, so use it
			$this->doSub( $par );
		}
		else {
			$this->ContactFormPicker();
		}
		
	}

	/**
	 * @access private
	 */
	function processCreation() {
		global $wgUser, $wgOut, $wgCityId, $wgSpecialContactEmail;
		global $wgLanguageCode;

		// If not configured, fall back to a default just in case.
		$wgSpecialContactEmail = (empty($wgSpecialContactEmail)?"community@wikia.com":$wgSpecialContactEmail);

		$wgOut->setPageTitle( wfMsg( 'specialcontact-pagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		//build common top of both emails
		$m_shared = '';
		$m_shared .= ( !empty($this->mRealName) )?( $this->mRealName ): ( (( !empty($this->mName) )?( $this->mName ): ('--')) );
		$m_shared .= " ({$this->mEmail})";
		$m_shared .= " ". (( !empty($this->mName) ) ? $this->mWhichWiki . "/wiki/User:" . urlencode(str_replace(" ", "_", $this->mName)) : $this->mWhichWiki) . "\n";


		//start wikia debug info, sent only to the internal email, not cc'd
		$items = array();
		$items[] = 'wkID: ' . $wgCityId;
		$items[] = 'wkLang: ' . $wgLanguageCode;

		//always add the IP
		$items[] = 'IP:' . wfGetIP();
		
		//if they are logged in, add the ID(and name) and their lang
		$uid = $wgUser->getID();
		if( !empty($uid) ) {
			$items[] = 'uID: ' . $uid . " (User:". $wgUser->getName() .")";
			$items[] = 'uLang: ' . $wgUser->getOption('language');
		}

		//smush it all together
		$info = $this->mBrowser . "\n";
		$info .= implode("; ", $items) . "\n";
		//end wikia debug data

		$body = "\n{$this->mProblemDesc}\n\n----\n" . $m_shared . $info;

		if($this->mCCme) {
			$mcc = wfMsg('specialcontact-ccheader') . "\n\n";
			$mcc .= $m_shared . "\n{$this->mProblemDesc}\n";
		}

		$mail_user = new MailAddress($this->mEmail);
		$mail_community = new MailAddress($wgSpecialContactEmail, 'Wikia Support');

		$errors = '';

		#to us, from user
		$subject = wfMsg('specialcontact-mailsub') . (( !empty($this->mProblem) )? ' - ' . $this->mProblem : '');
		$error = UserMailer::send( $mail_community, $mail_user, $subject, $body, $mail_user, null, 'SpecialContact' );
		if (WikiError::isError($error)) {
			$errors .= "\n" . $error->getMessage();
		}

		#to user, from us (but only if the first one didnt error, dont want to echo the user on an email we didnt get)
		if( empty($errors) && $this->mCCme && $wgUser->isEmailConfirmed() ) {
			$error = UserMailer::send( $mail_user, $mail_community, wfMsg('specialcontact-mailsubcc'), $mcc, $mail_user, null, 'SpecialContactCC' );
			if (WikiError::isError($error)) {
				$errors .= "\n" . $error->getMessage();
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
		$wgOut->addHTML('<br/>' . wfMsg( 'returnto', $link ) );

		return;
	}
	
	/**
	 * @access private
	 */
	function ContactFormPicker() {
		global $wgOut, $wgUser, $SpecialContactSecMap;

		$wgOut->setPageTitle( wfMsg( 'specialcontact-pagetitle' ) );
		
		$uskin = $wgUser->getSkin();

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
			foreach($section['links'] as $id => $info)
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
				$newsec['links'][] = $uskin->makeKnownLinkObj( $title, wfMsg('specialcontact-seclink-' . $msg ) );
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
		$wgOut->addHTML( $oTmpl->execute("picker") );
		
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
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;
		global $wgServer, $wgSitename;

		$wgOut->setPageTitle(
			wfMsg('specialcontact-sectitle', wfMsg('specialcontact-sectitle-'.$sub))
		);

		if( $wgUser->isLoggedIn() ) {
			//user mode

			//we have user data, so use it, overriding any passed in from url
			$this->mName = $wgUser->getName();
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
				$this->mName = @$_COOKIE[$wgCookiePrefix.'UserName'];
			}

			#anon mode, no locks
			$user_readonly = false;
			$name_readonly = false;
			$mail_readonly = false;

			/* captchas only for anon */
			$captchaObj = new FancyCaptcha();
			$captcha = $captchaObj->pickImage();
			$captchaIndex = $captchaObj->storeCaptcha( $captcha );
			$titleObj = SpecialPage::getTitleFor( 'Captcha/image' );
			$captchaUrl = $titleObj->getLocalUrl( 'wpCaptchaId=' . urlencode( $captchaIndex ) );
		}

		$q = 'action=submit';

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Contact' . '/' . $sub );
		$action = $titleObj->escapeLocalUrl( $q );

		$encName = htmlspecialchars( $this->mName );
		$encEmail = htmlspecialchars( $this->mEmail );
		$encRealName = htmlspecialchars( $this->mRealName );
		$encProblem = htmlspecialchars( $this->mProblem );
		$encProblemDesc = htmlspecialchars( $this->mProblemDesc );


		//global this, for use with unlocking a field
		global $wgSpecialContactUnlockURL;
		
		# pre calc if these fields are 'errors' or not
		$eclass = array();
		$fields = array( 'wpContactWikiName', 'wpName', 'wpContactRealName',
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
		else {
			#anon
			$vars[ 'captchaUrl' ] = $captchaUrl;
			$vars[ 'captchaIndex' ] = $captchaIndex;
		}
	
		if( !empty( $this->err ) ) {
			$vars['err'] = $this->formatError( $this->err );
		}

		$oTmpl->set_vars( $vars );

		if( $this->secDat['form'] === true ) {
			$wgOut->addHTML( $oTmpl->execute("form") );
		} else {
			$wgOut->addHTML( $oTmpl->execute( $this->secDat['form'] ) );
		}
		return true;
	}
	
	/**
	 * @access private
	 */
	function ShowNonForm( $sub = null ) {
		global $wgUser, $wgOut, $wgLang;

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

		$wgOut->addHTML( $oTmpl->execute("noform") );

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

					} else {
						$this->secDat = array('link'=>$link, 'msg'=>$link, 'form'=>false);
					}
					
					return true;
				}
			}
		}
		
		return false;
	}
}
