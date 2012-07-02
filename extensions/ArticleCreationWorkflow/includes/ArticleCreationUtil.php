<?php

/**
 * Utility class for Article Creation
 */
class ArticleCreationUtil {
	
	/**
	 * Check if tracking is enabled
	 */
	public static function trackingEnabled() {
		return class_exists( 'ApiClickTracking' );
	}
	
	/**
	 * Generate tracking code prefix
	 */
	public static function trackingCodePrefix() {
		global $wgExtensionCredits;
		return 'ext.articlecreationworkflow@' . $wgExtensionCredits['other'][0]['version'] . '-';	
	}
	
	/**
	 * Track the page stats to the special article creation landing page
	 * @param $request Object
	 * @param $user Object
	 */
	public static function TrackSpecialLandingPage( $request, $user ) {
		if ( $user->isAnon() ) {
			$event = 'landingpage-anonymous';
		} else {
			$event = 'landingpage-loggedin';
			
			if ( $request->getBool( 'fromlogin' ) ) {
				$event .= '-fromlogin';
			} elseif ( $request->getBool( 'fromsignup' ) ) {
				$event .= '-fromsignup';	
			}
		}
			
		self::clickTracking( $event, SpecialPage::getTitleFor( 'ArticleCreationLanding' ) );
	}

	/**
	 * Tracking code that calls ClickTracking 
	 * @param $event string the event name
	 * @param $title Object
	 */
	private static function clickTracking( $event, $title ) {		
		// check if ClickTracking API is enabled
		if ( !self::trackingEnabled() ) {
			return;	
		}

		$params = new FauxRequest( array(
			'action' => 'clicktracking',
			'eventid' => self::trackingCodePrefix() . $event,
			'token' => wfGenerateToken(),
			'namespacenumber' => $title->getNamespace()
		) );
		$api = new ApiMain( $params, true );
		$api->execute();
	}
	
}

