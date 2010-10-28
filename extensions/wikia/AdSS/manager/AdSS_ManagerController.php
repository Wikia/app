<?php

class AdSS_ManagerController {

	function execute( $subpage ) {
		global $wgRequest;

		$userId = $wgRequest->getSessionData( "AdSS_userId" );
		if( $userId ) {
			$this->displayAds( $userId );
		} else {
			$loginForm = new AdSS_ManagerLoginForm();
			if( $wgRequest->wasPosted() && AdSS_Util::matchToken( $wgRequest->getText( 'wpToken' ) ) ) {
				$loginForm->loadFromRequest( $wgRequest );
				$this->login( $loginForm );
			} else {
				$this->displayForm( $loginForm );
			}
		}
	}

	function displayAds( $userId ) {
		global $wgOut, $wgAdSS_templatesDir;

		$pager = new AdSS_ManagerPager( $userId );

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$tmpl->set( 'navigationBar', $pager->getNavigationBar() );
		$tmpl->set( 'filterForm', $pager->getFilterForm() );
		$tmpl->set( 'adList', $pager->getBody() );

		$wgOut->addHTML( $tmpl->render( 'adList' ) );
	}

	function displayForm( $loginForm ) {
		global $wgOut, $wgAdSS_templatesDir;

		AdSS_Util::generateToken();
		$token = AdSS_Util::getToken();

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$tmpl->set( 'action', Title::makeTitle( NS_SPECIAL, "AdSS/manager" )->getLocalURL() );
		$tmpl->set( 'token', $token );
		$tmpl->set( 'form', $loginForm );
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-login' ) );

		$wgOut->addHTML( $tmpl->render( 'loginForm' ) );
	}

	function login( $loginForm ) {
		global $wgRequest;

		if( !$loginForm->isValid() ) {
			$this->displayForm( $loginForm );
			return;
		}

		$user = AdSS_User::newFromForm( $loginForm );
		if( $user ) {
			$wgRequest->setSessionData( "AdSS_userId", $user->id );
			$this->displayAds( $user->id );
		} else {
			$loginForm->errors['wpEmail'] = wfMsgHtml( 'adss-form-auth-errormsg' );
			$this->displayForm( $loginForm );
		}
	}

	static function closeAdAjax( $id ) {
		global $wgRequest;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		$userId = $wgRequest->getSessionData( "AdSS_userId" );
		if( !$userId ) {
			$r = array( 'result' => 'error', 'respmsg' => 'You must be logged-in' );
		} else {
			$ad = AdSS_Ad::newFromId( $id );
			if( $id != $ad->id ) {
				$r = array( 'result' => 'error', 'respmsg' => 'wrong id' );
			} else {
				if( $userId != $ad->userId ) {
					$r = array( 'result' => 'error', 'respmsg' => 'no permission' );
				} else {
					$ad->close();

					AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
					AdSS_Util::commitAjaxChanges();
					$r = array(
							'result' => 'success',
							'id'     => $id,
							'closed' => wfTimestamp( TS_DB, $ad->closed ),
						  );
				}
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}
}
