<?php

if (!defined('MEDIAWIKI')) die();

/**
 * Subclass of SMWQueryResult - this class was mostly created in order to
 * get around an inconvenient print-request-compatibility check in
 * SMWQueryResult::addRow()
 *
 * @ingroup SemanticCompoundQueries
 * @author Yaron Koren
 */
class SCQQueryResult extends SMWQueryResult {

	function addResult($new_result) {
		// create an array of the pages already in this query result,
		// so that we can check against it to make sure that pages
		// aren't included twice
		$existing_page_names = array();
		while ($row = $this->getNext()) {
			if ($row[0] instanceof SMWResultArray) {
				$content = $row[0]->getContent();
				$existing_page_names[] = $content[0]->getLongText(SMW_OUTPUT_WIKI);
			}
		}
		while (($row = $new_result->getNext()) !== false) {
			$row[0]->display_options = $new_result->display_options;
			$content = $row[0]->getContent();
			$page_name = $content[0]->getLongText(SMW_OUTPUT_WIKI);
			if (! in_array($page_name, $existing_page_names))
				$this->m_content[] = $row;
		}
		reset($this->m_content);
	}
}
