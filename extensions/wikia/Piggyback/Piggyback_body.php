<?php

class Piggyback extends SpecialPage {
	var $mAction;

	function __construct() {
		global $wgRequest;
		parent::__construct( 'Piggyback', 'piggyback' );
		$this->mAction = $wgRequest->getVal( 'action' );
	}

	function execute( $par ){
		global $wgRequest, $wgOut, $wgUser;

		if( !$wgUser->isAllowed( 'piggyback' ) ) {
			throw new PermissionsError( 'piggyback' );
		}

		if( PBLoginForm::isPiggyback() ) {
			$wgOut->setPageTitle( wfMsg( 'badaccess' ) );
			$wgOut->addHtml( wfMsg( 'piggyback-firstlogout') );
			$wgOut->returnToMain();
			return;
		}

		if ( !empty( $par ) ) {
			$wgRequest->setVal( 'target', $par );
		}

		$this->setHeaders();
		$LoginForm = new PBLoginForm( $wgRequest );
		if( $this->mAction == 'submitlogin' && $wgRequest->wasPosted() ) {
			$LoginForm->validPiggyback();
		} else {
            $LoginForm->setDefaultTargetValue($wgRequest->getVal('target'));
        }

		$LoginForm->render();
	}
}


/*
 * overload LoginForm to not re-implement user verification
 */

class PBLoginForm extends LoginForm {
	var $mOtherName, $exTemplate, $plugin;

	function __construct( &$request ) {
		global $wgUser;

		$this->titleObj = SpecialPage::getTitleFor( 'Piggyback' );
		$this->plugin = new PiggybackTemplate();
		$this->exTemplate =  new UserloginTemplate();
		$this->exTemplate->set( 'actionlogin', $this->titleObj->getLocalUrl( 'action=submitlogin' ) );

		$this->mOtherName = $request->getVal( 'wpOtherName' );
		parent::load();

		$this->exTemplate->set("link", "");
		$this->exTemplate->set("usedomain", "");
		$this->exTemplate->set("canremember", "");
		$this->exTemplate->set("name", "");
		$this->exTemplate->set("useemail", "");
		$this->exTemplate->set( 'message', "" );

		$this->mType = "login";
		/* fake to don't change remember password */
		$this->mRemember = (bool) $wgUser->getOption( 'rememberpassword' );
	}

	function mainLoginForm( $msg, $msgtype = 'error' ) {
		$this->exTemplate->set( 'messagetype', $msgtype );
		$this->exTemplate->set( 'message', $msg );
		$this->exTemplate->set( 'name', $this->mUsername );
		$this->exTemplate->set( 'password', $this->mPassword );
		$this->plugin->set( 'otherName', $this->mOtherName );
	}

	function successfulLogin() {
		global $wgUser, $wgAuth,$wgOut,$wgRequest;

		/* post valid */
		$u = User::newFromName( $this->mOtherName );

		$cu = User::newFromName( $this->mUsername );

		if (!$cu->checkPassword( $this->mPassword )) {
			if( $retval = '' == $this->mPassword ) {
				$this->mainLoginForm( wfMsg( 'wrongpasswordempty' ) );
			} else {
				$this->mainLoginForm( wfMsg( 'wrongpassword' ) );
			}
			return ;
		}

		if ( !is_object( $u ) || $u->getId()  == 0 ) {
			$this->mainLoginForm( wfMsg( 'piggyback-nosuchuser', htmlspecialchars( $this->mOtherName ) ) );
			return ;
		}

		if ( $u->getId()  == $wgUser->getId() ) {
			$this->mainLoginForm( wfMsg( 'piggyback-itisyou') );
			return ;
		}

		$wgRequest->setSessionData( "PgParentUser", $wgUser->getID() );

		wfRunHooks( 'PiggybackLogIn',array( $wgUser, $u) );

		$log = new LogPage( 'piggyback' );
		$log->addEntry( 'piggyback', SpecialPage::getTitleFor( 'Piggyback') , "login ".$wgUser->getName()." to ".$u->getName(),  array() );

		$this->switchUser( $u );
	}

	function switchUser($u) {
		global $wgUser, $wgAuth, $wgOut, $wgRequest, $wgLang;
		$oldUserlang = $wgUser->getOption( 'language' );
		$wgAuth->updateUser( $u );
		$wgUser = $u;
		$wgUser->setCookies();

		if( $this->hasSessionCookie() || $this->mSkipCookieCheck ) {
			/* Replace the language object to provide user interface
			 * in "parent user" lenguage
			 *
			 */
			if( $this->hasSessionCookie() || $this->mSkipCookieCheck ) {
				$code = $wgRequest->getVal( 'uselang', $oldUserlang );
				$wgLang = Language::factory( $code );
			} else {
				return $this->cookieRedirectCheck( 'login' );
			}
		}

		$userpage = Title::makeTitle( NS_USER, $wgUser->getName() );
		$wgOut->redirect( $userpage->getLocalUrl() );
	}

	function validPiggyback() {
		global $wgUser;
		/* pre valid */
		$cUserId = User::idFromName( $this->mUsername );
		if( $this->mUsername != "" && $wgUser->getID() != $cUserId ) {
			$this->mainLoginForm( wfMsg( 'piggyback-wronguser', htmlspecialchars( $this->mUsername ) ) );
			return ;
		}

		if( $this->mUsername != "" && $cUserId == 0 ) {
			$this->mainLoginForm( wfMsg( 'piggyback-nosuchuser' ) );
		}

		$this->processLogin();
	}

    function setDefaultTargetValue($value){
        $this->plugin->set( 'otherName', $value );
    }

	function render() {
		global $wgOut, $wgExtensionsPath;

		if ( !LoginForm::getLoginToken() ) {
			LoginForm::setLoginToken();
		}
		$this->exTemplate->set("loginToken", LoginForm::getLoginToken());

		$this->exTemplate->set( "header", $this->plugin );
		$wgOut->addStyle( "$wgExtensionsPath/wikia/Piggyback/Piggyback.css" );
		$wgOut->addTemplate( $this->exTemplate );
	}

	static function isPiggyback() {
		global $wgRequest;
		return $wgRequest->getSessionData( "PgParentUser" ) != null;
	}

	function goToParent( $oldName ) {
		global $wgRequest;
		$u = User::newFromId( $wgRequest->getSessionData( "PgParentUser" ) );
		$log = new LogPage( 'piggyback' );
		$this->switchUser( $u );
		//$log->addEntry( 'piggyback', SpecialPage::getTitleFor( 'Piggyback' ), "logout ".$u->getName()." from ".$oldName, array() );
		$wgRequest->setSessionData( "PgParentUser" , null );
	}
}
