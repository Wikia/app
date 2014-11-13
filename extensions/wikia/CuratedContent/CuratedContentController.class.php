<?php

/**
 * CuratedContent mobile app API controller
 */
class CuratedContentController extends WikiaController {
	const API_VERSION = 1;
	const API_REVISION = 6;
	const API_MINOR_REVISION = 5;
	const APP_NAME = 'CuratedContent';
	const SKIN_NAME = 'wikiamobile';
	const DAYS = 86400;
	const HOURS = 3600;
	const MINUTES = 60;
	const SECONDS = 1;
	const LIMIT = 25;

	const NEW_API_VERSION = 1;

	const ASSETS_PATH = '/extensions/wikia/CuratedContent/assets/CuratedContentAssets.json';

	/**
	 * @var $mModel CuratedContentModel
	 */
	private $mModel = null;
	private $mPlatform = null;
	//Make sure this is updated as in CuratedContent.js
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
			throw new CuratedContentWrongAPIVersionException();
		}

		$this->mModel = new CuratedContentModel();
		$this->mPlatform = $this->request->getVal( 'os' );
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
	 * @example wikia.php?controller=CuratedContent&method=getPage&page={Title}
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
	 * API to get data from Curated Content Management Tool in json
	 *
	 * make sure that name of this function is aligned
	 * with what is in onCuratedContentSave to purge varnish correctly
	 *
	 * @return {}
	 *
	 * getList - list of sections on a wiki or list of all items if GGCMT was not used (this will be cached)
	 * getList&offset='' - next page of items if no sections were given
	 * getList&section='' - list of all members of a given section
	 *
	 */
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
		$this->response->setVal( 'messages', JSMessages::getPackages( array( 'CuratedContent' ) ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		$this->response->setVal( 'html', $html[ 'parse' ][ 'text' ][ '*' ] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief helper function to build a CuratedContentSpecial Preview
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

	public function getList() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( 'json' );

		$content = $this->wg->WikiaCuratedContent;
		if ( empty( $content ) ) {
			$this->getItems();
		} else {
			$section = $this->request->getVal( 'section' );

			if ( empty( $section ) ) {
				$this->cacheResponseFor( 14, self::DAYS );
				$this->getSections( $content );
			} else {
				$this->getSectionItems( $content, $section );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 *
	 * Returns list of items on a wiki in batches by self::LIMIT
	 *
	 * @requestParam Integer limit
	 * @requestParam String offset
	 *
	 * @response items
	 * @response offset
	 */
	private function getItems() {
		wfProfileIn( __METHOD__ );

		$limit = $this->request->getVal( 'limit', self::LIMIT * 2 );
		$offset = $this->request->getVal( 'offset', '' );

		$items = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $offset, $limit, self::NEW_API_VERSION ),
			6 * self::HOURS,
			function () use ( $limit, $offset ) {
				return ApiService::call(
					[
						'action' => 'query',
						'list' => 'allitems',
						'redirects' => true,
						'aclimit' => $limit,
						'acfrom' => $offset,
						'acprop' => 'id|size',
						//We don't want empty items to show up
						'acmin' => 1
					]
				);
			}
		);

		$allItems = $items[ 'query' ][ 'allcategories' ];

		if ( !empty( $allCategories ) ) {

			$ret = [ ];

			foreach ( $allCategories as $value ) {
				if ( $value[ 'size' ] - $value[ 'files' ] > 0 ) {
					$ret[ ] = $this::getJsonItem( $value[ '*' ],
						'category',
						isset( $value[ 'pageid' ] ) ? (int)$value[ 'pageid' ] : 0,
						NS_CATEGORY );
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
	 * Returns Items under a given Section
	 *
	 * @param $content
	 * @param $requestSection
	 *
	 * @responseReturn Array|false Items or false if section was not found
	 */
	private function getSectionItems( $content, $requestSection ) {
		wfProfileIn( __METHOD__ );

		$ret = false;

		foreach ( $content as $section ) {
			if ( $requestSection == $section[ 'title' ] ) {
				$ret = $section[ 'categories' ];
			}
		}

		if ( !empty( $ret ) ) {
			$sort = $this->request->getVal( 'sort' );

			if ( !empty( $sort ) ) {
				if ( $sort == 'alpha' ) {
					usort( $ret, function ( $a, $b ) {
						return strcasecmp( $a[ 'title' ], $b[ 'title' ] );
					} );
				} else if ( $sort == 'hot' ) {
					$hot = array_keys(
						DataMartService::getTopArticlesByPageview(
							$this->wg->CityId,
							array_reduce( $ret, function ( $ret, $item ) {
								$ret[ ] = $item[ 'id' ];
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
							$left[ ] = $value;
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
			foreach ( $ret as &$value ) {

				list( $image_id, $image_url ) =
					CuratedContentSpecialController::findImageIfNotSet(
						$value[ 'image_id' ],
						$value[ 'article_id' ] );
				$value[ 'image_id' ] = $image_id;
				$value[ 'image_url' ] = $image_url;
			}


			//Use 'id' instead of image_id
//			foreach( $ret as &$value ) {
//				if ( !empty( $value['image_id'] ) ) {
//					$value['id'] = $value['image_id'];
//				}
//				unset($value['image_id']);
//			}

			$this->response->setVal( 'items', $ret );
		} else if ( $requestSection !== '' ) {
			wfProfileOut( __METHOD__ );
			throw new InvalidParameterApiException( 'section' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $content Array content of a wgWikiaCuratedContent
	 *
	 * @responseReturn Array sections List of sections on a wiki
	 * @responseReturn See getSectionItems
	 */
	private function getSections( $content ) {
		wfProfileIn( __METHOD__ );
		$this->response->setVal(
			'sections',
			array_reduce(
				$content,
				function ( $ret, $item ) {
					if ( $item[ 'title' ] !== '' ) {
						$ret[ ] = [
							'title' => $item[ 'title' ],
							'id' => isset( $item[ 'image_id' ] ) ? $item[ 'image_id' ] : 0
						];
					}

					return $ret;
				}
			)
		);

		//there also might be some categories without SECTION, lets find them as well
		$this->getSectionItems( $content, '' );
		wfProfileOut( __METHOD__ );
	}


	function getJsonItem( $titleName, $ns, $pageId, $type ) {
		$title = Title::makeTitle( $ns, $titleName );

		return [
			'title' => $title->getFullText(),
			'type' => $type,
			'id' => $pageId,
			'nsId' => $ns,
		];
	}

	/**
	 * @brief Whenever data is saved in GG Content Managment Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onCuratedContentSave() {
		self::purgeMethod( 'getList' );

		return true;
	}


	/**
	 * @brief Whenever data is saved in GG Sponsored Videos Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onCuratedContentSponsoredSave() {
		$languages = array_keys( F::app()->wg->WikiaCuratedContentSponsoredVideos );
		//Empty array is there to purge call to getVideos without any language
		$variants = [
			[ ],
			[ 'lang' => 'list' ]
		];

		foreach ( $languages as $lang ) {
			$variants[ ] = [
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

class CuratedContentWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}
