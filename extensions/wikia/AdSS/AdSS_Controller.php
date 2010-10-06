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
		if ( $wgRequest->wasPosted() && $adForm->matchToken( $wgRequest->getText( 'wpToken' ) ) ) {
			$submitType = $wgRequest->getText( 'wpSubmit' );
			$adForm->loadFromRequest( $wgRequest );
			switch( $submitType ) {
				case wfMsg( 'adss-button-preview' ):
					$this->preview( $adForm );
					break;
				case wfMsg( 'adss-button-edit' ):
					$this->edit( $adForm );
					break;
				case wfMsg( 'adss-button-save-pay' ):
					$this->save( $adForm );
					break;
			}
		} elseif( ( $subpage == 'paypal/return' ) && ( $wgRequest->getSessionData( 'ecToken' ) == $wgRequest->getText( 'token' ) ) ) {
			unset( $_SESSION['ecToken'] );
			$this->processPayPalReturn( $wgRequest->getText( "token" ) );
		} else {
			$this->displayForm( $adForm );
		}
	}

	function displayForm( $adForm ) {
		global $wgOut, $wgUser, $wgAdSS_templatesDir;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl() );
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-preview' ) );
		$tmpl->set( 'token', $adForm->getToken() );
		$tmpl->set( 'priceConf', AdSS_Util::getPriceConf( Title::newFromText( $adForm->get( 'wpPage' ) ) ) );
		$tmpl->set( 'ad', $adForm );

		$wgOut->addHTML( $tmpl->render( 'adForm' ) );
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/adform.scss' ) );
	}

	function preview( $adForm ) {
		global $wgOut, $wgUser, $wgAdPrice, $wgRequest, $wgAdSS_templatesDir;

		if( !$adForm->isValid() ) {
			$this->edit( $adForm );
			return;
		}

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl() );
		$tmpl->set( 'submit_edit', wfMsgHtml( 'adss-button-edit' ) );
		$tmpl->set( 'submit_save', wfMsgHtml( 'adss-button-save-pay' ) );
		$tmpl->set( 'token', $adForm->getToken() );
		$tmpl->set( 'type', $adForm->get( 'wpType' ) );
		$title = Title::newFromText( $adForm->get( 'wpPage' ) );
		$tmpl->set( 'title', $title );
		$tmpl->set( 'priceConf', AdSS_Util::getPriceConf( $title ) );
		$tmpl->set( 'ad', AdSS_Ad::newFromForm( $adForm ) );

		$wgOut->addHTML( $tmpl->render( 'adPreview' ) );
	}

	function edit( $adForm ) {
		global $wgOut, $wgUser, $wgAdPrice, $wgRequest, $wgAdSS_templatesDir;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'action', $this->getTitle()->getLocalUrl() );
		$tmpl->set( 'submit', wfMsgHtml( 'adss-button-preview' ) );
		$tmpl->set( 'token', $adForm->getToken() );
		$tmpl->set( 'priceConf', AdSS_Util::getPriceConf( Title::newFromText( $adForm->get( 'wpPage' ) ) ) );
		$tmpl->set( 'ad', $adForm );

		$wgOut->addHTML( $tmpl->render( 'adForm' ) );
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/adform.scss' ) );
	}

	function save( $adForm ) {
		global $wgOut, $wgPayPalUrl;

		if( !$adForm->isValid() ) {
			$this->edit( $adForm );
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
			$wgOut->addHTML( wfMsgHtml( 'adss-paypal-error' ) );
		}
	}

	function processPayPalReturn( $token ) {
		global $wgAdSS_templatesDir, $wgOut;

		$pp = new PaymentProcessor();

		$adId = $pp->getAdId( $token );
		if( !$adId ) {
			$wgOut->addHTML( wfMsgHtml( 'adss-error' ) );
			return;
		}

		$ad = AdSS_Ad::newFromId( $adId );
		if( $adId != $ad->id ) {
			$wgOut->addHTML( wfMsgHtml( 'adss-error' ) );
			return;
		}

		$baid = $pp->createBillingAgreement( $token );
		if( $baid === false ) {
			$wgOut->addHTML( wfMsgHtml( 'adss-paypal-error' ) );
			return;
		}

		$wgOut->addHTML( wfMsgHtml( 'adss-form-thanks' ) );

		/*
		$priceConf = AdSS_Util::getPriceConf( Title::newFromID( $ad->pageId ) );

		if( $pp->collectPayment( $baid, $priceConf['price'] ) ) {
			$ad->refresh( $priceConf );

			$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
			$wgOut->addHTML( wfMsgHtml( 'adss-ad-purchased' ) );
			//FIXME make purge a bit smarter
			AdSS_Util::flushCache();
		} else {
			$wgOut->addHTML( wfMsgHtml( 'adss-paypal-error' ) );
		}
		*/
	}

}
