<?php 

/**
 * This class is responsible for handling all the methods needed to serve up document data for indexing.
 * @author Robert Elwell
 */
class WikiaSearchIndexer extends WikiaObject {
	
	/**
	 * Time to cache the wikipages value, used in indexing, in seconds -- 7 days.
	 * @var int
	 */
	const WIKIPAGES_CACHE_TTL	= 604800;
	
	/**
	 * Used for querying Solr
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Handles dependency injection for solarium client
	 * @param Solarium_Client $client
	 */
	public function __construct( Solarium_Client $client ) {
	    $this->client = $client;
	    parent::__construct();
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
	
		$page = Article::newFromID( $pageId );
	
		if( $page === null ) {
			throw new WikiaException( 'Invalid Article ID' );
		}

		if( $page->isRedirect() ) {
			$page = F::build( 'Article', array( $page->getRedirectTarget() ) );
		}
		
		$pageId		= $page->getID();
	
		$apiService = F::build( 'ApiService' );
		$response = $apiService->call( array(
					'pageid'	=> $pageId,
					'action'	=> 'parse',
		));
		
		$title		= $page->getTitle();
		$titleStr	= $this->getTitleString( $title );
		$html 		= $response['parse']['text']['*'];

		$categories = array();
		foreach ( $response['parse']['categories'] as $category ) {
			$categories[] = str_replace( '_', ' ', $category['*'] );
		}
		
		$headings = array();
		foreach( $response['parse']['sections'] as $section ) {
			$headings[] = $section['line'];
		}
		
		$result['wid']			= empty( $this->wg->ExternalSharedDB ) ? $this->wg->SearchWikiId : (int) $this->wg->CityId;
		$result['pageid']		= $pageId;
		$result['id']			= $result['wid'] . '_' . $result['pageid'];
		$result['title']		= $titleStr;
		$result['titleStrict']	= $titleStr;
		$result['html']			= html_entity_decode($html, ENT_COMPAT, 'UTF-8');
		$result['url']			= $title->getFullUrl();
		$result['ns']			= $title->getNamespace();
		$result['host']			= substr($this->wg->Server, 7);
		$result['lang']			= $this->wg->ContLang->mCode;
		$result['wikititle']	= $this->wg->Sitename;
		$result['categories']	= $categories;
		$result['page_images']	= count( $response['parse']['images'] );
		$result['headings']		= $headings;
	
		# these need to be strictly typed as bool strings since they're passed via http when in the hands of the worker
		$result['iscontent']	= in_array( $result['ns'], $this->wg->ContentNamespaces ) ? 'true' : 'false';
		$result['is_main_page']	= ( $pageId == F::build( 'Title', array( 'newMainPage' ) )->getArticleId() ) ? 'true' : 'false';
		// these will eventually be broken out into their own atomic updates
		$result = array_merge( 
				$result, 
				$this->getPageMetaData( $page ), 
				$this->getMediaMetadata( $title ),
				$this->getWikiPromoData() 
		);
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Perform the indexing logic with respect to videos
	 * This is separated out so that we can eventually handle 
	 * it separate from the main indexing pipeline
	 * @todo determine whether we expose the result array via a JSON service or perform atomic update here  
	 * @param Title $title
	 * @return array
	 */
	public function getMediaMetadata( Title $title )
	{
		$results = array();
		
		if ( $title->getNamespace() != NS_FILE ) {
			return $results;
		}
		
		$file = $this->wf->findFile( $title->getText() );
		if ( empty( $file ) ) {
			return $results;
		}
	
		$fileHelper	= F::build( 'WikiaFileHelper' );
		$detail		= $fileHelper->getMediaDetail( $title );
		$metadata	= $file->getMetadata();

		$results['is_video'] = $fileHelper->isVideoFile( $file ) ? 'true' : 'false';
		$results['is_image'] = ( ($detail['mediaType'] == 'image') && $results['is_video'] == 'false' ) ? 'true' : 'false';

		if ( $metadata != "0" ) {
			$metadata = unserialize( $metadata );
			$fileParams = array( 'description', 'keywords' );
			if ( $results['is_video'] ) {
				$fileParams = array_merge( $fileParams, array( 'movieTitleAndYear', 'videoTitle', 'title', 'tags', 'category' ) );
				
				/**
				 * This maps video metadata field keys to dynamic fields
				 */
				$videoMetadataMapper = array(
						'duration'		=>	'video_duration_i',
						'provider'		=>	'video_provider_s',
						'videoId'		=>	'video_id_s',
						'altVideoId'	=>	'video_altid_s',
						'aspectRatio'	=>	'video_aspectratio_s'
						);
				
				foreach ( $videoMetadataMapper as $key => $field ) {
					if ( isset( $metadata[$key] ) ) {
						$results[$field] = $metadata[$key];
					}
				}
				// special cases
				if ( isset( $metadata['hd'] ) ) {
					$results['video_hd_b'] = empty( $metadata['hd'] ) ? 'false' : 'true';
				}
				if ( isset( $metadata['genres'] ) ) {
					$results['video_genres_txt'] = preg_split( '/, ?/', $metadata['genres'] );
				}
				if ( isset( $metadata['actors'] ) ) {
					$results['video_actors_txt'] = preg_split( '/, ?/', $metadata['actors'] );
				}
			}
			
			$results['html_media_extras_txt'] = array();
			foreach ( $fileParams as $datum ) {
				if ( isset( $metadata[$datum] ) ) {
					$results['html_media_extras_txt'][] = $metadata[$datum];
				} 
			}
		}
		
		return $results;
	}
	
	/**
	 * Generates a Solr document from a page ID
	 * @param  int $pageId
	 * @return Solarium_Document_ReadWrite 
	 */
	public function getSolrDocument( $pageId ) {
		
		$pageData = $this->getPage( $pageId );
		
		$html = $pageData['html'];
		
		$regexes = array(
				'\+s',
				'<span[^>]*editsection[^>]*>.*?<\/span>',
				'<img[^>]*>',
				'<\/img>',
				'<noscript>.*?<\/noscript>',
				'<div[^>]*picture-attribution[^>]*>.*?<\/div>',
				'<ol[^>]*references[^>]*>.*?<\/ol>',
				'<sup[^>]*reference[^>]*>.*?<\/sup>',
				'<script .*?<\/script>',
				'<style .*?<\/style>',
				'\+s',
		);
		
		foreach ($regexes as $re ) {
			$html = preg_replace( "/$re/mU", $re == '\+s' ? ' ' : '', $html );
		}
		
		$pageData['html'] = strip_tags( $html );
		
		foreach ( WikiaSearch::$languageFields as $field ) {
			if ( isset( $pageData[$field] ) ) {
				$pageData[WikiaSearch::field( $field, $pageData['lang'] )] = $pageData[$field];
			}
		}

		return F::build( 'Solarium_Document_ReadWrite', array( $pageData ) );
	}
	
	/**
	 * Iterates over a set of page IDs reindexes their articles
	 * @param  array $documentIds
	 * @return bool true
	 */
	public function reindexBatch( array $documentIds = array() ) {
		$documents = array();
		foreach ($documentIds as $id ) {
			$documents[] = $this->getSolrDocument( $id );
		}
		return $this->updateDocuments( $documents );
	}
	
	/**
	 * Sends an update query to the client, provided a document set
	 * @param array $documents
	 * @return boolean
	 */
	public function updateDocuments( array $documents = array() ) {
		$updateHandler = $this->client->createUpdate();
		$updateHandler->addDocuments( $documents );
		$updateHandler->addCommit();
		try {
			$this->client->update( $updateHandler );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, '', $e);
		}
		return true;
	}
	
	/**
	 * Emits scribe events for each page to be reindexed by the search backend
	 * @param int $wid
	 */
	public function reindexWiki( $wid ) {
		try {
			$dataSource = F::build( 'WikiDataSource', array( $wid ) );
			$dbHandler = $dataSource->getDB();
			$rows = $dbHandler->query( "SELECT page_id FROM page" );
			while ( $page = $dbHandler->fetchObject( $rows ) ) {
				$sp = F::build( 'ScribeProducer', array( 'reindex', $page->page_id ) );
				$sp->reindexPage();
			}
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, '', $e );
		}
	}
	
	/**
	 * Deletes all documents containing the provided wiki ID
	 * Careful, this will alter our index!
	 * @param int $wid
	 * @return Solarium_Result|null
	 */
	public function deleteWikiDocs( $wid ) {
		$updateHandler = $this->client->createUpdate();
		$query = WikiaSearch::valueForField( 'wid', $wid );
		$updateHandler->addDeleteQuery( $query );
		$updateHandler->addCommit();
		try {
			return $this->client->update( $updateHandler );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, 'Delete: '.$query, $e);
		}
	}

	/**
	 * Deletes all documents containing one of the provided wiki IDs
	 * Used in the handle-closed-wikis maintenance script
	 * Careful, this will alter our index!
	 * @param  array $wids
	 * @return Solarium_Result|null
	 */
	public function deleteManyWikiDocs( $wids ) {
		$updateHandler = $this->client->createUpdate();
		foreach ( $wids as $wid ) {
			$query = WikiaSearch::valueForField( 'wid', $wid );
			$updateHandler->addDeleteQuery( $query );
		}
		$updateHandler->addCommit();
		try {
			return $this->client->update( $updateHandler );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, 'Delete: '.$query, $e);
		}
	}
	
	/**
	 * Given a set of page IDs, deletes by query
	 * @param  array $documentIds
	 * @return bool true
	 */
	public function deleteBatch( array $documentIds = array() ) {
	    $updateHandler = $this->client->createUpdate();
	    foreach ( $documentIds as $id ) {
		    $updateHandler->addDeleteQuery( WikiaSearch::valueForField( 'id', $id ) );
	    }
		$updateHandler->addCommit();
	    try {
	        $this->client->update( $updateHandler );
	    } catch ( Exception $e ) {
	        F::build( 'Wikia' )->Log( __METHOD__, implode( ',', $documentIds ), $e);
		}

		return true;
	}
	
	/**
	 * Written to work as a hook
	 * @param int $pageId
	 */
	public function reindexPage( $pageId ) {
		F::build( 'Wikia' )->log( __METHOD__, '', $pageId );
		$document = $this->getSolrDocument( $pageId );
		$this->reindexBatch( array( $document ) );
		
		return true;
	}
	
	/**
	 * Written to work as a hook
	 * @param int $pageId
	 */
	public function deleteArticle( $pageId) {
		
		$cityId	= $this->wg->CityId ?: $this->wg->SearchWikiId;
		$id		= sprintf( '%s_%s', $cityId, $pageId );
		
		$this->deleteBatch( array( $id ) );
		
		return true;
	}
	
	/**
	 * Access the promo text for a given wiki and set it in the document
	 * @todo these need to be updated any time one of these values change for a wiki. could get dicey. will def need atomic update.
	 * @param int $wid the wiki id
	 * @return array containing result data
	 */
	public function getWikiPromoData() {
		$homepageHelper = new WikiaHomePageHelper();
		$detail = $homepageHelper->getWikiInfoForVisualization( $this->wg->CityId, $this->wg->ContLang->getCode() );
		
		return array(
				'wiki_description_txt' => $detail['description'],
				'wiki_new_b' => empty( $detail['new'] ) ? 'false' : 'true',
				'wiki_hot_b' => empty( $detail['hot'] ) ? 'false' : 'true',
				'wiki_official_b' => empty( $detail['official'] ) ? 'false' : 'true',
				'wiki_promoted_b' => empty( $detail['promoted'] ) ? 'false' : 'true',
		);
	}
	
	/**
	 * Provided a page, returns the string value of that page's title
	 * This allows us to accommodate unconventional locations for titles
	 * @param Title $title
	 * @return string
	 */
	protected function getTitleString( Title $title ) {
		if ( in_array( $title->getNamespace(), array( NS_WIKIA_FORUM_BOARD_THREAD, NS_USER_WALL_MESSAGE ) ) ){
			$wm = WallMessage::newFromId( $title->getArticleID() );
			$wm->load();
			
			if ( !$wm->isMain() && ( $main = $wm->getTopParentObj() ) && !empty( $main ) ) {
				$main->load();
				$wm = $main;
			}
			
			return ''.$wm->getMetaTitle();
		}
		return ''.$title;
	}
	
	/**
	 * Makes a handful of MediaWiki API requests to get metadata about a page
	 * @see WikiaSearchIndexer::getPage()
	 * @param Article $page
	 */
	protected function getPageMetaData( Article $page ) {
		wfProfileIn(__METHOD__);
		$result = array();
	
		$apiService = F::build( 'ApiService' );
		$data = $apiService->call( array(
				'titles'	=> $page->getTitle(),
				'bltitle'	=> $page->getTitle(),
				'action'	=> 'query',
				'list'		=> 'backlinks',
				'blcount'	=> 1
		));
		$result['backlinks'] = isset($data['query']['backlinks_count'] ) ? $data['query']['backlinks_count'] : 0;  
	
		$pageId = $page->getId();
		
		if (! empty( $this->wg->ExternalSharedDB ) ) {
			$data = $apiService->call( array(
					'pageids'	=> $pageId,
					'action'	=> 'query',
					'prop'		=> 'info',
					'inprop'	=> 'url|created|views|revcount',
					'meta'		=> 'siteinfo',
					'siprop'	=> 'statistics|wikidesc|variables|namespaces|category'
			));
			if( isset( $data['query']['pages'][$pageId] ) ) {
				$pageData = $data['query']['pages'][$pageId];
				$result['views']	= $pageData['views'];
				$result['revcount']	= $pageData['revcount'];
				$result['created']	= $pageData['created'];
				$result['touched']	= $pageData['touched'];
			}
			
			$result['hub'] 			= isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
		}

		$result['redirect_titles'] = $this->getRedirectTitles($page);
	
		$wikiViews = $this->getWikiViews($page);
	
		$wam = F::build( 'DataMartService' )->getCurrentWamScoreForWiki( $this->wg->CityId );
		
		$result['wikiviews_weekly']		= (int) $wikiViews->weekly;
		$result['wikiviews_monthly']	= (int) $wikiViews->monthly;
		$result['wam']					= $wam > 0 ? ceil( $wam ) : 1; //mapped here for computational cheapness
	
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Provided an Article, queries the database for all titles that are redirects to that page.
	 * @see    WikiaSearchIndexerTest::testGetRedirectTitlesNoResults
	 * @see    WikiaSearchIndexerTest::testGetRedirectTitlesWithResults
	 * @param  Article $page
	 * @return string the pipe-joined redirect titles with underscores replaced with spaces
	 */
	protected function getRedirectTitles( Article $page ) {
		wfProfileIn(__METHOD__);
	
		$dbr = $this->wf->GetDB(DB_SLAVE);
	
		$result = array( 'redirect_titles' => array() );
		$query = $dbr->select(
				array( 'redirect', 'page' ),
				array( 'page_title' ),
				array(),
				__METHOD__,
				array( 'GROUP'=>'rd_title' ),
				array( 'page' => array( 'INNER JOIN', array('rd_title'=>$page->getTitle()->getDbKey(), 'page_id = rd_from' ) ) )
				);
		
		while ( $row = $dbr->fetchObject( $query ) ) {
			$result['redirect_titles'][] = str_replace( '_', '_', $row->page_title );
		}
		
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Provided an Article, queries the database for weekly and monthly pageviews. 
	 * @see   WikiaSearchIndexerTest::testGetWikiViewsWithCache
	 * @see   WikiaSearchIndexerTest::testGetWikiViewsNoCacheYesDb
	 * @see   WikiaSearchIndexerTest::testGetWikiViewsNoCacheNoDb
	 * @param Article $page
	 */
	protected function getWikiViews( Article $page ) {
		wfProfileIn(__METHOD__);
		$key = $this->wf->SharedMemcKey( 'WikiaSearchPageViews', $this->wg->CityId );

		// should probably re-poll for wikis without much love
		if ( ( $result = $this->wg->Memc->get( $key ) ) && ( $result->weekly > 0 || $result->monthly > 0 ) ) {
			wfProfileOut(__METHOD__);
			return $result;
		}

		$row = new stdClass();	
		$row->weekly = 0;
		$row->monthly = 0;
		
		$datamart = F::build( 'DataMartService' );
		
		$startDate = date( 'Y-m-d', strtotime('-1 week') );
		$endDate = date( 'Y-m-01', strtotime('now') );	
		$pageviews_weekly = $datamart->getPageviewsWeekly( $startDate, $endDate, (int) $this->wg->CityId );

		if (! empty( $pageviews_weekly ) ) {
			foreach ( $pageviews_weekly as $pview ) {
				$row->weekly += $pview;
			}
		}
			
		$startDate = date( 'Y-m-01', strtotime('-1 month') );
		$pageviews_monthly = $datamart->getPageviewsMonthly( $startDate, $endDate, (int) $this->wg->CityId );
		if (! empty( $pageviews_monthly ) ) {
			foreach ( $pageviews_monthly as $pview ) {
				$row->monthly += $pview;
			}
		}
	
		$this->wg->Memc->set( $key, $row, self::WIKIPAGES_CACHE_TTL );
	
		wfProfileOut(__METHOD__);
		return $row;
	}
	
	/**
	 * MediaWiki Hooks
	 */
	
	/**
	 * Sends delete request to article if it gets deleted
	 * @param WikiPage $article
	 * @param User $user
	 * @param integer $reason
	 * @param integer $id
	 */
	public function onArticleDeleteComplete( &$article, User &$user, $reason, $id ) {
		try {
			return $this->deleteArticle( $id );
		} catch ( Exception $e ) {
		    F::build( 'Wikia' )->log( __METHOD__, '', $e );
		    return true;
		}
	}
	
	/**
	 * Reindexes the page
	 * @param WikiPage $article
	 * @param User $user
	 * @param string $text
	 * @param string $summary
	 * @param bool $minoredit
	 * @param bool $watchthis
	 * @param string $sectionanchor
	 * @param array $flags
	 * @param Revision $revision
	 * @param int $status
	 * @param int $baseRevId
	 */
	public function onArticleSaveComplete( &$article, &$user, $text, $summary,
	        $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		try {
			return $this->reindexBatch( array( $article->getTitle()->getArticleID() ) );
		} catch ( Exception $e ) {
		    F::build( 'Wikia' )->log( __METHOD__, '', $e );
		    return true;
		}
	}
	
	/**
	 * Reindexes page on undelete
	 * @param Title $title
	 * @param int $create
	 */
	public function onArticleUndelete( $title, $create ) {
		try {
			return $this->reindexBatch( array( $title->getArticleID() ) );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->log( __METHOD__, '', $e );
			return true;
		}
	}
	
	/**
	 * Issues a reindex event or deletes all docs, depending on whether a wiki is being closed or reopened
	 * @see    WikiaSearchIndexerTest::testOnWikiFactoryPublicStatusChangeClosed
	 * @see    WikiaSearchIndexerTest::testOnWikiFactoryPublicStatusChangeOpened
	 * @todo   Rewrite this to use is_closed_wiki when we can utilize atomic updates
	 * @param  int    $city_public
	 * @param  int    $city_id
	 * @param  string $reason
	 * @return bool
	 */
	public function onWikiFactoryPublicStatusChange( &$city_public, &$city_id, $reason ) {
		
		if ( $city_public < 1 ) {
			$this->deleteWikiDocs( $city_id );
		} else {
			$this->reindexWiki( $city_id );
		}
		
		return true;
	}
}
