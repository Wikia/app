<?php
if (!defined('MEDIAWIKI')) {
	die('CentralAuth');
}

/**
 * Unlisted Special page to set requisite cookies for being logged into this wiki.
 *
 * @addtogroup Extensions
 */
class SpecialAutoLogin extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct('AutoLogin');
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgMemc, $IP;

		$tempToken = $wgRequest->getVal( 'token' );
		$logout = $wgRequest->getBool( 'logout' );

		# Don't cache error messages
		$wgOut->enableClientCache( false );

		if( strlen( $tempToken ) == 0 ) {
			wfLoadExtensionMessages( 'SpecialCentralAuth' );
			$this->setHeaders();
			$wgOut->addWikiMsg( 'centralauth-autologin-desc' );
			return;
		}

		$key = CentralAuthUser::memcKey( 'login-token', $tempToken );
		$data = $wgMemc->get( $key );
		$wgMemc->delete( $key );

		if( !$data ) {
			$msg = 'Token is invalid or has expired';
			wfDebug( __METHOD__.": $msg\n" );
			wfLoadExtensionMessages( 'SpecialCentralAuth' );
			$this->setHeaders();
			$wgOut->addWikiText( $msg );
			return;
		}

		$userName = $data['userName'];
		$token = $data['token'];
		$remember = $data['remember'];

		if( $data['wiki'] != wfWikiID() ) {
			$msg = 'Bad token (wrong wiki)';
			wfDebug( __METHOD__.": $msg\n" );
			wfLoadExtensionMessages( 'SpecialCentralAuth' );
			$this->setHeaders();
			$wgOut->addWikiText( $msg );
			return;
		}

		$centralUser = new CentralAuthUser( $userName );
		$loginResult = $centralUser->authenticateWithToken( $token );

		if( $loginResult != 'ok' ) {
			$msg = "Bad token: $loginResult";
			wfDebug( __METHOD__.": $msg\n" );
			wfLoadExtensionMessages( 'SpecialCentralAuth' );
			$this->setHeaders();
			$wgOut->addWikiText( $msg );
			return;
		}

		// Auth OK.
		if ( $logout ) {
			$centralUser->deleteGlobalCookies();
		} else {
			$centralUser->setGlobalCookies( $remember );
		}

		$wgOut->disable();

		wfResetOutputBuffers();
		header( 'Cache-Control: no-cache' );
		header( 'Content-Type: image/png' );

		global $wgCentralAuthLoginIcon;
		if( $wgCentralAuthLoginIcon ) {
			readfile( $wgCentralAuthLoginIcon );
		} else {
			readfile( dirname(__FILE__).'/1x1.png' );
		}
	}
}
