<?php

namespace Wikia\Search\Services;

use Wikia\Search\Query\Select;
use WikiService;
use Wikia\Measurements\Time;
use Wikia\Search\Config;
use Wikia\Search\Field\Field;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\Utilities;

class CombinedSearchService {
	const CROSS_WIKI_RESULTS = 3;
	const MAX_ARTICLES_PER_WIKI = 5;
	const TOP_ARTICLES_PER_WIKI = 3;
	const MAX_TOTAL_ARTICLES = 6;
	const SNIPPET_LENGTH = 200;
	const IMAGE_SIZE = 80;
	const TOP_ARTICLES_CACHE_TIME = 604800; // 60 * 60 * 24 * 7 - one week
	const ARTICLE_QUALITY_EPSILON = 1;
	const ARTICLE_TYPE_OTHER = "other";


	/**
	 * @var array
	 */
	protected $article_types_passed_on;

	/**
	 * @var bool
	 */
	private $hideNonCommercialContent = false;

	/**
	 * @var WikiService
	 */
	private $wikiService;

	function __construct( $wikiService = null ) {
		$this->wikiService = $wikiService === null ? new WikiService() : $wikiService;
		$this->article_types_passed_on = array_fill_keys( [
			"book", "character", "comic_book", "location", "movie", "person",
			"tv_episode", "tv_season", "tv_series", "video_game"
		], true );
	}

	/**
	 * @param \WikiService $wikiService
	 */
	public function setWikiService( $wikiService ) {
		$this->wikiService = $wikiService;
	}

	/**
	 * @return \WikiService
	 */
	public function getWikiService() {
		return $this->wikiService;
	}

	/**
	 * @param boolean $hideNonCommercialContent
	 */
	public function setHideNonCommercialContent( $hideNonCommercialContent ) {
		$this->hideNonCommercialContent = $hideNonCommercialContent;
	}

	/**
	 * @return boolean
	 */
	public function getHideNonCommercialContent() {
		return $this->hideNonCommercialContent;
	}

	public function search( $query, $langs, $namespaces, $hubs, $limit = null, $minArticleQuality = null ) {
		$timer = Time::start( [ __CLASS__, __METHOD__ ] );
		$wikias = $this->phraseSearchForWikias( $query, $langs, $hubs );

		$result = [ ];
		$limit = ( $limit !== null ) ? $limit : self::MAX_TOTAL_ARTICLES;
		if ( !empty( $wikias ) ) {
			$result[ 'wikias' ] = $wikias;
		} else {
			$result[ 'wikias' ] = [ ];
		}
		$articles = $this->phraseSearchForArticles( $query, $namespaces, $langs, $hubs, $minArticleQuality );
		$result[ 'articles' ] = array_slice( $articles, 0, $limit );
		$timer->stop();
		return $result;
	}

	/**
	 * @param $query
	 * @param $namespaces
	 * @param $wikias
	 * @param $maxArticlesPerWiki
	 * @return array
	 */
	public function searchForArticles( $query, $namespaces, $wikias, $maxArticlesPerWiki ) {
		$timer = Time::start( [ __CLASS__, __METHOD__ ] );
		$articles = [ ];
		foreach ( $wikias as $wiki ) {
			$currentResults = $this->querySolrForArticles( $query, $namespaces, $maxArticlesPerWiki, $wiki[ 'wikiId' ], $wiki[ 'lang' ] );
			foreach ( $currentResults as $article ) {
				$articles[ $article[ 'wid' ] ][ ] = $this->processArticle( $article );
			}
		}
		$timer->stop();
		return $articles;
	}

	public function phraseSearchForArticles( $query, $namespaces, $langs, $hubs = null, $minArticleQuality = null ) {
		$timer = Time::start( [ __CLASS__, __METHOD__ ] );
		$articles = [ ];
		foreach ( $langs as $lang ) {
			$currentResults = $this->queryPhraseSolrForArticles( $query, $namespaces, $lang, $hubs, $minArticleQuality );
			foreach ( $currentResults as $article ) {
				$articles[ ] = $this->processArticle( $article );
			}
			if ( count( $articles ) >= self::MAX_TOTAL_ARTICLES ) {
				break;
			}
		}
		$timer->stop();
		return $articles;
	}

	/**
	 * @param $query
	 * @param $namespaces
	 * @param $maxArticlesPerWiki
	 * @param $wikiId
	 * @param $wikiLang
	 * @return array
	 */
	protected function querySolrForArticles( $query, $namespaces, $maxArticlesPerWiki, $wikiId, $wikiLang ) {
		$requestedFields = [ "title", "url", "id", "score", "pageid", "lang", "wid", "article_quality_i", "article_type_s", Utilities::field( 'html', $wikiLang ) ];
		$searchConfig = new Config;
		$searchConfig->setQuery( $query )
			->setLimit( $maxArticlesPerWiki )
			->setPage( 1 )
			->setOnWiki( true )
			->setRequestedFields( $requestedFields )
			->setWikiId( $wikiId )
			->setNamespaces( $namespaces )
			->setFilterQuery( "is_main_page:false" )
			->setRank( 'default' );
		$resultSet = ( new Factory )->getFromConfig( $searchConfig )->search();
		$currentResults = $resultSet->toArray( $requestedFields );
		return $currentResults;
	}

	/**
	 * This is a temporary solution
	 * @param $query
	 * @param $namespaces
	 * @param $lang
	 * @param null|string[] $hubs
	 * @param int $minArticleQuality
	 * @return array
	 */
	protected function queryPhraseSolrForArticles( $query, $namespaces, $lang, $hubs = null, $minArticleQuality = null ) {
		$requestedFields = [
			'title' => Utilities::field( 'title', $lang ), "url", "id", "score", "pageid", "lang", "wid",
			"article_quality_i", "article_type_s", Utilities::field( 'html', $lang )
		];
		$config = ( new Factory() )->getSolariumClientConfig();

		$client = new \Solarium_Client( $config );

		$phrase = $this->sanitizeQuery( $query );
		$query = $this->prepareQuery( $phrase, $namespaces, $lang, $hubs, $minArticleQuality );

		$select = $client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );
		$select->setRows( self::MAX_TOTAL_ARTICLES );
		$select->setQuery( $query );

		$select->createFilterQuery( 'dis' )->setQuery( '-(title_en:disambiguation)' );
		//speedydeletion: 547090, scratchpad: 95, lyrics:43339,
		$select->createFilterQuery( 'banned' )->setQuery( '-(wid:547090) AND -(wid:95) AND -(wid:43339) AND -(host:*answers.wikia.com)' );
		if ( $minArticleQuality != null ) {
			$select->createFilterQuery( 'article_quality' )->setQuery( 'article_quality_i:[' . $minArticleQuality . ' TO *]' );
		}

		$boostedTypes = [ "character", "tv_series", "tv_episode", "person", "move", "video_game" ];
		$dismax->setBoostQuery( '+(wikititle_en:"' . $phrase . '"^100000)' . " +(article_type_s:(" . implode( " OR ", $boostedTypes ) . "))" );

		$result = $client->select( $select );
		return $this->extractData( $result, $requestedFields );
	}

	public function queryPhraseForWikias( $query, $hubs, $lang ) {
		$fields = [ "url", "lang_s", "sitename_txt", "id", "score", "description_txt" ];
		$config = ( new Factory() )->getSolariumClientConfig();
		$config[ 'adapteroptions' ][ 'core' ] = 'xwiki';
		$client = new \Solarium_Client( $config );

		$phrase = $this->sanitizeQuery( $query );
		$query = $this->prepareXWikiQuery( $phrase, $hubs, $lang );

		$select = $client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $query );
		$select->setRows( self::CROSS_WIKI_RESULTS );

		//filter queries
		$select->createFilterQuery( 'wam' )->setQuery( '-(wam_i:0)' );
		$select->createFilterQuery( 'users' )->setQuery( 'activeusers_i:[0 TO *]' );
		$select->createFilterQuery( 'pages' )->setQuery( 'articles_i:[50 TO *]' );
		//speedydeletion: 547090, scratchpad: 95, lyrics:43339,
		$select->createFilterQuery( 'banned' )->setQuery( '-(id:547090) AND -(id:95) AND -(id:43339) AND -(hostname_s:*answers.wikia.com)' );

		$dismax->setBoostQuery( 'domains_txt:"www.' . preg_replace( '|\s*|', '', $phrase ) . '.wikia.com"^1000' );
		$dismax->setBoostFunctions( 'wam_i^5 articles_i^0.5' );

		$result = $client->select( $select );
		return $this->extractData( $result, $fields );
	}

	protected function prepareXWikiQuery( $query, $hubs, $lang ) {
		$hubsQuery = '';
		if ( !empty( $hubs ) ) {
			$hubsList = [ ];
			foreach ( $hubs as $hub ) {
				$hubsList[ ] = '(hub_s:' . $hub . ')';
			}
			$hubsQuery = '+(' . implode( ' OR ', $hubsList ) . ') AND ';
		}
		return $hubsQuery . '+(lang_s:' . $lang .
		') AND +((sitename_txt:"' . $query . '") OR (headline_txt:"' . $query . '") OR (description_txt:"' . $query .
		'") OR (domains_txt:"www.' . preg_replace( '|\s*|', '', $query ) . '.wikia.com"))';
	}

	protected function extractData( $searchResult, $requestedFields ) {
		$result = [ ];
		foreach ( $searchResult->getDocuments() as $doc ) {
			$item = [ ];
			foreach ( $requestedFields as $key => $field ) {
				$keyValue = !is_numeric( $key ) ? $key : $field;
				$value = $doc->{$field};
				if ( isset( $value ) ) {
					$item[ $keyValue ] = $value;
				}
			}
			$result[ ] = $item;
		}
		return $result;
	}

	protected function prepareQuery( $query, $namespaces, $lang, $hubs = null, $minArticleQuality = null ) {
		$nsArr = [ ];
		$hubQuery = '';
		if ( !empty( $hubs ) ) {
			$hubsArr = [ ];
			foreach ( $hubs as $hub ) {
				$hubsArr[ ] = "(hub:$hub)";
			}
			$hubQuery = '(' . implode( ' OR ', $hubsArr ) . ') AND ';
		}
		foreach ( $namespaces as $ns ) {
			$nsArr[ ] = "(ns:$ns)";
		}
		$query = '+(' . $hubQuery . '(' . implode( ' OR ', $nsArr ) . ') AND (lang:' . $lang .
			')) AND +((title_en:"' . $query . '") OR (redirect_titles_mv_en:"' . $query . '")) AND +(nolang_txt:"' . $query . '")';
		return $query;
	}

	/**
	 * @param $query
	 * @return mixed|string
	 */
	protected function sanitizeQuery( $query ) {
		$select = new Select( $query );
		return $select->getSolrQuery( 10 );
	}

	/**
	 * @param $query
	 * @param $langs
	 * @param $hubs
	 * @return array
	 */
	public function searchForWikias( $query, $langs, $hubs ) {
		$timer = Time::start( [ __CLASS__, __METHOD__ ] );
		$wikias = [ ];
		foreach ( $langs as $lang ) {
			$crossWikiResults = $this->queryForWikias( $query, $hubs, $lang );
			foreach ( $crossWikiResults as $wikiSearchResult ) {
				$wikias[ ] = $this->processWiki( $wikiSearchResult );
			}
			if ( sizeof( $wikias ) >= self::CROSS_WIKI_RESULTS ) {
				break;
			}
		}
		$wikias = array_slice( $wikias, 0, self::CROSS_WIKI_RESULTS );
		$timer->stop();
		return $wikias;
	}

	public function phraseSearchForWikias( $query, $langs, $hubs ) {
		$timer = Time::start( [ __CLASS__, __METHOD__ ] );
		$wikias = [ ];
		foreach ( $langs as $lang ) {
			$crossWikiResults = $this->queryPhraseForWikias( $query, $hubs, $lang );
			foreach ( $crossWikiResults as $wikiSearchResult ) {
				//PLA-1116: set to false
				$wikias[ ] = $this->processWiki( $wikiSearchResult, false );
			}
			if ( sizeof( $wikias ) >= self::CROSS_WIKI_RESULTS ) {
				break;
			}
		}
		$timer->stop();
		return $wikias;
	}

	/**
	 * @param $query
	 * @param $hubs
	 * @param $lang
	 * @return array
	 */
	public function queryForWikias( $query, $hubs, $lang ) {
		$crossWikiSearchConfig = new Config;
		$crossWikiSearchConfig->setQuery( $query )
			->setLimit( self::CROSS_WIKI_RESULTS )
			->setPage( 1 )
			->setRank( 'default' )
			->setInterWiki( true )
			->setCommercialUse( $this->getHideNonCommercialContent() )
			->setLanguageCode( $lang );
		if ( !empty( $hubs ) ) {
			$crossWikiSearchConfig->setHubs( $hubs );
		}
		$crossWikiResultSet = ( new Factory )->getFromConfig( $crossWikiSearchConfig )->search();
		$crossWikiResults = $crossWikiResultSet->toArray( [ "sitename_txt", "url", "id", "description_txt", "lang_s", "score", "description_txt" ] );
		return $crossWikiResults;
	}

	protected function processWiki( $wikiInfo, $addTopArticles = false ) {
		$outputModel = [ ];
		$outputModel[ 'wikiId' ] = (int)$wikiInfo[ 'id' ];
		$outputModel[ 'name' ] = $wikiInfo[ 'sitename_txt' ][ 0 ]; // this is multivalue field
		$outputModel[ 'url' ] = $wikiInfo[ 'url' ];
		$outputModel[ 'lang' ] = $wikiInfo[ 'lang_s' ];
		$outputModel[ 'snippet' ] = $wikiInfo[ 'description_txt' ];
		$outputModel[ 'wordmark' ] = $this->wikiService->getWikiWordmark( $outputModel[ 'wikiId' ] );
//		$images = $this->wikiService->getWikiImages( $outputModel['wikiId'], self::IMAGE_SIZE, self::IMAGE_SIZE );

		if ( $addTopArticles ) {
			$outputModel[ 'topArticles' ] = $this->getTopArticles( $outputModel[ 'wikiId' ], $outputModel[ 'lang' ] );
		}

		return $outputModel;
	}

	private function processArticle( $articleInfo ) {
		$outputModel = [ ];
		$outputModel[ 'wikiId' ] = $articleInfo[ 'wid' ];
		$outputModel[ 'articleId' ] = $articleInfo[ 'pageid' ];
		$outputModel[ 'title' ] = $articleInfo[ 'title' ];
		$outputModel[ 'url' ] = $articleInfo[ 'url' ];
		$outputModel[ 'lang' ] = $articleInfo[ 'lang' ];
		$outputModel[ 'quality' ] = isset( $articleInfo[ 'article_quality_i' ] ) ? $articleInfo[ 'article_quality_i' ] : null;

		if ( isset( $articleInfo[ 'article_type_s' ] ) ) {
			$type = $articleInfo[ 'article_type_s' ];
			$outputModel[ 'type' ] = array_key_exists( $type, $this->article_types_passed_on ) ? $type : static::ARTICLE_TYPE_OTHER;
		} else {
			$outputModel[ 'type' ] = null;
		}

		if ( isset( $articleInfo[ Utilities::field( 'html', $articleInfo[ 'lang' ] ) ] ) ) {
			$fullText = $articleInfo[ Utilities::field( 'html', $articleInfo[ 'lang' ] ) ];
			$outputModel[ 'snippet' ] = trim( wfShortenText( $fullText, self::SNIPPET_LENGTH, true ) );
		}
		$image = $this->getImage( $outputModel[ "wikiId" ], $outputModel[ "articleId" ] );
		if ( !empty( $image ) ) {
			$outputModel[ 'image' ] = $image;
		}

		return $outputModel;
	}

	/**
	 * @param $outputModel
	 * @return mixed
	 */
	protected function getImage( $wikiId, $articleId ) {
		$dbName = '';
		try {
			$row = \WikiFactory::getWikiByID( $wikiId );
			if ( $row ) {
				$dbName = $row->city_dbname;
				if ( !empty( $dbName ) ) {
					$db = wfGetDB( DB_SLAVE, [ ], $dbName ); // throws if database does not exits.
					$imageServing = new \ImageServing(
						[ $articleId ],
						self::IMAGE_SIZE,
						self::IMAGE_SIZE,
						$db
					);
					$isResult = $imageServing->getImages( 1 );
					$images = isset( $isResult[ $articleId ] ) ? $isResult[ $articleId ] : false;
					if ( $images && sizeof( $images ) > 0 ) {
						$imageName = $images[ 0 ][ 'name' ];
						$file = \GlobalFile::newFromText( $imageName, $wikiId );
						if ( $file->exists() ) {
							return ( $imageServing->getUrl( $file, $file->getWidth(), $file->getHeight() ) );
						}
					}
				}
			}
		} catch ( \DBConnectionError $ex ) {
			// Swallow this exception. there is no simple way of telling if database does not exist other than catching exception.
			// Or am I wrong ?
			\Wikia::log( __METHOD__, false, "Cannot get database connection to " . $dbName );
		}
		return null;
	}

	protected function getTopArticles( $wikiId, $lang ) {
		return \WikiaDataAccess::cache( wfSharedMemcKey( "CombinedSearchService", $wikiId, $lang ), self::TOP_ARTICLES_CACHE_TIME, function () use ( $wikiId, $lang ) {
			$timer = Time::start( [ "CombinedSearchService", "getTopArticles" ] );
			$requestedFields = [ "title", "url", "id", "score", "pageid", "lang", "wid", "article_quality_i", Utilities::field( 'html', $lang ) ];
			$topArticlesMap = \DataMartService::getTopArticlesByPageview(
				$wikiId,
				null,
				[ NS_MAIN ],
				false,
				self::TOP_ARTICLES_PER_WIKI + 1
			);

			$query = " +(" . Utilities::valueForField( "wid", $wikiId ) . ") ";
			$query .= " +( " . implode( " OR ", array_map( function ( $x ) {
					return Utilities::valueForField( "pageid", $x );
				}, array_keys( $topArticlesMap ) ) ) . ") ";
			$query .= " +(is_main_page:false) ";

			$searchConfig = new Config;
			$searchConfig
				->setLimit( self::TOP_ARTICLES_PER_WIKI )
				->setQuery( $query )
				->setPage( 1 )
				->setRequestedFields( $requestedFields )
				->setDirectLuceneQuery( true )
				->setWikiId( $wikiId );

			$resultSet = ( new Factory )->getFromConfig( $searchConfig )->search();

			$currentResults = $resultSet->toArray( $requestedFields );
			$articles = [ ];
			foreach ( $currentResults as $article ) {
				$articles[ $article[ 'pageid' ] ] = $this->processArticle( $article );
				if ( sizeof( $articles ) >= self::TOP_ARTICLES_PER_WIKI ) {
					break;
				}
			}
			$result = [ ];
			foreach ( $topArticlesMap as $id => $a ) {
				if ( isset( $articles[ $id ] ) ) {
					$result[ ] = $articles[ $id ];
				}
			}

			$timer->stop();
			return $result;
		} );
	}
}
