<?php

require_once( getenv( 'MW_INSTALL_PATH' ) !== false ? getenv( 'MW_INSTALL_PATH' ) . '/maintenance/Maintenance.php' : dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class CountInvalidCommentIndexEntries extends Maintenance {

	public function execute() {
		global $wgCityId, $wgDBname;

		$count = $this->getInvalidEntriesCount();

		if ($count > 0) {
			$entry = '{"wiki": ' . $wgCityId . ', commentsIndexCount:' . $this->getCommentsIndexCount() . ', "invalidCount": ' . $count . ', "dbname": ' . $wgDBname . '}';
			$this->output($entry . "\n");

			$file = fopen($wgCityId . ".txt", "w");
			fwrite($file, $entry);
			fclose($file);
		}
	}

	public function  getCommentsIndexCount() {
		$db = wfGetDB( DB_SLAVE );
		$query = "select count(*) as cnt from comments_index";

		$row = $db->query($query)->fetchRow();
		return $row['cnt'];
	}

	public function getInvalidEntriesCount() {
		global $wgArticleCommentsNamespaces;

		$namespaces = array_unique(array_merge([1,500,501,1200,1201,2000,2001], $wgArticleCommentsNamespaces));

		$db = wfGetDB( DB_SLAVE );
		$query = "select count(*) as cnt from page, comments_index where  page_id=comment_id and  page_namespace not in (" . implode(',', $namespaces) . ")";

		$row = $db->query($query)->fetchRow();
		return $row['cnt'];
	}
}

$maintClass = 'CountInvalidCommentIndexEntries';
require_once( RUN_MAINTENANCE_IF_MAIN );
