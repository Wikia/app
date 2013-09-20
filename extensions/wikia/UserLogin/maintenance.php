<?php

	/**
	 * Maintenance script to 
	 *    - remove old temp users (user's registered date > 30 days)
	 *    - run reminder process: get list of wikis and send reminder for each wiki
	 *    - send reminder (user's registered date = 7 days) for current wiki ONLY
	 * @author Hyun
	 * @author Saipetch
	 */

	/**
	 * get list of wikis for sending reminder (user's registered date = 7 days)
	 * @param string $condition
	 * @return array $wikis
	 */
	function getWikis( $condition ) {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$wikis = array();

		$db = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$result = $db->select(
			'user_temp',
			array( 'distinct user_wiki_id' ),
			array( $condition ),
			__METHOD__
		);

		while ( $row = $db->fetchObject($result) ) {
			$wikis[] = $row->user_wiki_id;
		}
		$db->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $wikis;
	}

	/**
	 * get minimum/maximum user id
	 * @param integer $fromUserId
	 * @param integer $toUserId
	 * @param string $condition
	 */
	function getScope( &$fromUserId, &$toUserId, $condition ) {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$row = $db->selectRow(
			array( 'user_temp' ),
			array( 'min(user_id) fromUserId, max(user_id) toUserId' ),
			array( $condition ),
			__METHOD__
		);

		if ( $row ) {
			if ( empty($fromUserId) && !empty($row->fromUserId) ) {
				$fromUserId = $row->fromUserId - 1;
			}
			if ( empty($toUserId) && !empty($row->toUserId) ) {
				$toUserId = $row->toUserId;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get list of temp user's name for the option
	 * @param integer $fromUserId
	 * @param integer $toUserId
	 * @param string $condition
	 * @return array $users 
	 */
	function getTempUsers( $fromUserId, $toUserId, $condition ) {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$users = array();
		$where = $condition." and user_id > $fromUserId and user_id <= $toUserId ";

		$db = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$result = $db->select(
			'user_temp',
			array( 'user_name' ),
			array( $where ),
			__METHOD__
		);

		while ( $row = $db->fetchObject($result) ) {
			$users[] = $row->user_name;
		}
		$db->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $users;
	}

	/**
	 * remove user from user_temp table
	 * @param integer $fromUserId
	 * @param integer $toUserId
	 * @param integer $range 
	 * @param string $condition
	 */
	function removeOldTempUser( $fromUserId, $toUserId, $range, $condition ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			echo "Error: Read Only Mode.\n";
		} else {
			// get scope
			if ( empty($fromUserId) || empty($toUserId) ) {
				getScope( $fromUserId, $toUserId, $condition );
			}

			// remove old temp user
			$cnt = 0;
			do {
				$to = ( $toUserId - $fromUserId > $range ) ? $fromUserId + $range : $toUserId ;
				echo "Removing temp user (UserId $fromUserId to $to):\n";
				$users = getTempUsers( $fromUserId, $to, $condition );
				$cnt = $cnt + count($users);
				foreach ( $users as $username ) {
					$tempUser = TempUser::getTempUserFromName( $username );
					$id = $tempUser->getId();
					$tempUser->removeFromDatabase();
					
					// remove spoof normalization record from the database
					$spoof = new SpoofUser( $username );
					$spoof->removeRecord();
					
					echo "\tRemoved temp user (id=$id) from database.\n";
				}

				$fromUserId = $to;
			} while ( $fromUserId < $toUserId );

			echo "Total $cnt temp users removed from database.\n";
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * send confirmation reminder
	 * @param integer $fromUserId
	 * @param integer $toUserId
	 * @param integer $range 
	 * @param string $condition
	 */
	function sendReminder( $fromUserId, $toUserId, $range, $condition ) {
		global $wgCityId, $wgServer;

		wfProfileIn( __METHOD__ );

		$condition .= " and user_wiki_id = ".$wgCityId;

		// get scope
		if ( empty($fromUserId) || empty($toUserId) ) {
			getScope( $fromUserId, $toUserId, $condition );
		}

		// update url
		$wgServer = WikiFactory::getVarValueByName( 'wgServer', $wgCityId );

		$cnt = 0;
		do {
			$to = ( $toUserId - $fromUserId > $range ) ? $fromUserId + $range : $toUserId ;
			echo "WikiId $wgCityId: Sending reminder (UserId $fromUserId to $to)...\n";
			$users = getTempUsers( $fromUserId, $to, $condition );
			foreach ( $users as $username ) {
				$tempUser = TempUser::getTempUserFromName( $username );

				// send reminder email
				$user = $tempUser->mapTempUserToUser();
				$userLoginHelper = (new UserLoginHelper);
				$result = $userLoginHelper->sendConfirmationReminderEmail( $user );

				if( !$result->isGood() ) {
					echo "Error: Cannot Send reminder to temp user (id=".$tempUser->getId().", email=".$tempUser->getEmail()."): ".$result->getMessage()."\n";
				} else {
					$tempUser->saveSettingsTempUserToUser( $user );
					$cnt++;
					echo "Sent reminder to temp user (id=".$tempUser->getId().", email=".$tempUser->getEmail().").\n";
				}
			}

			$fromUserId = $to;
		} while ( $fromUserId < $toUserId );

		echo "WikiId $wgCityId: Total $cnt confirmation reminder emails sent.\n";

		wfProfileOut( __METHOD__ );
	}

	// ------------------------------------------- Main -------------------------------------------------

	ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

	require_once( "commandLine.inc" );

	if ( isset($options['help']) || !(isset($options['cleanup']) || isset($options['reminder']) || isset($options['wiki_reminder'])) ) {
		die( "Usage: php maintenance.php [--from_userid] [--to_userid] [--range] [--cleanup] [--reminder] [--wiki_reminder] [--help]
		--from_userid		from user id
		--to_userid			to user id
		--range				range of user (default = 10000)
		--cleanup			remove older temp user (user's registered date is older than 30 days)
		--reminder			send reminder (user's registered date = 7 days ago) for ALL wikis
		--wiki_reminder		send reminder for CURRENT wiki only
		--help				you are reading it right now\n\n" );
	}

	if ( isset($options['range']) && !is_numeric($options['range']) ) {
		die( "Error: Invalid range." );
	}

	if ( isset($options['from_userid']) && !is_numeric($options['from_userid']) ) {
		die( "Error: Invalid from_userid." );
	}

	if ( isset($options['to_userid']) && !is_numeric($options['to_userid']) ) {
		die( "Error: Invalid to_userid." );
	}

	if ( empty($wgCityId) ) {
		die( "Error: Invalid wiki id." );
	}

	$range = (isset($options['range'])) ? intval($options['range']) : 10000 ;
	$fromUserId = (isset($options['from_userid'])) ? intval($options['from_userid']) : 0 ;
	$toUserId = (isset($options['to_userid'])) ? intval($options['to_userid']) : 0 ;

	$cleanupCondition = "date(user_registration) < curdate() - interval 30 day";
	$reminderCondition = "date(user_registration) = curdate() - interval 7 day";

	// remove old temp user
	if ( isset($options['cleanup']) ) {
		removeOldTempUser( $fromUserId, $toUserId, $range, $cleanupCondition );
	}

	// send reminder for all wikis
	if ( isset($options['reminder']) ) {
		// get list of wikis
		$wikis = getWikis( $reminderCondition );

		// send reminder for each wiki
		foreach( $wikis as $wikiId) {
			$cmd = "SERVER_ID={$wikiId} php {$IP}/extensions/wikia/UserLogin/maintenance.php --conf={$wgWikiaLocalSettingsPath} --wiki_reminder";
			echo "Command: $cmd\n";
			$result = wfShellExec( $cmd, $retval );
			if ($retval) {
				echo "Error code $retval: $result \n";
			} else {
				echo "$result \n";
			}
		}
		echo "Reminder emails sent for ".count($wikis)." wikis.\n";
	}

	// send reminder for current wiki
	if ( isset($options['wiki_reminder']) ) {
		sendReminder( $fromUserId, $toUserId, $range, $reminderCondition );
	}
