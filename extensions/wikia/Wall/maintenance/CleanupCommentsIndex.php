<?php
require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class CleanupCommentsIndex extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'only checks how many rows is affected' );
	}

	public function execute() {

		$dbMaster = wfGetDB( DB_MASTER );
		$dbSlave = wfGetDB( DB_SLAVE );

		$this->updateDeletedFlag( $dbMaster, $dbSlave );
		$this->removeBrokenRows( $dbMaster, $dbSlave );
	}

	public function updateDeletedFlag( DatabaseMysqli $dbMaster, DatabaseMysqli $dbSlave ) {
		global $wgDBname;

		$ids = $dbSlave->selectFieldValues(
			[ 'archive', 'comments_index' ],
			'comment_id',
			[ 'archived=0', 'deleted=0', 'removed=0', 'comment_id=ar_page_id', 'ar_namespace in (500,501,1200,1201,2000,2001)' ],  //TODO: not sure about 500 and 501 here
			__METHOD__,
			[ 'DISTINCT' ]
		);

		if ( is_array( $ids ) ) {
			$ids = array_map( function( $item ) {
				return intval( $item );
			}, $ids);

			$this->output( "{$wgDBname}: " . count( $ids ) . " rows to update\n" );

			if ( !$this->hasOption('dry-run') && !empty( $ids ) ) {
				$dbMaster->update(
					'comments_index',
					[ 'deleted' => 1 ],
					[ 'comment_id' => $ids ],
					__METHOD__
				);
			}
		}
	}

	public function removeBrokenRows( DatabaseMysqli $dbMaster, DatabaseMysqli $dbSlave ) {
		global $wgDBname;

		$ids = $dbSlave->selectFieldValues(
			[ 'page', 'comments_index' ],
			'comment_id',
			[ 'page_id=comment_id', 'page_namespace not in (500,501,1200,1201,2000,2001)' ],
			__METHOD__
		);

		if ( is_array( $ids ) ) {
			$ids = array_map( function( $item ) {
				return intval( $item );
			}, $ids);

			//TODO: remove it
			\Wikia\Logger\WikiaLogger::instance()->info(
				"{$wgDBname}: " . count( $ids ) . " rows to remove",
				[ "rows_count" => count( $ids ) ]
			);

			$this->output( "{$wgDBname}: " . count( $ids ) . " rows to remove\n" );

			if ( !$this->hasOption('dry-run') && !empty( $ids ) ) {
				$dbMaster->delete(
					'comments_index',
					[ "comment_id" => $ids ]
				);
			}
		}
	}
}

$maintClass = 'CleanupCommentsIndex';
require_once( RUN_MAINTENANCE_IF_MAIN );