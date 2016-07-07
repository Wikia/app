<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Preferences\PreferenceService;

/**
 * Maintenance script for closing accounts that have been scheduled
 * to be closed
 *
 * @author  Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 */
class CloseMyAccountMaintenance extends Maintenance {

	const REQUEST_CLOSURE_PREF = 'requested-closure-date';

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		$this->setCurrentUser();

		$users = $this->getUsers();
		$numClosed = $this->closeAccounts( $users );

		$this->output( $numClosed . " user accounts closed.\n" );
	}

	public function getUsers() {
		/** @var PreferenceService $preferenceService */
		$preferenceService = Injector::getInjector()->get( PreferenceService::class );

		return $preferenceService->findUsersWithGlobalPreferenceValue( self::REQUEST_CLOSURE_PREF );
	}

	public function closeAccounts( $users ) {
		$accountsClosed = 0;

		if ( empty( $users ) ) {
			return $accountsClosed;
		}

		$closeAccountHelper = new CloseMyAccountHelper();

		foreach ( $users as $userId ) {
			$userObj = User::newFromId( $userId );
			$daysRemaining = $closeAccountHelper->getDaysUntilClosure( $userObj );

			if ( $daysRemaining === 0 ) {
				$success = $this->closeUserAccount( $userObj );
				if ( !$success ) {
					$this->output( "Failed to close account for {$userObj->getName()}\n" );
					continue;
				}

				$closeAccountHelper->track( $userObj, 'account-closed' );

				$accountsClosed++;
			}
		}

		return $accountsClosed;
	}

	public function closeUserAccount( User $userObj ) {
		$this->output( "Closing account {$userObj->getName()}...\n" );

		$closeReason = 'User requested account closure more than 30 days ago';
		$statusMsg1 = '';
		$statusMsg2 = '';
		$keepEmail = true;
		$success = EditAccount::closeAccount( $userObj, $closeReason, $statusMsg1, $statusMsg2, $keepEmail );

		if ( !$success ) {
			return false;
		}

		// Set an option that signifies this user was closed automatically
		$userObj->setGlobalPreference( 'disabled-by-user-request', true );

		// Cleanup
		$userObj->setGlobalPreference( 'requested-closure-date', null );

		$userObj->saveSettings();

		return true;
	}

	public function setCurrentUser() {
		global $wgUser;

		$wgUser = User::newFromName( 'Wikia' );
	}
}

$maintClass = 'CloseMyAccountMaintenance';
require_once RUN_MAINTENANCE_IF_MAIN;
