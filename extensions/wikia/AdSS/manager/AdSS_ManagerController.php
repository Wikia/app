<?php

class AdSS_ManagerController {

	private $tabs = array( 'adList', 'billing' );
	private $selectedTab = 'adList';
	private $userId;

	function execute( $sub ) {
		global $wgRequest, $wgOut;

		if( isset( $sub[1] ) && in_array( $sub[1], $this->tabs ) ) {
			$this->selectedTab = $sub[1];
		}
		$this->userId = $wgRequest->getSessionData( "AdSS_userId" );

		if( $this->userId ) {
			$this->displayPanel();
		} else {
			$loginForm = new AdSS_ManagerLoginForm();
			if( $wgRequest->wasPosted() && AdSS_Util::matchToken( $wgRequest->getText( 'wpToken' ) ) ) {
				$loginForm->loadFromRequest( $wgRequest );
				$this->login( $loginForm );
			} else {
				$this->displayForm( $loginForm );
			}
		}
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/manager.scss' ) );
	}

	function displayTabs() {
		global $wgOut, $wgAdSS_templatesDir;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$tmpl->set( 'selfUrl', Title::makeTitle( NS_SPECIAL, "AdSS/manager" )->getLocalURL() );
		$tmpl->set( 'selectedTab', $this->selectedTab );
		$tmpl->set( 'tabs', $this->tabs );
		$wgOut->addHTML( $tmpl->render( 'tabs' ) );
	}

	function displayPanel() {
		$this->displayTabs();
		call_user_func( array( $this, 'display'.ucfirst($this->selectedTab ) ) );
	}

	function displayAdList() {
		global $wgOut, $wgAdSS_templatesDir;

		$pager = new AdSS_ManagerAdListPager( $this->userId );

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$tmpl->set( 'navigationBar', $pager->getNavigationBar() );
		$tmpl->set( 'filterForm', $pager->getFilterForm() );
		$tmpl->set( 'adList', $pager->getBody() );

		$wgOut->addHTML( $tmpl->render( 'adList' ) );
	}

	function displayBilling() {
		global $wgOut;
		$wgOut->addHTML( "Billing goes here" );
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
			$this->userId = $user->id;
			$this->displayPanel();
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
