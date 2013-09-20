<?php

class Query_A {

	public function getKey() {
		return "order-by-ns-and-title";
	}

	/**
	 * @param $wikiId
	 * @param $query
	 * @return float
	 */
	public function performQueryTest($wikiId, $query) {
		$wgLinkSuggestLimit = 6;
		$dbName = WikiFactory::IDtoDB( $wikiId );
		$db = wfGetDB(DB_SLAVE, [], $dbName);
		$namespaces = WikiFactory::getVarValueByName("wgContentNamespaces", $wikiId);
		$namespaces = $namespaces ? $namespaces : [0];
		$query = addslashes($query);

		$queryLower = strtolower($query);

		if (count($namespaces) > 0) {
			$commaJoinedNamespaces = count($namespaces) > 1 ? array_shift($namespaces) . ', ' . implode(', ', $namespaces) : $namespaces[0];
		}

		$pageNamespaceClause = isset($commaJoinedNamespaces) ? 'page_namespace IN (' . $commaJoinedNamespaces . ') AND ' : '';

		$pageTitlePrefilter = "";
		if (strlen($queryLower) >= 2) {
			$pageTitlePrefilter = "(
							( page_title " . $db->buildLike(strtoupper($queryLower[0]) . strtolower($queryLower[1]), $db->anyString()) . " ) OR
							( page_title " . $db->buildLike(strtoupper($queryLower[0]) . strtoupper($queryLower[1]), $db->anyString()) . " ) ) AND ";
		} else if (strlen($queryLower) >= 1) {
			$pageTitlePrefilter = "( page_title " . $db->buildLike(strtoupper($queryLower[0]), $db->anyString()) . " ) AND ";
		}

		$sql = "SELECT page_len, page_id, page_title, rd_title, page_namespace, page_is_redirect
						FROM page
						LEFT JOIN redirect ON page_is_redirect = 1 AND page_id = rd_from
						LEFT JOIN querycache ON qc_title = page_title AND qc_type = 'BrokenRedirects'
						WHERE  {$pageTitlePrefilter} {$pageNamespaceClause} (LOWER(page_title) LIKE '{$queryLower}%')
							AND qc_type IS NULL
						ORDER BY page_namespace,page_title
						LIMIT " . ($wgLinkSuggestLimit * 3); // we fetch 3 times more results to leave out redirects to the same page

		$start = microtime(true);
		$res = $db->query($sql, __METHOD__);
		while( $res->fetchRow() ) {}

		return microtime(true) - $start;
	}
}
