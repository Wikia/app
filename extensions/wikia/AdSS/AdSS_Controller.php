<?php
class AdSS_Controller extends SpecialPage {

	function __construct() {
		parent::__construct("AdSS");
	}

	function execute( $sub ) {
		global $wgRequest, $wgUser, $wgOut;

		wfLoadExtensionMessages( 'AdSS' );
		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'adss-sponsor-links' ) );

		$sub = explode( '/', $sub );

		if( $sub[0] == 'admin' ) {
			$adminController = new AdSS_AdminController( $this );
			$adminController->execute( $sub );
			return;
		}
		if( $sub[0] == 'manager' ) {
			$managerController = new AdSS_ManagerController( $this );
			$managerController->execute( $sub );
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

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view/readonly") } )' );
			return;
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
		global $wgOut, $wgAdSS_templatesDir, $wgUser;

		$sitePricing = AdSS_Util::getSitePricing();

		$adsCount = count( AdSS_Publisher::getSiteAds() );
		if( $adsCount > 0 ) {
			$currentShare = min( $sitePricing['max-share'], 1/$adsCount );
		} else {
			$currentShare = $sitePricing['max-share'];
		}

		$ad = AdSS_AdFactory::createFromForm( $adForm );

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'ad', $ad->render( $tmpl ) );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl() );
		$tmpl->set( 'login', wfMsgHtml( 'adss-button-login-buy' ) );
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-pay-paypal' ) );
		$tmpl->set( 'token', AdSS_Util::getToken() );
		$tmpl->set( 'sitePricing', $sitePricing );
		$tmpl->set( 'bannerPricing', AdSS_Util::getBannerPricing() );
		$tmpl->set( 'adForm', $adForm );
		$tmpl->set( 'currentShare', intval( $currentShare * 100 ) );

		$wgOut->addHTML( $tmpl->render( 'adForm' ) );
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/adform.scss' ) );
	}

	function save( $adForm ) {
		global $wgOut, $wgPayPalUrl, $wgRequest, $wgUser;

		if( !$adForm->isValid() ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view/errors") } )' );
			$this->displayForm( $adForm );
			return;
		}

		if( $wgRequest->getText( 'wpSubmit' ) == wfMsgHtml( 'adss-button-login-buy' ) ) {
			$user = AdSS_User::newFromForm( $adForm );
			if( $user ) {
				if( $wgUser->isAllowed( 'adss-admin' ) ) {
					$this->saveAdInternal( AdSS_AdFactory::createFromForm( $adForm ), $user, "adss/form/save" );
					return;
				}
				$pp = PaymentProcessor::newFromUserId( $user->id );
				if( $pp && $pp->getBillingAgreement() ) {
					$this->saveAdInternal( AdSS_AdFactory::createFromForm( $adForm ), $user, "adss/form/save" );
					return;
				}
			} else {
				$adForm->errors['wpEmail'] = wfMsgHtml( 'adss-form-auth-errormsg' );
				$this->displayForm( $adForm );
				return;
			}
		}

		$selfUrl = $this->getTitle()->getFullURL();
		$returnUrl = $selfUrl . '/paypal/return';
		$cancelUrl = $selfUrl . '/paypal/cancel';
		$pp = new PaymentProcessor();
		if( $pp->fetchToken( $returnUrl, $cancelUrl ) ) {
			$ad = AdSS_AdFactory::createFromForm( $adForm );
			$ad->save();
			if( $ad->id > 0 ) {
				$pp->setAdId( $ad->id );
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

		$pp_new = new PaymentProcessor( $token );

		$ad = null;
		$adId = $pp_new->getAdId();
		if( $adId ) {
			$ad = AdSS_AdFactory::createFromId( $adId );
		}
		if( $ad === null ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-token-error' ) );
			return;
		}

		$payerId = $pp_new->fetchPayerId();
		if( $payerId === false ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
			return;
		}

		$baid = false;
		$pp_existing = PaymentProcessor::newFromPayerId( $payerId, $ad->userEmail );
		if( $pp_existing ) {
			$user = AdSS_User::newFromId( $pp_existing->getUserId() );
			wfDebug( "AdSS: got existing user: {$user->toString()})\n" );
			if( $user->password == '' ) {
				// generate a new password
				$password = AdSS_User::randomPassword();
				$user->password = $user->cryptPassword( $password );
				$user->save();
				$user->sendWelcomeMessage( $password );
			}

			$baid = $pp_existing->getBillingAgreement();
			if( $baid ) wfDebug( "AdSS: got existing BAID: $baid\n" );
		} else {
			$user = AdSS_User::register( $ad->userEmail );
			wfDebug( "AdSS: created new user: {$user->toString()})\n" );
		}
		$pp_new->setUserId( $user->id );

		if( $baid === false ) {
			$baid = $pp_new->createBillingAgreement();
			wfDebug( "AdSS: created new BAID: $baid\n" );
		}
		if( $baid === false ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
			return;
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
		} elseif( !empty( $wgAdSS_contactEmail ) ) {
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
			$body .= "Ad link text: {$ad->text}\n";
			$body .= "Ad URL: http://{$ad->url}\n";
			$body .= "Ad description: {$ad->desc}\n";

			UserMailer::send( $to, new MailAddress( $wgNoReplyAddress ), $subject, $body );
		}
	}

}
