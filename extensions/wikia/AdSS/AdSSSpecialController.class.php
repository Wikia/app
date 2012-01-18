<?php

/**
 * This is a new (Nirvana type) controller class for AdSS extension
 *
 * @author ADi
 */
class AdSSSpecialController extends WikiaSpecialPageController {

	private $paypalOptions = null;

	public function __construct() {

		// standard SpecialPage constructor call
		parent::__construct( 'AdSS', '', false );
	}

	public function init() {
		$this->paypalOptions = $this->wg->PayflowProCredentials;
		$this->paypalOptions['APIUrl'] = $this->wg->PayflowProAPIUrl;
		$this->paypalOptions['HTTPProxy'] = $this->wg->HTTPProxy;
		F::build('JSMessages')->enqueuePackage('AdSS', JSMessages::EXTERNAL);
	}

	public function index() {
		$this->setHeaders();
		$this->wg->Out->setPageTitle( wfMsg( 'adss-sponsor-links' ) );

		$sub = explode( '/', $this->request->getVal( 'par', '' ) );

		if( $sub[0] == 'admin' ) {
			$adminController = F::build('AdSS_AdminController');
			$adminController->execute( $sub );
			return false;
		}
		if( !empty( $this->wg->AdSS_OnlyAdmin ) ) {
			$this->wg->Out->setArticleRelated( false );
			$this->wg->Out->setRobotPolicy( 'noindex,nofollow' );
			$this->wg->Out->setStatusCode( 404 );
			$this->wg->Out->showErrorPage( 'nosuchspecialpage', 'nospecialpagetext' );
			return false;
		}

		if( $sub[0] == 'manager' ) {
			$managerController = F::build('AdSS_ManagerController');
			$managerController->execute( $sub );
			return false;
		}

		if ( $this->wf->ReadOnly() ) {
			$this->wg->Out->readOnlyPage();
			$this->wg->Out->addInlineScript( '$(function() { $.tracker.byStr("adss/form/view/readonly") } )' );
			return false;
		}

		// SponsoredLinks taking down: disabling everything else
		$this->wg->Out->redirect( 'http://www.wikia.com/Advertising' );
		return false;

		if( $sub[0] == 'paypal' && isset( $sub[1] ) ) {
			$this->request->setVal( 'status', $sub[1] );
			$this->forward( 'AdSSSpecial', 'processPaypalReturn' );
			return;
		}

		// default case, render form
		$this->forward( 'AdSSSpecial', 'displayForm' );
	}

	public function displayForm() {
		$adForm = new AdSS_AdForm();
		$adForm->set( 'wpType', 'site-premium' );

		$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdSS/css/adform.scss'));

		$sitePricing = AdSS_Util::getSitePricing();
		$adsCount = count( AdSS_Publisher::getSiteAds() );
		$currentShare = round( 100 / max( $sitePricing['min-slots'], $adsCount ) * intval($adsCount/100+1) );
		$ad = AdSS_AdFactory::createFromForm( $adForm );

		// @todo EasyTemplate needed for Ad rendering, refactor it
		$this->setVal( 'ad', $ad->render( F::build('EasyTemplate', array( $this->wg->AdSS_templatesDir ) ) ) );
		$this->setVal( 'action', $this->getTitle()->getLocalUrl() );
		//if( $this->wg->User->isAllowed( 'adss-admin' ) ) {
		//	$this->setVal( 'login', $this->wf->MsgHtml( 'adss-button-buy-now' ) );
		//	$this->setVal( 'isAdmin', true );
		//} else {
			$this->setVal( 'login', $this->wf->MsgHtml( 'adss-button-login-buy' ) );
			$this->setVal( 'isAdmin', false );
		//}
		$this->setVal( 'submit', $this->wf->MsgHtml( 'adss-button-pay-paypal' ) );
		$this->setVal( 'token', AdSS_Util::getToken() );
		$this->setVal( 'pagePricing', AdSS_Util::getPagePricing() );
		$this->setVal( 'sitePricing', $sitePricing );
		$this->setVal( 'hubPricing', AdSS_Util::getHubPricing() );
		$this->setVal( 'hubName', AdSS_Util::getHubName() );
		$this->setVal( 'wikiCount', AdSS_Util::getHubWikisCount( AdSS_Util::getHubId() ) );
		$this->setVal( 'adForm', $adForm );
		$this->setVal( 'currentShare', $currentShare );
		if( $this->request->getSessionData( "AdSS_userId" ) === null ) {
			$this->setVal( 'isUser', false );
		} else {
			$this->setVal( 'isUser', true );
			if( $adForm->get( "wpEmail" ) == '' ) {
				$user = AdSS_User::newFromId( $this->request->getSessionData( "AdSS_userId" ) );
				$adForm->set( "wpEmail", $user->email );
			}
		}
	}

	public function displayUpsellForm() {
		// SponsoredLinks taking down: disabling
		return false;

		$ad = $this->getVal( 'ad' );

		if( !empty( $ad ) && in_array( $ad->price['period'], array( 'd', 'w', 'm' ) ) ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdSS/css/upsell.scss') );

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

			$this->setVal( 'regularPrice', $this->wg->Lang->formatNum($regularPrice) );
			$this->setVal( 'promoPrice', $this->wg->Lang->formatNum($promoPrice) );
			$this->setVal( 'adId', $ad->id );
			$this->setVal( 'token', AdSS_Util::getToken() );
		}
		else {
			// skip rendering
			return false;
		}
	}

	public function processPaypalReturn() {
		// SponsoredLinks taking down: disabling
		return false;

		if( $this->getVal( 'status' ) == 'return' ) {
			$token = $this->getVal( 'token' );
			$ad = AdSS_AdFactory::createFromToken( $token );
			if( $ad === null ) {
				$this->setErrorResponse();
				return;
			}

			$pp = new PaypalPaymentService( $this->paypalOptions, $token );

			$payerId = $pp->fetchPayerId();
			if( $payerId === false ) {
				$this->setErrorResponse();
				return;
			}

			$user = AdSS_User::newFromPayerId( $payerId, $ad->userEmail );
			if( $user ) {
				$this->wf->Debug( "AdSS: got existing user: {$user->toString()})\n" );
				if( $user->password == '' ) {
					// generate a new password
					$password = AdSS_User::randomPassword();
					$user->password = $user->cryptPassword( $password );
					$user->save();
					$user->sendWelcomeMessage( $password );
				}
			}
			else {
				$user = AdSS_User::register( $ad->userEmail );
				$this->wf->Debug( "AdSS: created new user: {$user->toString()})\n" );
			}

			if( $user->baid ) {
				$this->wf->Debug( "AdSS: got existing BAID: {$user->baid}\n" );
			}
			else {
				$user->pp_payerId = $payerId;
				$user->baid = $pp->createBillingAgreement();

				if( $user->baid ) {
					$user->save();
					$this->wf->Debug( "AdSS: created new BAID: {$user->baid}\n" );
				}
				else {
					$this->setErrorResponse();
					return;
				}
			}

			$this->saveAdInternal( $ad, $user, "adss/form/paypal/return" );
		}
		else {
			$this->setErrorResponse();
		}
	}

	private function setErrorResponse() {
		$this->setVal( 'trackerStr', "adss/form/paypal/return/error" );
		$this->setVal( 'error', true );
		$this->setVal( 'msgKey', 'adss-paypal-error' );
	}

	public function process() {
		// SponsoredLinks taking down: disabling
		return false;

		$adForm = new AdSS_AdForm();
		if ( $this->request->wasPosted() && AdSS_Util::matchToken( $this->wg->Request->getText( 'wpToken' ) ) ) {
			$adForm->loadFromRequest( $this->wg->Request );
			$this->saveAd( $adForm );
		}
		else {
			$this->setVal('status', 'error');
			$this->setVal('info', 'Invalid token');
		}
	}

	private function saveAd( $adForm ) {
		if( !$adForm->isValid() ) {
			$this->setVal('status', 'error');
			$this->setVal('formToken', AdSS_Util::getToken());
			$this->setVal('form', $adForm);
			$this->setVal('trackerStr', "adss/form/view/errors" );
			return;
		}

		if( $this->wg->User->isAllowed( 'adss-admin' ) ) {
			$loginSubmit = wfMsgHtml( 'adss-button-buy-now' );
			$isAdmin = true;
		} else {
			$loginSubmit = wfMsgHtml( 'adss-button-login-buy' );
			$isAdmin = false;
		}

		if( $this->wg->Request->getText( 'wpSubmit' ) == $loginSubmit ) {
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
				$this->setVal('status', 'error');
				$this->setVal('formToken', AdSS_Util::getToken());
				$this->setVal('info', wfMsgHtml( 'adss-form-auth-errormsg' ) );
				$this->setVal('form', $adForm);
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
		  'name' => wfMsg( 'adss-paypal-item-type-' . $adForm->fields['wpType'] . '-name' ),
		  'cost' => $ad->price['price'],
		  'qty' => 1
		);

		$pp = new PaypalPaymentService( $this->paypalOptions );
		if( $pp->fetchToken( $returnUrl, $cancelUrl, $extraParams ) ) {
			$ad->pp_token = $pp->getToken();
			$ad->save();
			if( $ad->id > 0 ) {
				// redirect to PayPal
				$this->setVal( 'status', 'ok' );
				$this->setVal( 'paypalUrl', $this->wg->PayPalUrl . $pp->getToken() );
				$this->setVal( 'trackerStr', "adss/form/paypal/redirect/ok" );
			} else {
				// couldn't save the ad
				$this->setVal('status', 'error');
				$this->setVal('formToken', AdSS_Util::getToken());
				$this->setVal('info', wfMsgWikiHtml( 'adss-error' ) );
				$this->setVal('trackerStr', "adss/form/save/error" );
			}
		} else {
			// show PP error
			$this->setVal('status', 'error');
			$this->setVal('formToken', AdSS_Util::getToken());
			$this->setVal('info', wfMsgWikiHtml( 'adss-paypal-error' ) );
			$this->setVal('trackerStr', "adss/form/paypal/redirect/error" );
		}
	}

	private function saveAdInternal( $ad, $user, $fakeUrl ) {
		$ad->setUser( $user );
		if( $this->wg->User->isAllowed( 'adss-admin' ) ) {
			$ad->expires = strtotime( "+10 years", time() );
		}
		$ad->save();
		if( $ad->id == 0 ) {
			$this->setVal('status', 'error');
			$this->setVal('error', true );
			$this->setVal('formToken', AdSS_Util::getToken());
			$this->setVal('info', wfMsgWikiHtml( 'adss-error' ) );
			$this->setVal('trackerStr', $fakeUrl.'/error' );
			return;
		}

		$this->setVal('status', 'ok');
		$this->setVal('msgKey', 'adss-form-thanks');
		$this->setVal('trackerStr', $fakeUrl.'/ok' );

		if( $this->wg->User->isAllowed( 'adss-admin' ) ) {
			AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
		}
		else {
			$this->setVal( 'upsellForm', $this->sendSelfRequest( 'displayUpsellForm', array( 'ad' => $ad ) ) );

			$wgAdSS_contactEmail = $this->wg->AdSS_contactEmail;
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

				UserMailer::send( $to, new MailAddress( $this->wg->NoReplyAddress ), $subject, $body );
			}
		}
	}

	public function processUpsellRequest() {
		// SponsoredLinks taking down: disabling
		return false;

			$id = $this->getVal( 'id' );
			$token = $this->getVal( 'token' );

		if( wfReadOnly() || !empty( $this->wg->AdSS_ReadOnly ) ) {
			$result = 'error';
			$respmsg = $this->wf->MsgWikiHtml( 'readonlytext', wfReadOnlyReason() );
		}

		if( !AdSS_Util::matchToken( $token ) ) {
			$result = 'error';
			$respmsg = 'token mismatch';
		}
		else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( ( $ad->id != $id ) || ( $ad->closed != null ) || ( $ad->expires != null ) || ( $ad->price['period'] == 'y' ) ) {
				$rresult = 'error';
				$respmsg = 'wrong ad';
			}
			else {
				if( $ad->pageId > 0 ) {
					$title = Title::newFromID( $ad->pageId );
					if( !$title || !$title->exists() ) {
						$result = 'error';
						$respmsg = 'no such article';
					}
				}

				if( empty( $result ) ) {
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

					$result = 'success';
					$this->setVal('id', $ad->id);
				}
			}
		}

		$this->setVal( 'result', $result );
		if( !empty( $respmsg ) ) {
			$this->setVal( 'respmsg', $respmsg );
		}
	}

}