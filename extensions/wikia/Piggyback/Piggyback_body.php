<?php

class Piggyback extends SpecialPage {
	var $mAction;

	function __construct() {
		global $wgRequest;
		parent::__construct( 'Piggyback', 'piggyback' );
		$this->mAction = $wgRequest->getVal( 'action' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		if ( !$wgUser->isAllowed( 'piggyback' ) ) {
			throw new PermissionsError( 'piggyback' );
		}

		if ( PBLoginForm::isPiggyback() ) {
			$wgOut->setPageTitle( wfMessage( 'badaccess' )->plain() );
			$wgOut->addHtml( wfMessage( 'piggyback-firstlogout' )->escaped() );
			$wgOut->returnToMain();

			return;
		}

		if ( !empty( $par ) ) {
			$wgRequest->setVal( 'target', $par );
		}

		$this->setHeaders();
		$LoginForm = new PBLoginForm( $wgRequest );
		if ( $this->mAction == 'submitlogin' && $wgRequest->wasPosted() ) {
			$LoginForm->validPiggyback();
		} else {
			$LoginForm->setDefaultTargetValue( $wgRequest->getVal( 'target' ) );
		}

		$LoginForm->render();
	}
}


/*
 * overload LoginForm to not re-implement user verification
 */

class PBLoginForm extends LoginForm {
	private $mOtherName = '';
	private $templateData = [];

	function __construct( &$request ) {
		global $wgUser;

		$this->titleObj = SpecialPage::getTitleFor( 'Piggyback' );

		$this->templateData['actionlogin'] = $this->titleObj->getLocalUrl( 'action=submitlogin' );

		$this->mOtherName = $request->getVal( 'wpOtherName' );
		parent::load();

		$this->mType = 'login';
		/* fake to don't change remember password */
		$this->mRemember = (bool) $wgUser->getOption( 'rememberpassword' );
	}

	function mainLoginForm( $msg, $msgtype = 'error' ) {
		$this->templateData['messagetype'] = $msgtype;
		$this->templateData['message'] = $msg;
		$this->templateData['name'] = $this->mUsername;
		$this->templateData['password'] = $this->mPassword;
		$this->templateData['otherName'] = $this->mOtherName;
	}

	function successfulLogin() {
		global $wgUser, $wgAuth, $wgOut, $wgRequest;

		/* post valid */
		$u = User::newFromName( $this->mOtherName );

		$cu = User::newFromName( $this->mUsername );

		if ( !$cu->checkPassword( $this->mPassword ) ) {
			if ( $retval = '' == $this->mPassword ) {
				$this->mainLoginForm( wfMessage( 'wrongpasswordempty' )->escaped() );
			} else {
				$this->mainLoginForm( wfMessage( 'wrongpassword' )->escaped() );
			}

			return;
		}

		if ( !is_object( $u ) || $u->getId() == 0 ) {
			$this->mainLoginForm( wfMessage( 'piggyback-nosuchuser', $this->mOtherName )->escaped() );

			return;
		}

		if ( $u->getId() == $wgUser->getId() ) {
			$this->mainLoginForm( wfMessage( 'piggyback-itisyou' )->escaped() );

			return;
		}

		$wgRequest->setSessionData( 'PgParentUser', $wgUser->getID() );

		wfRunHooks( 'PiggybackLogIn', array( $wgUser, $u ) );

		$log = new LogPage( 'piggyback' );
		$log->addEntry(
			'piggyback',
			SpecialPage::getTitleFor( 'Piggyback' ),
			"login {$wgUser->getName()}  to {$u->getName()}"
		);

		$this->switchUser( $u );
	}

	function switchUser( $u ) {
		global $wgUser, $wgAuth, $wgOut, $wgRequest, $wgLang;
		$oldUserlang = $wgUser->getOption( 'language' );
		$wgAuth->updateUser( $u );
		$wgUser = $u;
		$wgUser->setCookies();

		if ( $this->hasSessionCookie() || $this->mSkipCookieCheck ) {
			/* Replace the language object to provide user interface
			 * in "parent user" language
			 *
			 */
			if ( $this->hasSessionCookie() || $this->mSkipCookieCheck ) {
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
		if ( $this->mUsername != '' ) {
			$cUserId = User::idFromName( $this->mUsername );

			if ( $wgUser->getID() != $cUserId ) {
				$this->mainLoginForm( wfMessage( 'piggyback-wronguser', $this->mUsername )->escaped() );
				return;
			}

			if ( $cUserId == 0 ) {
				$this->mainLoginForm( wfMessage( 'piggyback-nosuchuser' )->escaped() );
			}
		}

		$this->processLogin();
	}

	function setDefaultTargetValue( $value ) {
		$this->templateData['otherName'] = $value;
	}

	function render() {
		global $wgOut, $wgExtensionsPath;

		if ( !LoginForm::getLoginToken() ) {
			LoginForm::setLoginToken();
		}
		$this->templateData['loginToken'] = LoginForm::getLoginToken();

		$wgOut->addStyle( "$wgExtensionsPath/wikia/Piggyback/Piggyback.css" );

		$html = ( new Wikia\Template\PHPEngine )
			->setData( $this->templateData )
			->render( dirname( __FILE__ ) . '/templates/Piggyback_form.php' );
		$wgOut->addHtml( $html );
	}

	static function isPiggyback() {
		global $wgRequest;

		return $wgRequest->getSessionData( 'PgParentUser' ) != null;
	}

	function goToParent( $oldName ) {
		global $wgRequest;
		$u = User::newFromId( $wgRequest->getSessionData( 'PgParentUser' ) );
		$this->switchUser( $u );
		$wgRequest->setSessionData( 'PgParentUser', null );
	}
}
