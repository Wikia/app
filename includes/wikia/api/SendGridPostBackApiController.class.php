<?php
/**
 * API which SendGrid will post data to when an email is opened, clicked, bounced back, unsubscribed, marked as spam, etc..
 *
 * @author Piotr Molski ( moli@wikia-inc.com )
 */

class SendGridPostbackController extends WikiaApiController {

	const POSTBACK_LOG_TABLE_NAME = "wikia_mailer.postbackLog";
	const MAIL_SEND_TABLE = "wikia_mailer.mail_send";

	public function log(){
		wfProfileIn( __METHOD__ );
		
		$email_id    = $this->wg->Request->getInt( 'wikia-email-id' );
		$email_addr  = $this->wg->Request->getVal( 'email', '' );
		// cityId of the wiki which sent the email
		$city_id     = $this->wg->Request->getInt( 'wikia-email-city-id' ); 
		$sender_db   = $this->wg->Request->getVal( 'wikia-db', null );
		// Verify the token so that we know this POST probably came from SendGrid.
		$token       = $this->wg->Request->getVal( 'wikia-token' );
		$event_type  = $this->wg->Request->getVal( 'event', null );
		$url         = $this->wg->Request->getVal( 'url', '' );
		$status      = $this->wg->Request->getVal( 'status', '' );
		$reason      = $this->wg->Request->getVal( 'reason', '' );

		$generatedToken = wfGetEmailPostbackToken( $email_id, $email_addr );
		if ( $this->wg->Request->wasPosted() && $token == $generatedToken ) {
			Wikia::log( __METHOD__, false, "<postback>" . $email_addr . ", " . $status . ", " . $reason . "</postback>\n", true );
		
			// Add the token-validated postback to the database.
			$dbw = wfGetDb( DB_MASTER, array(), $this->wg->ExternalDatawareDB );
			
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
			
			$dbw->insert( self::POSTBACK_LOG_TABLE_NAME, $insert_data, __METHOD__ );

			// Take action on the eventType.
			$update_data = array();
			switch ( $event_type ) {
				case 'click'      : $update_data = array( 'clicked' => date('Y-m-d H:i:s') ); break;
				case 'open'       : $update_data = array( 'opened'  => date('Y-m-d H:i:s') ); break;
				case 'unsubscribe': /* not used now */ break;
				case 'bounce'     : $update_data = array( 'is_bounce' => 1, 'error_status' => $status, 'error_msg' => $reason ); break;
				case 'spamreport' : $update_data = array( 'is_spam' => 1 ); break;
				default           : Wikia::log( __METHOD__, false, "Unrecognized type: " . json_encode($_POST), true );
			}

			if ( !empty( $email_id ) && !empty( $update_data ) ) {
				$dbw->update( self::MAIL_SEND_TABLE, $update_data, array( 'id' => intval( $email_id ) ), __METHOD__ );
			}

			// Invalidate the users email to force them to reverify it
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
