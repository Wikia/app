<?php

/**
 * Game Guides mobile app API controller
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @deprecated
 */
class GameGuidesController extends WikiaController {
	const API_VERSION = 1;
	const API_REVISION = 6;
	const API_MINOR_REVISION = 5;
	const APP_NAME = 'GameGuides';
	const SKIN_NAME = 'wikiamobile';
	const DAYS = 86400;
	const HOURS = 3600;
	const MINUTES = 60;
	const SECONDS = 1;
	const LIMIT = 25;

	const NEW_API_VERSION = 1;

	const ASSETS_PATH = '/extensions/wikia/GameGuides/assets/GameGuidesAssets.json';

	/**
	 * @var $mModel GameGuidesModel
	 */
	private $mModel = null;
	private $mPlatform = null;
	//Make sure this is updated as in GameGuides.js
	private static $disabledNamespaces = [
		// Core MediaWiki
		-2,
		-1,
		1,
		2,
		3,
		4,
		5,
		6,
		7,
		10,
		11,
		12,
		13,
		15,
		// Forum
		110,
		111,
		// Blog
		500,
		501,
		// Top List
		700,
		701,
		// Wall
		1200,
		1201,
		1202,
		// Wikia Forum
		2000,
		2001,
		2002,
	];

	function init() {
		$requestedVersion = $this->request->getInt( 'ver', self::API_VERSION );
		$requestedRevision = $this->request->getInt( 'rev', self::API_REVISION );

		if ( $requestedVersion != self::API_VERSION || $requestedRevision != self::API_REVISION ) {
			throw new GameGuidesWrongAPIVersionException();
		}

		$this->mModel = new GameGuidesModel();
		$this->mPlatform = $this->request->getVal( 'os' );
	}

	/*
	 * @brief Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 *
	 * @requestParam integer $limit [OPTIONAL] the maximum number of results for this call
	 * @requestParam integer $batch [OPTIONAL] the batch of results for this call, used only when $limit is passed in
	 *
	 * @responseParam see GameGuidesModel::getWikiList
	 * @see GameGuidesModel::getWikiList
	 */
	public function listWikis() {
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->mModel->getWikisList( $limit, $batch );

		foreach ( $result as $key => $value ) {
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
	}

	/*
	 * @brief Returns a collection of data for the current wiki to use in the
	 * per-wiki screen of the application
	 *
	 * @responseParam see GameGuidesModel::getWikiContents
	 * @see GameGuidesModel::getWikiContents
	 */

	public function listWikiContents() {
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$result = $this->mModel->getWikiContents();

		foreach ( $result as $key => $value ) {
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
	}

	/*
	 * @brief Returns all the contents associated to a category for the current wiki
	 *
	 * @requestParam string $category the name of the category to fetch contents from
	 * @requestParam integer $limit [OPTIONAL] the maximum number of results for this call
	 * @requestParam integer $batch [OPTIONAL] the batch of results for this call, used only when $limit is passed in
	 *
	 * @responseParam see GameGuidesModel::getCategoryContents
	 * @see GameGuidesModel::getCategoryContents
	 */
	public function listCategoryContents() {
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$category = $this->getVal( 'category' );


		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->mModel->getCategoryContents( $category, $limit, $batch );

		foreach ( $result as $key => $value ) {
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Returns the results from a local wiki search for the passed in term
	 *
	 * @reqeustParam string $term the term to search for
	 * @requestParam integer $limit [OPTIONAL] the maximum number of results for this call
	 * @requestParam integer $batch [OPTIONAL] the batch of results for this call, used only when $limit is passed in
	 *
	 * @responseParam see GameGuidesModel::getSearchResults
	 * @see GameGuidesModel::getSearchResults
	 */
	public function search() {
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$term = $this->request->getVal( 'term' );
		$limit = $this->request->getInt( 'limit', GameGuidesModel::SEARCH_RESULTS_LIMIT );
		$result = $this->mModel->getSearchResults( $term, $limit );

		foreach ( $result as $key => $value ) {
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Simple DRY function to set cache for a given time
	 *
	 * @example:
	 * $this->cacheResponseFor( 1, self:HOURS )
	 * $this->cacheResponseFor( 14, self:DAYS )
	 */
	private function cacheResponseFor( $factor, $period ) {
		if ( isset( $period ) && isset( $factor ) ) {
			$cacheValidityTime = $factor * $period;

			$this->response->setCacheValidity( $cacheValidityTime );
		}
	}

	/**
	 * @brief Api entry point to get a page and globals and messages that are relevant to the page
	 *
	 * @example wikia.php?controller=GameGuides&method=getPage&page={Title}
	 */
	public function getPage() {
		global $wgTitle;

		//This will always return json
		$this->response->setFormat( 'json' );

		$this->cacheResponseFor( 7, self::DAYS );

		//set mobile skin as this is based on it
		RequestContext::getMain()->setSkin(
			Skin::newFromKey( 'wikiamobile' )
		);

		$titleName = $this->getVal( 'page' );

		$title = Title::newFromText( $titleName );

		if ( $title instanceof Title ) {
			RequestContext::getMain()->setTitle( $title );
			$wgTitle = $title;

			$revId = $title->getLatestRevID();
			$articleId = $title->getArticleID();

			if ( $revId > 0 ) {
				try {
					$relatedPages =
						$this->app->sendRequest( 'RelatedPagesApi', 'getList',
							[
								'ids' => [ $articleId ]
							]
						)->getVal( 'items' )[ $articleId ];

					if ( !empty( $relatedPages ) ) {
						$this->response->setVal( 'relatedPages', $relatedPages );
					}
				} catch ( NotFoundApiException $error ) {
					//If RelatedPagesApi is not available don't throw it to app
				}

				$this->response->setVal(
					'html',
					$this->sendSelfRequest( 'renderPage', array(
							'page' => $titleName
						)
					)->toString() );

				$this->response->setVal(
					'revisionid',
					$revId
				);
			} else {
				throw new NotFoundApiException( 'Revision ID = 0' );
			}
		} else {
			throw new NotFoundApiException( 'Title not found' );
		}
	}

	/**
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	static function onTitleGetSquidURLs( $title, &$urls ) {

		if ( !in_array( $title->getNamespace(), self::$disabledNamespaces ) ) {
			$urls[] = self::getUrl( 'getPage', array(
				'page' => $title->getPrefixedText()
			) );
		}

		return true;
	}

	/**
	 * @brief this is a function that return rendered article
	 *
	 * @requestParam String title of a page
	 */
	public function renderPage() {
		wfProfileIn( __METHOD__ );

		$titleName = $this->request->getVal( 'page' );

		$html = ApiService::call(
			array(
				'action' => 'parse',
				'page' => $titleName,
				'prop' => 'text',
				'redirects' => 1,
				'useskin' => 'wikiamobile'
			)
		);

		$this->response->setVal( 'globals', Skin::newFromKey( 'wikiamobile' )->getTopScripts() );
		$this->response->setVal( 'messages', JSMessages::getPackages( array( 'GameGuides' ) ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		$this->response->setVal( 'html', $html[ 'parse' ][ 'text' ][ '*' ] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief helper function to build a GameGuidesSpecial Preview
	 * it returns a page and all 'global' assets
	 */
	public function renderFullPage() {
		global $IP;

		wfProfileIn( __METHOD__ );

		$resources = json_decode( file_get_contents( $IP . self::ASSETS_PATH ) );

		$scripts = '';

		foreach ( $resources->scripts as $s ) {
			$scripts .= $s;
		}

		//getPage sets cache for a response for 7 days
		$page = $this->sendSelfRequest( 'getPage', [
			'page' => $this->getVal( 'page' )
		] );

		$this->response->setVal( 'html', $page->getVal( 'html' ) );
		$this->response->setVal( 'js', $scripts );
		$this->response->setVal( 'css', $resources->styles );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief function that returns a valid and current link to resources of GG
	 *
	 * @responseParam String url to current resources
	 * @responseParam Integer cb current style version number
	 */
	public function getResourcesUrl() {
		global $IP;

		$this->response->setFormat( 'json' );
		$this->cacheResponseFor( 300, self::MINUTES );

		$hash = md5_file( $IP . self::ASSETS_PATH );

		$this->response->setVal( 'url',
			self::ASSETS_PATH . '?cb=' . $hash
		);

		//when apps will be updated this won't be needed anymore
		$this->response->setVal( 'cb', $this->wg->StyleVersion );
	}


	/*
	 * if Curated content is enabled, take content from there,
	 * otherwise take content from GameGuide Content
	 */
	private function getContentSource() {
		$content = null;
		if ( $this->wg->EnableCuratedContentExt ) {
			global $wgCityId;
			$wikiaCuratedContent = ( new CommunityDataService( $wgCityId ) )->getNonFeaturedSections();
			$content = $this->curatedContentToGameGuides( $wikiaCuratedContent );
		} else {
			$content = $this->wg->WikiaGameGuidesContent;
		}
		return $content;
	}

	/**
	 * @param array $wikiaCuratedContent
	 * @return array
	 */
	public function curatedContentToGameGuides( array $wikiaCuratedContent ) {
		$gameGuideContent = array_map( function ( $CCTag ) {
			return [
				'title' => $CCTag[ 'label' ],
				'image_id' => $CCTag[ 'image_id' ],
				'categories' => array_map(
					function ( $CCItem ) {
						return $this->createGGItem( $CCItem );
					}, array_filter( $CCTag[ 'items' ],
						function ( $CCItem ) {
							return $this->isValidItem( $CCItem );
						}
					)
				)
			];
		}, $wikiaCuratedContent );
		return isset( $gameGuideContent ) ? $gameGuideContent : [ ];
	}

	/**
	 * @param $CCItem
	 * @return bool
	 */
	private function isValidItem( $CCItem ) {
		return ( !empty( $CCItem[ 'title' ] )
				 && is_string( $CCItem[ 'title' ] )
				 && $CCItem[ 'type' ] === 'category' );
	}

	/**
	 * @param $CCItem
	 * @return array
	 */
	private function createGGItem( $CCItem ) {
		$GGCategory = [ ];
		$GGCategory[ 'title' ] = $this->removeCategoryPrefix( $CCItem[ 'title' ] );
		$GGCategory[ 'label' ] = $CCItem[ 'label' ];
		if ( empty( $CCItem[ 'image_id' ] ) ) {
			$GGCategory[ 'image_id' ] = 0;
		} else {
			$GGCategory[ 'image_id' ] = $CCItem[ 'image_id' ];
		}
		$GGCategory[ 'id' ] = $CCItem[ 'article_id' ];
		return $GGCategory;
	}

	private function removeCategoryPrefix( $title ) {
		$pos = strpos( $title, ':' );
		return substr( $title, $pos + 1 );
	}

	/**
	 * API to get data from Game Guides Content Managment Tool in json
	 *
	 * make sure that name of this function is aligned
	 * with what is in onGameGuidesContentSave to purge varnish correctly
	 *
	 * @return {}
	 *
	 * getList - list of tags on a wiki or list of all categories if GGCMT was not used (this will be cached)
	 * getList&offset='' - next page of categories if no tages were given
	 * getList&tag='' - list of all members of a given tag
	 *
	 */
	public function getList() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( 'json' );

		$content = $this->getContentSource();

		if ( empty( $content ) ) {
			$this->getCategories();
		} else {
			$tag = $this->request->getVal( 'tag' );

			if ( empty( $tag ) ) {
				$this->cacheResponseFor( 14, self::DAYS );
				$this->getTags( $content );
			} else {
				$this->getTagCategories( $content, $tag );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 *
	 * Returns list of categories on a wiki in batches by self::LIMIT
	 *
	 * @requestParam Integer limit
	 * @requestParam String offset
	 *
	 * @response categories
	 * @response offset
	 */
	private function getCategories() {
		wfProfileIn( __METHOD__ );

		$limit = $this->request->getVal( 'limit', self::LIMIT * 2 );
		$offset = $this->request->getVal( 'offset', '' );

		$categories = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $offset, $limit, self::NEW_API_VERSION ),
			6 * self::HOURS,
			function () use ( $limit, $offset ) {
				return ApiService::call(
					array(
						'action' => 'query',
						'list' => 'allcategories',
						'redirects' => true,
						'aclimit' => $limit,
						'acfrom' => $offset,
						'acprop' => 'id|size',
						//We don't want empty categories to show up
						'acmin' => 1
					)
				);
			}
		);

		$allCategories = $categories[ 'query' ][ 'allcategories' ];

		if ( !empty( $allCategories ) ) {

			$ret = [ ];

			foreach ( $allCategories as $value ) {
				if ( $value[ 'size' ] - $value[ 'files' ] > 0 ) {

					$ret[] = array(
						'title' => $value[ '*' ],
						'id' => isset( $value[ 'pageid' ] ) ? (int)$value[ 'pageid' ] : 0
					);
				}
			}

			$this->response->setVal( 'items', $ret );

			if ( !empty( $categories[ 'query-continue' ] ) ) {
				$this->response->setVal( 'offset', $categories[ 'query-continue' ][ 'allcategories' ][ 'acfrom' ] );
			}

		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No Categories' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 *
	 * Returns Categories under a given Tag
	 *
	 * @param $content
	 * @param $requestTag
	 *
	 * @responseReturn Array|false Categories or false if tag was not found
	 */
	private function getTagCategories( $content, $requestTag ) {
		wfProfileIn( __METHOD__ );

		$ret = false;

		foreach ( $content as $tag ) {
			if ( $requestTag == $tag[ 'title' ] ) {
				$ret = $tag[ 'categories' ];
			}
		}

		if ( !empty( $ret ) ) {
			$sort = $this->request->getVal( 'sort' );

			if ( !empty( $sort ) ) {
				if ( $sort == 'alpha' ) {
					usort( $ret, function ( $a, $b ) {
						return strcasecmp( $a[ 'title' ], $b[ 'title' ] );
					} );
				} elseif ( $sort == 'hot' ) {
					$hot = array_keys(
						DataMartService::getTopArticlesByPageview(
							$this->wg->CityId,
							array_reduce( $ret, function ( $ret, $item ) {
								$ret[] = $item[ 'id' ];
								return $ret;
							} ),
							null,
							false,
							//I need all of them basically
							count( $ret )
						)
					);

					$sorted = [ ];
					$left = [ ];
					foreach ( $ret as $value ) {
						$key = array_search( $value[ 'id' ], $hot );

						if ( $key === false ) {
							$left[] = $value;
						} else {
							$sorted[ $key ] = $value;
						}
					}

					ksort( $sorted );

					$ret = array_merge( $sorted, $left );
				} else {
					wfProfileOut( __METHOD__ );
					throw new InvalidParameterApiException( 'sort' );
				}
			}

			//Use 'id' instead of image_id
			foreach ( $ret as &$value ) {
				if ( !empty( $value[ 'image_id' ] ) ) {
					$value[ 'id' ] = $value[ 'image_id' ];
				}
				unset( $value[ 'image_id' ] );
			}

			$this->response->setVal( 'items', $ret );
		} elseif ( $requestTag !== '' ) {
			wfProfileOut( __METHOD__ );
			throw new InvalidParameterApiException( 'tag' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $content Array content of a wgWikiaGameGuidesContent
	 *
	 * @responseReturn Array tags List of tags on a wiki
	 * @responseReturn See getTagCategories
	 */
	private function getTags( $content ) {
		wfProfileIn( __METHOD__ );

		$this->response->setVal( 'tags', array_reduce(
			$content,
			function ( $ret, $item ) {
				if ( $item[ 'title' ] !== '' ) {
					$ret[] = array(
						'title' => $item[ 'title' ],
						'id' => isset( $item[ 'image_id' ] ) ? $item[ 'image_id' ] : 0
					);
				}

				return $ret;
			}
		) );

		//there also might be some categories without TAG, lets find them as well
		$this->getTagCategories( $content, '' );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Whenever data is saved in GG Content Managment Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onGameGuidesContentSave() {
		self::purgeMethod( 'getList' );

		return true;
	}

	/**
	 *
	 */
	function getVideos() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( 'json' );
		//We have full control on when this data change so lets cache it for a longer period of time
		$this->cacheResponseFor( 120, self::DAYS );

		$lang = $this->request->getVal( 'lang', 'en' );

		$languages = $this->wg->WikiaGameGuidesSponsoredVideos;

		if ( !empty( $languages ) ) {
			if ( array_key_exists( $lang, $languages ) ) {
				$this->response->setVal( 'items', $languages[ $lang ] );
			} elseif ( $lang == 'list' ) {
				$this->response->setVal( 'items', array_keys( $languages ) );
			} else {
				throw new NotFoundApiException( 'No data found for \'' . $lang . '\' language' );
			}

		} else {
			throw new NotFoundApiException( 'No data is available now' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Whenever data is saved in GG Sponsored Videos Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onGameGuidesSponsoredSave() {
		$languages = array_keys( F::app()->wg->WikiaGameGuidesSponsoredVideos );
		//Empty array is there to purge call to getVideos without any language
		$variants = [
			[ ],
			[ 'lang' => 'list' ]
		];

		foreach ( $languages as $lang ) {
			$variants[] = [
				'lang' => $lang
			];
		}

		self::purgeMethodVariants(
			'getVideos',
			$variants
		);

		return true;
	}
}

class GameGuidesWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}
