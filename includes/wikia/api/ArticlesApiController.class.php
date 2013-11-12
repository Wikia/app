<?php
/**
 * Controller to fetch information about articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class ArticlesApiController extends WikiaApiController {

	const CACHE_VERSION = 15;

	const MAX_ITEMS = 250;
	const ITEMS_PER_BATCH = 25;
	const TOP_WIKIS_FOR_HUB = 10;
	const LANGUAGES_LIMIT = 10;

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

	const DEFAULT_WIDTH = 200;
	const DEFAULT_HEIGHT = 200;
	const DEFAULT_ABSTRACT_LEN = 100;

	const CLIENT_CACHE_VALIDITY = 86400;//24h
	const CATEGORY_CACHE_ID = 'category';
	const ARTICLE_CACHE_ID = 'article';
	const DETAILS_CACHE_ID = 'details';
	const PAGE_CACHE_ID = 'page';

	const ARTICLE_TYPE = 'article';
	const VIDEO_TYPE = 'video';
	const IMAGE_TYPE = 'image';
	const CATEGORY_TYPE = 'category';
	const UNKNOWN_PROVIDER = 'unknown';


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
		$ids = null;

		if ( !empty( $category )) {
			$category = Title::makeTitleSafe( NS_CATEGORY, str_replace( ' ', '_', $category ), false, false );

			if ( !is_null( $category ) && $category->exists() ) {
				self::followRedirect( $category );

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

		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			[
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			]
		);

		//if no mainpages were found and deleted we want to always return collection of self::MAX_ITEMS items
		if ( count( $collection ) > self::MAX_ITEMS ) {
			$collection = array_slice( $collection, 0, self::MAX_ITEMS );
		}

		$this->response->setVal( 'items', $collection );
		$this->response->setVal( 'basepath', $this->wg->Server );

		$batches = null;
		wfProfileOut( __METHOD__ );
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

			if ( !is_null( $category ) && $category->exists() ) {
				self::followRedirect( $category );

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

			$this->response->setVal( 'items', $ret );

			if ( !empty( $articles[1] ) ) {
				$this->response->setVal( 'offset', $articles[1] );
			}

			$this->response->setVal( 'basepath', $this->wg->Server );
		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No members' );
		}

		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			[
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			]
		);

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

		$this->response->setVal( 'items', $collection );
		$this->response->setVal( 'basepath', $this->wg->Server );

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
		if ( $width > 0 && $height > 0 ) {
			$is = new ImageServing( $articles, $width, $height );
			$thumbnails = $is->getImages( 1 );
		} else {
			$thumbnails = array();
		}

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
			$details['thumbnail'] = ( array_key_exists( $id, $thumbnails ) ) ? $thumbnails[$id][0]['url'] : null;
			$details['original_dimensions'] = ( array_key_exists( $id, $thumbnails ) && isset( $thumbnails[$id][0]['original_dimensions'] ) ) ? $thumbnails[$id][0]['original_dimensions'] : null;
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

	protected function getFromFile( $title ) {
		$file = wfFindFile( $title );
		if ( $file instanceof WikiaLocalFile ) {
			//media type: photo, video
			if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
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
	 * @private
	 */
	static function onArticleUpdateCategoryCounts( $this, $added, $deleted ) {
		foreach ( $added + $deleted as $cat) {
			WikiaDataAccess::cachePurge( self::getCacheKey( $cat, self::CATEGORY_CACHE_ID ) );

			$param = array(
				'category' => $cat
			);

			self::purgeMethods( [['getTop', $param], ['getList', $param]] );
		}

		return true;
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

	static private function followRedirect( &$category ) {
		$redirect = (new WikiPage( $category ))->getRedirectTarget();

		if ( !empty( $redirect ) ) {
			$category = $redirect;
		}
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
			throw new WikiaApiQueryError( "Article not found. Id:" . $articleId );
		}

		$jsonFormatService = new JsonFormatService();
		$jsonSimple = $jsonFormatService->getSimpleFormatForArticle( $article );

		$response = $this->getResponse();
		$response->setCacheValidity(self::SIMPLE_JSON_VARNISH_CACHE_EXPIRATION, self::SIMPLE_JSON_VARNISH_CACHE_EXPIRATION,
			[WikiaResponse::CACHE_TARGET_VARNISH,
				WikiaResponse::CACHE_TARGET_BROWSER ]);

		$response->setFormat("json");
		$response->setData( $jsonSimple );
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
