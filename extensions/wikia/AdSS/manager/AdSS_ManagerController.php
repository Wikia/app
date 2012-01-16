<?php

class AdSS_ManagerController {

	private $tabs = array( 'adList', 'billing' );
	private $selectedTab = 'adList';
	private $userId;
	private $paypalOptions;

	function __construct() {
		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
		$this->paypalOptions = $wgPayflowProCredentials;
		$this->paypalOptions['APIUrl'] = $wgPayflowProAPIUrl;
		$this->paypalOptions['HTTPProxy'] = $wgHTTPProxy;
	}

	function execute( $sub ) {
		global $wgRequest, $wgOut, $wgAdSS_ReadOnly;

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdSS/css/manager.scss'));

		if( isset( $sub[1] ) && in_array( $sub[1], $this->tabs ) ) {
			$this->selectedTab = $sub[1];
		}
		$this->userId = $wgRequest->getSessionData( "AdSS_userId" );

		if( $this->userId ) {
			if( isset( $sub[1] ) && ( $sub[1] == 'paypal' ) ) {
				if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
					$wgOut->readOnlyPage();
					$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view/readonly") } )' );
					return;
				}
				if( isset( $sub[2] ) ) {
					switch( $sub[2] ) {
						case 'redirect':
							$this->processPayPalRedirect( $wgRequest->getText( "wpToken" ) );
							return;
						case 'return':
							$this->processPayPalReturn( $wgRequest->getText( "token" ) );
							return;
						case 'cancel':
							$this->processPayPalCancel( $wgRequest->getText( "wpToken" ) );
							return;
						case 'error':
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
		$tmpl->set( 'buyUrl', Title::makeTitle( NS_SPECIAL, "AdSS" )->getLocalURL( ) );

		$wgOut->addHTML( $tmpl->render( 'adList' ) );
	}

	function displayBilling() {
		global $wgOut, $wgAdSS_templatesDir, $wgJsMimeType, $wgAdSS_DBname, $wgLang, $wgAdSS_ReadOnly;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
		$pager = new AdSS_ManagerBillingPager( $this->userId );
		$user = AdSS_User::newFromId( $this->userId );

		if( $user->baid ) {
			if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
				$baid = $user->baid;
			} else {
				$tmpl->set( 'action', Title::makeTitle( NS_SPECIAL, "AdSS/manager/paypal/cancel" )->getLocalURL() );
				$tmpl->set( 'token', AdSS_Util::getToken() );
				$baid = $user->baid . $tmpl->render( 'cancelBA' );
			}
		} else {
			// no BAID
			if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
				$baid = '';
			} else {
				$tmpl->set( 'action', Title::makeTitle( NS_SPECIAL, "AdSS/manager/paypal/redirect" )->getLocalURL() );
				$tmpl->set( 'token', AdSS_Util::getToken() );
				$tmpl->set( 'button', $tmpl->render( 'createBA' ) );
				$baid = $tmpl->render( 'noBA' );
			}
		}

		$balance = - $wgLang->formatNum( $user->getBillingBalance() );

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

	function processPayPalRedirect( $token ) {
		global $wgOut, $wgPayPalUrl;

		if( AdSS_Util::matchToken( $token ) ) {
			$selfUrl = Title::makeTitle( NS_SPECIAL, "AdSS/manager" )->getFullURL();
			$returnUrl = $selfUrl . '/paypal/return';
			$cancelUrl = $selfUrl . '/paypal/error';
			$pp = new PaypalPaymentService( $this->paypalOptions );
			if( $pp->fetchToken( $returnUrl, $cancelUrl ) ) {
				$_SESSION['wsAdSSToken'] = $pp->getToken();
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
			$pp = new PaypalPaymentService( $this->paypalOptions, $token );
			if( AdSS_Util::matchToken( $token ) ) {
				$payerId = $pp->fetchPayerId();
				$baid = $pp->createBillingAgreement();
			} else {
				list( $host, $lag ) = wfGetLB( $wgAdSS_DBname )->getMaxLag();
				sleep( $lag );
				$payerId = $pp->fetchPayerId();
				$baid = $pp->getBillingAgreement();
			}
			if( $payerId && $baid ) {
				$user = AdSS_User::newFromId( $this->userId );
				$user->pp_payerId = $payerId;
				$user->baid = $baid;
				$user->save();
				$wgOut->addHTML( wfMsgWikiHtml( 'adss-billing-agreement-created', $baid ) );
				return;
			} else {
				$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
				return;
			}
		}
		$this->displayPanel();
	}

	function processPayPalCancel( $token ) {
		global $wgOut;
		if( AdSS_Util::matchToken( $token ) ) {
			$user = AdSS_User::newFromId( $this->userId );
			if( $user->baid ) {
				$pp = new PaypalPaymentService( $this->paypalOptions );
				// first check if a user owes us anything
				$balance = $user->getBillingBalance();
				if( $balance < 0 ) {
					// try to clear his balance
					$pmt_id = $pp->collectPayment( $user->baid, -$balance );
					if( $pmt_id ) {
						$billing = new AdSS_Billing();
						$billing->addPayment( $user->id, $pmt_id, -$balance );
					} else {
						$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
						return;
					}
				}
				// now we can cancel the billing agreement
				if( $pp->cancelBillingAgreement( $user->baid ) ) {
					$user->baid = null;
					$user->save();
					$wgOut->addHTML( wfMsgWikiHtml( 'adss-billing-agreement-canceled' ) );
					return;
				} else {
					$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
					return;
				}
			}
		}
		$this->displayPanel();
	}

	static function closeAdAjax( $id ) {
		global $wgRequest, $wgAdSS_ReadOnly;

		wfLoadExtensionMessages( 'AdSS' );

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

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

					global $wgAdSS_contactEmail, $wgNoReplyAddress;
					if( $ad->type == 'b' && !empty( $wgAdSS_contactEmail ) ) {
						$to = array();
						foreach( $wgAdSS_contactEmail as $a ) {
							$to[] = new MailAddress( $a );
						}
						//FIXME move it to a template
						$subject = '[AdSS] banner ad canceled';

						$body = "The banner ad has been just canceled by user.\n";
						$body .= "\n";
						$body .= "ID: {$ad->id}\n";
						$body .= "Created by: {$ad->getUser()->toString()}\n";
						$body .= "Ad URL: http://{$ad->url}\n";
						$body .= "Banner: ".Title::makeTitle( NS_SPECIAL, "AdSS/admin/download/".$ad->id )->getFullURL()."\n";
						UserMailer::send( $to, new MailAddress( $wgNoReplyAddress ), $subject, $body );
					}
				}
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

	static function getAdAjax( $id ) {
		global $wgUser, $wgRequest;

		wfLoadExtensionMessages( 'AdSS' );

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
					$r = array( 'result' => 'success', 'ad' => $ad );
				}
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

	static function editAdAjax( $id, $url, $text, $desc ) {
		global $wgUser, $wgRequest, $wgAdSS_ReadOnly;

		wfLoadExtensionMessages( 'AdSS' );

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

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
				} elseif( $ad->type != 't' ) {
					$r = array( 'result' => 'error', 'respmsg' => 'you can edit only text ads' );
				} else {
					$adc = new AdSS_AdChange( $ad );
					$adc->url = $url;
					$adc->text = $text;
					$adc->desc = $desc;
					$adc->save();

					global $wgNoReplyAddress, $wgAdSS_contactEmail;
					if( !empty( $wgAdSS_contactEmail ) ) {
						$to = array();
						foreach( $wgAdSS_contactEmail as $a ) {
							$to[] = new MailAddress( $a );
						}

						//FIXME move it to a template
						$subject = '[AdSS] ad change request';

						$body = "User {$ad->getUser()->toString()} requested a change in the ad:\n";
						$body .= "\n";
						if( $ad->url != $adc->url ) {
							$body .= "Old Ad URL: http://{$ad->url}\n";
							$body .= "*New Ad URL: http://{$adc->url}\n";
						} else {
							$body .= "Ad URL: http://{$ad->url}\n";
						}
						if( $ad->text != $adc->text ) {
							$body .= "\nOld Ad link text: {$ad->text}\n";
							$body .= "*New Ad link text: {$adc->text}\n";
						} else {
							$body .= "\nAd link text: {$ad->text}\n";
						}
						if( $ad->desc != $adc->desc ) {
							$body .= "\nOld Ad description: {$ad->desc}\n";
							$body .= "*New Ad description: {$adc->desc}\n";
						} else {
							$body .= "\nAd description: {$ad->desc}\n";
						}
						$body .= "\nYou can approve or reject these changes here:\n";
						$body .= SpecialPage::getTitleFor( 'AdSS/admin/adList' )->getFullURL( 'filter=changes' );

						UserMailer::send( $to, new MailAddress( $wgNoReplyAddress ), $subject, $body );
					}

					AdSS_Util::commitAjaxChanges();

					$r = array(
						'result'  => 'success',
						'id'      => $id,
						'respmsg' => wfMsgHtml( 'adss-edit-thanks' ),
					);
				}
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}
}
