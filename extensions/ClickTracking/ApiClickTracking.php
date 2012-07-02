<?php
/**
 * Click tracking API module
 *
 * @file
 * @ingroup API
 */

class ApiClickTracking extends ApiBase {

	/**
	 * API clicktracking action
	 *
	 * Parameters:
	 * 		eventid: event name
	 * 		token: unique identifier for a user session
	 *
	 * @see includes/api/ApiBase#execute()
	 */
	public function execute() {
		global $wgUser, $wgClickTrackContribGranularity1, $wgClickTrackContribGranularity2,
			$wgClickTrackContribGranularity3;

		$params = $this->extractRequestParams();
		$eventid_to_lookup = $params['eventid'];
		$sessionId = $params['token'];
		$namespace = $params['namespacenumber'];
		
		$additional = null;

		if ( isset( $params['additional'] ) && strlen( $params['additional'] ) > 0 ) {
			$additional = $params['additional'];
		}

		// FIXME: API should already have urldecode()d
		$eventName = urldecode( $eventid_to_lookup );

		$isLoggedIn = $wgUser->isLoggedIn();
		$now = time();
		$granularity1 = $isLoggedIn ?
			getUserEditCountSince( $now - $wgClickTrackContribGranularity1 ) : 0;

		$granularity2 = $isLoggedIn ?
			getUserEditCountSince( $now - $wgClickTrackContribGranularity2 ) : 0;

		$granularity3 = $isLoggedIn ?
			getUserEditCountSince( $now - $wgClickTrackContribGranularity3 ) : 0;

		ClickTrackingHooks::trackEvent(
			$sessionId,  // randomly generated session ID
			$isLoggedIn, 						 // is the user logged in?
			(int)$namespace, 			 // what namespace are they editing?
			$eventName,							 // event ID passed in
			( $isLoggedIn ? $wgUser->getEditCount() : 0 ), // total edit count or 0 if anonymous
			$granularity1, // contributions made in granularity 1 time frame
			$granularity2, // contributions made in granularity 2 time frame
			$granularity3,  // contributions made in granularity 3 time frame
			$additional
		);

		// For links that go off the page, redirect the user
		// FIXME: The API should have a proper infrastructure for this
		if ( !is_null( $params['redirectto'] ) ) {
			$href = $params['redirectto'];
			global $wgOut;
			$wgOut->redirect( $params['redirectto'] );
			$wgOut->output();

			// Prevent any further output
			$wgOut->disable();
			$this->getMain()->getPrinter()->disable();
		}
	}

	public function getParamDescription() {
		return array(
			'eventid' => 'string of eventID',
			'token'  => 'unique edit ID for this edit session',
			'namespacenumber' => 'the namespace number being edited', 
			'redirectto' => 'URL to redirect to (only used for links that go off the page)',
			'additional' => 'additional info for the event, like state information'
		);
	}

	public function getDescription() {
		return array(
			'Track user clicks on JavaScript items.'
		);
	}

	public function getAllowedParams() {
		return array(
			'eventid' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'namespacenumber' => array(
				ApiBase::PARAM_TYPE => 'integer', // not 'namespace', we need to allow negative numbers
				ApiBase::PARAM_REQUIRED => true,
			),
			'token' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'redirectto' => null,
			'additional' => null
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiClickTracking.php 106679 2011-12-19 20:04:34Z catrope $';
	}
}
