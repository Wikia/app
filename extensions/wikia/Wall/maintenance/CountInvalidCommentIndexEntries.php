<?php

require_once( getenv( 'MW_INSTALL_PATH' ) !== false ? getenv( 'MW_INSTALL_PATH' ) . '/maintenance/Maintenance.php' : dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class CountInvalidCommentIndexEntries extends Maintenance {

	public function execute() {
		global $wgCityId, $wgDBname;

		$count = $this->getInvalidEntriesCount();

		if ($count > 0) {
			$this->output("Wiki: " . $wgCityId . " count: " . $count);
			$file = fopen($wgCityId . ".txt", "w");
			fwrite($file, '{"wiki": ' . $wgCityId . ', "count": ' . $count . ', "dbname": ' . $wgDBname . '}');
			fclose($file);
		}
	}

	public function getInvalidEntriesCount() {
		$db = wfGetDB( DB_SLAVE );
		$query = "select count(*) as cnt from page, comments_index where  page_id=comment_id and  page_namespace not in (1,500,501,1200,1201,2000,2001)";

		$row = $db->query($query)->fetchRow();
		return $row['cnt'];
	}
}

$maintClass = 'CountInvalidCommentIndexEntries';
require_once( RUN_MAINTENANCE_IF_MAIN );
