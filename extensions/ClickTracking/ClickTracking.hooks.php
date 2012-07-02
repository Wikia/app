<?php
/**
 * Hooks for ClickTracking extension
 *
 * @file
 * @ingroup Extensions
 */

class ClickTrackingHooks {

	/* Static Methods */

	/**
	 * LoadExtensionSchemaUpdates hook
	 * @return Boolean: always true
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ ) . '/';

		if ( $updater === null ) {
			global $wgExtNewTables, $wgExtNewIndexes, $wgExtNewFields;
			$wgExtNewTables[] = array( 'click_tracking', $dir . 'patches/ClickTracking.sql' );
			$wgExtNewTables[] = array( 'click_tracking_events', $dir . 'patches/ClickTrackingEvents.sql' );
			$wgExtNewTables[] = array( 'click_tracking_user_properties', $dir . 'patches/ClickTrackingUserProperties.sql' );
			$wgExtNewIndexes[] = array(
				'click_tracking',
				'click_tracking_action_time',
				$dir . 'patches/patch-action_time.sql',
			);
			$wgExtNewFields[] = array(
				'click_tracking',
				'additional_info',
				$dir . 'patches/patch-additional_info.sql',
			);
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'click_tracking',
				$dir . 'patches/ClickTracking.sql', true ) );
			$updater->addExtensionUpdate( array( 'addTable', 'click_tracking_events',
				$dir . 'patches/ClickTrackingEvents.sql', true ) );
			$updater->addExtensionUpdate( array( 'addTable', 'click_tracking_user_properties',
				$dir . 'patches/ClickTrackingUserProperties.sql', true ) );
			$updater->addExtensionUpdate( array( 'addIndex', 'click_tracking', 'click_tracking_action_time',
				$dir . 'patches/patch-action_time.sql', true ) );
			$updater->addExtensionUpdate( array( 'addField', 'click_tracking', 'additional_info',
				$dir . 'patches/patch-additional_info.sql', true ) );
		}
		return true;
	}

	/**
	 * ParserTestTables hook
	 *
	 * @param $tables Array
	 * @return Boolean: always true
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'click_tracking';
		$tables[] = 'click_tracking_events';
		$tables[] = 'click_tracking_user_properties';
		return true;
	}

	/**
	 * BeforePageDisplay hook
	 * Adds the modules to the page
	 *
	 * @param $out OutputPage output page
	 * @param $skin Skin current skin
	 * @return Boolean: always true
	 */
	public static function beforePageDisplay( $out, $skin ) {
		global $wgClickTrackThrottle;
		$out->addModules( 'ext.UserBuckets' );

		if ( $wgClickTrackThrottle >= 0 && rand() % $wgClickTrackThrottle == 0 ) {
			$out->addModules( 'ext.clickTracking' );
		}
		return true;
	}

	/**
	 * MakeGlobalVariablesScript hook
	 * Generates the random wgTrackingToken JS global variable
	 *
	 * @param $vars Array: existing JS globals
	 * @return Boolean: always true
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		global $wgUser;
		$vars['wgTrackingToken'] = wfGenerateToken( array( $wgUser->getName(), time() ) );
		return true;
	}

	//adds a bucket-testing campaign to the active campaigns
	public static function addCampaign($localBasePath, $remoteExtPath, $name ){
		global $wgResourceModules;

		$cusResourceTemplate = array(
			'localBasePath' => $localBasePath,
			'remoteExtPath' => $remoteExtPath,
		);
		$wgResourceModules["ext.UserBuckets.$name"] = array(
			'scripts' => "$name.js",
			'dependencies' => 'jquery.clickTracking',
		) + $cusResourceTemplate;
		$wgResourceModules['ext.UserBuckets']['dependencies'] = array_merge(
			( array ) $wgResourceModules['ext.UserBuckets']['dependencies'],
			array( "ext.UserBuckets.$name" )
		);
	}

	/**
	 * Get event ID from name
	 *
	 * @param $event_name String: name of the event to get
	 * @return integer
	 */
	public static function getEventIDFromName( $event_name ) {
		// Replication lag means sometimes a new event will not exist in the table yet
		$dbw = wfGetDB( DB_MASTER );
		$id_num = $dbw->selectField(
			'click_tracking_events',
			'id',
			array( 'event_name' => $event_name ),
			__METHOD__
		);
		// If this entry doesn't exist, which will be incredibly rare as the whole database will only have a few hundred
		// entries in it at most and getting DB_MASTER up top would be wasteful
		// FIXME: Use replace() instead of this selectField --> insert or update logic
		if ( $id_num === false ) {
			$dbw->insert(
				'click_tracking_events',
				array( 'event_name' => (string) $event_name ),
				__METHOD__
			);
			$id_num = $dbw->insertId();
		}
		return $id_num === false ? 0 : $id_num;
	}

	/**
	 * Returns bucket information
	 * @return Array array of buckets, or null
	 */
	public static function unpackBucketInfo(){
		global $wgRequest;

		//JSON-encoded because it's simple, can be replaced with any other encoding scheme
		return FormatJson::decode( $wgRequest->getCookie( 'userbuckets', "" ), true );
	}

	/**
	 * Takes in an array of buckets
	 * @param unknown_type $buckets
	 * @return unknown_type
	 */
	public static function packBucketInfo( $buckets ){
		global $wgRequest;
		//Can be another encoding scheme, just needs to match unpackBucketInfo
		$packedBuckets = FormatJson::encode( $buckets );

		//NOTE: $wgRequest->response setCookie sets it with a prefix and httponly by default
		setcookie( 'userbuckets' , $packedBuckets ,
					time() + 60 * 60 * 24 * 90 , '/' ); //expire in 90 days
	}

	/**
	 * Track particular event
	 *
	 * @param $sessionId String: unique session id for this editing sesion
	 * @param $isLoggedIn Boolean: whether or not the user is logged in
	 * @param $namespace Integer: namespace the user is editing
	 * @param $eventName String: event type
	 * @param $contribs Integer: contributions the user has made (or NULL if user not logged in)
	 * @param $contribs_in_timespan1 Integer: number of contributions user has made in timespan of granularity 1
	 * (defined by ClickTracking/$wgClickTrackContribGranularity1)
	 * @param $contribs_in_timespan2 Integer: number of contributions user has made in timespan of granularity 2
	 * (defined by ClickTracking/$wgClickTrackContribGranularity2)
	 * @param $contribs_in_timespan3 Integer: number of contributions user has made in timespan of granularity 3
	 * (defined by ClickTracking/$wgClickTrackContribGranularity3)
	 * @param $additional String: catch-all for any additional information we want to record about this click
	 * @param $relevantBucket String: name/index of the particular bucket we're concerned with for this event
	 * @return Boolean: true if the event was stored in the DB
	 */
	public static function trackEvent( $sessionId, $isLoggedIn, $namespace, $eventName, $contribs = 0,
	$contribs_in_timespan1 = 0, $contribs_in_timespan2 = 0, $contribs_in_timespan3 = 0, $additional = null, $recordBucketInfo = true ) {

		global $wgClickTrackingDatabase, $wgClickTrackingLog;
		$retval = true;
		if ( $wgClickTrackingDatabase ) {
			$eventId = self::getEventIDFromName( $eventName );
			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();
			// Builds insert information
			$data = array(
				'action_time' => $dbw->timestamp(),
				'session_id' => (string) $sessionId,
				'is_logged_in' => (bool) $isLoggedIn,
				'user_total_contribs' => ( $isLoggedIn ? (int) $contribs : null ),
				'user_contribs_span1' => ( $isLoggedIn ? (int) $contribs_in_timespan1 : null ),
				'user_contribs_span2' => ( $isLoggedIn ? (int) $contribs_in_timespan2 : null ),
				'user_contribs_span3' => ( $isLoggedIn ? (int) $contribs_in_timespan3 : null ),
				'namespace' => (int) $namespace,
				'event_id' => (int) $eventId,
				'additional_info' => ( isset( $additional ) ? (string) $additional : null )
			);
			$db_status_buckets = true;
			$db_status = $dbw->insert( 'click_tracking', $data, __METHOD__ );
			$dbw->commit();

			if( $recordBucketInfo && $db_status ) {
				$buckets = self::unpackBucketInfo();
				$dbw->begin();
				if( $buckets ) {
					foreach( $buckets as $bucketName => $bucketValue ){
							$db_current_bucket_insert = $dbw->insert( 'click_tracking_user_properties',
								array(
									'session_id' => (string) $sessionId,
									'property_name' => (string) $bucketName,
									'property_value' => (string) $bucketValue[0],
									'property_version' => (int) $bucketValue[1]
								),
							__METHOD__,
							array( 'IGNORE' )
							);
						$db_status_buckets = $db_status_buckets && $db_current_bucket_insert;
					}
				}//ifbuckets
				$dbw->commit();
			}//ifrecord

			$retval = $db_status && $db_status_buckets;
		}
		if ( $wgClickTrackingLog ) {
			$msg = implode( "\t", array(
				// Replace tabs with spaces in all strings
				str_replace( "\t", ' ', $eventName ),
				wfTimestampNow(),
				(int)$isLoggedIn,
				str_replace( "\t", ' ', $sessionId ),
				(int)$namespace,
				(int)$contribs,
				(int)$contribs_in_timespan1,
				(int)$contribs_in_timespan2,
				(int)$contribs_in_timespan3,
				str_replace( "\t", ' ', $additional ),
			) );
			wfErrorLog( $msg, $wgClickTrackingLog );

			// No need to mess with $retval here, doing
			// $retval == $retval && true is useless
		}
		return $retval;
	}

	public static function editPageShowEditFormFields( $editPage, $output ) {
		global $wgRequest;

		// Add clicktracking fields to form, if given
		$session = $wgRequest->getVal( 'clicktrackingsession' );
		$event = $wgRequest->getVal( 'clicktrackingevent' );
		$info = $wgRequest->getVal( 'clicktrackinginfo' );
		if ( $session !== null && $event !== null ) {
			$editPage->editFormTextAfterContent .= Html::hidden( 'clicktrackingsession', $session );
			$editPage->editFormTextAfterContent .= Html::hidden( 'clicktrackingevent', $event );
			$editPage->editFormTextAfterContent .= Html::hidden( 'clicktrackinginfo', $info );
		}

		return true;
	}

	public static function articleSave( $editpage ) {
		self::trackRequest( '-save-attempt' );
		return true;
	}

	public static function articleSaveComplete( $article, $user, $text, $summary, $minoredit,
			$watchthis, $sectionanchor, $flags, $revision, $baseRevId ) {
		self::trackRequest( '-save-complete' );
		return true;
	}

	protected static function trackRequest( $suffix ) {
		global $wgRequest, $wgTitle;

		$session = $wgRequest->getVal( 'clicktrackingsession' );
		$event = $wgRequest->getVal( 'clicktrackingevent' );
		$info = $wgRequest->getVal( 'clicktrackinginfo' );
		if ( $session !== null && $event !== null ) {
			$params = new FauxRequest( array(
				'action' => 'clicktracking',
				'eventid' => $event . $suffix,
				'token' => $session,
				'info' => $info,
				'namespacenumber' => $wgTitle->getNamespace(),
			) );
			$api = new ApiMain( $params, true );
			$api->execute();
		}

		return true;
	}
}
