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

		switch( $action ) {
			case 'returnOk':
				$this->returnPayment( $token );
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

	private function returnPayment( $token ) {
		global $wgOut, $wgWikiPaymentAdsFreePrice;

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
						self::toggleAds(false, $BAId);
					}
				}
			}
			$wgOut->addHTML( wfMsg( 'wikipayment-paypal-return-ok' ) );
		}
		else {
			$wgOut->addHTML( wfMsg( 'wikipayment-paypal-error', array( 'RP04') ) );
			wfProfileOut( __METHOD__ );
			return;
		}

		wfProfileOut( __METHOD__ );
	}

	private function cancelPayment( $token ) {
		global $wgOut;
		wfProfileIn( __METHOD__ );

		$wgOut->addHTML( wfMsg( 'wikipayment-paypal-return-cancel' ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Shows or hides ads - permanently change variable in WF DB
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function toggleAds($enable = true, $BAId = null) {
		global $wgCityId, $wgShowAds, $wgUser, $wgExternalDatawareDB;

		wfProfileIn( __METHOD__ );

		if ($wgShowAds != $enable) {
			//update DB if current value is different than new one
			$result = WikiFactory::setVarByName('wgShowAds', $wgCityId, (bool)$enable, 'WikiPayment extension');

			//record payment in DB for further list generating of paid wikis
			if (!is_null($BAId)) {
				$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
				$dbw->replace('user_flags', null /*not used*/,
					array(
						'city_id' => $wgCityId,
						'user_id' => $wgUser->getID(),
						'type' => self::USER_FLAGS_PAID_WIKI,
						'data' => serialize(array('BAId' => $BAId, 'enable' => $enable, 'endDate' => date( 'Y-m-d', strtotime( "+1 MONTH" ) )))
					),
					__METHOD__
				);

				// fix for AJAX calls (TODO: needed here?)
				$dbw->commit();
			}
		} else {
			$result = true;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * check status of the list (vote/edit permissions)
	 */
	public static function fetchPaypalToken() {
		global $wgRequest, $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy, $wgPayPalUrl;
		wfProfileIn( __METHOD__ );

		//wfLoadExtensionMessages( 'WikiPayment' );
		$result = array( 'url' => false );

		$paypalService = new PaypalPaymentService( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );
		$returnTitle = Title::makeTitle( NS_SPECIAL, 'WikiPayment' );

		$success = $paypalService->fetchToken( $returnTitle->getFullUrl( 'action=returnOk' ), $returnTitle->getFullUrl( 'action=returnCancel' ) );

		if ( $success ) {
			$result['url'] = $wgPayPalUrl . $paypalService->getToken() . "&useraction=commit";
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		wfProfileOut( __METHOD__ );
		return $response;
	}
}