<?php

class SuggestWantedPagesController extends WikiaController {

	/**
	 * Add wanted pages to results returned by API module
	 *
	 * @param ApiBase $api OpenSearch API module
	 * @param Array $params API query parameters
	 * @param Array $results API query results passed as a reference
	 * @return true it's a hook
	 */
	function onApiOpenSearchExecute(ApiBase $api, Array $params, Array $results) {
		$search = $params['search'];

		$dbr = $this->wf->GetDb(DB_SLAVE);
		$queryPage = new WantedPagesPage();

		$sql = $dbr->limitResult($queryPage->getSQL(), $params['limit'], 0);

		// modify wanted pages SQL
		$sql = str_replace(
			'GROUP BY ',
			'AND pl_title LIKE "' . addslashes($search)  . '%" GROUP BY ',
			$sql);

		$res = $dbr->query($sql, __METHOD__);

		foreach($res as $row) {
			$title = Title::newFromText($row->title, $row->namespace);

			if ($title instanceof Title) {
				$results[] = $title->getPrefixedText();
			}
		}

		return true;
	}
}
