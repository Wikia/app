<?php
/**
 * Controller to fetch information about articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class ArticlesApiController extends WikiaApiController {
	const MAX_ITEMS = 250;
	const ITEMS_PER_BATCH = 25;
	const CACHE_VERSION = 7;
	const CLIENT_CACHE_VALIDITY = 86400;//24h
	const PARAMETER_ARTICLES = 'ids';
	const PARAMETER_ABSTRACT = 'abstract';
	const PARAMETER_NAMESPACES = 'namespaces';
	const PARAMETER_CATEGORY = 'category';

	const CATEGORY_CACHE_ID = 'category';
	const ARTICLE_CACHE_ID = 'article';
	const DETAILS_CACHE_ID = 'details';

	static function onArticleUpdateCategoryCounts( $this, $added, $deleted ) {
		foreach ( $added + $deleted as $cat) {
			WikiaDataAccess::cachePurge( self::getCacheKey( $cat, self::CATEGORY_CACHE_ID ) );

			self::purgeMethod(
				'getList',
				array(
					'category' => $cat
				)
			);
		}

		return true;
	}

	/**
	 * @param $category
	 * @return array|null|string
	 */
	private function getCategoryMembers( $category ){
		return WikiaDataAccess::cache(
			self::getCacheKey( $category, self::CATEGORY_CACHE_ID ),
			self::CLIENT_CACHE_VALIDITY,
			function() use ( $category ) {
				$ids = ApiService::call(
					array(
						'action' => 'query',
						'list' => 'categorymembers',
						'cmprop' => 'ids',
						'cmsort' => 'timestamp',
						'cmdir' => 'desc',
						'cmtitle' => $category,
						'cmlimit' => 5000
					)
				);

				if ( !empty( $ids ) ) {
					$ids = $ids['query']['categorymembers'];

					foreach( $ids as &$id ) {
						$id = $id['pageid'];
					}
				}

				return $ids;
			}
		);
	}

	/**
	 * Get the top articles by pageviews optionally filtering by category and/or namespaces
	 *
	 * @requestParam string $namespaces [OPTIONAL] The name of the namespaces (e.g. Main, Category, File, etc.) to use as a filter, comma separated
	 * @requestParam string $category [OPTIONAL] The name of a category (e.g. Characters) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 *
	 * @responseParam array $items The list of top articles by pageviews matching the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 *
	 * @example http://glee.wikia.com/wikia.php?controller=ArticlesApi&method=getList&namespaces=Main,Category
	 */
	public function getList() {
		$this->wf->ProfileIn( __METHOD__ );

		$namespaces = $this->request->getVal( self::PARAMETER_NAMESPACES, null );
		$category = $this->request->getVal( self::PARAMETER_CATEGORY, null );
		$ids = null;

		if ( !empty( $category )) {
			$cat = Title::newFromText( $category, NS_CATEGORY );

			if ( !$cat->exists() ) {
				throw new InvalidParameterApiException( self::PARAMETER_CATEGORY );
			}

			$ids = $this->getCategoryMembers( $cat->getFullText() );
		}

		if ( !empty( $namespaces ) ) {
			$namespaces = explode( ',', $namespaces );

			foreach ( $namespaces as &$n ) {
				$n = ( strtolower( $n ) === 'main' ) ? 0 : $this->wg->ContLang->getNsIndex( $n );

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
						$ns = $t->getNamespace();
						$id = $t->getArticleID();
						$collection[$id] = array(
							'title' => $t->getText(),
							'url' => $t->getLocalURL(),
							'namespace' => array(
								'id' => $t->getNamespace(),
								'text' => ( $ns === 0 ) ? 'Main' : $t->getNsText()
							)
						);

						$this->wg->Memc->set( self::getCacheKey( $id, self::ARTICLE_CACHE_ID ), $collection[$id], 86400 );
					}
				}

				$titles = null;
			}
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

		$batches = null;
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
	 * @example http://glee.wikia.com/wikia.php?controller=ArticlesApi&method=getDetails&ids=2187,23478&abstract=200&width=300&height=150
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
						$ns = $t->getNamespace();
						$id = $t->getArticleID();

						$collection[$id] = array(
							'revision' => $t->getLatestRevID(),
							'namespace' => array(
								'id' => $t->getNamespace(),
								'text' => ( $ns === 0 ) ? 'Main' : $t->getNsText()
							)
						);

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

	static private function getCacheKey( $name, $type ) {
		return F::app()->wf->MemcKey( __CLASS__, self::CACHE_VERSION, $type, $name );
	}

	static public function purgeCache( $id ) {
		$memc = F::app()->wg->Memc;
		$memc->delete( self::getCacheKey( $id, self::ARTICLE_CACHE_ID ) );
		$memc->delete( self::getCacheKey( $id, self::DETAILS_CACHE_ID ) );
	}
}