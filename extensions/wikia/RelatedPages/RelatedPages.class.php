<?php

class RelatedPages {

	private $pages = null;
	private $categories = null;
	private $categoryCacheTTL = 8; // in hours
	private $categoryRankCacheTTL = 24; // in hours
	private $categoriesLimit = 6;
	private $pageSectionNo = 4; // number of section before which module should be injected (for long articles)
	private $isRendered = false;
	static private $instance = null;

	private function __construct( ) {
		$this->categories = array();
	}

	private function __clone() {
	}

	/**
	 * get class instance
	 * @return RelatedPages
	 */
	static public function getInstance() {
		if(self::$instance == null) {
			self::$instance = new RelatedPages();
		}
		return self::$instance;
	}

	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	public function getCategories() {
		return array_keys( $this->categories );
	}

	public function reset() {
		$this->pages = null;
	}

	public function isRendered() {
		return $this->isRendered;
	}

	public function setRendered($value) {
		$this->isRendered = $value;
	}

	public function getPageSectionNo() {
		return $this->pageSectionNo;
	}

	/**
	 * get related pages for article
	 * @param int $articleId Article ID
	 * @param int $limit limit
	 */
	public function get( $articleId, $limit = 3 ) {
		global $wgContentNamespaces, $wgEnableRelatedPagesUnionSelectQueries, $wgUser;
		wfProfileIn( __METHOD__ );

		// prevent from calling this function more than one, use reset() to omit
		if( is_array( $this->pages ) ) {
			wfProfileOut( __METHOD__ );
			return $this->pages;
		}

		$this->pages = array();
		$categories = $this->getCategories();

		if ( count($categories) > 0 ) {
			//RT#80681/RT#139837: apply category blacklist
			$categories = CategoriesService::filterOutBlacklistedCategories($categories);

			$categories = $this->getCategoriesByRank( $categories );

			if( count( $categories ) > $this->categoriesLimit ) {
				// limit the number of categories to look for
				$categories = array_slice( $categories, 0, $this->categoriesLimit );
			}

			// limit * 2 - get more pages (some can be filtered out - RT #72703)
			$pages = $this->getPagesForCategories($articleId, $limit * 2, $categories);
			
			//use text snippets for mobile skins
			if(
				class_exists('imageServing') &&
				!in_array( get_class( $wgUser->getSkin() ), array( 'SkinWikiaphone', 'SkinWikiaApp' ) )
			){
				// ImageServing extension enabled, get images
				$imageServing = new imageServing( array_keys($pages), 200, array( 'w' => 2, 'h' => 1 ) );
				$images = $imageServing->getImages(1); // get just one image per article

				// TMP: always remove last article to get a text snippeting working example
				// macbre: removed as requested by Angie
				//$images = array_slice($images, 0, $limit-1, true);

				foreach( $pages as $pageId => $data ) {
					if( isset( $images[$pageId] ) ) {
						$image = $images[$pageId][0];
						$data['imgUrl'] = $image['url'];

						$this->pages[] = $data;
					}
					else {
						// no images, get a text snippet
						$data['text'] = $this->getArticleSnippet( $pageId );

						if ($data['text'] != '') {
							$this->pages[] = $data;
						}
					}

					if (count($this->pages) >= $limit) {
						break;
					}
				}
			}
			else {
				// ImageServing not enabled, just get text snippets for all articles
				foreach( $pages as $pageId => &$data ) {
					$data['text'] = $this->getArticleSnippet( $pageId );

					if ($data['text'] != '') {
						$this->pages[] = $data;
					}

					if (count($this->pages) >= $limit) {
						break;
					}
				}
			}
		} // if $categories

		wfProfileOut( __METHOD__ );
		return $this->pages;
	}

	/**
	 * get all pages for given category
	 * @param string $category category name
	 * @return array list of page ids
	 */
	private function getPagesForCategory( $category ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$cacheKey = wfMemcKey( __METHOD__, $category );
		$cache = $wgMemc->get( $cacheKey );
		if( is_array($cache) ) {
			wfProfileOut( __METHOD__ );
			return $cache;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( "categorylinks" );
		$joinSql = $this->getPageJoinSql( $dbr, $tables );

		$pages = array();
		$res = $dbr->select(
			$tables,
			array( "cl_from AS page_id" ),
			array( "cl_to" => $category ),
			__METHOD__,
			array(),
			$joinSql
		);

		while( $row = $dbr->fetchObject($res) ) {
			$pages[] = $row->page_id;
		}

		$wgMemc->set( $cacheKey, $pages, ( $this->categoryCacheTTL * 3600 ) );

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	* get pages that belong to a list of categories
	* @author Owen
	*/
	private function getPagesForCategories($articleId, $limit, Array $categories) {
		global $wgMemc, $wgContentNamespaces;

		wfProfileIn(__METHOD__);
		$cacheKey = wfMemcKey(__METHOD__, $articleId);
		$cache = $wgMemc->get($cacheKey);
		if (is_array($cache)) {
			wfProfileOut(__METHOD__);
			return $cache;
		}

		$dbr = wfGetDB(DB_SLAVE);
		$pages = array();

		if ( empty($categories) ) {
			wfProfileOut(__METHOD__);
			return $pages;
		}

		$tables = array( "categorylinks" );
		$joinSql = $this->getPageJoinSql( $dbr, $tables );

		$innerSQL = $dbr->selectSQLText(
			$tables,
			array( "cl_from AS page_id"),
			array( "cl_to IN ( " . $dbr->makeList($categories) . " )"),
			__METHOD__,
			array(),
			$joinSql
		);

		$sql = "SELECT page_id, count(*) c FROM ( $innerSQL ) i WHERE page_id != $articleId GROUP BY page_id ORDER BY c desc LIMIT 6";
		$res = $dbr->query($sql, __METHOD__);
		while ($row = $dbr->fetchObject($res)) {
			$pageId = $row->page_id;
			$title = Title::newFromId($pageId);

			// filter out redirect pages (RT #72662)
			if (!empty($title) && $title->exists() && !$title->isRedirect()) {
				$prefixedTitle = $title->getPrefixedText();

				$pages[$pageId] = array(
					'url' => $title->getLocalUrl(),
					'title' => $prefixedTitle,
				);
			}
		}

		$wgMemc->set($cacheKey, $pages, ( $this->categoryCacheTTL * 3600));

		wfProfileOut(__METHOD__);
		return $pages;
	}

	private function getPageJoinSql( $dbr, &$tables ) {
		global $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		if(count($wgContentNamespaces) > 0) {
			$joinSql = array( "page" =>
				array(
					"JOIN",
					implode(
						" AND ",
						array(
							"page_id = cl_from",
							( count($wgContentNamespaces) == 1)
								? "page_namespace = " . intval(reset($wgContentNamespaces))
								: "page_namespace in ( " . $dbr->makeList( $wgContentNamespaces ) . " )",
						)
					)
				)
			);
			$tables[] = "page";
		} else {
			$joinSql = array();
		}

		wfProfileOut( __METHOD__ );
		return $joinSql;
	}

	/**
	 * get categories sorted by rank
	 * @param array $categories
	 */
	private function getCategoriesByRank( Array $categories ) {
		$categoryRank = $this->getCategoryRank();

		$results = array();
		foreach( $categories as $category ) {
			if( isset($categoryRank[$category]) ) {
				$results[$categoryRank[$category]] = $category;
			}
		}

		ksort( $results );
		return count($results) ? array_values( $results ) : $categories;
	}

	/**
	 * get category rank, based on number of articles assigned
	 * @return array
	 */
	private function getCategoryRank() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$cacheKey = wfMemcKey( __METHOD__ );
		$cache = $wgMemc->get( $cacheKey );
		if( is_array($cache) ) {
			wfProfileOut( __METHOD__ );
			return $cache;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( "categorylinks" );
		$joinSql = $this->getPageJoinSql( $dbr, $tables );

		$res = $dbr->select(
			$tables,
			array( "cl_to", "COUNT(cl_to) AS count" ),
			array(),
			__METHOD__,
			array(
				"GROUP BY" => "cl_to",
				"HAVING" => "count > 1",
				"ORDER BY" => "count DESC"
			),
			$joinSql
		);
		$results = array();

		$rank = 1;
		while($row = $dbr->fetchObject($res)) {
			$results[$row->cl_to] = $rank;
			$rank++;
		}

		$wgMemc->set( $cacheKey, $results, ( $this->categoryRankCacheTTL * 3600 ) );

		wfProfileOut( __METHOD__ );
		return $results;
	}

	/**
	 * get a snippet of article text
	 * @param int $articleId Article ID
	 * @param int $length snippet length (in characters)
	 */
	public function getArticleSnippet( $articleId, $length = 100 ) {
		$service = new ArticleService( $articleId );
		return $service->getTextSnippet();
	}

	public static function onOutputPageMakeCategoryLinks( $outputPage, $categories, $categoryLinks ) {
		RelatedPages::getInstance()->setCategories( $categories );
		return true;
	}

	public static function onOutputPageBeforeHTML( &$out, &$text ) {
		global $wgRequest;
		if( $out->isArticle() && $wgRequest->getVal( 'diff' ) === null ) {
			$text .= wfRenderModule('RelatedPages');
		}
		return true;
	}

}
