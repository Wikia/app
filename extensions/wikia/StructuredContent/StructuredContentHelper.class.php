<?php

class StructuredContentHelper extends WikiaModel {

 	public function getChangedPagesList( $fromTimestamp = 0 ) {

		if ( (int)$fromTimestamp == 0 || strlen((string)$fromTimestamp)!= 14) {
			throw new WikiaException("startFrom parameter must be in format:YYYYMMDDHHiiSS", 1);
		}

		wfProfileIn(__METHOD__);

		$dbw = wfGetDB( DB_SLAVE );

		$sqlQuery = "SELECT p.page_id,
				    p.page_namespace,
				    p.page_title,
				    r.rev_timestamp
			     FROM revision r, page p
			     WHERE
			     	r.rev_page = p.page_id
				AND r.rev_timestamp >= ".(int)$fromTimestamp."
				AND r.rev_deleted = 0
				AND p.page_namespace IN ( ".implode(",", $this->wg->contentNamespaces).")
			     GROUP BY p.page_id
			     ORDER BY
			      	r.rev_timestamp
			     ";


		$pages = array();
		$rows = $dbw->query( $sqlQuery, __METHOD__ );

		while ( $row = $dbw->fetchRow($rows) ) {
			$pages[] = $row;
		}

		wfProfileOut(__METHOD__);

		return $pages;
	}
}