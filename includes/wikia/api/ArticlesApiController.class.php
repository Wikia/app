<?php
/**
 * Controller to fetch information about articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
use Wikia\Search\Config;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\QueryService\DependencyContainer;
use Wikia\Util\GlobalStateWrapper;
use Wikia\Logger\WikiaLogger;

class ArticlesApiController extends WikiaApiController {

	const CACHE_VERSION = 16;

	const POPULAR_ARTICLES_PER_WIKI = 10;
	const POPULAR_ARTICLES_NAMESPACE = 0;
	const TRENDING_ARTICLES_LIMIT = 100;

	const MAX_ITEMS = 250;
	const ITEMS_PER_BATCH = 25;
	const LANGUAGES_LIMIT = 10;
	const MAX_NEW_ARTICLES_LIMIT = 100;
	const DEFAULT_NEW_ARTICLES_LIMIT = 20;
	const DEFAULT_ABSTRACT_LENGTH = 200;

	const PARAMETER_ARTICLES = 'ids';
	const PARAMETER_TITLES = 'titles';
	const PARAMETER_ABSTRACT = 'abstract';
	const PARAMETER_NAMESPACES = 'namespaces';
	const PARAMETER_CATEGORY = 'category';
	const PARAMETER_HUB = 'hub';
	const PARAMETER_WIDTH = 'width';
	const PARAMETER_HEIGHT = 'height';
	const PARAMETER_EXPAND = 'expand';
	const PARAMETER_LANGUAGES = 'lang';
	const PARAMETER_LIMIT = 'limit';
	const PARAM_ARTICLE_QUALITY = 'minArticleQuality';

	const DEFAULT_WIDTH = 200;
	const DEFAULT_HEIGHT = 200;
	const DEFAULT_ABSTRACT_LEN = 100;
	const DEFAULT_SEARCH_NAMESPACE = 0;
	const DEFAULT_AVATAR_SIZE = 20;

	const CLIENT_CACHE_VALIDITY = 86400;// 24h
	const CATEGORY_CACHE_ID = 'category';
	const ARTICLE_CACHE_ID = 'article';
	const DETAILS_CACHE_ID = 'details';
	const POPULAR_CACHE_ID = 'popular';
	const PAGE_CACHE_ID = 'page';
	const NEW_ARTICLES_CACHE_ID  = 'new-articles';

	const ARTICLE_TYPE = 'article';
	const VIDEO_TYPE = 'video';
	const IMAGE_TYPE = 'image';
	const CATEGORY_TYPE = 'category';
	const UNKNOWN_PROVIDER = 'unknown';

	const NEW_ARTICLES_VARNISH_CACHE_EXPIRATION = 86400; // 24 hours
	const SIMPLE_JSON_VARNISH_CACHE_EXPIRATION = 86400; // 24 hours
	const SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME = "id";
	const SIMPLE_JSON_ARTICLE_TITLE_PARAMETER_NAME = "title";

	private $imageDimensionFields = [
		'width',
		'height'
	];

	/**
	 * @var CrossOriginResourceSharingHeaderHelper
	 */
	protected $cors;

	const PARAMETER_BASE_ARTICLE_ID = 'baseArticleId';

	private $excludeNamespacesFromCategoryMembersDBQuery = false;

	public function __construct() {
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->readConfig();

		$this->setOutputFieldTypes(
			[
				"width" => self::OUTPUT_FIELD_CAST_NULLS | self::OUTPUT_FIELD_TYPE_INT,
				"height" => self::OUTPUT_FIELD_CAST_NULLS | self::OUTPUT_FIELD_TYPE_INT
			]
		);
	}

	public static function getMetadataCacheTime( $omitExpandParam = false ) {
		$app = F::app();
		if ( !empty( $app->wg->EnablePOIExt ) &&
			$app->wg->request->getBool( static::PARAMETER_EXPAND, $omitExpandParam ) ) {
			return PalantirApiController::METADATA_CACHE_EXPIRATION;
		}

		return self::CLIENT_CACHE_VALIDITY;
	}

	/**
	 * Get the top articles by pageviews optionally filtering by category and/or namespaces
	 *
	 * @requestParam array $namespaces [OPTIONAL] The ID's of the namespaces (e.g. 0, 14, 6, etc.) to use as a filter, comma separated
	 * @requestParam string $category [OPTIONAL] The name of a category (e.g. Characters) to use as a filter
	 * @requestParam string $expand [OPTIONAL] if set will expand result with getDetails data
	 *
	 * @responseParam array $items The list of top articles by pageviews matching the optional filtering
	 * @responseParam string $basepath domain of a wiki to create a url for an article
	 *
	 * @example
	 * @example &namespaces=0,14
	 * @example &category=Characters
	 * @example &category=Characters&namespaces=14
	 */
	public function getTop() {
		wfProfileIn( __METHOD__ );
		$this->cors->setHeaders( $this->response );

		$namespaces = self::processNamespaces( $this->request->getArray( self::PARAMETER_NAMESPACES, null ), __METHOD__ );
		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );
		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );
		$limit = $this->request->getInt( static::PARAMETER_LIMIT, 0 );
		$baseArticleId = $this->getRequest()->getVal( self::PARAMETER_BASE_ARTICLE_ID, false );
		if ( $baseArticleId !== false ) {
			$this->validateBaseArticleIdOrThrow( $baseArticleId );
		}

		$ids = null;

		if ( !empty( $category ) ) {
			$category = Title::makeTitleSafe( NS_CATEGORY, str_replace( ' ', '_', $category ), false, false );

			if ( !is_null( $category ) ) {
				$category = self::followRedirect( $category );

				$ids = self::getCategoryMembers( $category->getFullText(), 5000, '', '', 'timestamp' , 'desc' );

				if ( !empty( $ids ) ) {
					$ids = $ids[0];

					array_walk( $ids, function( &$val ) {
						$val = $val['pageid'];
					} );
				}
			} else {
				wfProfileOut( __METHOD__ );
				throw new InvalidParameterApiException( self::PARAMETER_CATEGORY );
			}
		}

		// This DataMartService method has
		// separate caching
		$articles = DataMartService::getTopArticlesByPageview(
			$this->wg->CityId,
			$ids,
			$namespaces,
			false,
			self::MAX_ITEMS + 1 // compensation for Main Page
		);

		$collection = [];

		if ( !empty( $articles ) ) {
			$mainPageId = Title::newMainPage()->getArticleID();
			if ( isset( $articles[ $mainPageId ] ) ) {
				unset( $articles[ $mainPageId ] );
			}
			$articleIds = array_keys( $articles );
			$ids = [];
			foreach ( array_keys( $articles ) as $i ) {

				if ( $i == $mainPageId ) {
					continue;
				}

				// data is cached on a per-article basis
				// to avoid one article requiring purging
				// the whole collection
				$cache = $this->wg->Memc->get( self::getCacheKey( $i, self::ARTICLE_CACHE_ID ) );

				if ( !is_array( $cache ) ) {
					$ids[] = $i;
				} else {
					$collection[ $cache[ 'id' ] ] = $cache;
				}
			}

			$articles = null;

			if ( count( $ids ) > 0 ) {
				$titles = Title::newFromIDs( $ids );

				if ( !empty( $titles ) ) {
					foreach ( $titles as $t ) {
						$id = $t->getArticleID();

						$article = [
							'id' => $id,
							'title' => $t->getText(),
							'url' => $t->getLocalURL(),
							'ns' => $t->getNamespace()
						];

						$collection[ $id ] = $article;

						$this->wg->Memc->set( self::getCacheKey( $id, self::ARTICLE_CACHE_ID ), $article, 86400 );
					}
				}

				$titles = null;
			}

			// sort articles correctly
			$result = [];
			foreach ( $articleIds as $id ) {
				if ( isset( $collection[ $id ] ) ) {
					$result[] = $collection[ $id ];
				}
			}
			$collection = $result;
		} else {
			wfProfileOut( __METHOD__ );
			if ( $baseArticleId === false ) {
				throw new NotFoundApiException();
			}
		}

		if ( $baseArticleId !== false ) {
			$collection = $this->rerankPopularToArticle( $collection, $baseArticleId );
		}

		$limitCollectionSize = self::MAX_ITEMS;
		if ( $limit > 0 && $limit < self::MAX_ITEMS ) {
			$limitCollectionSize = $limit;
		}
		if ( count( $collection ) > $limitCollectionSize ) {
			$collection = array_slice( $collection, 0, $limitCollectionSize );
		}

		if ( $expand ) {
			$collection = $this->expandArticlesDetails( $collection );
		}

		$this->setResponseData(
			[ 'basepath' => $this->wg->Server, 'items' => $collection ],
			[ 'imgFields' => 'thumbnail', 'urlFields' => [ 'thumbnail', 'url' ] ],
			self::getMetadataCacheTime()
		);

		$batches = null;
		wfProfileOut( __METHOD__ );
	}

	public function getMostLinked() {

		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );
		$nameSpace = NS_MAIN;

		$wikiService = new WikiService();
		$mostLinked = $wikiService->getMostLinkedPages();
		$mostLinkedOutput = [];

		if ( $expand ) {
			$params = $this->getDetailsParams();
			$mostLinkedOutput = $this->getArticlesDetails( array_keys( $mostLinked ), $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ], true );
		} else {
			foreach ( $mostLinked as $item ) {
				$title = Title::newFromText( $item['page_title'], $nameSpace );
				if ( !empty( $title ) && $title instanceof Title && !$title->isMainPage() ) {
					$mostLinkedOutput[] = [
						'id' => $item['page_id'],
						'title' => $item['page_title'],
						'url' => $title->getLocalURL(),
						'ns' => $nameSpace
					];
				}
			}
		}
		$this->setResponseData(
			[ 'basepath' => $this->wg->Server, 'items' => $mostLinkedOutput ],
			[ 'imgFields' => 'thumbnail', 'urlFields' => [ 'thumbnail', 'url' ] ],
			self::getMetadataCacheTime()
		);
	}

	/**
	 * Get the top articles by pageviews for a hub optionally filtering by namespace and/or language,
	 * available only on the www.wikia.com main domain (see examples)
	 *
	 * @requestParam string $hub The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam array $namespaces [OPTIONAL] The ID's of the namespaces (e.g. 0, 14, 6, etc.) to use as a filter, comma separated
	 *
	 * @responseParam array $items The list of top 10 wikis, each with a collection of top articles, the schema is as follows:[ [ wiki => [ id, name, language, domain ], articles => [ id, ns ] ] ]
	 *
	 * @example http://www.wikia.com/wikia.php?controller=ArticlesApi&method=getTopByHub&hub=Gaming
	 * @example http://www.wikia.com/wikia.php?controller=ArticlesApi&method=getTopByHub&hub=Gaming&namespaces=0,14
	 * @example http://www.wikia.com/wikia.php?controller=ArticlesApi&method=getTopByHub&hub=Gaming&lang=de
	 */
	public function getTopByHub() {
		wfProfileIn( __METHOD__ );

		if ( $this->wg->DBname == 'wikiaglobal' ) {
			$hub = trim( $this->request->getVal( self::PARAMETER_HUB, null ) );
			$langs = $this->request->getArray( self::PARAMETER_LANGUAGES );
			$namespaces = self::processNamespaces( $this->request->getArray( self::PARAMETER_NAMESPACES, null ), __METHOD__ );

			if ( empty( $hub ) ) {
				wfProfileOut( __METHOD__ );
				throw new MissingParameterApiException( self::PARAMETER_HUB );
			}

			if ( !empty( $langs ) &&  count( $langs ) > self::LANGUAGES_LIMIT ) {
				wfProfileOut( __METHOD__ );
				throw new LimitExceededApiException( self::PARAMETER_LANGUAGES, self::LANGUAGES_LIMIT );
			}

			$res = DataMartService::getTopCrossWikiArticlesByPageview( $hub, $langs, $namespaces );

			wfProfileOut( __METHOD__ );

			if ( empty( $res ) ) {
				wfProfileOut( __METHOD__ );
				throw new NotFoundApiException();
			}

			$this->response->setVal( 'items', $res );
		} else {
			wfProfileOut( __METHOD__ );
			throw new BadRequestApiException();
		}
	}


	public function getNew() {
		wfProfileIn( __METHOD__ );

		$ns = $this->request->getArray( self::PARAMETER_NAMESPACES );
		$limit = $this->request->getInt( self::PARAMETER_LIMIT, self::DEFAULT_NEW_ARTICLES_LIMIT );
		$minArticleQuality = $this->request->getInt( self::PARAM_ARTICLE_QUALITY );
		if ( $limit < 1 ) {
			throw new InvalidParameterApiException( self::PARAMETER_LIMIT );
		}

		if ( $limit > self::MAX_NEW_ARTICLES_LIMIT ) {
			$limit = self::MAX_NEW_ARTICLES_LIMIT;
		}

		if ( empty( $ns ) ) {
			$ns = [ self::DEFAULT_SEARCH_NAMESPACE ];
		}
		else {
			$ns = self::processNamespaces( $ns, __METHOD__ );
			sort( $ns );
			$ns = array_unique( $ns );
		}

		$key = self::getCacheKey( self::NEW_ARTICLES_CACHE_ID, '', [ implode( '-', $ns ) , $minArticleQuality, $limit ] );
		$results = $this->wg->Memc->get( $key );
		if ( $results === false ) {
			$solrResults = $this->getNewArticlesFromSolr( $ns, $limit, $minArticleQuality );
			if ( empty( $solrResults ) ) {
				$results = [];
			} else {
				$articles = array_keys( $solrResults );
				$articles = array_slice( $articles, 0, $limit );

				$rev = new RevisionService();
				$revisions = $rev->getFirstRevisionByArticleId( $articles );
				$creators = $this->getUserDataForArticles( $articles, $revisions );
				$thumbs = $this->getArticlesThumbnails( $articles );

				$results = [];
				foreach ( $solrResults as $id => $item ) {
					$title = Title::newFromText( $item[ 'title' ] );
					$item[ 'title' ] = $title->getText();
					$item[ 'url' ] = $title->getLocalURL();
					$item[ 'creator' ] = $creators[ $id ];
					$item[ 'creation_date' ] = isset( $revisions[ $id ] ) ? $revisions[ $id ][ 'rev_timestamp' ] : null;
					$item[ 'abstract' ] = wfShortenText( $item[ 'abstract' ], self::DEFAULT_ABSTRACT_LENGTH, true );
					$item = array_merge( $item, $thumbs[ $id ] );
					$results[] = $item;
				}

				$this->wg->Memc->set( $key, $results, self::CLIENT_CACHE_VALIDITY );
			}
		}

		if ( empty( $results ) )
		{
			throw new NotFoundApiException( 'No members' );
		}

		$this->setResponseData(
			[ 'items' => $results, 'basepath' => $this->wg->Server ],
			[ 'imgFields' => 'thumbnail', 'urlFields' => [ 'thumbnail', 'url', 'avatar' ] ],
			self::NEW_ARTICLES_VARNISH_CACHE_EXPIRATION
		);
		wfProfileOut( __METHOD__ );
	}


	protected function getNewArticlesFromSolr( $ns, $limit, $minArticleQuality ) {
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( '*' )
			->setLimit( $limit )
			->setRank( 'default' )
			->setOnWiki( true )
			->setWikiId( $this->wg->wgCityId )
			->setNamespaces( $ns )
			->setMinArticleQuality( $minArticleQuality )
			->setRank( \Wikia\Search\Config::RANK_NEWEST_PAGE_ID )
			->setRequestedFields( [ 'html_en' ] );

		$results = ( new Factory )->getFromConfig( $searchConfig )->searchAsApi(
			[ 'pageid' => 'id', 'ns', 'title_en' => 'title', 'html_en' => 'abstract' , 'article_quality_i' => 'quality' ],
			false, 'pageid' );

		return $results;
	}

	/**
	 * Resolve categor param name into internal category name (incl. redirecst)
	 * @param $category
	 * @return mixed|Title
	 */
	public static function resolveCategoryName( $category ) {
		$category = Title::makeTitleSafe( NS_CATEGORY, str_replace( ' ', '_', $category ), false, false );
		$category = self::followRedirect( $category );

		return $category;
	}

	/**
	 * Get Articles under a category
	 *
	 * @requestParam string $category [OPTIONAL] The name of a category (e.g. Characters) to use as a filter
	 * @requestParam array $namespaces [OPTIONAL] The name of the namespaces (e.g. 0, 14, 5, etc.) to use as a filter, comma separated
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 * @requestParam integer $offset [OPTIONAL] Offset to start fetching data from
	 * @requestParam string $expand [OPTIONAL] if set will expand result with getDetails data
	 *
	 * @responseParam array $items The list of top articles by pageviews matching the optional filtering
	 * @responseParam array $basepath domain of a wiki to create a url for an article
	 * @responseParam string $offset offset to start next batch of data
	 *
	 * @example
	 * @example &namespaces=14
	 * @example &limit=10&namespaces=14
	 * @example &limit=10&namespaces=14&offset=R
	 * @example &category=Weapons
	 * @example &category=Weapons&limit=5
	 */
	public function getList() {
		wfProfileIn( __METHOD__ );

		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );

		$namespaces = $this->request->getArray( self::PARAMETER_NAMESPACES, null );
		$limit = $this->request->getVal( 'limit', self::ITEMS_PER_BATCH );
		$offset = $this->request->getVal( 'offset', '' );
		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );

		if ( !empty( $category ) ) {
			$category = self::resolveCategoryName( $category );
			if ( !is_null( $category ) ) {
				if ( !empty( $namespaces ) ) {
					foreach ( $namespaces as &$n ) {
						if ( !is_numeric( $n ) ) {
							throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
						}
					}

					$namespaces = implode( '|', $namespaces );
				}

				/**
				 * Wrapping global wgMiserMode.
				 *
				 * wgMiserMode = true (default) changes the behavior of categorymembers mediawiki API, causing it to
				 * filter by namespace after making database query constrained by $limit and thus resulting
				 * in Api returning fewer than $limit results
				 *
				 * wgMiserMode = false filters on DB level
				 */
				$wrapper = new GlobalStateWrapper( [
					'wgMiserMode' => $this->excludeNamespacesFromCategoryMembersDBQuery
				] );
				$articles = $wrapper->wrap( function () use ( $category, $limit, $offset, $namespaces ) {
					return self::getCategoryMembers( $category->getFullText(), $limit, $offset, $namespaces );
				} );
			} else {
				wfProfileOut( __METHOD__ );
				throw new InvalidParameterApiException( self::PARAMETER_CATEGORY );
			}
		} else {

			$namespace = $namespaces[0];

			if (
				// if it is not numeric
				!empty( $namespace ) && !is_numeric( $namespace ) ||
				// is empty string
				$namespace === '' ||
				// or is an array with more than one value
				is_array( $namespaces ) && count( $namespaces ) > 1
			) {
				// throw an error as for now this method accepts only one namespace
				throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
			}

			$articles = WikiaDataAccess::cache(
				self::getCacheKey( $offset, self::PAGE_CACHE_ID, [ $limit . $namespace ] ),
				self::CLIENT_CACHE_VALIDITY,
				function() use ( $limit, $offset, $namespace ) {

					$params = [
						'action' => 'query',
						'list' => 'allpages',
						'aplimit' => $limit,
						'apfrom' => $offset
					];

					// even if this is $namespace empty string allpages fail to fallback to Main namespace
					if ( !empty( $namespace ) ) {
						$params['apnamespace'] = $namespace;
					}

					$pages = ApiService::call( $params );

					if ( !empty( $pages ) ) {
						return [
							$pages['query']['allpages'],
							!empty( $pages['query-continue'] ) ? $pages['query-continue']['allpages']['apfrom'] : null
						];
					} else {
						return null;
					}
				}
			);
		}

		if ( is_array( $articles ) && !empty( $articles[0] ) ) {
			$ret = [];

			if ( $expand ) {
				$articleIds = array_map( function( $item ) {
					if ( isset( $item[ 'pageid' ] ) ) {
						return $item[ 'pageid' ];
					}
				} , $articles[ 0 ] );
				$params = $this->getDetailsParams();
				$ret = $this->getArticlesDetails( $articleIds, $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ], true );
			} else {
				foreach ( $articles[0] as $article ) {
					$title = Title::newFromText( $article['title'] );

					if ( $title instanceof Title ) {
						$ret[] = [
							'id' => $article['pageid'],
							'title' => $title->getText(),
							'url' => $title->getLocalURL(),
							'ns' => $article['ns']
						];
					}
				}
			}
			$responseValues = [ 'items' => $ret, 'basepath' => $this->wg->Server ];

			if ( !empty( $articles[1] ) ) {
				$responseValues[ 'offset' ] = $articles[ 1 ];
			}

			$this->setResponseData(
				$responseValues,
				[ 'imgFields' => 'thumbnail', 'urlFields' => [ 'thumbnail', 'url' ] ],
				self::getMetadataCacheTime()
			);
		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No members' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get details about one or more articles, , those in the Special namespace (NS_SPECIAL) won't produce any result
	 *
	 * @requestParam string $ids A string with a comma-separated list of article ID's
	 * @requestParam string $titles DbKey titles
	 * @requestParam integer $abstract [OPTIONAL] The desired length for the article's abstract, defaults to 100, maximum 500, 0 for no abstract
	 * @requestParam integer $width [OPTIONAL] The desired width for the thumbnail, defaults to 200, 0 for no thumbnail
	 * @requestParam integer $height [OPTIONAL] The desired height for the thumbnail, defaults to 200, 0 for no thumbnail
	 *
	 * @responseParam array $items A list of results with the article ID as the index, each item has a title, url, revision, namespace ID, comments (if ArticleComments is enabled on the wiki), abstract (if available), thumbnail (if available), original_dimensions and type property, for videos it also includes metadata which consist title, description and duration
	 * @responseParam string $basepath domain of a wiki to create a url for an article
	 *
	 * @example &ids=2187,23478&abstract=200&width=300&height=150
	 */
	public function getDetails() {
		wfProfileIn( __METHOD__ );
		$this->setOutputFieldType( "items", self::OUTPUT_FIELD_TYPE_OBJECT );

		// get optional params for details
		$params = $this->getDetailsParams();

		// avoid going through the whole routine
		// if the requested length is out of range
		// as ArticleService::getTextSnippet would fail anyways
		if ( $params[ 'length' ] > ArticleService::MAX_LENGTH ) {
			throw new OutOfRangeApiException( self::PARAMETER_ABSTRACT, 0, ArticleService::MAX_LENGTH );
		}

		$articles = explode( ',', $this->request->getVal( self::PARAMETER_ARTICLES, null ) );

		if ( empty( $articles ) && empty( $params[ 'titleKeys' ] ) ) {
			throw new MissingParameterApiException( self::PARAMETER_ARTICLES );
		}
		$collection = $this->getArticlesDetails( $articles, $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ] );

		/*
		 * Varnish/Browser caching not appliable for
		 * for this method's data to be kept up-to-date
		 */
		$this->setResponseData(
			[ 'items' => $collection, 'basepath' => $this->wg->Server ],
			[ 'imgFields' => 'thumbnail', 'urlFields' => [ 'thumbnail', 'url' ] ],
			self::getMetadataCacheTime( true )
		);

		$collection = null;
		wfProfileOut( __METHOD__ );
	}

	protected function getDetailsParams() {
		return [
			'width' => $this->request->getInt( static::PARAMETER_WIDTH, static::DEFAULT_WIDTH ),
			'height' => $this->request->getInt( static::PARAMETER_HEIGHT, static::DEFAULT_HEIGHT ),
			'length' => $this->request->getInt( static::PARAMETER_ABSTRACT, static::DEFAULT_ABSTRACT_LEN ),
			'titleKeys' => $this->request->getArray( self::PARAMETER_TITLES )
		];
	}

	protected function appendMetadata( $collection ) {
		if ( !empty( $this->wg->EnablePOIExt ) ) {
			$helper = new QuestDetailsSolrHelper();
			$questDetailsSearch = new QuestDetailsSearchService();
			$metadata = $questDetailsSearch->newQuery()
				->withIds( array_keys( $collection ), $this->wg->CityId )
				->search();
			$metadata = $helper->processMetadata( $metadata );
			foreach ( $collection as &$item ) {
				$key = $this->wg->CityId . "_" . $item[ "id" ];
				if ( isset( $metadata[ $key ] ) ) {
					$item[ "metadata" ] = $metadata[ $key ];
				}
			}
		}
		return $collection;
	}

	protected function getArticlesDetails( $articleIds, $articleKeys = [], $width = 0, $height = 0, $abstract = 0, $strict = false ) {
		$articles = is_array( $articleIds ) ? $articleIds : [ $articleIds ];
		$ids = [];
		$collection = [];
		$resultingCollectionIds = [];
		$titles = [];
		foreach ( $articles as $i ) {
			// data is cached on a per-article basis
			// to avoid one article requiring purging
			// the whole collection
			$cache = $this->wg->Memc->get( self::getCacheKey( $i, self::DETAILS_CACHE_ID ) );

			if ( !is_array( $cache ) ) {
				$ids[] = $i;
			} else {
				$collection[$i] = $cache;
				$resultingCollectionIds [] = $i;
			}
		}

		if ( count( $ids ) > 0 ) {
			$titles = Title::newFromIDs( $ids );
		}

		if ( !empty( $articleKeys ) ) {
			foreach ( $articleKeys as $titleKey ) {
				$titleObj = Title::newFromDbKey( $titleKey );

				if ( $titleObj instanceof Title && $titleObj->exists() ) {
					$titles[] = $titleObj;
				}
			}
		}

		if ( !empty( $titles ) ) {
			foreach ( $titles as $t ) {
				$fileData = [];
				if ( $t->getNamespace() == NS_FILE ) {
					$fileData = $this->getFromFile( $t->getText() );
				} elseif ( $t->getNamespace() == NS_MAIN ) {
					$fileData = [ 'type' => static::ARTICLE_TYPE ];
				} elseif ( $t->getNamespace() == NS_CATEGORY ) {
					$fileData = [ 'type' => static::CATEGORY_TYPE ];
				}
				$id = $t->getArticleID();
				$revId = $t->getLatestRevID();
				$rev = Revision::newFromId( $revId );

				if ( !empty( $rev ) ) {
					$collection[$id] = [
						'id' => $id,
						'title' => $t->getText(),
						'ns' => $t->getNamespace(),
						'url' => $t->getLocalURL(),
						'revision' => [
							'id' => $revId,
							'user' => $rev->getUserText( Revision::FOR_PUBLIC ),
							'user_id' => $rev->getUser( Revision::FOR_PUBLIC ),
							'timestamp' => wfTimestamp( TS_UNIX, $rev->getTimestamp() )
						]
					];

					$collection[$id]['comments'] = ( class_exists( 'ArticleCommentList' ) ) ? ArticleCommentList::newFromTitle( $t )->getCountAllNested() : false;
					// add file data
					$collection[$id] = array_merge( $collection[ $id ], $fileData );
					$resultingCollectionIds [] = $id;
					$this->wg->Memc->set( self::getCacheKey( $id, self::DETAILS_CACHE_ID ), $collection[$id], 86400 );
				} else {
					$dataLog = [
						'titleText' => $t->getText(),
						'articleId' => $t->getArticleID(),
						'revId' => $revId
					];

					WikiaLogger::instance()->info( 'No revision found for article', $dataLog );
				}

			}

			$titles = null;
		}
		// ImageServing has separate caching
		// so processing it separately allows to
		// make the thumbnail's size parametrical without
		// invalidating the titles details' cache
		// or the need to duplicate it
		$thumbnails = $this->getArticlesThumbnails( $resultingCollectionIds, $width, $height );

		$articles = null;

		// ArticleService has separate caching
		// so processing it separately allows to
		// make the length parametrical without
		// invalidating the titles details' cache
		// or the need to duplicate it
		foreach ( $collection as $id => &$details ) {
			if ( $abstract > 0 ) {
				$as = new ArticleService( $id );
				$snippet = $as->getTextSnippet( $abstract );
			} else {
				$snippet = null;
			}

			$details['abstract'] = $snippet;
			if ( isset( $thumbnails[ $id ] ) ) {
				$details = array_merge( $details, $thumbnails[ $id ] );
			}
		}

		$collection = $this->appendMetadata( $collection );

		$thumbnails = null;
		// The collection can be in random order (depends if item was found in memcache or not)
		// lets preserve original order even if we are not using strict mode:
		// to keep things consistent over time (some other APIs that are using sorted results are using
		// ArticleApi::getDetails to fetch info about articles)
		$orderedIdsFromTitles = array_diff( array_keys( $collection ), $articleIds );
		// typecasting to convert falsy values into empty array (array_merge require arrays only)
		$orderedIds = array_merge( (array)$articleIds, (array)$orderedIdsFromTitles );
		$collection = $this->preserveOriginalOrder( $orderedIds, $collection );

		// if strict - return array instead of associative array (dict)
		if ( $strict ) {
			return array_values( $collection );
		} else {
			return $collection;
		}
	}

	protected function preserveOriginalOrder( $originalOrder, $collection ) {
		$result = [];
		foreach ( $originalOrder as $id ) {
			if ( !empty( $collection[ $id ] ) ) {
				$result[ $id ] = $collection[ $id ];
			}
		}
		return $result;
	}

	protected function getUserDataForArticles( $articles, $revisions ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [];

		foreach ( $revisions as $rev ) {
			$userIds[ $rev['rev_page'] ] = $rev[ 'rev_user' ];
		}
		if ( !empty( $userIds ) ) {
			$users = ( new UserService() )->getUsers( $userIds );
			foreach ( $users as $user ) {
				$userData[ $user->getId() ] = [ 'avatar' => AvatarService::getAvatarUrl( $user->getName(), self::DEFAULT_AVATAR_SIZE ), 'name' => $user->getName() ];
			}
		}
		foreach ( $ids as $pageId ) {
			if ( isset( $userIds[ $pageId ] ) && isset( $userData[ $userIds[ $pageId ] ] ) ) {
				$result[ $pageId ] = $userData[ $userIds[ $pageId ] ];
			} else {
				$result[ $pageId ] = [ 'avatar' => null, 'name' => null ];
			}
		}
		return $result;
	}

	protected function getArticlesThumbnails( $articles, $width = self::DEFAULT_WIDTH, $height = self::DEFAULT_HEIGHT ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [];
		if ( $width > 0 && $height > 0 ) {
			$is = $this->getImageServing( $ids, $width, $height );
			// only one image max is returned
			$images = $is->getImages( 1 );
			// parse results
			foreach ( $ids as $id ) {
				$data = [ 'thumbnail' => null, 'original_dimensions' => null ];
				if ( isset( $images[ $id ] ) ) {
					$data['thumbnail'] = $images[$id][0]['url'];

					if ( is_array( $images[$id][0]['original_dimensions'] ) ) {
						$data['original_dimensions'] = $images[$id][0]['original_dimensions'];
					} else {
						$data['original_dimensions'] = null;
					}
				}
				$result[ $id ] = $data;
			}
		}

		return $result;
	}

	protected function getImageServing( $ids, $width, $height ) {
		return new ImageServing( $ids, $width, $height );
	}

	protected function getFromFile( $title ) {
		$file = wfFindFile( $title );
		if ( $file instanceof LocalFile ) {
			// media type: photo, video
			if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
				/* @var VideoHandler $handler */
				$handler = VideoHandler::getHandler( $file->getMimeType() );
				$typeInfo = explode( '/', $file->getMimeType() );
				$metadata = ( $handler ) ? $handler->getVideoMetadata( true ) : null;
				return [
					'type' => static::VIDEO_TYPE,
					'provider' => isset( $typeInfo[1] ) ? $typeInfo[1] : static::UNKNOWN_PROVIDER,
					'metadata' => [
						'title' => isset( $metadata[ 'title' ] ) ? $metadata[ 'title' ] : '',
						'description' => isset( $metadata[ 'description' ] ) ? $metadata[ 'description' ] : '',
						'duration' => isset( $metadata[ 'duration' ] ) ? (int) $metadata[ 'duration' ] : 0
					]
				];
			} else {
				return [
					'type' => static::IMAGE_TYPE
				];
			}
		}
		return [];
	}

	/**
	 * @param $category
	 * @return array|null|string
	 */
	static private function getCategoryMembers( $category, $limit = 5000, $offset = '', $namespaces = '', $sort = 'sortkey', $dir = 'asc' ) {
		return WikiaDataAccess::cache(
			self::getCacheKey( $category, self::CATEGORY_CACHE_ID, [ $limit, $offset, $namespaces, $dir ] ),
			self::getMetadataCacheTime(),
			function() use ( $category, $limit, $offset, $namespaces, $sort, $dir ) {
				$ids = ApiService::call(
					array(
						'action' => 'query',
						'list' => 'categorymembers',
						'cmprop' => 'ids|title',
						'cmsort' => $sort,
						'cmnamespace' => $namespaces,
						'cmdir' => $dir,
						'cmtitle' => $category,
						'cmlimit' => $limit,
						'cmcontinue' => $offset
					)
				);

				if ( !empty( $ids ) ) {
					return array( $ids['query']['categorymembers'], !empty( $ids['query-continue'] ) ? $ids['query-continue']['categorymembers']['cmcontinue'] : null );
				} else {
					return null;
				}
			}
		);
	}

	static private function followRedirect( $category ) {
		if ( $category instanceof Title && $category->exists() ) {
			$redirect = ( new WikiPage( $category ) )->getRedirectTarget();

			// Follow redirects only to other categories.
			if ( !empty( $redirect ) && $redirect->getNamespace() === NS_CATEGORY ) {
				return $redirect;
			}
		}

		return $category;
	}

	/**
	 * @param Array $namespaces
	 *
	 * @return Array
	 */
	static private function processNamespaces( $namespaces, $caller = null ) {
		if ( !empty( $namespaces ) ) {
			foreach ( $namespaces as &$n ) {
				$n = is_numeric( $n ) ? (int) $n : false;

				if ( $n === false ) {
					if ( $caller !== null ) {
						wfProfileOut( $caller );
					}

					throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
				}
			}
		}

		return $namespaces;
	}

	public function getAsSimpleJson() {
		$this->cors->setHeaders( $this->response );
		$articleId = (int) $this->getRequest()->getInt( self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME, NULL );
		if ( empty( $articleId ) ) {
			throw new InvalidParameterApiException( self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME );
		}

		$article = Article::newFromID( $articleId );
		if ( empty( $article ) ) {
			throw new NotFoundApiException( "Unable to find any article with " . self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME . '=' . $articleId );
		}

		$jsonFormatService = new JsonFormatService();
		$jsonSimple = $jsonFormatService->getSimpleFormatForArticle( $article );

		$this->setResponseData(
			$jsonSimple,
			[ 'imgFields' => 'images', 'urlFields' => 'src' ],
			self::SIMPLE_JSON_VARNISH_CACHE_EXPIRATION
		);
	}

	public function getAsJson() {
		$articleId = $this->getRequest()->getInt( self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME, NULL );
		$articleTitle = $this->getRequest()->getVal( self::SIMPLE_JSON_ARTICLE_TITLE_PARAMETER_NAME, NULL );
		$redirect = $this->request->getVal( 'redirect' );

		if ( !empty( $articleId ) && !empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'Can\'t use id and title in the same request' );
		}

		if ( empty( $articleId ) && empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'You need to pass title or id of an article' );
		}

		if ( !empty( $articleId ) ) {
			$article = Article::newFromID( $articleId );
		} else {
			$title = Title::newFromText( $articleTitle, NS_MAIN );

			if ( $title instanceof Title && $title->exists() ) {
				$article = Article::newFromTitle( $title, RequestContext::getMain() );
			}
		}

		if ( empty( $article ) ) {
            $response = $this->getResponse();
            $response->setCacheValidity( self::SIMPLE_JSON_VARNISH_CACHE_EXPIRATION );
			throw new NotFoundApiException( "Unable to find any article" );
		}

		if ( $redirect !== 'no' && $article->getPage()->isRedirect() ) {
			// false, Title object of local target or string with URL
			/* @var Title|string|boolean $followRedirect */
			$followRedirect = $article->getPage()->followRedirect();

			if ( $followRedirect instanceof Title && !empty( $followRedirect->getArticleID() ) ) {
				$article = Article::newFromTitle( $followRedirect, RequestContext::getMain() );
			}
		}

		// Response is based on wikiamobile skin as this already removes inline style
		// and make response smaller
		RequestContext::getMain()->setSkin(
			Skin::newFromKey( 'wikiamobile' )
		);

		global $wgArticleAsJson;
		$wgArticleAsJson = true;

		$parsedArticle = $article->getParserOutput();

		if ( $parsedArticle instanceof ParserOutput ) {
			$articleContent = json_decode( $parsedArticle->getText() );
			$content = $articleContent->content;
			$wgArticleAsJson = false;
		} else {
			$wgArticleAsJson = false;
			throw new ArticleAsJsonParserException( 'Parser is currently not available' );
		}

		$categories = [];

		foreach ( array_keys( $parsedArticle->getCategories() ) as $category ) {
			$categoryTitle = Title::newFromText( $category, NS_CATEGORY );
			if ( $categoryTitle ) {
				$categories[] = [
					'title' => $categoryTitle->getText(),
					'url' => $categoryTitle->getLocalURL()
				];
			}
		}

		$result = [
			'content' => $content,
			'media' => $articleContent->media,
			'users' => $articleContent->users,
			'categories' => $categories,
			// The same transformation that happens in OutputPage::setPageTitle:
			'displayTitle' => Sanitizer::stripAllTags( $parsedArticle->getTitleText() ),
		];

		$this->setResponseData( $result, '', self::SIMPLE_JSON_VARNISH_CACHE_EXPIRATION );
	}

	public function getPopular() {
		$limit = $this->getRequest()->getInt( self::PARAMETER_LIMIT, self::POPULAR_ARTICLES_PER_WIKI );
		if ( $limit < 1 || $limit > self::POPULAR_ARTICLES_PER_WIKI ) {
			throw new OutOfRangeApiException( self::PARAMETER_LIMIT, 1, self::POPULAR_ARTICLES_PER_WIKI );
		}

		$baseArticleId = $this->getRequest()->getVal( self::PARAMETER_BASE_ARTICLE_ID, false );
		if ( $baseArticleId !== false ) {
			$this->validateBaseArticleIdOrThrow( $baseArticleId );
		}

		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );

		$key = self::getCacheKey( self::POPULAR_CACHE_ID, '', [ $expand, $baseArticleId ] );

		$popular = $this->wg->Memc->get( $key );
		if ( $popular === false ) {
			$popular = $this->getResultFromConfig( $this->getConfigFromRequest() );

			if ( $baseArticleId !== false ) {
				$popular = $this->rerankPopularToArticle( $popular, $baseArticleId );
			}

			if ( $expand ) {
				$popular = $this->expandArticlesDetails( $popular );
			}

			$this->wg->set( $key, $popular, self::CLIENT_CACHE_VALIDITY );
		}

		$popular = array_slice( $popular, 0, $limit );

		global $wgServer;
		$this->setResponseData(
			[ 'items' => $popular, 'basepath' => $wgServer ],
			[ 'imgFields' => 'thumbnail', 'urlFields' => [ 'thumbnail', 'url' ] ],
			self::getMetadataCacheTime()
		);

	}

	protected function expandArticlesDetails( $articles ) {
		$articleIds = [ ];
		$params = $this->getDetailsParams();
		foreach ( $articles as $item ) {
			$articleIds[ ] = $item[ 'id' ];
		}
		$expanded = $this->getArticlesDetails( $articleIds, $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ], true );
		return $expanded;
	}

	/**
	 * For finding trending articles - we perform reranking of popular articles:
	 * 1) Extract list of popular articles for given wikia
	 * 2) Extract links from given article
	 * 3) Promote that popular articles, to which given article has links (move to top of popular list)
	 *
	 * If popular articles were not reranked - it means that
	 * given article doesn't have links to any popular articles within whole wikia
	 *
	 * So, we perform the following fallback:
	 * 1) Find category to which base article belongs
	 * 2) Get most popular articles of this category
	 * 3) Rerank these articles due to links in base article
	 */
	protected function rerankPopularToArticle( $popular, $baseArticleId ) {
		$links = ( new ApiOutboundingLinksService() )->getOutboundingLinks( $baseArticleId );
		$rerankedPopular = $this->reorderForLinks( $popular, $links );

		$baseArticleTitle = Title::newFromID( $baseArticleId );
		$baseArticleUrl = $baseArticleTitle->getLocalURL();

		// if base article in the list of popular - remove it from this list
		$popular = array_filter( $popular, $this->otherUrlThan( $baseArticleUrl ) );

		if ( $rerankedPopular === $popular ) {

			$category = $this->getCategoryOfArticle( $baseArticleId );

			if ( !empty( $category ) ) {

				$popularForCategory = $this->getPopularForCategory( $category );

				// if base article in the list of popular for category - remove it from this list
				$popularForCategory = array_filter( $popularForCategory, $this->otherUrlThan( $baseArticleUrl ) );

				// collect urls of popular articles for given category
				$categoryUrls = [ ];
				foreach ( $popularForCategory  as $item ) {
					$categoryUrls[ ] = $item[ 'url' ];
				}

				// remove articles from array of popular articles for entire wikia, which have url as popular articles for given category
				$popular = array_filter( $popular, $this->otherUrlThan( $categoryUrls ) );

				// merge: popular for category + popular for entire wikia
				$popularForCategory = array_merge( $popularForCategory, $popular );

				$rerankedPopularForCategory = $this->reorderForLinks( $popularForCategory, $links );

				$popular = $rerankedPopularForCategory;
			}

		} else {
			$popular = $rerankedPopular;
		}

		return $popular;
	}

	/**
	 * Return function (predicate), which consumes objects, which contains field 'url'
	 * and compares value of this field with list of $urls
	 * if this list doesn't contain given url - predicate returns true
	 *
	 * This function used for filtering array
	 */
	protected function otherUrlThan( $urls ) {
		if ( !is_array( $urls ) ) {
			$urls = [ $urls ];
		}

		$hashSet = [ ];
		foreach ( $urls as $url ) {
			$hashSet[ $url ] = true;
		}

		return function( $item ) use ( $hashSet ) {
			$url = $item[ 'url' ];
			return $hashSet[ $url ] !== true;
		} ;
	}

	protected function getCategoryOfArticle( $articleId ) {

		// querying Solr for all categories for given article

		global $wgCityId;

		$categoriesConfig = ( new Wikia\Search\Config() )
			->setDirectLuceneQuery( true )
			->setQuery( 'id:' . $wgCityId . '_' . $articleId )
			->setLimit( 1 );

		$categories = ( new Factory )->getFromConfig( $categoriesConfig )->searchAsApi( [ 'categories_mv_en' ] );

		if ( !empty( $categories[ 0 ][ 'categories_mv_en' ][ 0 ] ) ) {
			// returning first category from Solr response
			return $categories[ 0 ][ 'categories_mv_en' ][ 0 ];
		}

		return null;
	}

	protected function getPopularForCategory( $category ) {
		global $wgCityId;

		$popularForCategoryConfig = ( new Wikia\Search\Config() )
			->setLimit( self::TRENDING_ARTICLES_LIMIT )
			->setDirectLuceneQuery( true )
			->setRank( \Wikia\Search\Config::RANK_MOST_VIEWED )
			->setQuery( '(wid:' . $wgCityId . ') AND (ns:' . NS_MAIN . ') AND (categories_mv_en:' . $category . ')' );

		$popularForCategory = $this->getResultFromConfig( $popularForCategoryConfig );

		return $popularForCategory;
	}

	/**
	 * Adds to solr result localUrl from title
	 * @param Config $searchConfig
	 * @return array
	 * @throws NotFoundApiException
	 */
	protected function getResultFromConfig( Wikia\Search\Config $searchConfig ) {
		$responseValues = ( new Factory )->getFromConfig( $searchConfig )->searchAsApi( [ 'pageid' => 'id', 'title' ] );

		if ( empty( $responseValues ) ) {
			throw new NotFoundApiException();
		}

		foreach ( $responseValues as &$item ) {
			$title = Title::newFromID( $item[ 'id' ] );
			if ( $title instanceof Title ) {
				$item[ 'url' ] = $title->getLocalURL();
			}
		}

		return $responseValues;
	}

	/**
	 * Inspects request and sets config accordingly.
	 * @return Wikia\Search\Config
	 */
	protected function getConfigFromRequest() {
		$request = $this->getRequest();

		$limit = self::POPULAR_ARTICLES_PER_WIKI;
		$baseArticleId = $request->getVal( self::PARAMETER_BASE_ARTICLE_ID, false );
		if ( $baseArticleId !== false ) {
			$limit = self::TRENDING_ARTICLES_LIMIT;
		}

		$searchConfig = new Wikia\Search\Config;
		$searchConfig
			->setLimit( $limit )
			->setRank( \Wikia\Search\Config::RANK_MOST_VIEWED )
			->setOnWiki( true )
			->setNamespaces( [ self::POPULAR_ARTICLES_NAMESPACE ] )
			->setQuery( '*' )
			->setMainPage( false );

		return $searchConfig;
	}

	static private function getCacheKey( $name, $type, $params = '' ) {
		$app = F::app();
		if ( !empty( $app->wg->EnablePOIExt ) ) {
			$name .= PalantirApiController::MEMC_KEY_SUFFIX;
		}
		if ( $params !== '' ) {
			$params = md5( implode( '|', $params ) );
		}

		return wfMemcKey( __CLASS__, self::CACHE_VERSION, $type, $name, $params );
	}

	/**
	 * @private
	 */
	static public function purgeCache( $id ) {
		$memc = F::app()->wg->Memc;
		$memc->delete( self::getCacheKey( $id, self::ARTICLE_CACHE_ID ) );
		$memc->delete( self::getCacheKey( $id, self::DETAILS_CACHE_ID ) );
	}

	/**
	 * Reorders array $popular in such way:
	 * that items, which urls are in array $links - will be moved to the beginning of array.
	 *
	 * Example:
	 *
	 * Assume that:
	 * $popular = [ [ url => '1'], [ url => '2'], [ url => '3'], [ url => '4'], [ url => '5'], [ url => '6'] ]
	 *
	 * Assume that:
	 * $links = [ '2', '4', '5', '100', '200' ]
	 *
	 * This method will returns the following array:
	 * [ [ url => '2'], [ url => '4'], [ url => '5'], [ url => '1'], [ url => '3'], [ url => '6'] ]
	 *
	 * @param popular - array of objects, which contains field 'url'
	 * @param links - array of strings
	 */
	protected function reorderForLinks( $popular, $links ) {
		if ( empty( $popular ) ) {
			return [ ];
		}

		if ( empty( $links ) ) {
			return $popular;
		}

		$linksHashSet = [ ];
		foreach ( $links as $link ) {
			$linksHashSet[ $link ] = true;
		}

		$popularForArticle = [ ];
		foreach ( $popular as $key => $item ) {
			$link = $item[ 'url' ];
			if ( array_key_exists( $link, $linksHashSet ) ) {
				$popularForArticle[ ] = $item;
			}
		}

		foreach ( $popular as $key => $item ) {
			$link = $item[ 'url' ];
			if ( !array_key_exists( $link, $linksHashSet ) ) {
				$popularForArticle[ ] = $item;
			}
		}
		return $popularForArticle;
	}

	/**
	 * @param $value boolean
	 *
	 * @see wgMiserMode
	 */
	public function setExcludeNamespacesFromCategoryMembersDBQuery( $value ) {
		$this->excludeNamespacesFromCategoryMembersDBQuery = $value;
	}

	/**
	 * @return bool
	 */
	public function getExcludeNamespacesFromCategoryMembersDBQuery() {
		return $this->excludeNamespacesFromCategoryMembersDBQuery;
	}

	/**
	 * Checking existence of article with given $baseArtcileId
	 *
	 * If provided id corresponds to non-existent article,
	 * then throwing BadRequestApiException.
	 *
	 * @param $baseArticleId
	 * @throws BadRequestApiException
	 */
	protected function validateBaseArticleIdOrThrow( $baseArticleId ) {
		$baseArticleTitle = Title::newFromID( $baseArticleId );
		if ( empty( $baseArticleTitle ) ) {
			$message = wfMessage( 'invalid-parameter-basearticleid', $baseArticleId )->text();
			throw new BadRequestApiException( $message );
		}
	}
}
