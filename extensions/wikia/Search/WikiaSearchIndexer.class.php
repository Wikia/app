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
		$vidFields	= array();	
		
		if ( $namespace == NS_FILE && ($file = $this->wf->findFile( $this->wg->Title->getText() )) ) {
			$detail		= WikiaFileHelper::getMediaDetail( $this->wg->Title );
			$isVideo	= WikiaFileHelper::isVideoFile( $file );
			$isImage	= ($detail['mediaType'] == 'image') && !$isVideo;
			$metadata	= $file->getMetadata();
	
			if ( $metadata !== "0" ) {
				$metadata = unserialize( $metadata );
				$fileParams = array( 'description', 'keywords' );
				$videoParams = array( 'movieTitleAndYear', 'videoTitle', 'title', 'tags', 'category' );
				if ( $isVideo ) {
					$fileParams = array_merge( $fileParams, $videoParams );
					
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
							$vidFields[$field] = $metadata[$key];
						}
					}
					// special cases
					if ( isset( $metadata['hd'] ) ) {
						$vidFields['video_hd_b'] = empty( $metadata['hd'] ) ? 'false' : 'true';
					}
					if ( isset( $metadata['genres'] ) ) {
						$vidFields['video_genres_txt'] = preg_split( '/, ?/', $metadata['genres'] );
					}
					if ( isset( $metadata['actors'] ) ) {
						$vidFields['video_actors_txt'] = preg_split( '/, ?/', $metadata['actors'] );
					}
				}
	
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
	
		$result['wid']			= empty( $this->wg->ExternalSharedDB ) ? $this->wg->SearchWikiId : (int) $this->wg->CityId;
		$result['pageid']		= $pageId;
		$result['id']			= $result['wid'] . '_' . $result['pageid'];
		$result['title']		= $title;
		$result['canonical']	= $canonical;
		$result['html']			= html_entity_decode($html, ENT_COMPAT, 'UTF-8');
		$result['url']			= $page->getTitle()->getFullUrl();
		$result['ns']			= $page->getTitle()->getNamespace();
		$result['host']			= substr($this->wg->Server, 7);
		$result['lang']			= $this->wg->ContLang->mCode;
	
		# these need to be strictly typed as bool strings since they're passed via http when in the hands of the worker
		$result['iscontent']	= in_array( $result['ns'], $this->wg->ContentNamespaces ) ? 'true' : 'false';
		$result['is_main_page']	= ($page->getId() == Title::newMainPage()->getArticleId() && $page->getId() != 0) ? 'true' : 'false';
		$result['is_redirect']	= ($canonical == '') ? 'false' : 'true';
		$result['is_video']		= $isVideo ? 'true' : 'false';
		$result['is_image']		= $isImage ? 'true' : 'false';
	
		foreach ( $vidFields as $fieldName => $fieldValue ) {
			$result[$fieldName] = $fieldValue;
		}
		
		$result = array_merge($result, $this->getPageMetaData($page));
	
		// restore global state
		$this->wg->Title	= $wgTitle;
		$this->wg->Request	= $wgRequest;
	
		wfProfileOut(__METHOD__);
		return $result;
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
				'\+s'											=>	' ',
				'<span[^>]*editsection[^>]*>.*?<\/span>'		=>	'',
				'<img[^>]*>'									=>	'',
				'<\/img>'										=>	'',
				'<noscript>.*?<\/noscript>'						=>	'',
				'<div[^>]*picture-attribution[^>]*>.*?<\/div>'	=>	'',
				'<ol[^>]*references[^>]*>.*?<\/ol>'				=>	'',
				'<sup[^>]*reference[^>]*>.*?<\/sup>'			=>	'',
				'<script .*?<\/script>'							=>	'',
				'<style .*?<\/style>'							=>	'',
				'\+s'											=>	' ',
		);
		
		foreach ($regexes as $re => $repl ) {
			$html = preg_replace( "/$re/mU", $repl, $html );
		}
		
		$pageData['html'] = strip_tags( $html );
		
		foreach ( WikiaSearch::$languageFields as $field ) {
			if ( isset( $pageData[$field] ) ) {
				$pageData[WikiaSearch::field( $field )] = $pageData[$field];
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
		$updateHandler = $this->client->createUpdate();
		
		$documents = array();
		foreach ($documentIds as $id ) {
			$documents[] = $this->getSolrDocument( $id );
		}
		
		$updateHandler->addDocuments( $documents );
		$updateHandler->addCommit();
		try {
			$this->client->update( $updateHandler );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, implode( ',', $documentIds ), $e);
		}
		
		return true;
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
	        $confirmationString = implode(' ', $documentIds). ' ' . count( $documentIds ) . " document(s) deleted\n";
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
					'prop'		=> 'info|categories',
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
		
			$result['categories'] = array();
		
			if ( isset( $pageData['categories'] ) ) {
				foreach ( $pageData['categories'] as $category ) {
					$result['categories'][] = implode( ':', array_slice( explode( ':', $category['title'] ), 1 ) );
				}
			}
		
			$result['hub'] 			= isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
			$result['wikititle']	= isset($data['query']['wikidesc']['pagetitle']) ? $data['query']['wikidesc']['pagetitle'] : '';
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
	
		$result = $dbr->selectRow(
				array( 'redirect', 'page' ),
				array( 'GROUP_CONCAT(page_title SEPARATOR " | ") AS redirect_titles' ),
				array(),
				__METHOD__,
				array( 'GROUP'=>'rd_title' ),
				array( 'page' => array( 'INNER JOIN', array('rd_title'=>$page->getTitle()->getDbKey(), 'page_id = rd_from' ) ) )
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
}
