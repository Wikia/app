<?php 

/**
 * This class is responsible for handling all the methods needed to serve up document data for indexing.
 * These methods used to live in WikiaSearch, but there seems to be a nice point of functional cleavage between searching and indexing.
 * Note that this class DOES NOT actually send values to Solr. This powers a JSON-based service our back-end indexer queries.
 * @author Robert Elwell
 */
class WikiaSearchIndexer extends WikiaObject {
	
	/**
	 * Time to cache the wikipages value, used in indexing, in seconds -- 7 days.
	 * @var int
	 */
	const WIKIPAGES_CACHE_TTL	= 604800;
	
	/**
	 * Used to determine whether we have registered the onParserClearState hook
	 * @var boolean
	 */
	protected $parserHookActive	= false;
	
	/**
	 * ParserClearState hook handler, called internally.
	 * @static
	 * @param $parser Parser
	 * @return bool
	 */
	public static function onParserClearState( &$parser ) {
		// prevent from caching when indexer is running to avoid infrastructure overload
		$parser->getOutput()->setCacheTime(-1);
		return true;
	}
	
	/**
	 * Used to generate indexing data for a number of page IDs on a given  wiki
	 * @see WikiaSearchController::getPages()
	 * @param array $pageIds those ids we want to populate indexing data for
	 * @return array result, for JSON encoding 
	 */
	public function getPages( array $pageIds ) {
		wfProfileIn(__METHOD__);
		$result = array(
				'pages'			=> array(), 
				'missingPages'	=> array(), 
		);

		foreach ( $pageIds as $pageId ) {
			try {
				$result['pages'][$pageId] = $this->getPage( $pageId );
			} catch (WikiaException $e) {
				/**
				 * here's how we will pretend that a page is empty for now. the risk is that if any of the
				 * API code is broken in the getPage() method, it will tell the indexer to queue the page up
				 * for removal from the index.
				 **/
				$result['missingPages'][] = $pageId;
			}
		}
		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * This method does the brunt of the work for populating an array with the values
	 * we need when servicing the backend search indexer processes
	 * @see WikiaSearchIndexer::getPages()
	 * @see WikiaSearchController::getPage()
	 * @param int $pageId
	 * @throws WikiaException
	 * @return array result
	 */
	public function getPage( $pageId ) {
		wfProfileIn(__METHOD__);

		$result = array();
	
		$page = F::build( 'Article', array( $pageId ), 'newFromID' );
	
		if(!($page instanceof Article)) {
			throw new WikiaException('Invalid Article ID');
		}
	
		if(! $this->parserHookActive ) {
			$this->app->registerHook('ParserClearState', 'WikiaSearchIndexer', 'onParserClearState');
			$this->parserHookActive = true;
		}
	
		// hack: setting wgTitle as rendering fails otherwise
		$wgTitle 			= $this->wg->Title;
		$this->wg->Title	= $page->getTitle();

		// hack: setting action=render to exclude "Related Pages" and other unwanted stuff
		$wgRequest = $this->wg->Request;
		$this->wg->Request->setVal('action', 'render');

		if( $page->isRedirect() ) {
			$redirectPage = F::build( 'Article', array( $page->getRedirectTarget() ) );
			$redirectPage->loadContent();
	
			// hack: setting wgTitle as rendering fails otherwise
			$this->wg->Title = $page->getRedirectTarget();

			$redirectPage->render();
			$canonical = $page->getRedirectTarget()->getPrefixedText();
		}
		else {
			$page->render();
			$canonical = '';
		}
	
		$html 		= $this->wg->Out->getHTML();
		$namespace	= $this->wg->Title->getNamespace();
	
		$isVideo	= false;
		$isImage	= false;
		
		if ( $namespace == NS_FILE && ($file = $this->wf->findFile( $this->wg->Title->getText() )) ) {
			$detail		= WikiaFileHelper::getMediaDetail( $this->wg->Title );
			$isVideo	= WikiaFileHelper::isVideoFile( $file );
			$isImage	= ($detail['mediaType'] == 'image') && !$isVideo;
			$metadata	= $file->getMetadata();
	
			if ( $metadata !== "0" ) {
				$metadata = unserialize( $metadata );
	
				$fileParams = array('description', 'keywords')
				+ ($isVideo ? array('movieTitleAndYear', 'videoTitle') : array());
	
				foreach ($fileParams as $datum) {
					$html .= isset( $metadata[$datum] ) ? ' ' . $metadata[$datum] : '';
				}
			}
		}
	
		$title = $page->getTitle()->getText();
	
		if ( in_array( $namespace, array( NS_WIKIA_FORUM_BOARD_THREAD, NS_USER_WALL_MESSAGE ) ) ){
			$wm = WallMessage::newFromId($page->getId());
			$wm->load();
			if ($wm->isMain()) {
				$title = $wm->getMetaTitle();
			} else {
				if ($main = $wm->getTopParentObj() and !empty($main)) {
					$main->load();
					$title = $main->getMetaTitle();
				}
			}
		}
	
		// clear output buffer in case we want get more pages
		$this->wg->Out->clearHTML();
	
		$result['wid']			= (int) $this->wg->CityId;
		$result['pageid']		= $page->getId();
		$result['id']			= $result['wid'] . '_' . $result['pageid'];
		$result['sitename']		= $this->wg->Sitename;
		$result['title']		= $title;
		$result['canonical']	= $canonical;
		$result['html']			= html_entity_decode($html, ENT_COMPAT, 'UTF-8');
		$result['url']			= $page->getTitle()->getFullUrl();
		$result['ns']			= $page->getTitle()->getNamespace();
		$result['host']			= substr($this->wg->Server, 7);
		$result['lang']			= $this->wg->Lang->mCode;
	
		# these need to be strictly typed as bool strings since they're passed via http when in the hands of the worker
		$result['iscontent']	= in_array( $result['ns'], $this->wg->ContentNamespaces ) ? 'true' : 'false';
		$result['is_main_page']	= ($page->getId() == Title::newMainPage()->getArticleId() && $page->getId() != 0) ? 'true' : 'false';
		$result['is_redirect']	= ($canonical == '') ? 'false' : 'true';
		$result['is_video']		= $isVideo ? 'true' : 'false';
		$result['is_image']		= $isImage ? 'true' : 'false';
	
		if ( $this->wg->EnableBacklinksExt && $this->wg->IndexBacklinks ) {
			$result['backlink_text'] = Backlinks::getForArticle($page);
		}
		
		$result = array_merge($result, $this->getPageMetaData($page));
	
		// restore global state
		$this->wg->Title	= $wgTitle;
		$this->wg->Request	= $wgRequest;
	
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Makes a handful of MediaWiki API requests to get metadata about a page
	 * @see WikiaSearchIndexer::getPage()
	 * @param Article $page
	 */
	private function getPageMetaData( Article $page ) {
		wfProfileIn(__METHOD__);
		$result = array();
	
		$data = $this->callMediaWikiAPI( array(
				'titles'	=> $page->getTitle(),
				'bltitle'	=> $page->getTitle(),
				'action'	=> 'query',
				'list'		=> 'backlinks',
				'blcount'	=> 1
		));
	
		$result['backlinks'] = isset($data['query']['backlinks_count'] ) ? $data['query']['backlinks_count'] : 0;  
	
		$data = $this->callMediaWikiAPI( array(
				'pageids'	=> $page->getId(),
				'action'	=> 'query',
				'prop'		=> 'info|categories',
				'inprop'	=> 'url|created|views|revcount',
				'meta'		=> 'siteinfo',
				'siprop'	=> 'statistics|wikidesc|variables|namespaces|category'
		));
	
		if( isset( $data['query']['pages'][$page->getId()] ) ) {
			$pageData = $data['query']['pages'][$page->getId()];
			$result['views']	= $pageData['views'];
			$result['revcount']	= $pageData['revcount'];
			$result['created']	= $pageData['created'];
			$result['touched']	= $pageData['touched'];
		}
	
		$result['categories'] = array();
	
		if ( isset( $pageData['categories'] ) ) {
			foreach ( $pageData['categories'] as $category ) {
				$result['categories'][] = implode( ':', array_slice( explode( ':', $category['title'] ), 1 ) );
			}
		}
	
		$result['hub'] 			= isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
		$result['wikititle']	= isset($data['query']['wikidesc']['pagetitle']) ? $data['query']['wikidesc']['pagetitle'] : '';
	
		$statistics = $data['query']['statistics'];
		if( is_array($statistics) ) {
			$result['wikipages']	= $statistics['pages'];
			$result['wikiarticles']	= $statistics['articles'];
			$result['activeusers']	= $statistics['activeusers'];
			$result['wiki_images']	= $statistics['images'];
		}
	
		$result['redirect_titles'] = $this->getRedirectTitles($page);
	
		$wikiViews = $this->getWikiViews($page);
	
		$result['wikiviews_weekly']		= (int) $wikiViews->weekly;
		$result['wikiviews_monthly']	= (int) $wikiViews->monthly;
	
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Provided an Article, queries the database for all titles that are redirects to that page.
	 * @param Article $page
	 */
	private function getRedirectTitles( Article $page ) {
		wfProfileIn(__METHOD__);
	
		$dbr = wfGetDB(DB_SLAVE);
	
		$result = $dbr->selectRow(
				array( 'redirect', 'page' ),
				array( 'GROUP_CONCAT(page_title SEPARATOR " | ") AS redirect_titles' ),
				array(),
				__METHOD__,
				array( 'GROUP'=>'rd_title' ),
				array( 'page' => array( 'INNER JOIN', array('rd_title'=>$page->mTitle->getDbKey(), 'page_id = rd_from' ) ) )
		);
	
		wfProfileOut(__METHOD__);
		return ( !empty( $result ) ) ? str_replace( '_', ' ', $result->redirect_titles ) : '';
	}
	
	/**
	 * Provided an Article, queries the database for weekly and monthly pageviews. 
	 * @see   WikiaSearchIndexerTest::testGetWikiViewsWithCache
	 * @see   WikiaSearchIndexerTest::testGetWikiViewsNoCacheYesDb
	 * @see   WikiaSearchIndexerTest::testGetWikiViewsNoCacheNoDb
	 * @param Article $page
	 */
	private function getWikiViews( Article $page ) {
		wfProfileIn(__METHOD__);
		$key = $this->wf->SharedMemcKey( 'WikiaSearchPageViews', $this->wg->CityId );

		// should probably re-poll for wikis without much love
		if ( ( $result = $this->wg->Memc->get( $key ) ) && ( $result->weekly > 0 || $result->monthly > 0 ) ) {
			return $result;
		}
	
		$db = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->statsDB );
		$row = $db->selectRow(
				array( 'page_views' ),
				array(	'SUM(pv_views) as "monthly"',
						'SUM(CASE WHEN pv_ts >= DATE_SUB(DATE(NOW()), INTERVAL 7 DAY) THEN pv_views ELSE 0 END) as "weekly"' ),
				array(	'pv_city_id' => (int) $this->wg->CityId,
						'pv_ts >= DATE_SUB(DATE(NOW()), INTERVAL 30 DAY)' ),
				__METHOD__
		);
	
		// a pinch of defensive programming
		if ( !$row ) {
			$row = new stdClass();
			$row->weekly = 0;
			$row->monthly = 0;
		}
	
		$this->wg->Memc->set( $key, $row, self::WIKIPAGES_CACHE_TTL );
	
		wfProfileOut(__METHOD__);
		return $row;
	}

	/**
	 * Used to access API data from various MediaWiki services
	 * @param  array $params
	 * @return array result data
	 **/
	private function callMediaWikiAPI( Array $params ) {
	    wfProfileIn(__METHOD__);
	
	    $api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
	    $api->execute();
	
	    wfProfileOut(__METHOD__);
	    return  $api->getResultData();
	}
}