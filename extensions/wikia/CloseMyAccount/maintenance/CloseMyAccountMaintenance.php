<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

/**
 * Maintenance script for closing accounts that have been scheduled
 * to be closed
 *
 * @author  Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 */
class CloseMyAccountMaintenance extends Maintenance {

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgUser, $wgExternalSharedDB;

		// Currently, inverted searches (using a column other than up_user) may not
		// be supported for preferences in the future. However this feature may be
		// supported for user "flags" if we need to do reverse lookups like these.
		// See https://wikia-inc.atlassian.net/browse/SERVICES-469.
		// --drsnyder

		echo "*******************************************************";
		echo "Warning, inverted searches on 'user_properties' may be deprecated soon. Contact the services team.";
		echo "*******************************************************";

		$closeAccountHelper = new CloseMyAccountHelper();

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		// Only get users who self-requested account closure
		$subQuery = $dbr->selectSQLText(
			'user_properties',
			[ 'up_user' ],
			[
				'up_property' => 'requested-closure-date',
			],
			__METHOD__
		);

		$res = $dbr->select(
			'user_properties',
			[ 'up_user' ],
			[
				'up_property' => 'requested-closure',
				'up_value' => 1,
				'up_user IN (' . $subQuery . ')',
			],
			__METHOD__
		);

		$usersClosed = [];

		$closeReason = 'User requested account closure more than 30 days ago';

		$wgUser = User::newFromName( 'Wikia' );

		foreach ( $res as $row ) {
			$userObj = User::newFromId( $row->up_user );
			$daysRemaining = $closeAccountHelper->getDaysUntilClosure( $userObj );

			if ( $daysRemaining === 0 ) {
				$this->output( "Closing account {$userObj->getName()}...\n" );
				$statusMsg1 = '';
				$statusMsg2 = '';
				$result = EditAccount::closeAccount( $userObj, $closeReason, $statusMsg1, $statusMsg2, /*$keepEmail = */true );

				// Set an option that signifies this user was closed automatically
				$userObj->setGlobalFlag( 'disabled-by-user-request', true );

				// Cleanup
				$userObj->setGlobalFlag( 'requested-closure', null );

				// requested-closure-date is temporarily being stored as both an attribute and a preference.
				// Make sure to delete from both places. This will be changed to just a preference once the
				// migration is complete. See SOC-2185
				$userObj->setGlobalAttribute( 'requested-closure-date', null );
				$userObj->setGlobalPreference( 'requested-closure-date', null );

				$userObj->saveSettings();

				$closeAccountHelper->track( $userObj, 'account-closed' );

				$usersClosed[] = $userObj->getName();
			}
		}

		$this->output( count( $usersClosed ) . " user accounts closed.\n" );
	}
}

$maintClass = 'CloseMyAccountMaintenance';
require_once RUN_MAINTENANCE_IF_MAIN;
