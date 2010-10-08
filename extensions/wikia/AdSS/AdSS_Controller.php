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
			$this->save( $adForm );
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
			$this->displayForm( $adForm );
		}
	}

	function displayForm( $adForm ) {
		global $wgOut, $wgUser, $wgAdSS_templatesDir;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl() );
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-pay-paypal' ) );
		$tmpl->set( 'token', AdSS_Util::getToken() );
		$tmpl->set( 'sitePricing', AdSS_Util::getSitePricing() );
		$tmpl->set( 'pagePricing', AdSS_Util::getPagePricing( Title::newFromText( $adForm->get( 'wpPage' ) ) ) );
		$tmpl->set( 'adForm', $adForm );
		$tmpl->set( 'ad', AdSS_Ad::newFromForm( $adForm ) );

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

	function processPayPalReturn( $token ) {
		global $wgAdSS_templatesDir, $wgOut;

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
	}

}
