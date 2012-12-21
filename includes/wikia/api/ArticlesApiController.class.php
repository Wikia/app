<?php
/**
 * Controller to fetch information about articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class ArticlesApiController extends WikiaApiController {

	const CACHE_VERSION = 8;

	const MAX_ITEMS = 250;
	const ITEMS_PER_BATCH = 25;
	const CLIENT_CACHE_VALIDITY = 86400;//24h
	const PARAMETER_ARTICLES = 'ids';
	const PARAMETER_ABSTRACT = 'abstract';
	const PARAMETER_NAMESPACES = 'namespaces';
	const PARAMETER_CATEGORY = 'category';

	const CATEGORY_CACHE_ID = 'category';
	const ARTICLE_CACHE_ID = 'article';
	const DETAILS_CACHE_ID = 'details';
	const PAGE_CACHE_ID = 'page';

	/**
	 * @private
	 */
	static function onArticleUpdateCategoryCounts( $this, $added, $deleted ) {
		foreach ( $added + $deleted as $cat) {
			WikiaDataAccess::cachePurge( self::getCacheKey( $cat, self::CATEGORY_CACHE_ID ) );

			$param = array(
				'category' => $cat
			);

			self::purgeMethod(
				'getTop',
				$param
			);

			self::purgeMethod(
				'getList',
				$param
			);
		}

		return true;
	}

	/**
	 * @param $category
	 * @return array|null|string
	 */
	private static function getCategoryMembers( $category, $limit = 5000, $offset = '', $namespaces = '', $sort = 'sortkey', $dir = 'asc' ){
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

	/**
	 * Get the top articles by pageviews optionally filtering by category and/or namespaces
	 *
	 * @requestParam array $namespaces [OPTIONAL] The name of the namespaces (e.g. 0, 14, 6, etc.) to use as a filter, comma separated
	 * @requestParam string $category [OPTIONAL] The name of a category (e.g. Characters) to use as a filter
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
		$this->wf->ProfileIn( __METHOD__ );

		$namespaces = $this->request->getArray( self::PARAMETER_NAMESPACES, null );
		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );
		$ids = null;

		if ( !empty( $category )) {
			$cat = Title::newFromText( $category, NS_CATEGORY );

			if ( !$cat->exists() ) {
				throw new InvalidParameterApiException( self::PARAMETER_CATEGORY );
			}

			$ids = self::getCategoryMembers( $cat->getFullText(), 5000, '', '', 'timestamp' , 'desc' );

			if ( !empty( $ids ) ) {
				$ids = array_reduce($ids[0], function( $ret, $item ) {
					$ret[] = $item['pageid'];
					return $ret;
				});
			}
		}

		if ( !empty( $namespaces ) ) {
			foreach ( $namespaces as &$n ) {
				$n = is_numeric( $n ) ? (int) $n : false;

				if ( $n === false ) {
					throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
				}
			}
		}

		//This DataMartService method has
		//separate caching
		$articles = DataMartService::getTopArticlesByPageview(
			$this->wg->CityId,
			$ids,
			$namespaces,
			false,
			self::MAX_ITEMS
		);

		$collection = array();

		if ( !empty( $articles ) ) {
			$ids = array();

			foreach ( array_keys( $articles ) as $i ) {
				//data is cached on a per-article basis
				//to avoid one article requiring purging
				//the whole collection
				$cache = $this->wg->Memc->get( self::getCacheKey( $i, self::ARTICLE_CACHE_ID ) );

				if ( !is_array( $cache ) ) {
					$ids[] = $i;
				} else {
					$collection[$i] = $cache;
				}
			}

			$articles = null;

			if ( count( $ids) > 0 ) {
				$titles = Title::newFromIDs( $ids );

				if ( !empty( $titles ) ) {
					foreach ( $titles as $t ) {
						$id = $t->getArticleID();
						$collection[$id] = array(
							'title' => $t->getText(),
							'url' => $t->getLocalURL(),
							'ns' => $t->getNamespace()
						);

						$this->wg->Memc->set( self::getCacheKey( $id, self::ARTICLE_CACHE_ID ), $collection[$id], 86400 );
					}
				}

				$titles = null;
			}
		} else {
			$this->wf->ProfileOut( __METHOD__ );
			throw new NotFoundApiException();
		}

		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->response->setVal( 'items', $collection );
		$this->response->setVal( 'basepath', $this->wg->Server );

		$batches = null;
		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * Get Articles under a category
	 *
	 * @requestParam string $category [OPTIONAL] The name of a category (e.g. Characters) to use as a filter
	 * @requestParam array $namespaces [OPTIONAL] The name of the namespaces (e.g. 0, 14, 5, etc.) to use as a filter, comma separated
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 * @requestParam integer $offset [OPTIONAL] Offset to start fetching data from
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
		$this->wf->ProfileIn( __METHOD__ );

		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );

		$namespaces = $this->request->getArray( self::PARAMETER_NAMESPACES, null );
		$limit = $this->request->getVal( 'limit', self::ITEMS_PER_BATCH );
		$offset = $this->request->getVal( 'offset', '' );

		if ( !empty( $category ) ) {
			//if $category does not have Category: in it, add it as API needs it
			$category = Title::newFromText( $category, NS_CATEGORY );

			if ( !is_null( $category ) ) {
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
				$this->wf->profileOut( __METHOD__ );
				throw new NotFoundApiException( 'Title::newFromText returned null' );
			}
		} else {

			$namespace = $namespaces[0];

			if (
				//if it is not numeric
				!empty( $namespace ) && !is_numeric( $namespace ) ||
				//is empty string
				$namespace === '' ||
				//or is an array with more than one value
				is_array($namespaces) && count($namespaces ) > 1
			) {
				//throw an error as for now this method accepts only one namespace
				throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
			}

			$articles = WikiaDataAccess::cache(
				self::getCacheKey( $offset, self::PAGE_CACHE_ID, [ $limit . $namespace ] ),
				self::CLIENT_CACHE_VALIDITY,
				function() use ( $limit, $offset, $namespace ) {

					$params = array(
						'action' => 'query',
						'list' => 'allpages',
						'aplimit' => $limit,
						'apfrom' => $offset
					);

					//even if this is $namespace empty string allpages fail to fallback to Main namespace
					if ( !empty( $namespace ) ) {
						$params['apnamespace'] = $namespace;
					}

					$pages = ApiService::call( $params );

					if ( !empty( $pages ) ) {
						return array( $pages['query']['allpages'], !empty( $pages['query-continue']) ? $pages['query-continue']['allpages']['apfrom'] : null );
					} else {
						return null;
					}
				}
			);
		}

		if ( is_array( $articles ) && !empty( $articles[0] ) ) {
			$ret = [];

			foreach( $articles[0] as $article ) {
				$title = Title::newFromText( $article['title'] );

				if ( $title ) {
					$ret[ $article['pageid'] ] = [
						'title' => $title->getText(),
						'url' => $title->getLocalURL(),
						'ns' => $article['ns']
					];
				}
			}

			$this->response->setVal( 'items', $ret );

			if ( !empty( $articles[1] ) ) {
				$this->response->setVal( 'offset', $articles[1] );
			}

			$this->response->setVal( 'basepath', $this->wg->Server );
		} else {
			$this->wf->profileOut( __METHOD__ );
			throw new NotFoundApiException( 'No members' );
		}

		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * Get details about one or more articles
	 *
	 * @requestParam string $ids A string with a comma-separated list of article ID's
	 * @requestParam integer $abstract [OPTIONAL] The desired length for the article's abstract, defaults to 100, maximum 500, 0 for no abstract
	 * @requestParam integer $width [OPTIONAL] The desired width for the thumbnail, defaults to 200, 0 for no thumbnail
	 * @requestParam integer $height [OPTIONAL] The desired height for the thumbnail, defaults to 200, 0 for no thumbnail
	 *
	 * @responseParam array A list of results with the article ID as the index, each item has a revision, namespace (id, text), comments (if ArticleComments is enabled on the wiki), abstract (if available), thumbnail (if available) property
	 *
	 * @example &ids=2187,23478&abstract=200&width=300&height=150
	 */
	public function getDetails() {
		$this->wf->profileIn( __METHOD__ );

		$articles = $this->request->getVal( self::PARAMETER_ARTICLES, null );
		$abstractLen = $this->request->getInt( self::PARAMETER_ABSTRACT, 100 );
		$width = $this->request->getInt( 'width', 200 );
		$height = $this->request->getInt( 'height', 200 );
		$collection = array();

		//avoid going through the whole routine
		//if the requested length is out of range
		//as ArticleService::getTextSnippet would fail anyways
		if ( $abstractLen > ArticleService::MAX_LENGTH ) {
			throw new OutOfRangeApiException( self::PARAMETER_ABSTRACT, 0, ArticleService::MAX_LENGTH );
		}

		if ( !empty( $articles ) ) {
			$articles = explode( ',', $articles );
			$ids = array();


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

				if ( !empty( $titles ) ) {
					foreach ( $titles as $t ) {
						$id = $t->getArticleID();

						$collection[$id] = [
							'revision' => $t->getLatestRevID(),
							'ns' => $t->getNamespace()
						];

						$collection[$id]['comments'] = ( class_exists( 'ArticleCommentList' ) ) ? ArticleCommentList::newFromTitle( $t )->getCountAllNested() : false;

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
				if ( $abstractLen > 0 ) {
					$as = new ArticleService( $id );
					$snippet = $as->getTextSnippet( $abstractLen );
				} else {
					$snippet = null;
				}

				$details['abstract'] = $snippet;
				$details['thumbnail'] = ( array_key_exists( $id, $thumbnails ) ) ? $thumbnails[$id][0]['url'] : null;
			}

			$thumbnails = null;
		} else {
			throw new MissingParameterApiException( self::PARAMETER_ARTICLES );
		}

		/*
		 * Varnish/Browser caching not appliable for
		 * for this method's data to be kept up-to-date
		 */

		$this->response->setVal( 'items', $collection );

		$collection = null;
		$this->wf->ProfileOut( __METHOD__ );
	}

	static private function getCacheKey( $name, $type, $params = '' ) {
		if ( $params !== '' ) {
			$params = md5( implode( '|', $params ) );
		}
		return F::app()->wf->MemcKey( __CLASS__, self::CACHE_VERSION, $type, $name, $params );
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