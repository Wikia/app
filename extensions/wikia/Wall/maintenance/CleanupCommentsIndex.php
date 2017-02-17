<?php
require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class CleanupCommentsIndex extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'only checks how many rows is affected' );
	}

	public function execute() {
		global $wgDBname;

		$db = wfGetDB( DB_MASTER );

		$ids = $db->selectFieldValues(
			[ 'page', 'comments_index' ],
			'comment_id',
			[ 'page_id=comment_id', 'page_namespace not in (1,500,501,1200,1201,2000,2001)' ],
			__METHOD__
		);

		if ( is_array( $ids ) ) {
			$ids = array_map( function( $item ) {
				return intval( $item );
			}, $ids);

			\Wikia\Logger\WikiaLogger::instance()->info(
				"{$wgDBname}: " . count( $ids ) . " rows affected",
				[ "rows_count" => count( $ids ) ]
			);

			$this->output( "{$wgDBname}: " . count( $ids ) . " rows affected\n" );

			if ( !$this->hasOption('dry-run') ) {
				$db->delete( 'comments_index', "comment_id in (" . implode( ',', $ids ) . ")" );
			}
		}
	}
}

$maintClass = 'CleanupCommentsIndex';
require_once( RUN_MAINTENANCE_IF_MAIN );