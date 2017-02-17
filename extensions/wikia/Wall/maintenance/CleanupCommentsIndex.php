<?php
require_once( getenv( 'MW_INSTALL_PATH' ) !== false ? getenv( 'MW_INSTALL_PATH' ) . '/maintenance/Maintenance.php' : dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class CleanupCommentsIndex extends Maintenance {


	public function execute() {
		$getIdsQuery = "select page_id from page, comments_index where page_id=comment_id and page_namespace not in (1,500,501,1200,1201,2000,2001)";

		$db = wfGetDB( DB_MASTER );

		$ids = [];

		$result = $db->query( $getIdsQuery );
		while ( $row = $db->fetchRow( $result ) ) {
			$ids[] = intval( $row['page_id'] );
		};

		$deleteQuery = "DELETE FROM comments_index WHERE comment_id in (" . implode( ',', $ids ) . ")";

		$db->query( $deleteQuery );
	}
}

$maintClass = 'CleanupCommentsIndex';
require_once( RUN_MAINTENANCE_IF_MAIN );