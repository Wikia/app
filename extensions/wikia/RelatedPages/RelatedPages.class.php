<?php

class RelatedPages {

	protected $pages = null;
	protected $categories = null;
	protected $categoriesLimit = 6;
	protected $pageSectionNo = 4; // number of section before which module should be injected (for long articles)
	protected $isRendered = false;
	static protected $instance = null;

	const MCACHE_VER = '1.01';

	const LIMIT_MAX = 10;

	/**
	 * Limit the number of results taken from categorylinks and improve the performance on big wikis
	 * by making the temporary table much smaller
	 *
	 * @author macbre
	 * @see PLATFORM-1591
	 */
	const CATEGORY_LINKS_LIMIT = 100000;

	protected function __construct() {
	}

	protected function __clone() {
	}

	/**
	 * get class instance
	 * @return RelatedPages
	 */
	static public function getInstance() {
		if ( RelatedPages::$instance == null ) {
			RelatedPages::$instance = new RelatedPages();
		}
		return RelatedPages::$instance;
	}

	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	private static function followRedirect( &$title ) {
		$redirect = ( new WikiPage( $title ) )->getRedirectTarget();

		if ( !empty( $redirect ) ) {
			$title = $redirect;
		}
	}

	/**
	 * @param $titleOrId Title|int Title object or article ID
	 * @return array|null
	 */
	public function getCategories( $titleOrId ) {
		if ( is_null( $this->categories ) ) {
			$title = $titleOrId instanceof Title ? $titleOrId : Title::newFromID( $titleOrId );

			if ( !empty( $title ) ) {
				$categories = [];

				self::followRedirect( $title );

				foreach ( $title->getParentCategories() as $category => $title ) {
					$titleObj = Title::newFromText( $category, NS_CATEGORY );

					// User might add category like [[Category: ]] and from that I could not create proper Title object
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

	public function setData( $data ) {
		$this->pages = $data;
	}

	public function getData() {
		return $this->pages;
	}

	public function pushData( $data ) {
		$this->pages[] = $data;
	}

	public function isRendered() {
		return $this->isRendered;
	}

	public function setRendered( $value ) {
		$this->isRendered = $value;
	}

	public function getPageSectionNo() {
		return $this->pageSectionNo;
	}

	/**
	 * Get related pages for article
	 *
	 * @param int $articleId Article ID
	 * @param int $limit limit (up to 10 - see LIMIT_MAX const)
	 * @return array
	 */
	public function get( $articleId, $limit = 3 ) {
		wfProfileIn( __METHOD__ );

		// prevent from calling this function more than one, use reset() to omit
		if ( is_array( $this->getData() ) ) {
			wfProfileOut( __METHOD__ );
			return $this->getData();
		}

		// get up to self::LIMIT_MAX items and cache them
		$data = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $articleId, self::MCACHE_VER ),
			WikiaResponse::CACHE_STANDARD,
			function() use ( $articleId ) {
				$this->setData( [] );
				$categories = $this->getCategories( $articleId );

				if ( count( $categories ) > 0 ) {
					// RT#80681/RT#139837: apply category blacklist
					$categories = CategoriesService::filterOutBlacklistedCategories( $categories );
					$categories = $this->getCategoriesByRank( $categories );

					if ( count( $categories ) > $this->categoriesLimit ) {
						// limit the number of categories to look for
						$categories = array_slice( $categories, 0, $this->categoriesLimit );
					}

					// limit * 2 - get more pages (some can be filtered out - RT #72703)
					$pages = $this->getPagesForCategories( $articleId, self::LIMIT_MAX * 2, $categories );

					$this->afterGet( $pages, self::LIMIT_MAX );
				}
				return $this->getData();
			}
		);

		// apply the limit
		$this->setData( array_slice( $data, 0, $limit ) );

		wfProfileOut( __METHOD__ );
		return $this->getData();
	}

	protected function afterGet( $pages, $limit ) {
		wfProfileIn( __METHOD__ );

		$imageServing = new ImageServing( array_keys( $pages ), 200, array( 'w' => 2, 'h' => 1 ) );
		$images = $imageServing->getImages( 1 ); // get just one image per article

		foreach ( $pages as $pageId => $data ) {
			$data[ 'imgUrl' ] = isset( $images[ $pageId ] ) ? $images[ $pageId ][ 0 ][ 'url' ] : null;
			$data[ 'imgOriginalDimensions' ] = isset( $images[ $pageId ] )
				? $images[ $pageId ][ 0 ][ 'original_dimensions' ]
				: null;
			$data[ 'text' ] = $this->getArticleSnippet( $pageId );
			$this->pushData( $data );
			if ( count( $this->getData() ) >= $limit ) {
				break;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get pages that belong to a list of categories
	 * @author Owen
	 *
	 * @param int $articleId
	 * @param int $limit
	 * @param array $categories
	 * @return array
	 * @throws DBUnexpectedError|MWException
	 */
	protected function getPagesForCategories( $articleId, $limit, Array $categories ) {
		if ( empty( $categories ) ) {
			return [];
		}

		wfProfileIn( __METHOD__ );
		$fname = __METHOD__;

		// make the caching key more deterministic
		sort( $categories );

		$pages = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, 'categories', md5( serialize( $categories ) ) ),
			WikiaResponse::CACHE_STANDARD,
			function() use ( $categories, $fname, $limit ) {
				$dbr = wfGetDB( DB_SLAVE );

				# sanitize query parameters
				$articleId = intval( $articleId );
				$limit = intval( $limit );

				/**
				 * SELECT count(page_id) as c, cl_from AS page_id, page_namespace, page_title, page_is_redirect, page_len, page_latest
				 * FROM `categorylinks` JOIN `page` ON ( (page_id = cl_from AND page_namespace = 0))
				 * WHERE (cl_to IN ( 'Gwara','Gzik','Kuchnia_regionalna','Potrawy','Tradycja' )
				 * 		AND page_is_redirect = 0)
				 * GROUP BY page.page_id
				 * ORDER BY c desc
				 * LIMIT 20;
				 *
				 * @see PLATFORM-2226
				 */
				$res = $dbr->select(
					[ 'categorylinks', 'page' ],
					[
						'count(page_id) AS c',
						// columns below are required by Title::newFromRow
						'page_id',
						'page_namespace',
						'page_title',
						'page_is_redirect',
						'page_len',
						'page_latest'
					],
					[
						'cl_to' => $categories,
						'page_is_redirect' => 0, # ignore redirects
					],
					$fname,
					[
						'GROUP BY' => 'page.page_id',
						'ORDER BY' => 'c DESC',
						'LIMIT' => $limit,
					],
					[
						'page' => [
							'JOIN',
							[
								'page_id = cl_from',
								'page_namespace = 0'
							]
						]
					]
				);

				$pages = [];

				while ( $row = $dbr->fetchObject( $res ) ) {
					$pageId = (int) $row->page_id;
					$title = Title::newFromRow( $row );

					$pages[ $pageId ] = [
						'url' => $title->getLocalUrl(),
						'title' => $title->getPrefixedText(),
						'id' => $pageId
					];
				}

				return $pages;
			}
		);

		// filter out the page we want to get related pages for
		if ( array_key_exists( $articleId, $pages ) ) {
			unset( $pages[ $articleId ] );
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * get categories sorted by rank
	 * @param array $categories
	 */
	protected function getCategoriesByRank( Array $categories ) {
		$results = array();
		if ( empty( $categories ) ) {
			return $results;
		}

		$category_rank = [];
		foreach ( $categories as $category ) {
			$category_rank[ $category ] = $this->getCategoryRankByName( $category );
		}

		if ( !empty( $category_rank ) ) {
			arsort( $category_rank );

			$rank = 0;
			foreach ( $category_rank as $category => $not_used ) {
				$results[ ++$rank ] = $category;
			}
		}

		return count( $results ) ? array_values( $results ) : $categories;
	}

	/**
	 * @param string $category
	 * @return int
	 */
	private function getCategoryRankByName( $category ) {
		wfProfileIn( __METHOD__ );

		$count = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, md5( $category ) ),
			WikiaResponse::CACHE_STANDARD,
			function() use ( $category ) {
				global $wgContentNamespaces;

				$dbr = wfGetDB( DB_SLAVE );
				$sql = ( new WikiaSQL() )->SELECT( "COUNT(cl_to)" )->AS_( "count" )->FROM( 'categorylinks' )->WHERE( 'cl_to' )->EQUAL_TO( $category );
				if ( count( $wgContentNamespaces ) > 0 ) {
					$join_cond = ( count( $wgContentNamespaces ) == 1 ) ? "page_namespace = " . intval( reset( $wgContentNamespaces ) ) : "page_namespace in ( " . $dbr->makeList( $wgContentNamespaces ) . " )";
					$sql->JOIN( 'page' )->ON( "page_id = cl_from AND $join_cond" );
				}

				$result = $sql->run( $dbr, function( $result ) { return $result->fetchObject(); } );
				return ( is_object( $result ) ) ? intval( $result->count ) : 0;
			}
		);

		wfProfileOut( __METHOD__ );
		return $count;
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

	/**
	 * @param OutputPage $out
	 * @param            $text
	 *
	 * Add needed messages to page and add JS assets
	 *
	 * @return bool
	 */
	public static function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		$app = F::app();
		$wg = $app->wg;
		$request = $app->wg->Request;
		$title = $wg->Title;
		$am = AssetsManager::getInstance();
		$relatedPagesGroupName = 'relatedpages_js';

		if ( $out->isArticle() && $request->getVal( 'action', 'view' ) == 'view' ) {
			JSMessages::enqueuePackage( 'RelatedPages', JSMessages::INLINE );

			if (
				!( Wikia::isMainPage() || !empty( $title ) && !in_array( $title->getNamespace(), $wg->ContentNamespaces ) )
				&& !$app->checkSkin( 'wikiamobile' )
				&& $am->checkIfGroupForSkin( $relatedPagesGroupName, $out->getSkin() )
			) {
				if ( $app->checkSkin( 'oasis' ) ) {
					OasisController::addSkinAssetGroup( $relatedPagesGroupName );
				}
				else {
					$scripts = $am->getURL( $relatedPagesGroupName );

					foreach ( $scripts as $script ) {
						$wg->Out->addScript( "<script src='{$script}'></script>" );
					}
				}
			}
		}

		return true;
	}

	/**
	 * @param $jsStaticPackages
	 * @param $jsExtensionPackages
	 * @param $scssPackages
	 *
	 * Adds assets for RelatedPages on wikiamobile
	 *
	 * @return bool
	 */
	public static function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages ) {
		if ( F::app()->wg->Request->getVal( 'action', 'view' ) == 'view' ) {
			$jsStaticPackages[] = 'relatedpages_wikiamobile_js';
			// css is in WikiaMobile.scss as AM can't concatanate scss files currently
		}

		return true;
	}

	public static function onSkinAfterContent( &$text ) {
		global $wgTitle;

		$skin = RequestContext::getMain()->getSkin()->getSkinName();

		// File pages handle their own rendering of related pages wrapper
		if ( ( $skin === 'oasis' || $skin === 'monobook' ) && $wgTitle->getNamespace() !== NS_FILE ) {
			$text = $text . '<div id="RelatedPagesModuleWrapper"></div>';
		}

		return true;
	}
}
