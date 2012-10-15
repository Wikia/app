<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "LandingCheck extension\n";
	exit( 1 );
}

/**
 * This checks to see if a version of a landing page exists for the user's language and country. 
 * If not, it looks for a version localized for the user's language. If that doesn't exist either, 
 * it looks for the English version. If any of those exist, it then redirects the user.
 */
class SpecialLandingCheck extends SpecialPage {
	protected $localServerType = null;
	/**
	 * If basic is set to true, do a local redirect, ignore priority, and don't pass tracking 
	 * params. This is for non-fundraising links that just need localization.
	 *
	 * @var boolean
	 */
	protected $basic = false;
	
	public function __construct() {
		// Register special page
		parent::__construct( 'LandingCheck' );
	}
	
	public function execute( $sub ) {
		global $wgRequest, $wgPriorityCountries;
		
		// Pull in query string parameters
		$language = $wgRequest->getVal( 'language', 'en' );
		$this->basic = $wgRequest->getBool( 'basic' );
		$country = $wgRequest->getVal( 'country' );
		
		// If no country was passed, try to do GeoIP lookup
		// Requires php5-geoip package
		if ( !$country && function_exists( 'geoip_country_code_by_name' ) ) {
			$ip = wfGetIP();
			if ( IP::isValid( $ip ) ) {
				$country = geoip_country_code_by_name( $ip );
			}
		}
		if ( !$country ) {
			$country = 'US'; // Default
		}
		
		// determine if we are fulfilling a request for a priority country
		$priority = in_array( $country, $wgPriorityCountries );

		// handle the actual redirect
		$this->routeRedirect( $country, $language, $priority );
	}
	
	/**
	 * Determine whether this server is configured as the priority or normal server
	 * 
	 * If this is neither the priority nor normal server, assumes 'local' - meaning
	 * this server should be handling the request.
	 */
	public function determineLocalServerType() {
		global $wgServer, $wgLandingCheckPriorityURLBase, $wgLandingCheckNormalURLBase;
		
		$localServerDetails = wfParseUrl( $wgServer );
		
		// The following checks are necessary due to a bug in wfParseUrl that was fixed in r94352.
		if ( $wgLandingCheckPriorityURLBase ) {
			$priorityServerDetails = wfParseUrl( $wgLandingCheckPriorityURLBase );
		} else {
			$priorityServerDetails = false;
		}
		if ( $wgLandingCheckNormalURLBase ) {
			$normalServerDetails = wfParseUrl( $wgLandingCheckNormalURLBase );
		} else {
			$normalServerDetails = false;
		}
		//$priorityServerDetails = wfParseUrl( $wgLandingCheckPriorityURLBase );
		//$normalServerDetails = wfParseUrl( $wgLandingCheckNormalURLBase );
		
		if ( $localServerDetails[ 'host' ] == $priorityServerDetails[ 'host' ] ) {
			return 'priority';
		} elseif ( $localServerDetails[ 'host' ] == $normalServerDetails[ 'host' ] ) {
			return 'normal';
		} else {
			return 'local';
		}
	}
	
	/**
	 * Route the request to the appropriate redirect method
	 * @param string $country
	 * @param string $language
	 * @param bool $priority Whether or not we handle this request on behalf of a priority country
	 */
	public function routeRedirect( $country, $language, $priority ) {
		$localServerType = $this->getLocalServerType();
		
		if ( $this->basic ) {
			$this->localRedirect( $country, $language, false );
			
		} elseif ( $localServerType == 'local' ) {
			$this->localRedirect( $country, $language, $priority );
			
		} elseif ( $priority && $localServerType == 'priority' ) {
			$this->localRedirect( $country, $language, $priority );

		} elseif ( !$priority && $localServerType == 'normal' ) {
			$this->localRedirect( $country, $language, $priority );
		
		} else {
			$this->externalRedirect( $priority );
		
		}
	}
	
	/**
	 * Handle an external redirect
	 * 
	 * The external redirect should point to another instance of LandingCheck
	 * which will ultimately handle the request.
	 * @param bool $priority
	 */
	public function externalRedirect( $priority ) {
		global $wgRequest, $wgOut, $wgLandingCheckPriorityURLBase, $wgLandingCheckNormalURLBase;
		
		if ( $priority ) {
			$urlBase = $wgLandingCheckPriorityURLBase;
		
		} else {
			$urlBase = $wgLandingCheckNormalURLBase;
		
		}
		
		$query = $wgRequest->getValues();
		unset( $query[ 'title' ] );
		
		$url = wfAppendQuery( $urlBase, $query );
		$wgOut->redirect( $url );
	}
	
	/**
	 * Handle local redirect 
	 * @param bool $priority Whether or not we handle this request on behalf of a priority country
	 */
	public function localRedirect( $country, $language, $priority=false ) {
		global $wgOut, $wgRequest;
		$landingPage = $wgRequest->getVal( 'landing_page', 'Donate' );
		
		/**
		 * Construct new query string for tracking
		 * 
		 * Note that both 'language' and 'uselang' get set to 
		 * 	$wgRequest->getVal( 'language', 'en')
		 * This is wacky, yet by design! This is a unique oddity to fundraising
		 * stuff, but CentralNotice converts wgUserLanguage to 'language' rather than
		 * 'uselang'. Ultimately, this is something that should probably be rectified
		 * in CentralNotice. Until then, this is what we've got.
		 */
		$tracking = wfArrayToCGI( array( 
			'utm_source' => $wgRequest->getVal( 'utm_source' ),
			'utm_medium' => $wgRequest->getVal( 'utm_medium' ),
			'utm_campaign' => $wgRequest->getVal( 'utm_campaign' ),
			'language' => $wgRequest->getVal( 'language', 'en'),
			'uselang' => $wgRequest->getVal( 'language', 'en'), // for {{int:xxx}} rendering
			'country' => $country,
			'referrer' => $wgRequest->getHeader( 'referer' )
		) );
		
		if ( $priority ) {
			// Build array of landing pages to check for
			$targetTexts = array(
				$landingPage . '/' . $country . '/' . $language,
				$landingPage . '/' . $country
			);
		} else {
			// Build array of landing pages to check for
			$targetTexts = array(
				$landingPage . '/' . $language . '/' . $country,
				$landingPage . '/' . $language
			);
			// Add fallback languages
			$code = $language;
			while ( $code !== 'en' ) {
				$code = Language::getFallbackFor( $code );
				$targetTexts[] = $landingPage . '/' . $code;
			}
		}
		
		// Go through the possible landing pages and redirect the user as soon as one is found to exist
		foreach ( $targetTexts as $targetText ) {
			$target = Title::newFromText( $targetText );
			if ( $target && $target->isKnown() && $target->getNamespace() == NS_MAIN ) {
				if ( $this->basic ) {
					$wgOut->redirect( $target->getLocalURL() );
				} else {
					$wgOut->redirect( $target->getLocalURL( $tracking ) );
				}
				return;
			} 
		}

		# Output a simple error message if no pages were found
		$this->setHeaders();
		$this->outputHeader();
		$wgOut->addWikiMsg( 'landingcheck-nopage' );
	}
	
	/**
	 * Setter for $this->localServerType
	 * @param string $type 
	 */
	public function setLocalServerType( $type = null ) {
		if ( !$type ) {
			$this->localServerType = $this->determineLocalServerType();
		} else {
			$this->localServerType = $type;
		}
	}

	/**
	 * Getter for $this->localServerType
	 */
	public function getLocalServerType() {
		if ( !$this->localServerType ) {
			$this->setLocalServerType();
		}
		return $this->localServerType;
	}
}
