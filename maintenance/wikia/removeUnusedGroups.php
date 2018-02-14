<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * SUS-4169: Maintenance script that runs periodically to clean unused user groups from database.
 */
class RemoveUnusedGroups extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Removes entries for no longer existing groups from user_groups table' );
		$this->addOption( 'dry-run', 'run script without making any changes', false );
		$this->addOption( 'run-on-wikicities', 'execute script against wikicities (shared) DB', false );
	}

	public function execute() {
		if ( $this->hasOption( 'dry-run' ) ) {
			$this->output( "Dry-run mode, no changes will be made!\n" );

			$dbr = $this->getDatabase( DB_SLAVE );

			$count = $dbr->selectField(
				'user_groups',
				'count(*)',
				'ug_group NOT IN (' . $dbr->makeList( $this->getValidGroups() ) . ')',
				__METHOD__
			);

			$notValidScope = $this->hasOption( 'run-on-wikicities' ) ? "local" : "global";

			$notValidGroups = $dbr->select(
				'user_groups',
				'distinct ug_group',
				'ug_group NOT IN (' . $dbr->makeList( $this->getValidGroups() ) . ')',
				__METHOD__
			);

			if ( $count == 0 ) {
				$this->output( "There are no entries referring to nonexistent or $notValidScope groups.\n" );
				return;
			}

			$this->output( "Found $count entries referring to the following nonexistent or $notValidScope groups:\n" );

			foreach ( $notValidGroups as $row ) {
				$this->output( "\t- {$row->ug_group}\n" );
			}

		} else {
			$dbw = $this->getDatabase( DB_MASTER );

			$dbw->delete(
				'user_groups',
				[ 'ug_group NOT IN (' . $dbw->makeList( $this->getValidGroups() ) . ')' ],
				__METHOD__
			);

			$this->output( "Deleted {$dbw->affectedRows()} entries referring to nonexistent groups.\n" );
		}
	}

	private function getValidGroups(): array {
		$injector = \Wikia\DependencyInjection\Injector::getInjector();
		$permissionsConfiguration =
			$injector->get( \Wikia\Service\User\Permissions\PermissionsConfiguration::class );

		if ( $this->hasOption( 'run-on-wikicities' ) ) {
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
		if ( $this->hasOption( 'run-on-wikicities' ) ) {
			global $wgExternalSharedDB;
			return wfGetDB( $dbType, [], $wgExternalSharedDB );
		}

		return wfGetDB( $dbType );
	}
}

$maintClass = RemoveUnusedGroups::class;
require_once RUN_MAINTENANCE_IF_MAIN;
