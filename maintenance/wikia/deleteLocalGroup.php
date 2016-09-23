<?php

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Use this script together with "run_maintenance" to delete all user assignments to the given local group
 */
class DeleteLocalGroupMaintenance extends Maintenance {

	const TABLE_NAME = 'user_groups';

	static $allowed_groups = [
		'upwizcampeditors'
	];

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Deletes a given local group from all wikis';
		$this->addOption( 'group', 'Name of group to delete', true, true );
		$this->addOption( 'delete', 'Do actually delete the data (no dry run mode)', false, false );
	}

	public function execute() {
		global $wgDBname, $wgDBCluster;

		$group = $this->getOption( "group" );
		$delete = $this->getOption( "delete", false );
		if ( !in_array( $group, self::$allowed_groups ) ) {
			die( "Error: requested group " . $group . " not in the allowed white-list\n" );
		}

		$then = microtime( true );
		if ( !$delete ) {
			$this->output( "Getting entries count for group on {$wgDBname} ({$wgDBCluster})\n" );
			$dbw = $this->getDB( DB_SLAVE );

			$count = $dbw->selectField(
				self::TABLE_NAME,
				'count(*)',
				[ 'ug_group' => $group ],
				__METHOD__
			);

			$this->output( "Row count: " . $count . "\n" );
		} else {
			$this->output( "Deleting group on {$wgDBname} ({$wgDBCluster})\n" );
			$dbw = $this->getDB( DB_MASTER );
			$dbw->begin();
			$dbw->delete(
				self::TABLE_NAME,
				[ 'ug_group' => $group ],
				__METHOD__
			);
			$dbw->commit();
		}
		$took = microtime( true ) - $then;

		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'cluster' => $wgDBCluster,
			'took' => round( $took, 6 ),
		] );

		$this->output( "done\n" );
	}
}

$maintClass = DeleteLocalGroupMaintenance::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
