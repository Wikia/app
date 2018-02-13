<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * SUS-4169: Maintenance script that runs periodically to clean unused user groups from database.
 */
class RemoveUnusedGroups extends Maintenance {
	use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Removes entries for no longer existing groups from user_groups table' );
		$this->addArg( 'dry-run', 'run script without making any changes' );
		$this->addArg( 'run-on-wikicities', 'execute script against wikicities (shared) DB' );
	}

	public function execute() {
		if ( $this->hasArg( 'dry-run' ) ) {
			$this->output( "Dry-run mode, no changes will be made!\n" );

			$dbr = $this->getDatabase( DB_SLAVE );

			$count = $dbr->selectField(
				'user_groups',
				'count(*)',
			'ug_group NOT IN (' . $dbr->makeList( $this->getValidGroups() ) . ')',
				__METHOD__
			);

			$this->output( "Found $count entries referring to nonexistent groups" );
		} else {
			$dbw = $this->getDatabase( DB_MASTER );

			$dbw->delete(
				'user_groups',
				[ 'ug_group NOT IN (' . $dbw->makeList( $this->getValidGroups() ) . ')' ],
				__METHOD__
			);

			$this->output( "Deleted {$dbw->affectedRows()} entries referring to nonexistent groups." );
		}
	}

	private function getValidGroups(): array {
		$permissionsConfiguration = $this->permissionsService()->getConfiguration();

		if ( $this->hasArg( 'run-on-wikicities' ) ) {
			// only global groups should be set on wikicities
			return $permissionsConfiguration->getGlobalGroups();
		}

		// remove entries for global groups on individual wikis
		return array_diff(
			$permissionsConfiguration->getExplicitGroups(),
			$permissionsConfiguration->getGlobalGroups()
		);
	}

	private function getDatabase( int $dbType ): DatabaseBase {
		if ( $this->hasArg( 'run-on-wikicities' ) ) {
			global $wgExternalSharedDB;
			return wfGetDB( $dbType, [], $wgExternalSharedDB );
		}

		return wfGetDB( $dbType );
	}
}

$maintClass = RemoveUnusedGroups::class;
require_once RUN_MAINTENANCE_IF_MAIN;
