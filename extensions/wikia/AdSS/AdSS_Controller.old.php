<?php
class AdSS_Controller extends SpecialPage {

	private $paypalOptions;

	function __construct() {
		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
		$this->paypalOptions = $wgPayflowProCredentials;
		$this->paypalOptions['APIUrl'] = $wgPayflowProAPIUrl;
		$this->paypalOptions['HTTPProxy'] = $wgHTTPProxy;
		parent::__construct("AdSS");
	}

	function execute( $sub ) {
		global $wgRequest, $wgUser, $wgOut, $wgAdSS_OnlyAdmin, $wgAdSS_ReadOnly;

		wfLoadExtensionMessages( 'AdSS' );
		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'adss-sponsor-links' ) );

		$sub = explode( '/', $sub );

		if( $sub[0] == 'admin' ) {
			$adminController = new AdSS_AdminController();
			$adminController->execute( $sub );
			return;
		}
		if( !empty( $wgAdSS_OnlyAdmin ) ) {
			$wgOut->setArticleRelated( false );
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$wgOut->setStatusCode( 404 );
			$wgOut->showErrorPage( 'nosuchspecialpage', 'nospecialpagetext' );
			return;
		}

		if( $sub[0] == 'manager' ) {
			$managerController = new AdSS_ManagerController();
			$managerController->execute( $sub );
			return;
		}

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$wgOut->readOnlyPage();
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view/readonly") } )' );
			return;
		}

		if( $sub[0] == 'paypal' ) {
			if( isset( $sub[1] ) ) {
				if( $sub[1] == 'return' ) {
					$this->processPayPalReturn( $wgRequest->getText( "token" ) );
					return;
				}
				if( $sub[1] == 'cancel' ) {
					$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
					return;
				}
			}
		}

		$adForm = new AdSS_AdForm();
		if ( $wgRequest->wasPosted() && AdSS_Util::matchToken( $wgRequest->getText( 'wpToken' ) ) ) {
			$adForm->loadFromRequest( $wgRequest );
			$this->save( $adForm );
		} else {
			$adForm->set( 'wpType', 'site-premium' );
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view") } )' );
			$this->displayForm( $adForm );
		}
	}

	function displayForm( $adForm ) {
		global $wgOut, $wgAdSS_templatesDir, $wgUser, $wgRequest;

		$sitePricing = AdSS_Util::getSitePricing();

		$adsCount = count( AdSS_Publisher::getSiteAds() );
		$currentShare = round( 100 / max( $sitePricing['min-slots'], $adsCount ) * intval($adsCount/100+1) );

		$ad = AdSS_AdFactory::createFromForm( $adForm );

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'ad', $ad->render( $tmpl ) );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl( isset( $_GET['b'] ) ? 'b' : '' ) );
		if( $wgUser->isAllowed( 'adss-admin' ) ) {
			$tmpl->set( 'login', wfMsgHtml( 'adss-button-buy-now' ) );
			$tmpl->set( 'isAdmin', true );
		} else {
			$tmpl->set( 'login', wfMsgHtml( 'adss-button-login-buy' ) );
			$tmpl->set( 'isAdmin', false );
		}
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-pay-paypal' ) );
		$tmpl->set( 'token', AdSS_Util::getToken() );
		$tmpl->set( 'pagePricing', AdSS_Util::getPagePricing() );
		$tmpl->set( 'sitePricing', $sitePricing );
		$tmpl->set( 'hubPricing', AdSS_Util::getHubPricing() );
		$tmpl->set( 'hubName', AdSS_Util::getHubName() );
		$tmpl->set( 'wikiCount', AdSS_Util::getHubWikisCount( AdSS_Util::getHubId() ) );
		$tmpl->set( 'adForm', $adForm );
		$tmpl->set( 'currentShare', $currentShare );
		if( $wgRequest->getSessionData( "AdSS_userId" ) === null ) {
			$tmpl->set( 'isUser', false );
		} else {
			$tmpl->set( 'isUser', true );
			if( $adForm->get( "wpEmail" ) == '' ) {
				$user = AdSS_User::newFromId( $wgRequest->getSessionData( "AdSS_userId" ) );
				$adForm->set( "wpEmail", $user->email );
			}
		}

		$wgOut->addHTML( $tmpl->render( 'adForm' ) );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdSS/css/adform.scss'));
	}

	function displayUpsellForm( $ad ) {
		global $wgOut, $wgAdSS_templatesDir, $wgLang;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		switch( $ad->price['period'] ) {
			case 'd':
				$regularPrice = 365 * $ad->price['price'];
				break;
			case 'w':
				$regularPrice = 52 * $ad->price['price'];
				break;
			case 'm':
				$regularPrice = 12 * $ad->price['price'];
				break;
		}
		$regularPrice = round( $regularPrice / 4 );
		$promoPrice = intval( round( $regularPrice*2/3 ) );
		$tmpl->set( 'regularPrice', $wgLang->formatNum($regularPrice) );
		$tmpl->set( 'promoPrice', $wgLang->formatNum($promoPrice) );
		$tmpl->set( 'adId', $ad->id );
		$tmpl->set( 'token', AdSS_Util::getToken() );
		$wgOut->addHTML( $tmpl->render( 'upsellForm' ) );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdSS/css/upsell.scss'));
	}

	function save( $adForm ) {
		global $wgOut, $wgPayPalUrl, $wgRequest, $wgUser;

		if( !$adForm->isValid() ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view/errors") } )' );
			$this->displayForm( $adForm );
			return;
		}

		if( $wgUser->isAllowed( 'adss-admin' ) ) {
			$loginSubmit = wfMsgHtml( 'adss-button-buy-now' );
			$isAdmin = true;
		} else {
			$loginSubmit = wfMsgHtml( 'adss-button-login-buy' );
			$isAdmin = false;
		}

		if( $wgRequest->getText( 'wpSubmit' ) == $loginSubmit ) {
			$user = AdSS_User::newFromForm( $adForm );
			if( $user ) {
				if( $isAdmin ) {
					$this->saveAdInternal( AdSS_AdFactory::createFromForm( $adForm ), $user, "adss/form/save" );
					return;
				}
				if( $user->baid ) {
					$this->saveAdInternal( AdSS_AdFactory::createFromForm( $adForm ), $user, "adss/form/save" );
					return;
				}
			} else {
				$adForm->errors['wpEmail'] = wfMsgHtml( 'adss-form-auth-errormsg' );
				$this->displayForm( $adForm );
				return;
			}
		}

		$ad = AdSS_AdFactory::createFromForm( $adForm );
		$selfUrl = $this->getTitle()->getFullURL();
		$returnUrl = $selfUrl . '/paypal/return';
		$cancelUrl = $selfUrl . '/paypal/cancel';
		$extraParams = array(
		  'currency' => 'USD',
		  'items' => array()
		);
		$extraParams['items'][] = array(
		  'name' => wfMsg( 'adss-paypal-item-type-' . $ad->type . '-name' ),
		  'cost' => $ad->price['price'],
		  'qty' => 1
		);

		$pp = new PaypalPaymentService( $this->paypalOptions );
		if( $pp->fetchToken( $returnUrl, $cancelUrl, $extraParams ) ) {
			$ad->pp_token = $pp->getToken();
			$ad->save();
			if( $ad->id > 0 ) {
				// redirect to PayPal
				$wgOut->addMeta( 'http:Refresh', '0;URL=' . $wgPayPalUrl . $pp->getToken() );
				$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/redirect/ok") } )' );
				$wgOut->addHTML( wfMsgHtml( 'adss-paypal-redirect', Xml::element( 'a', array( 'href' => $wgPayPalUrl . $pp->getToken() ), wfMsg( 'adss-click-here' ) ) ) );
			} else {
				// couldn't save the ad
				$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/save/error") } )' );
				$wgOut->addHTML( wfMsgWikiHtml( 'adss-error' ) );
			}
		} else {
			// show PP error
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/redirect/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
		}
	}

	function processPayPalReturn( $token ) {
		global $wgAdSS_templatesDir, $wgOut, $wgAdSS_contactEmail, $wgUser;

		$ad = AdSS_AdFactory::createFromToken( $token );
		if( $ad === null ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-token-error' ) );
			return;
		}

		$pp = new PaypalPaymentService( $this->paypalOptions, $token );

		$payerId = $pp->fetchPayerId();
		if( $payerId === false ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
			return;
		}

		$user = AdSS_User::newFromPayerId( $payerId, $ad->userEmail );
		if( $user ) {
			wfDebug( "AdSS: got existing user: {$user->toString()})\n" );
			if( $user->password == '' ) {
				// generate a new password
				$password = AdSS_User::randomPassword();
				$user->password = $user->cryptPassword( $password );
				$user->save();
				$user->sendWelcomeMessage( $password );
			}
		} else {
			$user = AdSS_User::register( $ad->userEmail );
			wfDebug( "AdSS: created new user: {$user->toString()})\n" );
		}

		if( $user->baid ) {
			wfDebug( "AdSS: got existing BAID: {$user->baid}\n" );
		} else {
			$user->pp_payerId = $payerId;
			$user->baid = $pp->createBillingAgreement();

			if( $user->baid ) {
				$user->save();
				wfDebug( "AdSS: created new BAID: {$user->baid}\n" );
			} else {
				$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
				$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
				return;
			}
		}

		$this->saveAdInternal( $ad, $user, "adss/form/paypal/return" );
	}

	private function saveAdInternal( $ad, $user, $fakeUrl ) {
		global $wgOut, $wgAdSS_contactEmail, $wgNoReplyAddress, $wgUser;

		$ad->setUser( $user );
		if( $wgUser->isAllowed( 'adss-admin' ) ) {
			$ad->expires = strtotime( "+10 years", time() );
		}
		$ad->save();
		if( $ad->id == 0 ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("'.$fakeUrl.'/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-error' ) );
			return;
		}

		$wgOut->addInlineScript( '$(function() { $.tracker.byStr("'.$fakeUrl.'/ok") } )' );
		$wgOut->addHTML( wfMsgWikiHtml( 'adss-form-thanks' ) );

		if( $wgUser->isAllowed( 'adss-admin' ) ) {
			AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
		} else {
			$this->displayUpsellForm( $ad );

			if( !empty( $wgAdSS_contactEmail ) ) {
				$to = array();
				foreach( $wgAdSS_contactEmail as $a ) {
					$to[] = new MailAddress( $a );
				}
				//FIXME move it to a template
				$subject = '[AdSS] new ad pending approval';

				$body = "New ad has been just created and it's waiting your approval:\n";
				$body .= SpecialPage::getTitleFor( 'AdSS/admin' )->getFullURL();
				$body .= "\n\n";
				$body .= "Created by: {$ad->getUser()->toString()}\n";
				$body .= "Ad URL: http://{$ad->url}\n";
				switch( $ad->type ) {
					case 't':
						$body .= "Ad link text: {$ad->text}\n";
						$body .= "Ad description: {$ad->desc}\n";
						break;
					case 'b':
						$downloadUrl = Title::makeTitle( NS_SPECIAL, "AdSS/admin/download/".$ad->id )->getFullURL();
						$body .= "Banner: {$downloadUrl}\n";
						break;
				}

				UserMailer::send( $to, new MailAddress( $wgNoReplyAddress ), $subject, $body );
			}
		}
	}

	static function upsellAjax( $id, $token ) {
		global $wgUser, $wgAdSS_DBname, $wgAdSS_ReadOnly;

		wfLoadExtensionMessages( 'AdSS' );

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

		if( !AdSS_Util::matchToken( $token ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'token mismatch' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( ( $ad->id != $id ) || ( $ad->closed != null ) || ( $ad->expires != null ) || ( $ad->price['period'] == 'y' ) ) {
				$r = array( 'result' => 'error', 'respmsg' => 'wrong ad' );
			} else {
				if( $ad->pageId > 0 ) {
					$title = Title::newFromID( $ad->pageId );
					if( !$title || !$title->exists() ) {
						$r = array( 'result' => 'error', 'respmsg' => 'no such article' );
					}
				}

				if( empty( $r ) ) {
					switch( $ad->price['period'] ) {
						case 'd':
							$regularPrice = 365 * $ad->price['price'];
							break;
						case 'w':
							$regularPrice = 52 * $ad->price['price'];
							break;
						case 'm':
							$regularPrice = 12 * $ad->price['price'];
							break;
					}
					$regularPrice = round( $regularPrice / 4 );
					$promoPrice = intval( round( $regularPrice*2/3 ) );
					$ad->price['price'] = $promoPrice;
					$ad->price['period'] = 'q';
					$ad->save();
					AdSS_Util::commitAjaxChanges();
					$r = array(
							'result'  => 'success',
							'id'      => $ad->id,
						  );
				}
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

}
