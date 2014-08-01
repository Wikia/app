<?php

/**
 * Class MonetizationModuleHelper
 */
class MonetizationModuleHelper extends WikiaModel {

	const SLOT_TYPE_ABOVE_TITLE = 'above_title';
	const SLOT_TYPE_BELOW_TITLE = 'below_title';
	const SLOT_TYPE_IN_CONTENT = 'in_content';
	const SLOT_TYPE_BELOW_CATEGORY = 'below_category';
	const SLOT_TYPE_ABOVE_FOOTER = 'above_footer';
	const SLOT_TYPE_FOOTER = 'footer';

	const CACHE_TTL = 3600;

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @return boolean
	 */
	public static function canShowModule() {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$status = false;
		$showableNameSpaces = array_merge( $app->wg->ContentNamespaces, [ NS_FILE ] );
		if ( $app->wg->Title->exists()
			&& !$app->wg->Title->isMainPage()
			&& in_array( $app->wg->Title->getNamespace(), $showableNameSpaces )
			&& in_array( $app->wg->request->getVal( 'action' ), [ 'view', null ] )
			&& $app->wg->request->getVal( 'diff' ) === null
			&& $app->wg->User->isAnon()
			&& $app->checkSkin( 'oasis' )
		) {
			$status = true;
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Get monetization units
	 * @global string $wgMonetizationServiceUrl
	 * @param array $params
	 * @return array|false $result
	 */
	public static function getMonetizationUnits( $params ) {
		wfProfileIn( __METHOD__ );

		global $wgMonetizationServiceUrl;

		$url = $wgMonetizationServiceUrl.'?'.http_build_query( $params );
		$req = MWHttpRequest::factory( $url, [ 'noProxy' => true ] );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$result = json_decode( $req->getContent(), true );
		} else {
			$result = false;
			print( "ERROR: problem getting monetization units (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Get country code
	 * @param Request $request
	 * @return string $countryCode
	 */
	public static function getCountryCode( $request ) {
		wfProfileIn( __METHOD__ );

		$countryCode = '';
		$geo = $request->getCookie( 'Geo' );
		if ( !empty( $geo ) ) {
			$geo = json_decode( $geo, true );
			$countryCode = $geo['country'];
		}

		wfProfileOut( __METHOD__ );

		return $countryCode;
	}

}
