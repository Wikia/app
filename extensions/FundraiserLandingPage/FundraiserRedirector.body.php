<?php
/*
 * Provides redirect service for donors coming from external sites (so that they get
 * directed to the proper form for their country).
 *
 * @author Ryan Kaldari <rkaldari@wikimedia.org>
 */
class FundraiserRedirector extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( 'FundraiserRedirector' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgFundraiserLPDefaults;
		
		// Set the country parameter
		$country = $wgRequest->getVal( 'country' );
		// If no country was passed do a GeoIP lookup
		if ( !$country ) {
			if ( function_exists( 'geoip_country_code_by_name' ) ) {
				$ip = wfGetIP();
				if ( IP::isValid( $ip ) ) {
					$country = geoip_country_code_by_name( $ip );
				}
			}
		}
		// If country still isn't set, set it to the default
		if ( !$country ) {
			$country = $wgFundraiserLPDefaults[ 'country' ];
		}
		
		$params = array( 'country' => $country );
		
		// Pass any other params that are set
		$excludeKeys = array( 'country', 'title' );
		foreach ( $wgRequest->getValues() as $key => $value ) {
			// Skip the required variables
			if ( !in_array( $key, $excludeKeys ) ) {
				$params[$key] = $value;
			}
		}
		
		// Redirect to FundraiserLandingPage
		$wgOut->redirect( $this->getTitleFor( 'FundraiserLandingPage' )->getLocalUrl( $params ) );
	}
}
