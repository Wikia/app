<?php
/**
 * Migrate requested-closure-date values from the user_properties table
 * to the permissions service. Note, this does not delete those values
 * from the user_properties table, that will be done separately.
 *
 * This is a one time script.
 * See SOC-2187
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class MigrateReqCloseDateToPermService extends Maintenance {

	private $force;
	private $totalUsersMigrated = 0;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'force', "Actually perform migration, script defaults to test mode" );
	}

	public function execute() {
		$this->force = $this->hasOption( 'force' );

		if ( !$this->force ) {
			$this->output( "Running in dry-run mode!" );
		}

		foreach ( $this->getUsersToMigrate() as $user ) {
			$this->migrateUser( $user );
		}

		$this->printResults();
	}

	private function getUsersToMigrate() {
		global $wgExternalSharedDB;
		$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		return ( new WikiaSQL() )
			->SELECT( 'up_user', 'up_value' )
			->FROM( 'user_properties' )
			->WHERE( 'up_property' )->EQUAL_TO( 'requested-closure-date' )
			->runLoop( $db, function( &$result, $row ) {
				$result[] = [
					'userId' => $row->up_user,
					'requestedClosureDate' => $row->up_value
				];
			} );
	}

	private function migrateUser( array $userArray ) {
		$this->logUserMigration( $userArray );
		$user = User::newFromId( $userArray['userId'] );
		$user->setGlobalPreference( 'requested-closure-date', $userArray['requestedClosureDate'] );
		if ( $this->force ) {
			$user->saveSettings();
		}

		$this->totalUsersMigrated++;
	}

	private function logUserMigration( array $userArray ) {
		$this->output(
			sprintf( "Migrating user %d with requested-closure-date value %s...",
				$userArray['userId'],
				$userArray['requestedClosureDate']
			)
		);
	}

	private function printResults() {
		$this->output( "Done!" );
		$this->output( sprintf( "Total users migrated: %d", $this->totalUsersMigrated ) );
	}

	protected function output( $msg ) {
		parent::output( $msg . "\n" );
	}
}

$maintClass = "MigrateReqCloseDateToPermService";
require_once( RUN_MAINTENANCE_IF_MAIN );
