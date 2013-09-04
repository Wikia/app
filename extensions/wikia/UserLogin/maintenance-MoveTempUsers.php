<?php

	/**
	 * Maintenance script to 
	 *    - move records from user_temp to user table and mark with unconfirmed signup
	 * @author Kamil Koterba
	 */

	/**
	 * Get list of temp users' names
	 * Pick only not expired records (later than 30 days)
	 * @return $tempUsersNames Array of Strings
	 */
	function getTempUsers() {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$tempUsersNames = array();

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		//prepare date range
		$date = new DateTime();
		$date->add(date_interval_create_from_date_string('1 day'));
		$to = date_format($date, 'Ymdu');
		$date->sub(date_interval_create_from_date_string('31 days'));
		$from =  date_format($date, 'Ymdu');

		//query
		$queryString = "SELECT user_name FROM `user_temp` force key(user_registration) WHERE (user_registration between '$from' and '$to') order by user_registration;";

		$result = $dbr->query( $queryString, __METHOD__ );

		while ( $row = $dbr->fetchObject($result) ) {
			$tempUsersNames[] = $row->user_name;
		}
		$dbr->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $tempUsersNames;
	}

	/**
	 * Move temp users from user_temp table to user table
	 */
	function moveTempUsers() {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			echo "Error: Read Only Mode.\n";
		} else {
			$cnt = 0;
			$tempUsersNames = getTempUsers();

			// remove old temp user
			foreach ( $tempUsersNames as $tempusername ) {
				$tempUser = TempUser::getTempUserFromName( $tempusername );
				$user = $tempUser->mapTempUserToUser( false );
				$user->setOption( UserLoginSpecialController::SIGNUP_REDIRECT_OPTION_NAME, $tempUser->getSource() );
				$user->setOption( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, true );
				$user->setOption( UserLoginSpecialController::USER_SIGNED_UP_ON_WIKI_OPTION_NAME, $tempUser->getWikiId() );
				$user->saveSettings();
				$tempUser->removeFromDatabase();
				
				$id = $user->getId();
				$cnt++;

				echo "\tMoved temp user (id=$id) from database.\n";
			}

			echo "$cnt of total ". sizeof($tempUsersNames) ." temp users were moved to user table.\n";
		}

		wfProfileOut( __METHOD__ );
	}


	// ------------------------------------------- Main -------------------------------------------------

	ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

	require_once( "commandLine.inc" );

	if ( isset($options['help']) || !( isset( $options['move_temp_users'] ) ) ) {
		die( "Usage: php maintenance.php [--move_temp_users] [--help]
		--move_temp_users	move records from user_temp to user
		--help				you are reading it right now\n\n" );
	}

	if ( empty($wgCityId) ) {
		die( "Error: Invalid wiki id." );
	}

	// remove old temp user
	if ( isset($options['move_temp_users']) ) {
		moveTempUsers();
	}
