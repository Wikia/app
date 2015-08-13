<?php

	/**
	 * Maintenance script to
	 *    - run reminder process: get list of wikis and send reminder for each wiki
	 *    - send reminder (user's registered date = 7 days) for current wiki ONLY
	 * @author Hyun
	 * @author Saipetch
	 * @author Kamil Koterba
	 */

	/**
	 * Get list of wikis for sending reminder (user's registered date = 7 days)
	 *
	 * @return array $wikis
	 */
	function getWikis() {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$wikis = array();

		$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$result = $db->select(
			'user_properties',
			array( 'distinct up_value' ),
			array( 'up_property = "' . UserLoginSpecialController::SIGNED_UP_ON_WIKI_OPTION_NAME . '"' ),
			__METHOD__
		);

		while ( $row = $db->fetchObject( $result ) ) {
			$wikis[] = $row->up_value;
		}
		$db->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $wikis;
	}


	/**
	 * Get IDs of users to send reminder
	 * Conditions
	 * - user email not authenticated
	 * - users created on current wiki ($wgCityId)
	 * - users signed up 7 days ago
	 * - users with NotConfirmedSignup property set to 1
	 *
	 * @return $recepients Array of Users
	 */
	function getRecipientsForCurrentWiki() {
		global $wgCityId, $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$res = $dbr->select(
			array( '`user`', 'user_properties' ),
			array( 'user_id' ),
			array( /* WHERE */
				'user_email_authenticated' => NULL,
				'up_property' => UserLoginSpecialController::SIGNED_UP_ON_WIKI_OPTION_NAME,
				'up_value' => $wgCityId,
				'date(user_registration) = curdate() - interval 7 day'
			),
			__METHOD__,
			array(),
			array(
				'user_properties' => array( 'INNER JOIN', 'user_id = up_user' )
			)
		);

		$recepients = array();

		foreach ( $res as $userItem ) {
			$user = User::newFromId( $userItem->user_id );
			if ( $user->getGlobalFlag( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME ) ) {
				$recepients[] = $user;
			}
		}

		wfProfileOut( __METHOD__ );

		return $recepients;
	}

	/**
	 * Send confirmation reminder emails for users that signed up on current wiki 7 days ago
	 */
	function sendReminder() {
		global $wgCityId, $wgServer;

		wfProfileIn( __METHOD__ );

		// update url
		$wgServer = WikiFactory::getVarValueByName( 'wgServer', $wgCityId );

		$users = getRecipientsForCurrentWiki();

		$cnt = 0;
		$userLoginHelper = ( new UserLoginHelper );
		foreach ( $users as $user ) {

			// send reminder email
			$result = $userLoginHelper->sendConfirmationReminderEmail( $user );

			if ( !$result->isGood() ) {
				echo "Error: Cannot send reminder to user (id=" . $user->getId() . ", email=" . $user->getEmail() . "): " . $result->getMessage() . "\n";
			} else {
				$cnt++;
				echo "Sent reminder to user (id=" . $user->getId() . ", email=" . $user->getEmail() . ").\n";
			}

		}

		echo "WikiId $wgCityId: " . sizeof( $users ) . " of total $cnt confirmation reminder emails sent.\n";

		wfProfileOut( __METHOD__ );
	}

	// ------------------------------------------- Main -------------------------------------------------

	ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

	require_once( "commandLine.inc" );

	if ( isset( $options['help'] ) || !( isset( $options['cleanup'] ) || isset( $options['reminder'] ) || isset( $options['wiki_reminder'] ) ) ) {
		die( "Usage: php maintenance.php [--cleanup] [--reminder] [--wiki_reminder] [--help]
		--reminder			send reminder (user's registered date = 7 days ago) for ALL wikis
		--wiki_reminder		send reminder for CURRENT wiki only
		--help				you are reading it right now\n\n" );
	}

	if ( empty( $wgCityId ) ) {
		die( "Error: Invalid wiki id." );
	}

	// send reminder for all wikis
	if ( isset( $options['reminder'] ) ) {
		// get list of wikis
		$wikis = getWikis();

		// send reminder for each wiki
		foreach ( $wikis as $wikiId ) {
			$cmd = "SERVER_ID={$wikiId} php {$IP}/extensions/wikia/UserLogin/maintenance.php --conf={$wgWikiaLocalSettingsPath} --wiki_reminder";
			echo "Command: $cmd\n";
			$result = wfShellExec( $cmd, $retval );
			if ( $retval ) {
				echo "Error code $retval: $result \n";
			} else {
				echo "$result \n";
			}
		}
		echo "Reminder emails sent for " . count( $wikis ) . " wikis.\n";
	}

	// send reminder for current wiki
	if ( isset( $options['wiki_reminder'] ) ) {
		sendReminder();
	}
