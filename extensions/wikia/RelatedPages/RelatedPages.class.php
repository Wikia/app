<?php

class RelatedPages {

	protected $pages = null;
	protected $categories = null;
	protected $categoryCacheTTL = 8; // in hours
	protected $categoryRankCacheTTL = 24; // in hours
	protected $categoriesLimit = 6;
	protected $pageSectionNo = 4; // number of section before which module should be injected (for long articles)
	protected $isRendered = false;
	protected $memcKeyPrefix = '';
	static protected $instance = null;

	protected function __construct( ) {
	}

	protected function __clone() {
	}

	/**
	 * get class instance
	 * @return RelatedPages
	 */
	static public function getInstance() {
		if( RelatedPages::$instance == null ) {
			RelatedPages::$instance = new RelatedPages();
		}
		return RelatedPages::$instance;
	}

	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	/**
	 * @param $titleOrId Title|int Title object or article ID
	 * @return array|null
	 */
	public function getCategories( $titleOrId ) {
		if ( is_null( $this->categories ) ) {
			$title = $titleOrId instanceof Title ? $titleOrId : Title::newFromID( $titleOrId );

			if( !empty( $title ) ) {
				$categories = [];

				foreach( $title->getParentCategories() as $category => $title ) {
					$titleObj = Title::newFromText( $category, NS_CATEGORY );

					//User might add category like [[Category: ]] and from that I could not create proper Title object
					if ( $titleObj instanceof Title ) {
						$categories[] = $titleObj->getDBkey();
					}
				}

				$this->categories = $categories;
			}
		}

		return $this->categories;
	}

	public function reset() {
		$this->pages = null;
		$this->categories = null;
	}

	public function setData( $data ){
		$this->pages = $data;
	}

	public function getData(){
		return $this->pages;
	}

	public function pushData( $data ){
		$this->pages[] = $data;
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
		wfProfileIn( __METHOD__ );

		// prevent from calling this function more than one, use reset() to omit
		if( is_array( $this->getData() ) ) {
			wfProfileOut( __METHOD__ );
			return $this->getData();
		}

		$this->setData( array() );
		$categories = $this->getCategories( $articleId );

		if ( count($categories) > 0 ) {
			//RT#80681/RT#139837: apply category blacklist
			$categories = CategoriesService::filterOutBlacklistedCategories($categories);
			$categories = $this->getCategoriesByRank( $categories );

			if( count( $categories ) > $this->categoriesLimit ) {
				// limit the number of categories to look for
				$categories = array_slice( $categories, 0, $this->categoriesLimit );
			}

			// limit * 2 - get more pages (some can be filtered out - RT #72703)
			$pages = $this->getPagesForCategories( $articleId, $limit * 2, $categories );

			$this->afterGet( $pages, $limit );
		}

		wfProfileOut( __METHOD__ );
		return $this->getData();
	}

	protected function afterGet( $pages, $limit ){
		wfProfileIn( __METHOD__ );

		// ImageServing extension enabled, get images
		$imageServing = new ImageServing( array_keys($pages), 200, array( 'w' => 2, 'h' => 1 ) );
		$images = $imageServing->getImages(1); // get just one image per article

		// TMP: always remove last article to get a text snippeting working example
		// macbre: removed as requested by Angie
		//$images = array_slice($images, 0, $limit-1, true);

		foreach( $pages as $pageId => $data ) {
			if( isset( $images[$pageId] ) ) {
				$image = $images[$pageId][0];
				$data['imgUrl'] = $image['url'];

				$this->pushData( $data );
			}
			else {
				// no images, get a text snippet
				$data['text'] = $this->getArticleSnippet( $pageId );

				if ($data['text'] != '') {
					$this->pushData( $data );
				}
			}
			if (count($this->getData()) >= $limit) {
				break;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get all pages for given category
	 * @param string $category category name
	 * @return array list of page ids
	 */
	protected function getPagesForCategory( $category ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		if ( empty( $this->memcKeyPrefix ) ){
			$cacheKey = wfMemcKey( __METHOD__, $category);
		} else {
			$cacheKey = wfMemcKey( $this->memcKeyPrefix, __METHOD__, $category);
		}
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
	protected function getPagesForCategories($articleId, $limit, Array $categories) {
		global $wgMemc;

		wfProfileIn(__METHOD__);
		if ( empty( $this->memcKeyPrefix ) ) {
			$cacheKey = wfMemcKey( __METHOD__, $articleId);
		} else {
			$cacheKey = wfMemcKey( $this->memcKeyPrefix, __METHOD__, $articleId);
		}
		$cache = $wgMemc->get($cacheKey);

		if ( is_array( $cache ) ) {
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
			array( "cl_to IN ( " . $dbr->makeList( $categories ) . " )"),
			__METHOD__,
			array(),
			$joinSql
		);

		$sql = "SELECT page_id, count(*) c FROM ( $innerSQL ) i WHERE page_id != $articleId GROUP BY page_id ORDER BY c desc LIMIT $limit";
		$res = $dbr->query($sql, __METHOD__);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$pageId = $row->page_id;
			$title = Title::newFromId($pageId);

			// filter out redirect pages (RT #72662)
			if (!empty($title) && $title->exists() && !$title->isRedirect()) {
				$prefixedTitle = $title->getPrefixedText();

				$pages[$pageId] = array(
					'url' => $title->getLocalUrl(),
					'title' => $prefixedTitle,
					'id' => (int) $pageId
				);
			}
		}

		$wgMemc->set($cacheKey, $pages, ( $this->categoryCacheTTL * 3600));
		wfProfileOut(__METHOD__);
		return $pages;
	}

	protected function getPageJoinSql( $dbr, &$tables ) {
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
	protected function getCategoriesByRank( Array $categories ) {
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
	protected function getCategoryRank() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		if ( empty( $this->memcKeyPrefix ) ){
			$cacheKey = wfMemcKey( __METHOD__);
		} else {
			$cacheKey = wfMemcKey( $this->memcKeyPrefix, __METHOD__);
		}
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
	public function getArticleSnippet( $articleId ) {
		$service = new ArticleService( $articleId );
		return $service->getTextSnippet();
	}

	public static function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		global $wgRequest;

		if ( $out->isArticle() && $wgRequest->getVal( 'diff' ) === null ) {
			$text .= F::app()->renderView( 'RelatedPagesController', 'index' );
		}

		return true;
	}

}
