<?php
/**
 * API which SendGrid will post data to when an email is opened, clicked, bounced back, unsubscribed, marked as spam, etc..
 *
 * @author Piotr Molski ( moli@wikia-inc.com )
 */

class SendGridPostbackController extends WikiaApiController {

	public function safe_get($arr, $key, $default = null) {
		return isset($arr[$key]) ? $arr[$key] : $default;
	}

	public function log() {
		wfProfileIn( __METHOD__ );

		// Sendgrid uses raw JSON POST format, this is how PHP ingests it
		$data = file_get_contents("php://input");
		$events = json_decode($data, true);  // true = return value is array

		if (empty($events)) {
			\Wikia\Logger\WikiaLogger::instance()->debug( __CLASS__ . ": No data to process");
			wfProfileOut( __METHOD__ );
			return;
		}

		if (!is_array($events)) {
			\Wikia\Logger\WikiaLogger::instance()->debug( __CLASS__ . ": Supplied data is not an array", [
				'data_first_100_chars' => is_string($data) ? substr($data,0,100) : '[type: ' . gettype($data) . ']'
			]);
			wfProfileOut( __METHOD__ );
			return;
		}

		foreach ($events as $event) {
			$email_addr = $this->safe_get($event, 'email', '');
			$email_id 	= $this->safe_get($event, 'wikia-email-id');
			$city_id 	= $this->safe_get($event, 'wikia-email-city-id');
			$sender_db 	= $this->safe_get($event, 'wikia-db');
			$token 		= $this->safe_get($event, 'wikia-token');
			$event_type	= $this->safe_get($event, 'event');
			$url 		= $this->safe_get($event, 'url', '');
			$status 	= $this->safe_get($event, 'status', '');
			$reason		= $this->safe_get($event, 'reason', '');

			if ( $this->wg->Request->wasPosted() ) {
				// log postback data
				$insert_data = array(
					"mail_id"      => $email_id,
					"emailAddr"    => $email_addr,
					"cityId"       => $city_id,
					"eventType"    => $event_type,
					"senderDbName" => $sender_db,
					"url"          => $url,
					"status"       => $status,
					"reason"       => $reason
				);

				// Log to logstash/kibana
				\Wikia\Logger\WikiaLogger::instance()->info( "SendgridPostback", $insert_data);

				// On bounce, invalidate the users email to force them to re-verify it
				if ( $event_type == 'bounce' ) {
					if ( isset( $this->wg->SharedDB ) ) {
						$dbr = wfGetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );
					} else {
						$dbr = wfGetDB( DB_SLAVE );
					}

					$res = $dbr->select( array( '`user`' ), array( 'user_id' ), array( 'user_email' => $email_addr ), __METHOD__ );
					while( $row = $dbr->fetchObject( $res ) ) {
						$user = User::newFromId( $row->user_id );
						if (!$user) {
							continue;
						}
						$user->invalidateEmail();
						$user->saveSettings();
					}
				}

				$this->response->setVal( 'response', 'Postback processed.' );
			} else {
				// Log the token-validation problem.
				Wikia::log(__METHOD__, false, "INVALID TOKEN DURING THIS POSTBACK: " . json_encode($_POST), true);
				$this->response->setVal( 'response', 'Postback token did not match expected value.  Ignoring.' );
			}

			wfProfileOut( __METHOD__ );
		}
	}
}
