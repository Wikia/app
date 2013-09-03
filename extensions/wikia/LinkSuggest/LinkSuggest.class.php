<?php

use \Wikia\Measurements\Time as T;

/**
 * LinkSuggest main class
 *
 * @author Inez Korczyński <inez@wikia-inc.com>
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Lucas Garczewski (TOR) <tor@wikia-inc.com>
 * @author Sean Colombo <sean@wikia.com>
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Robert Elwell <robert@wikia-inc.com>
 */
class LinkSuggest {

	/**
	 * Get list of suggested images
	 *
	 * @param string $imageName
	 * @return string
	 *
	 * @author Inez Korczyński <inez@wikia-inc.com>
	 */
	static function getLinkSuggestImage($imageName) {
		wfProfileIn(__METHOD__);

		$out = 'N/A';
		try {
			$img = wfFindFile($imageName);
			if($img instanceof File) {
				$out = $img->createThumb(180);
			}
		} catch (Exception $e) {
			$out = 'N/A';
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Get a list of suggested titles
	 *
	 * @param WebRequest $request
	 * @return bool|Object|string
	 *
	 * @author Inez Korczyński <inez@wikia-inc.com>
	 * @author Robert Elwell <robert@wikia-inc.com>
	 */

	static function getLinkSuggest(WebRequest $request) {
		global $wgContLang, $wgContentNamespaces, $wgMemc, $wgLinkSuggestLimit;
		$measurement = T::start(__FUNCTION__);
		wfProfileIn(__METHOD__);

		$isMobile = F::app()->checkSkin( 'wikiamobile' );
		// trim passed query and replace spaces by underscores
		// - this is how MediaWiki store article titles in database
		$query = urldecode( trim( $request->getText('query') ) );
		$query = str_replace(' ', '_', $query);

		if ( $isMobile ) {
			$key = wfMemcKey( __METHOD__, md5( $query.'_'.$request->getText('format').$request->getText('nospecial', '') ), 'WikiaMobile' );
		} else {
			$key = wfMemcKey( __METHOD__, md5( $query.'_'.$request->getText('format').$request->getText('nospecial', '') ) );
		}

		if (strlen($query) < 3) {
			// enforce minimum character limit on server side
			$out = self::getEmptyResponse($request->getText('format'));
		} else if (false && $cached = $wgMemc->get($key)) {
			$out = $cached;
		}

		if (isset($out)) {
			wfProfileOut(__METHOD__);
			return $out;
		}

		// Allow the calling-code to specify a namespace to search in (which at the moment, could be overridden by having prefixed text in the input field).
		// NOTE: This extension does parse titles to try to find things in other namespaces, but that actually doesn't work in practice because jQuery
		// Autocomplete will stop making requests after it finds 0 results.  So if you start to type "Category" and there is no page beginning
		// with "Cate", it will not even make the call to LinkSuggest.
		$namespace = $request->getVal('ns');

		// explode passed query by ':' to get namespace and article title
		$queryParts = explode(':', $query, 2);

		if(count($queryParts) == 2) {
			$query = $queryParts[1];

			$namespaceName = $queryParts[0];

			// try to get the index by canonical name first
			$namespace = MWNamespace::getCanonicalIndex(strtolower($namespaceName));
			if ( $namespace == null ) {
				// if we failed, try looking through localized namespace names
				$namespace = array_search(ucfirst($namespaceName), $wgContLang->getNamespaces());
				if (empty($namespace)) {
					// getting here means our "namespace" is not real and can only be part of the title
					$query = $namespaceName . ':' . $query;
				}
			}

			if ($namespace !== null && $query === '') {
				$out = self::getEmptyResponse($request->getText('format'));
				wfProfileOut(__METHOD__);
				return $out;
			}
		}

		// which namespaces to search in?
		if (empty($namespace)) {
			// search only within content namespaces (BugId:4625) - default behaviour
			$namespaces = $wgContentNamespaces;
		}
		else {
			// search only within a given namespace
			$namespaces = array($namespace);
		}

		//limit the result only to this namespace
		$namespaceFilter = $request->getVal('nsfilter');

		if(strlen($namespaceFilter) > 0) {
			$namespaces = array($namespaceFilter);
		}

		if (!empty($namespaceFilter) && $namespace != $namespaceFilter) {
			$out = self::getEmptyResponse($request->getText('format'));

			wfProfileOut(__METHOD__);
			return $out;
		}

		$query = addslashes($query);

		$db = wfGetDB(DB_SLAVE, 'search');

		$redirects = array();
		$results = array();
		$exactMatchRow = null;

		$queryLower = strtolower($query);
		$sql1Measurement = T::start([ __FUNCTION__ , "sql-1" ]);
		$res = $db->select(
			array( 'querycache', 'page' ),
			array( 'page_namespace', 'page_title', 'page_is_redirect' ),
			array(
				'qc_title = page_title',
				'qc_namespace = page_namespace',
				'page_is_redirect = 0',
				'qc_type' => 'Mostlinked',
				"(qc_title LIKE '{$query}%' or LOWER(qc_title) LIKE '{$queryLower}%')",
				'qc_namespace' => $namespaces
			),
			__METHOD__,
			array( 'ORDER BY' => 'qc_value DESC', 'LIMIT' => $wgLinkSuggestLimit )
		);

		self::formatResults($db, $res, $query, $redirects, $results, $exactMatchRow);
		$sql1Measurement->stop();
		if (count($namespaces) > 0) {
			$commaJoinedNamespaces = count($namespaces) > 1 ?  array_shift($namespaces) . ', ' . implode(', ', $namespaces) : $namespaces[0];
		}

		$pageNamespaceClause = isset($commaJoinedNamespaces) ?  'page_namespace IN (' . $commaJoinedNamespaces . ') AND ' : '';
		if( count($results) < $wgLinkSuggestLimit ) {
			/**
			 * @var string $pageTitlePrefilter this condition is able to use name_title index. It's added only for performance reasons.
			 * It uses fact that page titles can't start with lowercase letter.
			 */
			$pageTitlePrefilter = "";
			if( strlen($queryLower) >= 2 ) {
				$pageTitlePrefilter = "(
							( page_title " . $db->buildLike(strtoupper($queryLower[0]) . strtolower($queryLower[1]) , $db->anyString() ) . " ) OR
							( page_title " . $db->buildLike(strtoupper($queryLower[0]) . strtoupper($queryLower[1]) , $db->anyString() ) . " ) ) AND ";
			} else if( strlen($queryLower) >= 1 ) {
				$pageTitlePrefilter = "( page_title " . $db->buildLike(strtoupper($queryLower[0]) , $db->anyString() ) . " ) AND ";
			}
			// TODO: use $db->select helper method
			$sql = "SELECT page_len, page_id, page_title, rd_title, page_namespace, page_is_redirect
						FROM page
						LEFT JOIN redirect ON page_is_redirect = 1 AND page_id = rd_from
						LEFT JOIN querycache ON qc_title = page_title AND qc_type = 'BrokenRedirects'
						WHERE  {$pageTitlePrefilter} {$pageNamespaceClause} (LOWER(page_title) LIKE '{$queryLower}%')
							AND qc_type IS NULL
						LIMIT ".($wgLinkSuggestLimit * 3); // we fetch 3 times more results to leave out redirects to the same page

			$sql2Measurement = T::start([ __FUNCTION__, "sql-2" ]);
			$res = $db->query($sql, __METHOD__);

			self::formatResults($db, $res, $query, $redirects, $results, $exactMatchRow);
			$sql2Measurement->stop();
		}

		if ($exactMatchRow !== null) {

			/* @var StdClass $exactMatchRow */
			$row = $exactMatchRow;

			$titleFormatted = self::formatTitle($row->page_namespace, $row->page_title);

			if ($row->page_is_redirect == 0) {

				// remove any instances of original array's value
				$resultsFlipped = array_flip($results);
				unset($resultsFlipped[$titleFormatted]);
				$results = array_flip($resultsFlipped);

				array_unshift($results, $titleFormatted);

				$flippedRedirs = array_flip($redirects);
				if (isset($flippedRedirs[$titleFormatted])) {
					unset($redirects[$flippedRedirs[$titleFormatted]]);
				}

			} else {

				$redirTitleFormatted = self::formatTitle($row->page_namespace, $row->rd_title);

				// remove any instances of original array's value
				$resultsFlipped = array_flip($results);
				unset($resultsFlipped[$redirTitleFormatted]);
				$results = array_flip($resultsFlipped);

				array_unshift($results, $redirTitleFormatted);
				$redirects[$redirTitleFormatted] = $titleFormatted;
			}
		}

		$db->freeResult( $res );

		if($request->getText('nospecial', 0) != 1) {
			// bugid 29988: include special pages
			// (registered in SpecialPage::$mList, not in the DB like a normal page)
			if (($namespaces == array('-1')) && (strlen($query) > 0)) {
				$specialPagesByAlpha = SpecialPageFactory::getList();
				$specialPagesByAlpha = get_object_vars($specialPagesByAlpha);

				ksort($specialPagesByAlpha, SORT_STRING);
				array_walk( $specialPagesByAlpha,
					function($val,$key) use (&$results, $query) {
						if (strtolower(substr($key, 0, strlen($query))) === strtolower($query)) {
							$results[] = self::formatTitle('-1', $key);
						}
					}
				);
			}
		}

		// Overwrite canonical title with redirect title for all formats
		self::replaceResultIfRedirected($results, $redirects);

		$format = $request->getText('format');

		if ($format == 'json') {
			$result_values = array_values($results);

			if ( $isMobile ) {
				$out = json_encode( array( array_splice( $result_values, 0, 10), array_splice($redirects, -1, 1) ) );
			} else {
				$out = json_encode(array('query' => $request->getText('query'), 'suggestions' => $result_values, 'redirects' => $redirects));
			}
		} elseif ($format == 'array') {
			$out = $results;
		} else {
			// legacy: LinkSuggest.js uses plain text
			$out = implode("\n", $results);
		}

		// 15 minutes times four (one hour, but easier to slice and dice)
		$wgMemc->set($key, $out, 4 * 900);

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 *
	 * helper function for return empty response
	 *
	 * @param String $format json or html(default)
	 *
	 * @return string
	 *
	 * @author Tomasz Odrobny <tomek@wikia-inc.com>
	 *
	 */

	static function getEmptyResponse($format) {
		return $format == 'json' ? json_encode(array('suggestions'=>array(),'redirects'=>array())) : '';
	}

	/**
	 *
	 * Helper function for replacing results if redirections are available
	 *
	 * @param Array $results
	 * @param Array $redirects
	 *
	 * @return Array
	 *
	 * @author Artur Klajnerok <arturk@wikia-inc.com>
	 *
	 */

	static private function replaceResultIfRedirected(&$results, &$redirects) {
		foreach($results as &$val){
			if (isset($redirects[$val])) {
				$val = $redirects[$val];
			}
		}
	}

	/**
	 * @param DatabaseBase $db
	 * @param $res
	 * @param $query
	 * @param $redirects
	 * @param $results
	 * @param $exactMatchRow
	 *
	 * @author dymsza
	 */

	static private function formatResults($db, $res, $query, &$redirects, &$results, &$exactMatchRow) {
		global $wgLinkSuggestLimit;
		while(($row = $db->fetchObject($res)) && count($results) < $wgLinkSuggestLimit ) {

			if (strtolower($row->page_title) == $query) {
				$exactMatchRow = $row;
				continue;
			}

			$titleFormatted = self::formatTitle($row->page_namespace, $row->page_title);

			if ($row->page_is_redirect == 0) {

				if (!in_array($titleFormatted, $results)) {
					$results[] = $titleFormatted;
				}

				$flippedRedirs = array_flip($redirects);
				if (isset($flippedRedirs[$titleFormatted])) {
					unset($redirects[$flippedRedirs[$titleFormatted]]);
				}

			} else {

				$redirTitleFormatted = self::formatTitle($row->page_namespace, $row->rd_title);

				if ( !in_array( $redirTitleFormatted, $results ) ) {

					$results[] = $redirTitleFormatted;
					$redirects[$redirTitleFormatted] = $titleFormatted;

				}

			}

		}
	}

	/**
	 * Returns formatted title based on given namespace and title
	 *
	 * @param $namespace integer page namespace ID
	 * @param $title string page title
	 * @return string formatted title (prefixed with localised namespace)
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static private function formatTitle($namespace, $title) {
		global $wgContLang;

		if ($namespace != NS_MAIN) {
			$title = $wgContLang->getNsText($namespace) . ':' . $title;
		}

		return str_replace('_', ' ', $title);
	}
}
