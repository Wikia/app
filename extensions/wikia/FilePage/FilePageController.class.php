<?php

/**
 * Controller for the video file page
 *
 * @author garth@wikia-inc.com
 * @author hyun@wikia-inc.com
 * @author saipetch@wikia-inc.com
 */

class FilePageController extends WikiaController {

	CONST LIMIT_GLOBAL_USAGE = 50;
	CONST LIMIT_LOCAL_USAGE = 100;
	CONST LIMIT_DISPLAYED_USAGES = 3;

	/**
	 * SUS-1531: Restrict access to methods other than fileList (required by FilePageTabbed.js)
	 * @throws ForbiddenException if a different method is requested externally
	 */
	public function init() {
		if ( !$this->request->isInternal() && $this->request->getVal( 'method' ) !== 'fileList' ) {
			throw new ForbiddenException();
		}
	}

	protected function getSkipMethods() {
		return [ 'fileUsage' ];
	}

	/**
	 * Collects data about what articles the current file appears in, either
	 * locally and globally.
	 *
	 * @requestParam string type (optional) Possible values are 'global' or 'local', defaulting to 'local' if not given.
	 *                                      Determines whether this collects a local or global file usage data
	 */
	public function fileUsage() {
		wfProfileIn( __METHOD__ );

		$seeMoreLink = '';
		$shortenedSummary = array(); // A subset of the data returned to show immediately

		$type = $this->getVal( 'type', 'local' );

		// Based on $type get global or local data
		if ( $type === 'global' ) {
			$heading = wfMessage( 'video-page-global-file-list-header' )->escaped();

			// Forward to the getGlobalUsage method
			$summary = $this->getGlobalUsage();
			if ( array_key_exists( $this->wg->DBname, $summary ) ) {
				unset( $summary[$this->wg->DBname] );
			}

			// Shorten the list to 3 articles.  We'll flesh out these three with full
			// details to display now and flesh out the others dynamically from JS when
			// the user pages forward
			$shortenedSummary = array_slice( $summary, 0, self::LIMIT_DISPLAYED_USAGES );
		} else {
			$heading = wfMessage( 'video-page-file-list-header' )->escaped();
			$summary = $this->getLocalUsage();

			// Shorten the list down to three articles much like above in global, but
			// here we also need to make the $shortentedSummary structure uniform to match
			// the global case
			if ( $summary && count( $summary ) ) {
				$dbName = $this->wg->DBname;
				$shortenedSummary = array( $dbName => array_slice( $summary, 0, self::LIMIT_DISPLAYED_USAGES ) );
			}
		}

		// Send the $shortenedSummary to fileList to flesh out the details
		$params = array( 'summary' => $shortenedSummary, 'type' => $type );
		$data = $this->sendSelfRequest( 'fileList', $params )->getData();
		$fileList = empty( $data['fileList'] ) ? array() : $data['fileList'];

		if ( $type === 'local' && count( $summary ) > self::LIMIT_DISPLAYED_USAGES ) {
			$seeMoreLink = SpecialPage::getTitleFor( 'WhatLinksHere' )->escapeLocalUrl() .
				'/' . $this->wg->Title->getPrefixedDBkey();
		}

		// Set template variables
		$this->heading = $heading;
		$this->fileList = $fileList;
		$this->summary = $summary;
		$this->type = $type;
		$this->seeMoreLink = $seeMoreLink;
		$this->seeMoreText = wfMessage( 'file-page-more-links' )->escaped();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Figure out what articles include this file from any wiki
	 * @param string $fileTitle
	 * @return array
	 */
	private function getGlobalUsage( $fileTitle = null ): array {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->wg->EnableGlobalUsageExt ) ) {
			wfProfileOut( __METHOD__ );
			return [];
		}

		$titleObj = empty( $fileTitle ) ? $this->wg->Title : Title::newFromText( $fileTitle );

		$memcKey = $this->getMemcKeyGlobalUsage( $titleObj->getDBkey() );
		$globalUsage = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $globalUsage ) ) {
			// Query the global usage table to see where the current File title is used
			$db = wfGetDB( DB_SLAVE, array(), $this->wg->GlobalUsageDatabase );

			$gilTo = $db->addQuotes( $titleObj->getDBkey() );
			$wiki = $db->addQuotes( $this->wg->DBname );

			// The 'limit' parameter is used by both usage methods we forward to as a way to limit
			// the number of rows returned.  This is a safeguard against extreme cases
			$limit = self::LIMIT_GLOBAL_USAGE;

			$sql = <<<SQL
				SELECT *
				FROM (
					SELECT  *
					FROM `globalimagelinks`
					WHERE gil_to = $gilTo AND gil_wiki != $wiki
					ORDER BY gil_wiki, gil_page_namespace_id
					LIMIT 1000
				) s
				GROUP BY gil_wiki
				LIMIT $limit
SQL;
			$result = $db->query( trim( $sql ), __METHOD__ );

			// We need to make sure $globalUsage is an array. If the query below returns no rows, $globalUsage
			// ends up being null due to it's initial assignment of $globalUsage = $this->wg->Memc->get( $memcKey );
			$globalUsage = array();
			while ( $row = $db->fetchObject( $result ) ) {

				// Don't show private wikis in the list of global usage for a video
				$wikiId = WikiFactory::DBtoID( $row->gil_wiki );
				$isPrivate = WikiFactory::getVarByName( 'wgIsPrivateWiki', $wikiId )->cv_value;
				// getVarByName returns a serialized value, eg 'b:1'
				$isPrivate = unserialize( $isPrivate );

				if ( $isPrivate ) {
					continue;
				}

				$globalUsage[$row->gil_wiki][] = [
					'image' => $row->gil_page_title,
					'id' => $row->gil_page,
					'namespace_id' => $row->gil_page_namespace_id,
					'title' => $row->gil_to,
					'wiki' => $row->gil_wiki,
				];
			}

			$this->wg->Memc->set( $memcKey, $globalUsage, 60*60 );
		}

		wfProfileOut( __METHOD__ );
		return $globalUsage;
	}

	/**
	 * Figure out what articles on the local wiki are using this file.  A lot of this code is lifted from the
	 * includes/ImagePage.php file.  The original code includes a lot of HTML building which means it wasn't
	 * possible to reuse there.
	 *
	 * @param string $fileTitle
	 * @return array
	 */
	private function getLocalUsage( $fileTitle = null ): array {
		wfProfileIn( __METHOD__ );

		$target = $fileTitle ?? $this->getContext()->getTitle()->getDBkey();

		// Put an upper limit on how many of files to show
		$limit = self::LIMIT_LOCAL_USAGE;

		// Do a first pass to get everything that directly points here
		$res = $this->queryImageLinks( $target, $limit + 1 );
		$rows = array();
		$redirects = array();
		foreach ( $res as $row ) {
			if ( $row->page_is_redirect ) {
				$redirects[$row->page_title] = array();
			}
			$rows[] = $row;
		}
		$count = count( $rows );

		// If we haven't reached $limit files yet, check for any pages that point to
		// redirects of the current target page
		$hasMore = $count > $limit;
		if ( !$hasMore && count( $redirects ) ) {
			$res = $this->queryImageLinks( array_keys( $redirects ), $limit - count( $rows ) + 1 );
			foreach ( $res as $row ) {
				$redirects[$row->il_to][] = $row;
				$count++;
			}
		}

		// Sort the list by namespace:title
		usort( $rows, array( $this, 'compare' ) );

		// We're showing redirects to this File, and sometimes the same File can have multiple
		// redirects that point to it.  For example say we have File:A and it has File:B and File:C that
		// redirect to it.  Additionally, page "D" includes links to File:B an File:C.  On the File:A file
		// page we'll see all the page links to File:B and to File:C.  Since page "D" links to both of those
		// it will show up twice on the File:A file page.  We just want to show it once.
		$seen = array();

		$summary = array();
		$currentCount = 0;
		foreach ( $rows as $element ) {

			// Determine if we should summarize this $element as is or if its a redirect to the current file.
			// If its a redirect we should summarize all the pages that link to this redirect
			$pages = array();
			if ( isset( $redirects[$element->page_title] ) ) {
				$pages = $redirects[$element->page_title];
			} else {
				$pages[] = $element;
			}

			// Iterate over everything to summarize
			foreach ( $pages as $page ) {
				// Skip this title if we've already seen it.
				if ( !empty( $seen[$page->page_title] ) ) {
					break;
				}
				$seen[$page->page_title] = 1;

				$summary[] = array("title"        => $page->page_title,
					"id"           => $page->page_id,
					"namespace_id" => $page->page_namespace,
				);

				// Keep track of whether we've reach the limit
				$currentCount++;
				if ( $currentCount > $limit ) {
					break;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $summary;
	}

	/**
	 * Query the imagelinks table to find pages that link to the current file page, $target
	 *
	 * @param $target string File page title to find links to
	 * @param $limit integer Limit the number of results returned
	 * @return ResultWrapper
	 */
	protected function queryImageLinks( $target, $limit ) {
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect', 'il_to' ),
			array( 'il_to' => $target, 'il_from = page_id' ),
			__METHOD__,
			array( 'LIMIT' => $limit + 1, 'ORDER BY' => 'il_from', )
		);
	}

	/**
	 * Callback for usort() to do link sorts by (namespace, title)
	 * Function copied from Title::compare()
	 *
	 * @param $a object page to compare with
	 * @param $b object page to compare with
	 * @return Integer: result of string comparison, or namespace comparison
	 */
	protected function compare( $a, $b ) {
		if ( $a->page_namespace == $b->page_namespace ) {
			return strcmp( $a->page_title, $b->page_title );
		} else {
			return $a->page_namespace - $b->page_namespace;
		}
	}

	/**
	 * This method takes the minimum data provided in summary (at least an article title
	 * an article ID and namespace ID) and fills in additional details needed to show
	 * an image, a snippet and some links to the source article.
	 *
	 * @requestParam summary array (required) An array of associative arrays.  This data is
	 *                                        returned by fileUsage above as $summary
	 * @requestParam type string (optional) Can be 'global' or 'local'.  Defaults to 'local'.
	 *                                      Determines whether to grab summary data from the local wiki
	 *                                      or from an external wiki
	 */
	public function fileList() {
		wfProfileIn( __METHOD__ );

		$summary = $this->getVal( 'summary', '' );
		$type = $this->getVal( 'type', '' );
		$result = array();
		if ( empty( $summary ) || empty( $type ) ) {
			$this->result = $result;
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( $type === 'global' ) {
			$expandedSummary = $this->addGlobalSummary( $summary );
		} else {
			$expandedSummary = $this->addLocalSummary( $summary );
		}

		foreach ( $expandedSummary as $wiki => $articles ) {
			foreach ( $articles as $article ) {
				if ( !empty( $article['url'] ) ) {
					$result[] = $article;
				}
			}
		}

		$this->fileList = $result;
		$this->type = $type;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Add more detail for global articles to the current $data by making HTTP requests to the other wiki URLs
	 * @param array $data
	 * @return array
	 */
	private function addGlobalSummary( array $data ): array {
		return $this->addSummary( $data, function ( $dbName, $articleIds ) {
			$ids = array();
			$result = array();

			foreach ( $articleIds as $id ) {
				$memcKey = $this->getMemcKeyGlobalSummary( $dbName, $id );
				$summary = $this->wg->Memc->get( $memcKey );
				if ( is_array( $summary ) ) {
					$result['summary'][$id] = $summary;
				} else {
					$ids[] = $id;
				}
			}

			if ( !empty( $ids ) ) {
				$params = array(
					'controller' => 'ArticleSummaryController',
					'method' => 'blurb',
					'ids' => implode( ',', $ids ),
				);

				$response = ApiService::foreignCall( $dbName, $params, ApiService::WIKIA );
				if ( !empty( $response['summary'] ) ) {
					foreach ( $response['summary'] as $id => $info ) {
						if ( !array_key_exists( 'error', $info ) ) {
							$result['summary'][$id] = $info;

							$memcKey = $this->getMemcKeyGlobalSummary( $dbName, $id );
							$this->wg->Memc->set( $memcKey, $info, 60*60 );
						}
					}
				}
			}

			return $result;
		});
	}

	/**
	 * Add more detail for local articles to the current $data by forwarding to
	 * the ArticleSummaryController
	 * @param array $data
	 * @return array
	 */
	private function addLocalSummary( array $data ): array {
		return $this->addSummary( $data, function ( $dbName, $articleIds ) {
			$response = $this->sendRequest( 'ArticleSummaryController', 'blurb', array( 'ids' => implode( ',', $articleIds ) ) );
			return $response->getData();
		});
	}

	private function addSummary ( $data, $summaryFunc ) {
		wfProfileIn( __METHOD__ );

		// Copy results into a new array to make sure we only return
		// wikis that gave full summaries
		$fullData = array();

		// Iterate through each wiki DB name in the data
		foreach ( $data as $dbName => $articles ) {

			// Get all the article IDs for this wiki so we can make one call to
			// grab the extra data we need from the ArticleSummaryController
			$articleIds = array_map( function ( $item ) { return $item['id']; }, $articles );

			// This function will fetch the data for us
			$extraData = $summaryFunc( $dbName, $articleIds );

			if ( !empty( $extraData['summary'] ) ) {
				// Eliminate the superfluous 'summary' key
				$extraData = $extraData['summary'];

				// Loop with indexes so we can change $data in place
				for ( $i = 0; $i < count($articles); $i++ ) {
					$info = $articles[$i];

					if ( empty( $extraData[$info['id']] ) ) {
						continue;
					} else {
						$extraInfo = $extraData[$info['id']];
					}

					if ( !is_array( $extraInfo ) ) {
						continue;
					}

					// Let the wall code clean up any links to the user wall or forums
					Hooks::run( 'FormatForumLinks', array( &$extraInfo, $info['title'], $info['namespace_id'] ) );

					// Clean up any type of comment on any article page
					$cleanedText = preg_replace( '/\/@comment-.+-[0-9]+$/', '', $extraInfo['titleText'] );
					if ( !empty( $cleanedText ) ) {
						$extraInfo['titleText'] = $cleanedText;
					}

					$articles[$i] = array_merge( $info, $extraInfo );
				}

				$fullData[$dbName] = $articles;
			}
		}

		wfProfileOut( __METHOD__ );

		return $fullData;
	}


	/**
	 * Controller to display a caption under the video, including provider and views
	 */
	public function videoCaption() {
		wfProfileIn( __METHOD__ );

		$provider = $this->getVal( 'provider' );
		if ( !empty( $provider ) ) {
			$providerName = explode( '/', $provider );
			$provider = array_pop( $providerName );
		}

		$expireDate = $this->getVal( 'expireDate', '' );
		if ( !empty( $expireDate ) ) {
			$date = $this->wg->Lang->date( $expireDate );
			$expireDate = wfMessage( 'video-page-expires', $date )->escaped();
		}

		// Get restricted country list
		$regionalRestrictions = $this->getVal( 'regionalRestrictions', '' );
		if ( !empty( $regionalRestrictions ) ) {
			// Create a list of restrictions to pass to the front end
			$regionalRestrictions = json_encode( explode( ',', str_replace( ', ', ',', $regionalRestrictions ) ) );
		}

		// Assemble provider link
		$providerUrl = $this->getVal( 'providerUrl' );
		$providerLink = Html::element( 'a', [ 'href' => $providerUrl, 'target' => '_blank' ], ucwords( $provider ) );
		$providerPhrase = wfMessage( 'video-page-from-provider' )->rawParams( $providerLink )->escaped();
		if ( $expireDate ) {
			$providerPhrase .= "<span class='expire-date'>$expireDate</span>";
		}

		$this->providerPhrase = $providerPhrase;
		$this->regionalRestrictions = $regionalRestrictions;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get memcache key for global usage of the video
	 * @param string $title
	 * @return string
	 */
	private function getMemcKeyGlobalUsage( string $title ): string {
		return wfSharedMemcKey( 'filepage', 'globalusage', md5( $title ) );
	}

	/**
	 * Get memcache key for summary of the global usage
	 * @param string $dbName
	 * @param integer $pageId
	 * @return string
	 */
	private function getMemcKeyGlobalSummary( string $dbName, int $pageId ): string {
		return wfSharedMemcKey( 'filepage', 'globalusage', $dbName, $pageId );
	}
}
