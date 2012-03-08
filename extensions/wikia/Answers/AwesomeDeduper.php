<?php

class AwesomeDeduper extends SuperDeduper {

	function getPotentialMatchesFromMediawiki( $text, $limit ) {

		$out = array();

		// Nick wrote: Lock contention issues due to MyISAM
		// Disabling until we have a better solution
		return $out;

/**
		$dbr = wfGetDB( DB_SLAVE, 'search', $this->db_name );
		$sql = "SELECT page_title, si_title FROM searchindex
			INNER JOIN page ON searchindex.si_page = page.page_id
			WHERE MATCH (si_title)
			 AGAINST ('" . $dbr->strencode($text) . "' WITH QUERY EXPANSION)
			AND page.page_is_redirect = 0
			AND page_namespace = 0";
		if( !empty( $limit ) ) {
			$sql .= " LIMIT " . intval($limit)*2;
		}
		$res = $dbr->query( $sql );
		foreach( $res as $row ) {
			$out[] = str_replace( '_', ' ', $row->page_title );
		}
		return $out;
**/
	}

}

