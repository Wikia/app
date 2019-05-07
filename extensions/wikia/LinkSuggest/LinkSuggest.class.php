<?php

use Wikia\Measurements\Time as T;

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
	const MAX_LINK_SUGGESTIONS_LIMIT = 100;
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
		wfProfileIn(__METHOD__);

		$isMobile = F::app()->checkSkin( 'wikiamobile' );
		// trim passed query and replace spaces by underscores
		// - this is how MediaWiki store article titles in database
		$query = urldecode( trim( $request->getText('query') ) );
		$query = str_replace(' ', '_', $query);
		$limit = min($request->getInt('limit', $wgLinkSuggestLimit), self::MAX_LINK_SUGGESTIONS_LIMIT);

		if ($limit <= 0) {
			$limit = $wgLinkSuggestLimit;
		}

		if ( $isMobile ) {
			$key = wfMemcKey( __METHOD__, md5( $query.$limit.'_'.$request->getText('format').$request->getText('nospecial', '') ), 'WikiaMobile' );
		} else {
			$key = wfMemcKey( __METHOD__, md5( $query.$limit.'_'.$request->getText('format').$request->getText('nospecial', '') ) );
		}

		// use mb_strlen to test string length accurately
		if ( mb_strlen( $query ) < 3 ) {
			// enforce minimum character limit on server side
			$out = self::getEmptyResponse($request->getText('format'));
		} else if ($cached = $wgMemc->get($key)) {
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
			array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect' ),
			array(
				'qc_title = page_title',
				'qc_namespace = page_namespace',
				'page_is_redirect = 0',
				'qc_type' => 'Mostlinked',
				"(convert(binary convert(qc_title using latin1) using utf8) LIKE convert(binary convert('{$query}%' using latin1) using utf8))",
				'qc_namespace' => $namespaces
			),
			__METHOD__,
			array( 'ORDER BY' => 'qc_value DESC', 'LIMIT' => $limit )
		);

		self::formatResults($db, $res, $query, $redirects, $results, $exactMatchRow, $limit);
		$sql1Measurement->stop();
		if (count($namespaces) > 0) {
			$commaJoinedNamespaces = count($namespaces) > 1 ?  $db->makeList( $namespaces ) : $db->addQuotes( $namespaces[0] );
		}

		$pageNamespaceClause = isset($commaJoinedNamespaces) ?  'page.page_namespace IN (' . $commaJoinedNamespaces . ') AND ' : '';
		if( count($results) < $limit ) {
			/**
			 * @var string $pageTitlePrefilter this condition is able to use name_title index. It's added only for performance reasons.
			 * It uses fact that page titles can't start with lowercase letter.
			 */
			$pageTitlePrefilter = "";

			// use mb_substring to get the first & second chars
			// in case of multi-byte
			$firstChar = mb_substr($queryLower, 0, 1);
			$secondChar = mb_substr($queryLower, 1, 1);

			if( mb_strlen( $queryLower ) >= 2 ) {
				if ( LinkSuggest::containsMultibyteCharacters( $firstChar . $secondChar ) ) {
					$pageTitlePrefilter = "(
						( convert(binary convert(page.page_title using latin1) using utf8) LIKE convert(binary '" . strtoupper( $firstChar ) . strtolower( $secondChar ) . "%' using utf8)) ) OR
						( convert(binary convert(page.page_title using latin1) using utf8) LIKE convert(binary '" . strtoupper( $firstChar ) . strtoupper( $secondChar )  . "%' using utf8) ) AND ";
				} else {
					$pageTitlePrefilter = "(
						( convert(binary convert(page.page_title using latin1) using utf8) " . $db->buildLike( strtoupper( $firstChar ) . strtolower( $secondChar ) , $db->anyString() ) . " ) OR
						( convert(binary convert(page.page_title using latin1) using utf8) " . $db->buildLike( strtoupper( $firstChar ) . strtoupper( $secondChar ) , $db->anyString() ) . " ) ) AND ";
				}
			} else if( mb_strlen($queryLower) >= 1 ) {
				if ( LinkSuggest::containsMultibyteCharacters( $firstChar ) ) {
					$pageTitlePrefilter = "( convert(binary convert(page.page_title using latin1) using utf8) LIKE convert(binary '" . $firstChar . "%' using utf8) ) AND ";
				} else {
					$pageTitlePrefilter = "( convert(binary convert(page.page_title using latin1) using utf8) " . $db->buildLike(strtoupper( $firstChar ) , $db->anyString() ) . " ) AND ";
				}
			}

			if ( LinkSuggest::containsMultibyteCharacters( $queryLower ) ) {
				$pageTitleLikeClause = "convert(binary '{$queryLower}%' using utf8)";
			} else {
				$pageTitleLikeClause = "'{$queryLower}%'";
			}

			$res = $db->select(
				[ 'page', 'redirect', 'redirect_target' => 'page' ],
				[
					'page.page_len AS page_len',
					'page.page_id AS page_id',
					'page.page_namespace AS page_namespace',
					'page.page_title AS page_title',
					'page.page_is_redirect AS page_is_redirect',
					'rd_namespace',
					'rd_title',
					'redirect_target.page_id AS redirect_target_id'
				],
				[
					"{$pageTitlePrefilter} {$pageNamespaceClause} (convert(binary convert(page.page_title using latin1) using utf8) LIKE {$pageTitleLikeClause} )",
					'page.page_is_redirect = 0 OR redirect_target.page_id IS NOT NULL',
				],
				__METHOD__,
				// we fetch 3 times more results to leave out redirects to the same page
				[ 'LIMIT' => $limit * 3 ],
				[
					'redirect' => [ 'LEFT JOIN', 'page.page_id = rd_from' ],
					'redirect_target' => [ 'LEFT JOIN', 'rd_namespace = redirect_target.page_namespace AND rd_title = redirect_target.page_title' ],
				]
			);

			self::formatResults($db, $res, $query, $redirects, $results, $exactMatchRow, $limit);
		}

		if ($exactMatchRow !== null) {

			/* @var StdClass $exactMatchRow */
			$row = $exactMatchRow;

			$titleFormatted = self::formatTitle($row->page_namespace, $row->page_title);

			if ($row->page_is_redirect == 0) {

				// remove any instances of original array's value
				unset( $results[$row->page_id] );

				$results = [ $row->page_id => $titleFormatted ] + $results;

				$flippedRedirs = array_flip($redirects);
				if (isset($flippedRedirs[$titleFormatted])) {
					unset($redirects[$flippedRedirs[$titleFormatted]]);
				}

			} else {

				$redirTitleFormatted = self::formatTitle( $row->rd_namespace, $row->rd_title );

				// remove any instances of original array's value
				unset( $results[$row->page_id] );

				$results = [ $row->redirect_target_id => $redirTitleFormatted ] + $results;

				$redirects[$titleFormatted] = $redirTitleFormatted;
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
				$dummySpecialPageId = -1;
				array_walk( $specialPagesByAlpha,
					function($val,$key) use (&$results, $query, &$dummySpecialPageId) {
						if (strtolower(substr($key, 0, strlen($query))) === strtolower($query)) {
							$results[$dummySpecialPageId] = self::formatTitle('-1', $key);
							$dummySpecialPageId--;
						}
					}
				);
			}
		}

		// Overwrite canonical title with redirect title for all formats
		self::replaceResultIfRedirected($results, $redirects);

		$format = $request->getText('format');

		if ( $format == 'json' ) {
			$result_values = array_values( $results );

			if ( $isMobile ) {
				$out =
					json_encode( [
						array_splice( $result_values, 0, 10 ),
						array_splice( $redirects, - 1, 1 ),
					] );
			} else {
				$out =
					json_encode( [
						'query' => $request->getText( 'query' ),
						'ids' => array_flip( $results ),
						'suggestions' => $result_values,
						'redirects' => $redirects,
					] );
			}
		} elseif ( $format == 'array' ) {
			$out = $results;
		} else {
			// legacy: LinkSuggest.js uses plain text
			$out = implode( "\n", $results );
		}

		// 15 minutes times four (one hour, but easier to slice and dice)
		$wgMemc->set($key, $out, 4 * 900);

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * helper function to determine if given string contains multibyte characters
	 *
	 * @param String $string
	 *
	 * @return bool
	 */
	static function containsMultibyteCharacters( $string ) {
		return mb_strlen ( $string ) != strlen( $string );
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
	 * @param $limit
	 *
	 * @author dymsza
	 */

	static private function formatResults($db, $res, $query, &$redirects, &$results, &$exactMatchRow, $limit) {
		while(($row = $db->fetchObject($res)) && count($results) < $limit ) {
			$upperCaseTitle = mb_strtoupper( $row->page_title, 'UTF-8' );
			$upperCaseQuery = mb_strtoupper( $query, 'UTF-8' );

			// SUS-846: Ensure we only have one exact match, to prevent overwriting it and losing the suggestion
			if ( is_null( $exactMatchRow ) && $upperCaseQuery === $upperCaseTitle ) {
				$exactMatchRow = $row;
				continue;
			}

			$titleFormatted = self::formatTitle($row->page_namespace, $row->page_title);

			if ($row->page_is_redirect == 0) {

				if ( !isset( $results[$row->page_id] ) ) {
					$results[$row->page_id] = $titleFormatted;
				}

				$flippedRedirs = array_flip($redirects);
				if (isset($flippedRedirs[$titleFormatted])) {
					unset($redirects[$flippedRedirs[$titleFormatted]]);
				}

			} else {

				$redirTitleFormatted = self::formatTitle($row->rd_namespace, $row->rd_title);

				if ( !in_array( $redirTitleFormatted, $results ) ) {

					$results[$row->redirect_target_id] = $redirTitleFormatted;
					$redirects[$titleFormatted] = $redirTitleFormatted;

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
