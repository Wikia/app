<?php
/**
 * API which SendGrid will post data to when an email is opened, clicked, etc..
 *
 * For more information see:
 *
 *   https://sendgrid.com/docs/API_Reference/Webhooks/event.html
 */

use Wikia\Logger\WikiaLogger;

class SendGridPostbackController extends WikiaApiController {

	/**
	 * Requests from SendGrid are POSTed via this controller.  The POST data contains a JSON
	 * encoded associative array with the following keys:
	 *
	 * - email
	 * - wikia-email-id
	 * - wikia-email-city-id
	 * - wikia-db
	 * - event
	 * - url
	 * - status
	 * - reason
	 *
	 * NOTE: The 'response' key set before returning is for debugging purposes only.  SendGrid
	 * only requires that we send back a 200 response code.
	 *
	 */
	public function log() {
		if ( !$this->wg->Request->wasPosted() ) {
			// Log the token-validation problem.
			WikiaLogger::instance()->debug( __CLASS__ . ': Request method must be POST' );
			$this->response->setVal( 'response', 'Request method must be POST' );
			return;
		}

		$events = $this->getEvents();
		if ( empty( $events ) ) {
			$this->response->setVal( 'response', 'Unable to find any events' );
			return;
		}

		wfRunHooks( 'SendGridPostbackLogEvents', [ $events ] );

		foreach ( $events as $event ) {
			$eventType = $this->safeGet( $event, 'event' );

			// Log to logstash/kibana
			WikiaLogger::instance()->info( 'SendgridPostback', $event );

			// On bounce, invalidate the users email to force them to re-verify it
			if ( $eventType == 'bounce' ) {
				// SOC-1435 : For now don't invalidate email on bounce
				# $this->handleBounce( $event );
			}

			$this->response->setVal( 'response', 'Postback processed' );
		}
	}

	/**
	 * Pull the event information from the POST data.  Return an array if successful, null otherwise
	 *
	 * @return mixed|null
	 */
	protected function getEvents() {
		// Sendgrid uses raw JSON POST format, this is how PHP ingests it
		$data = file_get_contents( "php://input" );
		$events = json_decode( $data, $returnArray = true );

		if ( empty( $events ) ) {
			WikiaLogger::instance()->debug( __CLASS__ . ": No data to process" );
			return null;
		}

		if ( !is_array( $events ) ) {
			if ( is_string( $data ) ) {
				$firstChars = substr( $data, 0, 100 );
			} else {
				$firstChars = '[type: ' . gettype( $data ) . ']';
			}

			WikiaLogger::instance()->debug( __CLASS__ . ": Supplied data is not an array", [
				'data_first_100_chars' => $firstChars,
			] );
			return null;
		}

		return $events;
	}

	protected function handleBounce( Array $event ) {
		$dbType = $this->wg->SharedDB ? $this->wg->ExternalSharedDB : null;
		$dbr = wfGetDB( DB_SLAVE, [], $dbType );

		$res = $dbr->select(
			[ 'user' ],
			[ 'user_id' ],
			[ 'user_email' => $this->safeGet( $event, 'email' ) ],
			__METHOD__
		);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$user = User::newFromId( $row->user_id );
			if ( !$user ) {
				continue;
			}
			$user->invalidateEmail();
			$user->saveSettings();
		}
	}

	public function safeGet( $arr, $key, $default = null ) {
		return isset( $arr[$key] ) ? $arr[$key] : $default;
	}
}
