<?php
class AdSS_Controller extends SpecialPage {

	function __construct() {
		parent::__construct("AdSS");
	}

	function execute( $subpage ) {
		global $wgRequest, $wgUser, $wgOut;

		wfLoadExtensionMessages( 'AdSS' );
		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'adss-sponsor-links' ) );

		if( $subpage == 'admin' ) {
			$adminController = new AdSS_AdminController();
			$adminController->execute( $subpage );
			return;
		}

		$adForm = new AdSS_AdForm();
		if ( $wgRequest->wasPosted() && AdSS_Util::matchToken( $wgRequest->getText( 'wpToken' ) ) ) {
			$submitType = $wgRequest->getText( 'wpSubmit' );
			$adForm->loadFromRequest( $wgRequest );
			if( $wgUser->isAllowed( 'adss-admin' ) ) {
				$this->saveSpecial( $adForm );
			} else {
				$this->save( $adForm );
			}
		} elseif( ( $subpage == 'paypal/return' ) && ( $wgRequest->getSessionData( 'ecToken' ) == $wgRequest->getText( 'token' ) ) ) {
			unset( $_SESSION['ecToken'] );
			$this->processPayPalReturn( $wgRequest->getText( "token" ) );
		} elseif( $subpage == 'paypal/cancel' ) {
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
		} else {
			$page = $wgRequest->getText( 'page' );
			if( !empty( $page ) ) {
				$title = Title::newFromText( $page );
				if( $title && $title->exists() ) {
					$adForm->set( 'wpPage', $page );
				}
			}
			$adForm->set( 'wpType', 'site' );
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
		if( $wgUser->isAllowed( 'adss-admin' ) ) {
			$tmpl->set( 'submit', 'Add this ad NOW' );
		} else {
			$tmpl->set( 'submit', wfMsgHtml( 'adss-button-pay-paypal' ) );
		}
		$tmpl->set( 'token', AdSS_Util::getToken() );
		$tmpl->set( 'sitePricing', $sitePricing );
		$tmpl->set( 'pagePricing', AdSS_Util::getPagePricing( Title::newFromText( $adForm->get( 'wpPage' ) ) ) );
		$tmpl->set( 'adForm', $adForm );
		$tmpl->set( 'ad', AdSS_Ad::newFromForm( $adForm ) );
		$tmpl->set( 'currentShare', intval( $currentShare * 100 ) );

		$wgOut->addHTML( $tmpl->render( 'adForm' ) );
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/adform.scss' ) );
	}

	function save( $adForm ) {
		global $wgOut, $wgPayPalUrl;

		if( !$adForm->isValid() ) {
			$this->displayForm( $adForm );
			return;
		}

		$ad = AdSS_Ad::newFromForm( $adForm );
		if( $ad->pageId > 0 ) {
			$ad->weight = 1;
		}
		$ad->save();

		$selfUrl = $this->getTitle()->getFullURL();
		$returnUrl = $selfUrl . '/paypal/return';
		$cancelUrl = $selfUrl . '/paypal/cancel';
		$pp = new PaymentProcessor();
		$token = $pp->initialize( $ad, $returnUrl, $cancelUrl );
		if( $token ) {
			// redirect to PayPal
			$_SESSION['ecToken'] = $token;
			$wgOut->redirect( $wgPayPalUrl . $token );
		} else {
			// show error
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
		}
	}

	function saveSpecial( $adForm ) {
		global $wgOut;

		if( !$adForm->isValid() ) {
			$this->displayForm( $adForm );
			return;
		}

		$ad = AdSS_Ad::newFromForm( $adForm );
		if( $ad->pageId > 0 ) {
			$ad->weight = 1;
		}
		$ad->expires = strtotime( "+1 month", time() ); 

		$ad->save();
		AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );

		$wgOut->addHTML( "Your ad has been added to the system." );
	}

	function processPayPalReturn( $token ) {
		global $wgAdSS_templatesDir, $wgOut, $wgAdSS_contactEmail;

		$pp = new PaymentProcessor();

		$adId = $pp->getAdId( $token );
		if( !$adId ) {
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-error' ) );
			return;
		}

		$ad = AdSS_Ad::newFromId( $adId );
		if( $adId != $ad->id ) {
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-error' ) );
			return;
		}

		$baid = $pp->createBillingAgreement( $token );
		if( $baid === false ) {
			$wgOut->addHTML( wfMsgWikiHtml( 'adss-paypal-error' ) );
			return;
		}

		$wgOut->addHTML( wfMsgWikiHtml( 'adss-form-thanks' ) );

		if( !empty( $wgAdSS_contactEmail ) ) {
			$to = array();
			foreach( $wgAdSS_contactEmail as $a ) {
				$to[] = new MailAddress( $a );
			}
			//FIXME move it to a template
			$subject = '[AdSS] new ad pending approval';

			$body = "New ad has been just created and it's waiting your approval:\n";
			$body .= Title::makeTitle( NS_SPECIAL, "AdSS/admin" )->getFullURL();
			$body .= "\n\n";
			$body .= "Created by: {$ad->email}\n";
			$body .= "Ad link text: {$ad->text}\n";
			$body .= "Ad URL: {$ad->url}\n";
			$body .= "Ad description: {$ad->desc}\n";

			UserMailer::send( $to, new MailAddress( 'adss@wikia-inc.com' ), $subject, $body );
		}
	}

}
