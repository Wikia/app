<?php
/**
 * Controller to fetch information about articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
use Wikia\Search\Config, Wikia\Search\QueryService\Factory, Wikia\Search\QueryService\DependencyContainer;

class ArticlesApiController extends WikiaApiController {

	const CACHE_VERSION = 15;

	const POPULAR_ARTICLES_PER_WIKI = 10;
	const POPULAR_ARTICLES_NAMESPACE = 0;

	const MAX_ITEMS = 250;
	const ITEMS_PER_BATCH = 25;
	const TOP_WIKIS_FOR_HUB = 10;
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

	const CLIENT_CACHE_VALIDITY = 86400;//24h
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

	const NEW_ARTICLES_VARNISH_CACHE_EXPIRATION = 86400; //24 hours
	const SIMPLE_JSON_VARNISH_CACHE_EXPIRATION = 86400; //24 hours
	const SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME = "id";

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

		$namespaces = self::processNamespaces( $this->request->getArray( self::PARAMETER_NAMESPACES, null ), __METHOD__ );
		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );
		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );
		$limit = $this->request->getInt( static::PARAMETER_LIMIT, 0 );

		$ids = null;

		if ( !empty( $category )) {
			$category = Title::makeTitleSafe( NS_CATEGORY, str_replace( ' ', '_', $category ), false, false );

			if ( !is_null( $category ) ) {
				$category = self::followRedirect( $category );

				$ids = self::getCategoryMembers( $category->getFullText(), 5000, '', '', 'timestamp' , 'desc' );

				if ( !empty( $ids ) ) {
					$ids = $ids[0];

					array_walk( $ids, function( &$val ) {
						$val = $val['pageid'];
					});
				}
			} else {
				throw new InvalidParameterApiException( self::PARAMETER_CATEGORY );
			}
		}

		//This DataMartService method has
		//separate caching
		$articles = DataMartService::getTopArticlesByPageview(
			$this->wg->CityId,
			$ids,
			$namespaces,
			false,
			self::MAX_ITEMS + 1 //compensation for Main Page
		);

		if(empty($articles)){
			$articles = DataMartService::getTopArticlesByPageview(
				$this->wg->CityId,
				$ids,
				$namespaces,
				false,
				self::MAX_ITEMS + 1 ,//compensation for Main Page
				DataMartService::findLastRollupsDate()
			);
		}

		$collection = [];

		if ( !empty( $articles ) ) {
			$mainPageId = Title::newMainPage()->getArticleID();
			if ( isset( $articles[ $mainPageId ] ) ) {
				unset( $articles[ $mainPageId ] );
			}
			$articleIds = array_keys( $articles );
			if ( $expand ) {
				$params = $this->getDetailsParams();
				$collection = $this->getArticlesDetails( $articleIds, $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ], true );
			} else {
				$ids = [];

				foreach ( array_keys( $articles ) as $i ) {

					if ( $i == $mainPageId ) {
						continue;
					}

					//data is cached on a per-article basis
					//to avoid one article requiring purging
					//the whole collection
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

				//sort articles correctly
				$result = [];
				foreach( $articleIds as $id ) {
					if ( isset( $collection[ $id ] ) ) {
						$result[] = $collection[ $id ];
					}
				}
				$collection = $result;
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException();
		}

		$limitCollectionSize = self::MAX_ITEMS;
		if ( $limit > 0 && $limit < self::MAX_ITEMS ) {
			$limitCollectionSize = $limit;
		}
		if ( count( $collection ) > $limitCollectionSize ) {
			$collection = array_slice( $collection, 0, $limitCollectionSize );
		}

		$this->setResponseData(
			[ 'basepath' => $this->wg->Server, 'items' => $collection ],
			'thumbnail',
			self::CLIENT_CACHE_VALIDITY
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
					if ( !empty($title) && $title instanceof Title && !$title->isMainPage() ) {
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
			'thumbnail',
			self::CLIENT_CACHE_VALIDITY
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

			if ( !empty( $langs ) &&  count($langs) > self::LANGUAGES_LIMIT) {
				throw new LimitExceededApiException( self::PARAMETER_LANGUAGES, self::LANGUAGES_LIMIT );
			}

			//fetch the top 10 wikis on a weekly pageviews basis
			//this has it's own cache
			$wikis = DataMartService::getTopWikisByPageviews(
				DataMartService::PERIOD_ID_WEEKLY,
				self::TOP_WIKIS_FOR_HUB,
				$langs,
				$hub,
				1 /* only pubic */
			);

			$wikisCount = count( $wikis );

			if ( $wikisCount < 1 ) {
				throw new NotFoundApiException();
			}

			$found = 0;
			$articlesPerWiki = ceil( self::MAX_ITEMS / $wikisCount );
			$res = array();

			//fetch $articlesPerWiki articles from each wiki
			//see FB#73094 for performance review
			foreach ( $wikis as $wikiId => $data ) {
				//this has it's own cache
				$articles = DataMartService::getTopArticlesByPageview(
					$wikiId,
					null,
					$namespaces,
					false,
					$articlesPerWiki
				);

				if ( count( $articles ) == 0 ) {
					continue;
				}

				$item = [
					'wiki' => [
						'id' => $wikiId,
						//WF data has it's own cache
						'name' => WikiFactory::getVarValueByName( 'wgSitename', $wikiId ),
						'language' => WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId ),
						'domain' => WikiFactory::getVarValueByName( 'wgServer', $wikiId )
					],
					'articles' => []
				];

				foreach ( $articles as $articleId => $article ) {
					$found++;
					$item['articles'][] = [
						'id' => $articleId,
						'ns' => $article['namespace_id']
					];
				}

				$res[] = $item;
				$articles = null;
			}

			$wikis = null;
			wfProfileOut( __METHOD__ );

			if ( $found == 0 ) {
				throw new NotFoundApiException();
			}

			$this->response->setVal( 'items', $res );
		} else {
			wfProfileOut( __METHOD__ );
			throw new BadRequestApiException();
		}
	}


	public function getNew(){
		wfProfileIn( __METHOD__ );

		$ns = $this->request->getArray( self::PARAMETER_NAMESPACES );
		$limit = $this->request->getInt(self::PARAMETER_LIMIT, self::DEFAULT_NEW_ARTICLES_LIMIT);
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

		$key = self::getCacheKey( self::NEW_ARTICLES_CACHE_ID, '', [ implode( '-', $ns ) , $minArticleQuality ] );
		$results = $this->wg->Memc->get( $key );
		if ( $results === false ) {
			$solrResults = $this->getNewArticlesFromSolr( $ns, self::MAX_NEW_ARTICLES_LIMIT, $minArticleQuality );
			if ( empty( $solrResults ) ) {
				$results = [];
			} else {
				$articles = array_keys( $solrResults );
				$rev = new RevisionService();
				$revisions = $rev->getFirstRevisionByArticleId( $articles );
				$creators = $this->getUserDataForArticles( $articles, $revisions );
				$thumbs = $this->getArticlesThumbnails( array_keys( $solrResults ) );

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

		$results = array_slice( $results, 0, $limit );
		$this->setResponseData(
			[ 'items' => $results, 'basepath' => $this->wg->Server ],
			'thumbnail',
			self::NEW_ARTICLES_VARNISH_CACHE_EXPIRATION
		);
		wfProfileOut( __METHOD__ );
	}


	protected function getNewArticlesFromSolr( $ns, $limit, $minArticleQuality) {
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
	public function getList(){
		wfProfileIn( __METHOD__ );

		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );

		$namespaces = $this->request->getArray( self::PARAMETER_NAMESPACES, null );
		$limit = $this->request->getVal( 'limit', self::ITEMS_PER_BATCH );
		$offset = $this->request->getVal( 'offset', '' );
		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );

		if ( !empty( $category ) ) {
			$category = Title::makeTitleSafe( NS_CATEGORY, str_replace( ' ', '_', $category ), false, false );

			if ( !is_null( $category ) ) {
				$category = self::followRedirect( $category );

				if ( !empty( $namespaces ) ) {
					foreach ( $namespaces as &$n ) {
						if ( !is_numeric( $n ) ) {
							throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
						}
					}

					$namespaces = implode( '|', $namespaces );
				}

				$articles = self::getCategoryMembers( $category->getFullText(), $limit, $offset, $namespaces );
			} else {
				wfProfileOut( __METHOD__ );
				throw new InvalidParameterApiException( self::PARAMETER_CATEGORY );
			}
		} else {

			$namespace = $namespaces[0];

			if (
				//if it is not numeric
				!empty( $namespace ) && !is_numeric( $namespace ) ||
				//is empty string
				$namespace === '' ||
				//or is an array with more than one value
				is_array( $namespaces ) && count( $namespaces ) > 1
			) {
				//throw an error as for now this method accepts only one namespace
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

					//even if this is $namespace empty string allpages fail to fallback to Main namespace
					if ( !empty( $namespace ) ) {
						$params['apnamespace'] = $namespace;
					}

					$pages = ApiService::call( $params );

					if ( !empty( $pages ) ) {
						return [
							$pages['query']['allpages'],
							!empty( $pages['query-continue']) ? $pages['query-continue']['allpages']['apfrom'] : null
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
				}, $articles[ 0 ] );
				$params = $this->getDetailsParams();
				$ret = $this->getArticlesDetails( $articleIds, $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ], true );
			} else {
				foreach( $articles[0] as $article ) {
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

			$this->setResponseData( $responseValues, 'thumbnail', self::CLIENT_CACHE_VALIDITY );
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

		//get optional params for details
		$params = $this->getDetailsParams();

		//avoid going through the whole routine
		//if the requested length is out of range
		//as ArticleService::getTextSnippet would fail anyways
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
			'thumbnail',
			self::CLIENT_CACHE_VALIDITY
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

	protected function getArticlesDetails( $articleIds, $articleKeys = [], $width = 0, $height = 0, $abstract = 0, $strict = false ) {
		$articles = is_array( $articleIds ) ? $articleIds : [ $articleIds ];
		$ids = [];
		$collection = [];
		$titles = [];
		foreach ( $articles as $i ) {
			//data is cached on a per-article basis
			//to avoid one article requiring purging
			//the whole collection
			$cache = $this->wg->Memc->get( self::getCacheKey( $i, self::DETAILS_CACHE_ID ) );

			if ( !is_array( $cache ) ) {
				$ids[] = $i;
			} else {
				$collection[$i] = $cache;
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
					//add file data
					$collection[$id] = array_merge( $collection[ $id ], $fileData );
					$articles[] = $id;
					$this->wg->Memc->set( self::getCacheKey( $id, self::DETAILS_CACHE_ID ), $collection[$id], 86400 );
				}

			}

			$titles = null;
		}
		//ImageServing has separate caching
		//so processing it separately allows to
		//make the thumbnail's size parametrical without
		//invalidating the titles details' cache
		//or the need to duplicate it
		$thumbnails = $this->getArticlesThumbnails( $articles, $width, $height );

		$articles = null;

		//ArticleService has separate caching
		//so processing it separately allows to
		//make the length parametrical without
		//invalidating the titles details' cache
		//or the need to duplicate it
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

		$thumbnails = null;
		//if strict return to original ids order
		if ( $strict ) {
			foreach( $articleIds as $id ) {
				if ( !empty( $collection[ $id ] ) ) {
					$result[] = $collection[ $id ];
				}
			}
			return $result;
		}

		return $collection;
	}

	protected function getUserDataForArticles( $articles, $revisions ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [];

		foreach( $revisions as $rev ) {
			$userIds[ $rev['rev_page'] ] = $rev[ 'rev_user' ];
		}
		if( !empty( $userIds ) ) {
			$users = (new UserService())->getUsers( $userIds );
			foreach( $users as $user ) {
				$userData[ $user->getId() ] = [ 'avatar' => AvatarService::getAvatarUrl( $user->getName(), self::DEFAULT_AVATAR_SIZE ), 'name' => $user->getName() ];
			}
		}
		foreach( $ids as $pageId ) {
			if ( isset( $userIds[ $pageId ] ) && isset( $userData[ $userIds[ $pageId ] ] ) ){
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
			//only one image max is returned
			$images = $is->getImages( 1 );
			//parse results
			foreach( $ids as $id ) {
				$data = [ 'thumbnail' => null, 'original_dimensions' => null ];
				if ( isset( $images[ $id ] ) ) {
					$data['thumbnail'] = $images[$id][0]['url'];
					$data['original_dimensions'] = isset( $images[$id][0]['original_dimensions'] ) ?
						$images[$id][0]['original_dimensions'] : null;
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
			//media type: photo, video
			if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
				/* @var VideoHandler $handler */
				$handler = VideoHandler::getHandler( $file->getMimeType() );
				$typeInfo = explode( '/', $file->getMimeType() );
				$metadata = ( $handler ) ? $handler->getMetadata( true ) : null;
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
	static private function getCategoryMembers( $category, $limit = 5000, $offset = '', $namespaces = '', $sort = 'sortkey', $dir = 'asc' ){
		return WikiaDataAccess::cache(
			self::getCacheKey( $category, self::CATEGORY_CACHE_ID, [ $limit, $offset, $namespaces, $dir ] ),
			self::CLIENT_CACHE_VALIDITY,
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
					return array( $ids['query']['categorymembers'], !empty( $ids['query-continue']) ? $ids['query-continue']['categorymembers']['cmcontinue'] : null );
				} else {
					return null;
				}
			}
		);
	}

	static private function followRedirect( $category ) {

		if ( $category instanceof Title && $category->exists() ) {
			$redirect = (new WikiPage( $category ))->getRedirectTarget();

			if ( !empty( $redirect ) ) {
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
		$articleId = (int) $this->getRequest()->getInt(self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME, NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME );
		}

		$article = Article::newFromID( $articleId );
		if( empty($article) ) {
			throw new NotFoundApiException( "Unable to find any article with " . self::SIMPLE_JSON_ARTICLE_ID_PARAMETER_NAME . '=' . $articleId );
		}

		$jsonFormatService = new JsonFormatService();
		$jsonSimple = $jsonFormatService->getSimpleFormatForArticle( $article );

		$this->setResponseData( $jsonSimple, 'images', self::SIMPLE_JSON_VARNISH_CACHE_EXPIRATION );
	}

	public function getPopular() {
		$limit = $this->getRequest()->getInt( self::PARAMETER_LIMIT, self::POPULAR_ARTICLES_PER_WIKI );
		$expand = $this->request->getBool( static::PARAMETER_EXPAND, false );
		if ( $limit < 1 || $limit > self::POPULAR_ARTICLES_PER_WIKI ) {
			throw new OutOfRangeApiException( self::PARAMETER_LIMIT, 1, self::POPULAR_ARTICLES_PER_WIKI );
		}
		$key = self::getCacheKey( self::POPULAR_CACHE_ID, '' , [ $expand ]);

		$result = $this->wg->Memc->get( $key );
		if ( $result === false ) {
			$result = $this->getResultFromConfig( $this->getConfigFromRequest() );
			if ( $expand ) {
				$articleIds = [];
				$params = $this->getDetailsParams();
				foreach($result as $item){
					$articleIds[] = $item['id'];
				}
				$result = $this->getArticlesDetails( $articleIds, $params[ 'titleKeys' ], $params[ 'width' ], $params[ 'height' ], $params[ 'length' ], true );
			}

			$this->wg->set( $key, $result, self::CLIENT_CACHE_VALIDITY );
		}

		$result = array_slice( $result, 0, $limit );
		$this->setResponseData(
			[ 'items' => $result, 'basepath' => $this->wg->Server ],
			'thumbnail',
			self::CLIENT_CACHE_VALIDITY
		);

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
		$searchConfig = new Wikia\Search\Config;
		$searchConfig
			->setLimit( self::POPULAR_ARTICLES_PER_WIKI )
			->setRank( \Wikia\Search\Config::RANK_MOST_VIEWED )
			->setOnWiki( true )
			->setNamespaces( [ self::POPULAR_ARTICLES_NAMESPACE ] )
			->setQuery( '*' )
			->setMainPage(false);

		return $searchConfig;
	}

	static private function getCacheKey( $name, $type, $params = '' ) {
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
}
