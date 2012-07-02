<?php
/**
 * Centralized class used by both the old interstitial page, and the API to
 * process transactions and send donors off to the correct gateway location.
 * @author Katie Horn <khorn@wikimedia.org>
 */
class ContributionTrackingProcessor {

	/**
	 * If a database connection has already been established, it returns that
	 * connection. Otherwise, it establishes one, and returns that.
	 * @global string $wgContributionTrackingDBserver : DB Server name, defined
	 * in ContributionTracking.php
	 * @global string $wgContributionTrackingDBname : Database name, defined in
	 * ContributionTracking.php
	 * @global string $wgContributionTrackingDBuser : Database user, defined in
	 * ContributionTracking.php
	 * @global string $wgContributionTrackingDBpassword : Database password,
	 * defined in ContributionTracking.php
	 * @staticvar DatabaseMysql $db
	 * @return DatabaseMysql The established database connection
	 */
	static function contributionTrackingConnection() {
		global $wgContributionTrackingDBserver, $wgContributionTrackingDBname;
		global $wgContributionTrackingDBuser, $wgContributionTrackingDBpassword;

		static $db;

		if ( !$db ) {
			$db = new DatabaseMysql(
					$wgContributionTrackingDBserver,
					$wgContributionTrackingDBuser,
					$wgContributionTrackingDBpassword,
					$wgContributionTrackingDBname );
			$db->query( "SET names utf8" );
		}

		return $db;
	}

	/**
	 * Looks up the url specified in $ref. If it is known, the existing id is
	 * returned. If it is new, a row is added to contribution_owa_ref and the
	 * new id is returned.
	 * @param string $ref owa_ref URL
	 * @return integer ID of the URL in the contribution_tracking_owa_ref table,
	 * 0 if something went wrong.
	 */
	static function get_owa_ref_id( $ref ) {
		// Replication lag means sometimes a new event will not exist in the table yet
		$dbw = ContributionTrackingProcessor::contributionTrackingConnection(); //wfGetDB( DB_MASTER );
		$id_num = $dbw->selectField(
				'contribution_tracking_owa_ref',
				'id',
				array( 'url' => $ref ),
				__METHOD__
		);
		// Once we're on mysql 5, we can use replace() instead of this selectField --> insert or update hooey
		if ( $id_num === false ) {
			$dbw->insert(
				'contribution_tracking_owa_ref',
				array( 'url' => ( string ) $ref ),
				__METHOD__
			);
			$id_num = $dbw->insertId();
		}
		return $id_num === false ? 0 : $id_num;
	}

	/**
	 * Saves a record of a new contribution to the contribution_tracking_table
	 * @param array $params A staged array of parameters that can be processed
	 * by the ContributionTrackingProcessor.
	 * @return integer The id of the saved contribution in the
	 * contribution_tracking table
	 */
	static function saveNewContribution( $params = array( ) ) {
		$db = ContributionTrackingProcessor::contributionTrackingConnection();

		$params['ts'] = $db->timestamp();

		$owa_ref = null;
		if ( array_key_exists( 'owa_ref', $params ) && $params['owa_ref'] != null ) {
			if ( $params['owa_ref'] == null || is_numeric( $params['owa_ref'] ) ) {
				$owa_ref = $params['owa_ref'];
			} else {
				$owa_ref = ContributionTrackingProcessor::get_owa_ref_id( $params['owa_ref'] );
			}
		}
		$params['owa_ref'] = $owa_ref;

		$tracked_contribution = ContributionTrackingProcessor::stage_contribution( $params );

		$db->insert( 'contribution_tracking', $tracked_contribution );
		$contribution_tracking_id = $db->insertId();

		return $contribution_tracking_id;
	}

	/**
	 * Stages the contribution parameters
	 * @param array $params Key-value pairs of the contribution parameters we
	 * want to pass in.
	 * @return array Staged key-value pairs ready to be saved as a contribution.
	 */
	static function stage_contribution( $params ) {

		//change the posted names to match the db where necessary
		ContributionTrackingProcessor::rekey( $params, 'comment', 'note' );
		ContributionTrackingProcessor::rekey_invert_boolean( $params, 'comment-option', 'anonymous' );
		ContributionTrackingProcessor::rekey_invert_boolean( $params, 'email-opt', 'optout' );

		$tracked_contribution = ContributionTrackingProcessor::mergeArrayDefaults( $params, ContributionTrackingProcessor::getContributionDefaults(), true );

		return $tracked_contribution;
	}

	/**
	 * Stages the relevent data that will be sent to the gateway
	 * @global string $wgContributionTrackingPayPalRecurringIPN URL for paypal
	 * recurring donations : Defined in ContributionTracking.php
	 * @global string $wgContributionTrackingPayPalIPN URL for paypal recurring
	 * donations : Defined in ContributionTracking.php
	 * @param array $params Parameters to post to the gateway
	 * @return array Staged array
	 */
	static function stage_repost( $params ) {
		global $wgContributionTrackingPayPalRecurringIPN, $wgContributionTrackingPayPalIPN;
		//TODO: assert that gateway makes The Sense here.
		//change the posted names to match the db where necessary
		ContributionTrackingProcessor::rekey( $params, 'amountGiven', 'amount_given' );
		ContributionTrackingProcessor::rekey( $params, 'returnto', 'return' );

		//booleanize!
		ContributionTrackingProcessor::stage_checkbox( $params, 'recurring_paypal' );

		//poke our language function with the current parameters - this sets the static var correctly
		$params['language'] = ContributionTrackingProcessor::getLanguage( $params );

		if ( array_key_exists( 'recurring_paypal', $params ) && $params['recurring_paypal'] ) {
			$params['notify_url'] = $wgContributionTrackingPayPalRecurringIPN;
			$params['item_name'] = ContributionTrackingProcessor::msg( 'contrib-tracking-item-name-recurring' );
		} else {
			$params['notify_url'] = $wgContributionTrackingPayPalIPN;
			$params['item_name'] = ContributionTrackingProcessor::msg( 'contrib-tracking-item-name-onetime' );
		}

		$repost_params = ContributionTrackingProcessor::mergeArrayDefaults( $params, ContributionTrackingProcessor::getRepostDefaults(), true );
		return $repost_params;
	}

	/**
	 * Effectively changes the name of a key in an array. If the key does not
	 * exist, no change is made.
	 * @param array $array The array to rekey (by reference)
	 * @param string $oldkey The key to change
	 * @param string $newkey The new value for the key
	 */
	static function rekey( &$array, $oldkey, $newkey ) {
		if ( array_key_exists( $oldkey, $array ) ) {
			$array[$newkey] = $array[$oldkey];
			unset( $array[$oldkey] );
		}
	}

	/**
	 * There are a few values that come in, which are both generated by
	 * checkboxes, and are the exact inverse of the way we save them in the
	 * table.
	 * For these values, if the key exists (and is not explicit false), it is
	 * received as "true". Therefore, the rekey'd value should be false.
	 * However, the old key not existing isn't exactly conclusive.
	 * @param array $array The array to rekey (by reference)
	 * @param string $oldkey The key to change
	 * @param string $invertedkey The key meant to contain the inverted boolean
	 * of the old key.
	 */
	static function rekey_invert_boolean( &$array, $oldkey, $invertedkey ) {
		if ( array_key_exists( $oldkey, $array ) ) {
			if ( $array[$oldkey] !== false ) {
				unset( $array[$oldkey] );
				$array[$invertedkey] = false;
			} else {
				$array[$invertedkey] = 1;
			}
			return;
		}

		if ( array_key_exists( $invertedkey, $array ) ) {
			ContributionTrackingProcessor::stage_checkbox( $array, $invertedkey );
			return;
		}

		//at this point, neither key exists. We go with the default.
		$default = ContributionTrackingProcessor::getContributionDefaults();
		if ( array_key_exists( $invertedkey, $default ) ) {
			$array[$invertedkey] = $default[$invertedkey];
		}
	}

	/**
	 * Stages a value generated by a checkbox or similar control, for use in our
	 *  database. If the key exists and has not been set to exactly false, it's
	 * "true".
	 * @param array $array The array containing the value to stage, by reference
	 * @param string $key The key of a checkbox-generated value
	 */
	static function stage_checkbox( &$array, $key ) {
		//apparently so far in the code, if the key exists, the value is considered true
		//and is therefore set to "1"
		if ( array_key_exists( $key, $array ) && $array[$key] !== false ) {
			$array[$key] = 1;
		}
	}

	/**
	 * Returns a default value for every relevent field in a new contribution.
	 * @return array Default values for a new contribution.
	 */
	static function getContributionDefaults() {
		return array( //defaults
			'note' => null,
			'referrer' => null,
			'anonymous' => 0,
			'utm_source' => null,
			'utm_medium' => null,
			'utm_campaign' => null,
			'optout' => 0,
			'language' => null,
			'owa_session' => null,
			'owa_ref' => null,
			'ts' => null,
		);
	}

	/**
	 * Returns a default value for every relevent field in a repost to a gateway
	 * @return array Default values for a payment gateway repost
	 */
	static function getRepostDefaults() {
		return array( //defaults
			'gateway' => '',
			'tshirt' => false,
			'size' => false,
			'premium_language' => false,
			'currency_code' => 'USD',
			'return' => 'Donate-thanks/' . ContributionTrackingProcessor::getLanguage(),
			'fname' => '',
			'lname' => '',
			'email' => '',
			'recurring_paypal' => '0',
			'amount' => '',
			'amount_given' => '',
			'contribution_tracking_id' => '',
			'notify_url' => '',
			'item_name' => '',
			'address1' => '',
			'city' => '',
			'state' => '',
			'zip' => '',
			'country' => 'US',
			'address_override' => '0'

		);
	}

	/**
	 * Merges an array of parameters from a payment form, with an array of
	 * default values. Additionally: Values in the $params array will only be
	 * returned if there is a corresponding key in the $defaults array.
	 * @param array $params Form / API data
	 * @param array $defaults A set of default values for a particular
	 * transaction type
	 * @param boolean $nullify If true, keys with empty string values will be
	 * set to null in the return array.
	 * @return array
	 */
	static function mergeArrayDefaults( $params, $defaults, $nullify=false ) {
		$ret = $defaults;
		foreach ( $ret as $key => $value ) {
			if ( array_key_exists( $key, $params ) ) {
				$ret[$key] = $params[$key];
			}
			if ( $nullify && $ret[$key] === '' ) {
				$ret[$key] = null;
			}
		}
		return $ret;
	}

	/**
	 * Takes staged transaction data, and constructs the key/value pairs
	 * formatted to be reposted to the gateway specified in $input['gateway']
	 * @global string $wgContributionTrackingPayPalBusiness 'Business' string
	 * for PayPal: Defined in ContributionTracking.php
	 * @global string $wgContributionTrackingReturnToURLDefault Default URL to
	 * return to after the transaction was processed by the gateway. Used if
	 * none supplied.
	 * @param array $input The staged data to repost to a gateway.
	 * @return array Key/value pairs, ready to be reposted to the specified
	 * gateway to complete the transaction.
	 */
	static function getRepostFields( $input ) {
		global $wgContributionTrackingPayPalBusiness, $wgContributionTrackingReturnToURLDefault, $wgContributionTrackingRPPLength;
		// Set the action and tracking ID fields
		$input = ContributionTrackingProcessor::stage_repost( $input );

		$repost = array( );
		$repost['action'] = 'http://wikimediafoundation.org/';
		$amount_field_name = 'amount'; // the amount fieldname may be different depending on the service
		if ( $input['gateway'] == 'paypal' ) {

			$repost['action'] = 'https://www.paypal.com/cgi-bin/webscr';

			// Premiums
			if ( array_key_exists( 'tshirt', $input ) && $input['tshirt'] ) {
				$repost['fields']['on0'] = 'Shirt size';
				$repost['fields']['os0'] = $input['size'];
				$repost['fields']['on1'] = 'Shirt language';
				$repost['fields']['os1'] = $input['premium_language'];
				$repost['fields']['no_shipping'] = 2;
			}

			// PayPal
			$repost['fields']['business'] = $wgContributionTrackingPayPalBusiness;
			$repost['fields']['item_number'] = 'DONATE';
			$repost['fields']['no_note'] = '0';

			$returnText = $input['return'];
			$returnTitle = Title::newFromText( $returnText );
			if ( $returnTitle ) {
				$returnto = wfExpandUrl( $returnTitle->getFullUrl(), PROTO_CURRENT );
			} else {
				$returnto = $wgContributionTrackingReturnToURLDefault . "/$language"; // FIXME: $language is undefined
			}
			$repost['fields']['return'] = $returnto;
			$repost['fields']['currency_code'] = $input['currency_code'];

			// additional fields to pass to PayPal from single-step credit card form and 1st step with address fields
			if ( array_key_exists( 'fname', $input ) && !empty( $input['fname'] ) ) {
				$repost['fields']['first_name'] = $input['fname'];
			}
			if ( array_key_exists( 'lname', $input ) && !empty( $input['lname'] ) ) {
				$repost['fields']['last_name'] = $input['lname'];
			}
			if ( array_key_exists( 'email', $input ) && !empty( $input['email'] ) ) {
				$repost['fields']['email'] = $input['email'];
			}

			if ( array_key_exists( 'address1', $input ) && !empty( $input['address1'] ) ) {
				$repost['fields']['address1'] = $input['address1'];
			}

			if ( array_key_exists( 'city', $input ) && !empty( $input['city'] ) ) {
				$repost['fields']['city'] = $input['city'];
			}

			if ( array_key_exists( 'state', $input ) && !empty( $input['state'] ) ) {
				$repost['fields']['state'] = $input['state'];
			}

			if ( array_key_exists( 'zip', $input ) && !empty( $input['zip'] ) ) {
				$repost['fields']['zip'] = $input['zip'];
			}


			if ( array_key_exists( 'country', $input ) && !empty( $input['country'] ) ) {
				$repost['fields']['country'] = $input['country'];
			}

			if ( array_key_exists( 'address_override', $input ) && !empty( $input['address_override'] ) ) {
				$repost['fields']['address_override'] = $input['address_override'];
			}


			// if this is a recurring donation, we have add'l fields to send to paypal
			if ( $input['recurring_paypal'] && $input['recurring_paypal'] != 0 ) {

				$repost['fields']['t3'] = "M"; // The unit of measurement for for p3 (M = month)
				$repost['fields']['p3'] = '1'; // Billing cycle duration
				$repost['fields']['srt'] = $wgContributionTrackingRPPLength; // # of billing cycles
				$repost['fields']['src'] = '1'; // Make this 'recurring'
				$repost['fields']['sra'] = '1'; // Turn on re-attempt on failure
				$repost['fields']['cmd'] = '_xclick-subscriptions';
				$amount_field_name = 'a3';
				$repost['fields']['notify_url'] = $input['notify_url'];
				$repost['fields']['item_name'] = $input['item_name'];
			} else {
				$repost['fields']['cmd'] = '_xclick';
				$repost['fields']['notify_url'] = $input['notify_url'];
				$repost['fields']['item_name'] = $input['item_name'];
			}
		} elseif ( $input['gateway'] == 'moneybookers' ) {
			$repost['action'] = 'https://www.moneybookers.com/app/payment.pl';

			// Tracking
			$repost['fields']['merchant_fields'] = 'os0';

			// Moneybookers
			$repost['fields']['pay_to_email'] = 'donation@wikipedia.org';
			$repost['fields']['status_url'] = 'https://civicrm.wikimedia.org/fundcore_gateway/moneybookers';
			$repost['fields']['language'] = 'en';
			$repost['fields']['detail1_description'] = 'One-time donation';
			$repost['fields']['detail1_text'] = 'DONATE';
			$repost['fields']['currency'] = $input['currency_code'];
		} else {
			throw new MWException( "Unknown payment gateway!" );
		}

		// Normalized amount
		$amount = $input['amount'];
		// If amount is not a number, use amount_given
		if ( !( preg_match( '/^\d+(\.(\d+)?)?$/', $amount ) ) && $input['amount_given'] ) {
			$amount = $input['amount_given'];
		}
		$repost['fields'][$amount_field_name] = $amount;

		// Tracking
		$repost['fields']['custom'] = $input['contribution_tracking_id'];

		return $repost;
	}

	/**
	 * Sets any language that is expressly specified in the posted parameters.
	 * If no language is expressly set, it gets the global language code.
	 * @global Language $wgLang
	 * @staticvar string $language The language code currently in use
	 * @param array $params Request parameters that may or may not contain a
	 * 'language' key.
	 * @return string A valid language code
	 */
	static function getLanguage( $params = '' ) {
		static $language = '';

		if ( is_array( $params ) && array_key_exists( 'language', $params ) && $params['language'] != null ) {
			//set/reset if something inteligable got sent.
			$language = $params['language'];
		}

		if ( $language == '' ) { //if we have nothing by this point...
			global $wgLang;
			$language = $wgLang->getCode();
		}

		return $language;
	}

	/**
	 * Gets a message in the local language
	 * @param string $key Message key
	 * @return string translated message
	 */
	static function msg( $key ) {
		return wfMsgExt( $key, array( 'escape', 'language' => ContributionTrackingProcessor::getLanguage() ) );
	}

}
