<?php

class AdSS_ManagerController {

	private $tabs = array( 'adList', 'billing' );
	private $selectedTab = 'adList';
	private $userId;

	function execute( $sub ) {
		global $wgRequest, $wgOut;

		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/manager.scss' ) );

		if( isset( $sub[1] ) && in_array( $sub[1], $this->tabs ) ) {
			$this->selectedTab = $sub[1];
		}
		$this->userId = $wgRequest->getSessionData( "AdSS_userId" );

		if( $this->userId ) {
			if( isset( $sub[1] ) && ( $sub[1] == 'paypal' ) ) {
				if( isset( $sub[2] ) ) {
					switch( $sub[2] ) {
						case 'redirect':
							$this->processPayPalRedirect( $wgRequest->getText( "wpToken" ) );
							return;
						case 'return':
							$this->processPayPalReturn( $wgRequest->getText( "token" ) );
							return;
						case 'cancel':
							$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
							return;
					}
				}	
			}
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
	}

	function displayPanel() {
		$this->displayTabs();
		call_user_func( array( $this, 'display' . ucfirst( $this->selectedTab ) ) );
	}

	function displayTabs() {
		global $wgOut, $wgAdSS_templatesDir;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$tmpl->set( 'selfUrl', Title::makeTitle( NS_SPECIAL, "AdSS/manager" )->getLocalURL() );
		$tmpl->set( 'selectedTab', $this->selectedTab );
		$tmpl->set( 'tabs', $this->tabs );
		$wgOut->addHTML( $tmpl->render( 'tabs' ) );
	}

	function displayAdList() {
		global $wgOut, $wgAdSS_templatesDir;

		$pager = new AdSS_ManagerAdListPager( $this->userId );

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$tmpl->set( 'adList', $pager->getBody() );

		$wgOut->addHTML( $tmpl->render( 'adList' ) );
	}

	function displayBilling() {
		global $wgOut, $wgAdSS_templatesDir, $wgJsMimeType, $wgAdSS_DBname, $wgLang;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );

		$pager = new AdSS_ManagerBillingPager( $this->userId );

		$baid = null;
		$pp = PaymentProcessor::newFromUserId( $this->userId );
		if( $pp ) $baid = $pp->getBillingAgreement();
		if( !$baid ) {
			$tmpl->set( 'action', Title::makeTitle( NS_SPECIAL, "AdSS/manager/paypal/redirect" )->getLocalURL() );
			$tmpl->set( 'token', AdSS_Util::getToken() );
			$tmpl->set( 'button', $tmpl->render( 'createBA' ) );
			$baid = $tmpl->render( 'noBA' );
		}

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$balance = $dbr->selectField( 'billing', 'sum(billing_amount)', array( 'billing_user_id' => $this->userId ), __METHOD__ );
		$balance = - $wgLang->formatNum( $balance );

		$tmpl->set( 'navigationBar', $pager->getNavigationBar() );
		$tmpl->set( 'billing', $pager->getBody() );
		$tmpl->set( 'baid', $baid );
		$tmpl->set( 'balance', $balance );

		$wgOut->addHTML( $tmpl->render( 'billing' ) );
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
			$r = array( 'result' => 'error', 'respmsg' => wfMsgHtml( 'adss-not-logged-in' ) );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id != $ad->id ) {
				$r = array( 'result' => 'error', 'respmsg' => wfMsgHtml( 'adss-wrong-id' ) );
			} else {
				if( $userId != $ad->userId ) {
					$r = array( 'result' => 'error', 'respmsg' => wfMsgHtml( 'adss-no-permission' ) );
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

	function processPayPalRedirect( $token ) {
		global $wgOut, $wgPayPalUrl;

		if( AdSS_Util::matchToken( $token ) ) {
			$selfUrl = Title::makeTitle( NS_SPECIAL, "AdSS/manager" )->getFullURL();
			$returnUrl = $selfUrl . '/paypal/return';
			$cancelUrl = $selfUrl . '/paypal/cancel';
			$pp = new PaymentProcessor();
			if( $pp->fetchToken( $returnUrl, $cancelUrl ) ) {
				$_SESSION['wsAdSSToken'] = $pp->getToken();
				$pp->setUserId( $this->userId );
				// redirect to PayPal
				$wgOut->addMeta( 'http:Refresh', '0;URL=' . $wgPayPalUrl . $pp->getToken() );
				$wgOut->addHTML( wfMsgHtml( 'adss-paypal-redirect', Xml::element( 'a', array( 'href' => $wgPayPalUrl . $pp->getToken() ), wfMsg( 'adss-click-here' ) ) ) );
				return;
			}
		}
		$this->displayPanel();
	}

	function processPayPalReturn( $token ) {
		global $wgOut, $wgAdSS_DBname;
		if( $token ) {
			$pp = new PaymentProcessor( $token );
			if( AdSS_Util::matchToken( $token ) ) {
				$baid = $pp->createBillingAgreement();
			} else {
				list( $host, $lag ) = wfGetLB( $wgAdSS_DBname )->getMaxLag();
				sleep( $lag );
				$baid = $pp->getBillingAgreement();
			}
			if( $baid ) {
				$wgOut->addHTML( wfMsgWikiHtml( 'adss-billing-agreement-created', $baid ) );
				return;
			} else {
				$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
				return;
			}
		}
		$this->displayPanel();
	}
}
