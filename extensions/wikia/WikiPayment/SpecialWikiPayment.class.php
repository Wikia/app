<?php

/**
 * WikiPayment
 *
 * A WikiPayment extension for MediaWiki
 * Allows payment per wiki to disable ads
 *
 * @author Adrian 'ADi' Wieczorek <adi at wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-12-09
 * @copyright Copyright (C) 2010 Adrian Wieczorek, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WikiBuilder/SpecialWikiPayment.class.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named WikiPayment.\n";
	exit(1) ;
}

$dir = dirname(__FILE__).'/';
$wgExtensionMessagesFiles['WikiPayment'] = $dir.'WikiPayment.i18n.php';

$wgExtensionCredits['special'][] = array(
	'author' => array('[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'description' => 'Allows payment per wiki to disable ads.',
	'description-msg' => 'wikipayment-desc',
	'name' => 'WikiPayment'
);

class SpecialWikiPayment extends UnlistedSpecialPage {
	//used as type in user_flags table
	const USER_FLAGS_PAID_WIKI = 2;

	private $paypalService = null;

	public function __construct() {
		//wfLoadExtensionMessages('WikiBuilder');
		parent::__construct('WikiPayment', 'wikipayment');
	}

	public function execute() {
		global $wgRequest, $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages( 'WikiPayment' );
		$this->paypalService = new PaypalPaymentService( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );

		$action = $wgRequest->getVal( 'action', 'init' );
		$token = $wgRequest->getVal( 'token', null );
		$cityId = $wgRequest->getVal( 'cityId', null);

		switch( $action ) {
			case 'returnOk':
				$this->returnPayment( $token, $cityId );
				break;
			case 'returnCancel':
				$this->cancelPayment( $token );
				break;
			case 'init':
			default:
				$this->initPayment();
		}

		wfProfileOut( __METHOD__ );
	}

	private function initPayment() {
		global $wgTitle, $wgOut, $wgPayPalUrl;

		wfProfileIn( __METHOD__ );

		$success = $this->paypalService->fetchToken( $wgTitle->getFullUrl( 'action=returnOk' ), $wgTitle->getFullUrl( 'action=returnCancel' ) );

		if ( $success ) {
			$paypalUrl = $wgPayPalUrl . $this->paypalService->getToken() . "&useraction=commit";
			$wgOut->addMeta( 'http:Refresh', '0;URL=' . $paypalUrl );
			$wgOut->addInlineScript( '$(function() { $.tracker.byStr("wikipayment/paypal/redirect/ok") } )' );
			$wgOut->addHTML( wfMsgHtml( 'wikipayment-paypal-redirect', Xml::element( 'a', array( 'href' => $paypalUrl ), wfMsg( 'wikipayment-click-here' ) ) ) );
		}

		wfProfileOut( __METHOD__ );
	}

	private function returnPayment( $token, $cityId = null ) {
		global $wgOut, $wgWikiPaymentAdsFreePrice, $wgCityId;
		$cityId = empty($cityId) ? $wgCityId : $cityId;

		wfProfileIn( __METHOD__ );

		if ( !empty( $token ) ) {
			$this->paypalService->setToken( $token);
			$payerId = $this->paypalService->fetchPayerId();

			if ( $payerId === false ) {
				$wgOut->addHTML( wfMsg( 'wikipayment-paypal-error', array( 'RP01') ) );
				wfProfileOut( __METHOD__ );
				return;
			} else {
				$BAId = $this->paypalService->createBillingAgreement();

				if ( $BAId === false ) {
					$wgOut->addHTML( wfMsg( 'wikipayment-paypal-error', array( 'RP02') ) );
					wfProfileOut( __METHOD__ );
					return;
				} else {
					//$profileId = $this->paypalService->createRecurringPayment( $BAId, wfMsg( 'wikipayment-paypal-profile-name' ), $wgWikiPaymentAdsFreePrice, date( 'Y-m-d', strtotime( "+1 MONTH" ) ) );
					$paymentId = $this->paypalService->collectPayment( $BAId, $wgWikiPaymentAdsFreePrice );

					if ( $paymentId === false ) {
						$wgOut->addHTML( wfMsg( 'wikipayment-paypal-error', array( 'RP03') ) );
						wfProfileOut( __METHOD__ );
						return;
					} else {
						//disable ads
						self::toggleAds(false, $BAId, $cityId);
					}
				}
			}
			$finishCreateTitle = GlobalTitle::newFromText("FinishCreate", NS_SPECIAL, $cityId);
			$wgOut->redirect($finishCreateTitle->getFullURL());
		}
		else {
			$wgOut->addHTML( wfMsg( 'wikipayment-paypal-error', array( 'RP04') ) );
			wfProfileOut( __METHOD__ );
			return;
		}

		wfProfileOut( __METHOD__ );
	}

	private function cancelPayment( $token ) {
		global $wgOut, $wgCityId;
		wfProfileIn( __METHOD__ );
		$finishCreateTitle = GlobalTitle::newFromText("FinishCreate", NS_SPECIAL, $wgCityId);
		$wgOut->redirect($finishCreateTitle->getFullURL());
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Shows or hides ads - permanently change variable in WF DB
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function toggleAds($enable = true, $BAId = null, $cityId = null) {
		global $wgCityId, $wgShowAds, $wgUser, $wgExternalDatawareDB, $wgServer;

		wfProfileIn( __METHOD__ );
		
		$cityId = empty($cityId) ? $wgCityId : $cityId;

		if ($wgShowAds != $enable) {
			//update DB if current value is different than new one
			$result = WikiFactory::setVarByName('wgShowAds', $cityId, (bool)$enable, 'WikiPayment extension');

			//record payment in DB for further list generating of paid wikis
			if (!is_null($BAId)) {
				$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
				$dbw->replace('user_flags', null /*not used*/,
					array(
						'city_id' => $cityId,
						'user_id' => $wgUser->getID(),
						'type' => self::USER_FLAGS_PAID_WIKI,
						'data' => serialize(array('BAId' => $BAId, 'enable' => $enable, 'endDate' => date( 'Y-m-d', strtotime( "+1 MONTH" ) )))
					),
					__METHOD__
				);

				// fix for AJAX calls (TODO: needed here?)
				$dbw->commit();
			}

			//purge all pages on the wiki ... ?
			//SquidUpdate::purge( array( $wgServer ) );

			// ... or just Mainpage for now:
			$oMainPage = new Article( Title::newFromText( wfMsgForContent( 'Mainpage' ) ), NS_MAIN );
			$oMainPage->doPurge();
		} else {
			$result = true;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * check status of the list (vote/edit permissions)
	 */
	public static function fetchPaypalToken($cityId = null) {
		global $wgRequest, $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy, $wgPayPalUrl, $wgCityId;
		wfProfileIn( __METHOD__ );
		$cityId = empty($cityId) ? $wgCityId : $cityId;

		$result = array( 'url' => false );

		$paypalService = new PaypalPaymentService( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );
		$returnTitle = GlobalTitle::newFromText('WikiPayment', NS_SPECIAL, $cityId);
		
		$url = $returnTitle->getFullUrl( 'action=returnOk'.(empty($cityId) ? '' : '&cityId='.$cityId));
		$success = $paypalService->fetchToken( $url, $returnTitle->getFullUrl( 'action=returnCancel' ) );

		if ( $success ) {
			$result['url'] = $wgPayPalUrl . $paypalService->getToken() . "&useraction=commit";
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
}