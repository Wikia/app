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
			$page = $wgRequest->getText( 'page' );
			if( !empty( $page ) ) {
				$title = Title::newFromText( $page );
				if( $title && $title->exists() ) {
					$adForm->set( 'wpPage', $page );
				}
			}
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

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl() );
		$tmpl->set( 'login', wfMsgHtml( 'adss-button-login-buy' ) );
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-pay-paypal' ) );
		$tmpl->set( 'token', AdSS_Util::getToken() );
		$tmpl->set( 'sitePricing', $sitePricing );
		$tmpl->set( 'pagePricing', AdSS_Util::getPagePricing( Title::newFromText( $adForm->get( 'wpPage' ) ) ) );
		$tmpl->set( 'adForm', $adForm );
		$tmpl->set( 'ad', AdSS_AdFactory::createFromForm( $adForm ) );
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
					$this->saveAdInternal( $adForm, $user, "adss/form/save" );
					return;
				}
				$pp = PaymentProcessor::newFromUserId( $user->id );
				if( $pp && $pp->getBillingAgreement() ) {
					$this->saveAdInternal( $adForm, $user, "adss/form/save" );
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
			// redirect to PayPal
			$_SESSION['ecToken'] = $pp->getToken();
			$_SESSION['AdSS_adForm'] = $adForm;
			$wgOut->addMeta( 'http:Refresh', '0;URL=' . $wgPayPalUrl . $pp->getToken() );
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/redirect/ok") } )' );
			$wgOut->addHTML( wfMsgHtml( 'adss-paypal-redirect', Xml::element( 'a', array( 'href' => $wgPayPalUrl . $pp->getToken() ), wfMsg( 'adss-click-here' ) ) ) );
		} else {
			// show error
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/redirect/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
		}
	}

	function processPayPalReturn( $token ) {
		global $wgAdSS_templatesDir, $wgOut, $wgAdSS_contactEmail, $wgUser;

		if( empty( $_SESSION['ecToken'] ) || ( $_SESSION['ecToken'] != $token ) ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-token-error' ) );
			return;
		}
		unset( $_SESSION['ecToken'] );
		$adForm = $_SESSION['AdSS_adForm'];

		$pp_new = new PaymentProcessor( $token );

		$payerId = $pp_new->fetchPayerId();
		if( $payerId === false ) {
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("adss/form/paypal/return/error") } )' );
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
			return;
		}

		$baid = false;
		$pp_existing = PaymentProcessor::newFromPayerId( $payerId, $adForm->get( 'wpEmail' ) );
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
			$user = AdSS_User::register( $adForm->get( 'wpEmail' ) );
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

		$this->saveAdInternal( $adForm, $user, "adss/form/paypal/return" );
	}

	private function saveAdInternal( $adForm, $user, $fakeUrl ) {
		global $wgOut, $wgAdSS_contactEmail, $wgNoReplyAddress, $wgUser;

		$ad = AdSS_AdFactory::createFromForm( $adForm );
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
			$body .= "Ad URL: {$ad->url}\n";
			$body .= "Ad description: {$ad->desc}\n";

			UserMailer::send( $to, new MailAddress( $wgNoReplyAddress ), $subject, $body );
		}
	}

}
