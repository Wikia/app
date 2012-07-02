<?php

class SpecialVariablePage extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'VariablePage' );
		
		// make sure configuration will result in something sane
		if ( !$this->sanityCheck() ) {
			throw new MWException( 'VariablePage configuation not sane!  Either $wgVariablePageDefault must be set or probabilites in $wgVariablePagePossibilities must add up to 100.' );
		}
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest;
		global $wgVariablePagePossibilities;

		$lang = ( preg_match( '/^[A-Za-z-]+$/', $wgRequest->getVal( 'lang' ) ) )
				? $wgRequest->getVal( 'lang' )
				: 'en' ;
		$utm_source = $wgRequest->getVal( 'utm_source' );
		$utm_medium = $wgRequest->getVal( 'utm_medium' );
		$utm_campaign = $wgRequest->getVal( 'utm_campaign' );
		$referrer = ( $wgRequest->getVal( 'referrer' ))
				? $wgRequest->getVal( 'referrer' )
				: $wgRequest->getHeader( 'referer' );
	
		$query = array();
		if ( strlen( $lang ) ) $query[ 'language' ] = $lang;
		if ( strlen( $utm_source ) ) $query[ 'utm_source' ] = $utm_source;
		if ( strlen( $utm_medium ) ) $query[ 'utm_medium' ] = $utm_medium;
		if ( strlen( $utm_campaign ) ) $query[ 'utm_campaign' ] = $utm_campaign;
		if ( strlen( $referrer ) ) $query[ 'referrer' ] = $referrer;

		// determine the URL to which we will redirect the user
		$url = $this->determinePage( $wgVariablePagePossibilities );
		$wgOut->redirect( wfAppendQuery( $url, $query ) );
	}

	/**
	 * Determine the URL to use based on its configured probability
	 *
	 * This is a basic weighted random selection algorithm borrowed from:
	 * http://20bits.com/articles/random-weighted-elements-in-php/
	 *
	 * @param array $page_possibilities
	 * @return string $url
	 */
	public function determinePage( $page_possibilities ) {
		global $wgVariablePageDefault;

		/**
		 * Determine a random number to measure probability again
		 *
		 * We use a # larger than 100 to increase 'randomness'
		 */
		$random_number = mt_rand( 0, 100*100 );
		$offset = 0;

		foreach ( $page_possibilities as $url => $probability ) {
			$offset += $probability * 100;
			if ( $random_number <= $offset ) {
				return $url;
			}
		}

		// if all else fails, return the default
		return $wgVariablePageDefault;
	}

	/**
	 * Check configuartion sanity
	 *
	 * Probabilities defined in $wgVariablePagePossibilities MUST add
	 * up to 100 -or- $wgVariablePageDefault MUST be set.
	 *
	 * @return bool
	 */
	public function sanityCheck() {
		global $wgVariablePagePossibilities, $wgVariablePageDefault;

		$total_probability = 0;
		foreach ( $wgVariablePagePossibilities as $probability ) {
			$total_probability += $probability;
		}

		if ( $total_probability != 100 && !strlen( $wgVariablePageDefault ) ) {
			return false;
		} else {
			return true;
		}
	}
}
