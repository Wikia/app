<?php

/**
 * CuratedContent mobile app API controller
 */
class CuratedContentController extends WikiaController {
	const API_VERSION = 1;
	const API_REVISION = 1;
	const API_MINOR_REVISION = 1;
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
			$this->getCategories();
		} else {
			$section = $this->request->getVal( 'section' );

			if ( empty( $section ) ) {
				$this->cacheResponseFor( 14, self::DAYS );
				$this->getSections( $content );
				$this->getFeaturedSection( $content );
			} else {
				$this->getSectionItems( $content, $section );
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
	 * @response items
	 * @response offset
	 */
	private function getCategories() {
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
						'list' => 'allcategories',
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

		$allCategories = $items[ 'query' ][ 'allcategories' ];
		if ( !empty( $allCategories ) ) {

			$ret = [ ];
			$app = F::app();
			$categoryName = $app->wg->contLang->getNsText( NS_CATEGORY );

			foreach ( $allCategories as $value ) {
				if ( $value[ 'size' ] - $value[ 'files' ] > 0 ) {
					$ret[ ] = $this::getJsonItem( $value[ '*' ],
						$categoryName,
						isset( $value[ 'pageid' ] ) ? (int)$value[ 'pageid' ] : 0 );
				}
			}

			$this->response->setVal( 'items', $ret );

			if ( !empty( $items[ 'query-continue' ] ) ) {
				$this->response->setVal( 'offset', $items[ 'query-continue' ][ 'allcategories' ][ 'acfrom' ] );
			}

		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No Curated Content' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 *
	 * Returns Items under a given Section
	 *
	 * @param $content
	 * @param $requestSection
	 * @param string $sectionName
	 *
	 * @throws CuratedContentSectionNotFoundException
	 * @responseReturn Array|false Items or false if section was not found
	 */
	private function getSectionItems( $content, $requestSection ) {
		$ret = false;

		foreach ( $content as $section ) {
			if ( $requestSection == $section[ 'title' ] && $section[ 'featured' ] == false ) {
				$ret = $section[ 'items' ];
			}
		}

		if ( !empty( $ret ) ) {
			$this->setSectionItemsResponse( 'items', $ret );
		} else if ( $requestSection !== '' ) {
			throw new CuratedContentSectionNotFoundException( $requestSection );
		}
	}

	private function getFeaturedSection( $content ) {
		$ret = false;
		foreach ( $content as $section ) {
			if ( $section[ 'featured' ] ) {
				$ret = $section[ 'items' ];
			}
		}
		if ( !empty( $ret ) ) {
			$this->setSectionItemsResponse( 'featured', $ret );
		}
	}


	/**
	 * @param $sectionName
	 * @param $ret
	 * @param $value
	 * @return mixed
	 */
	private function setSectionItemsResponse( $sectionName, $ret ) {
		foreach ( $ret as &$value ) {
			list( $image_id, $image_url ) =
				CuratedContentSpecialController::findImageIfNotSet(
					$value[ 'image_id' ],
					$value[ 'article_id' ] );
			$value[ 'image_id' ] = $image_id;
			$value[ 'image_url' ] = $image_url;
		}
		$this->response->setVal( $sectionName, $ret );
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
					if ( $item[ 'title' ] !== '' && $item[ 'featured' ] == false ) {
						$imageId = $item[ 'image_id' ] != 0 ? $item[ 'image_id' ] : null;
						$ret[ ] = [
							'title' => $item[ 'title' ],
							'image_id' => $imageId,
							'image_url' => CuratedContentSpecialController::findImageIfNotSet
							( $imageId )[ 1 ] ];
					}
					return $ret;
				}
			)
		);

		//there also might be some categories without SECTION, lets find them as well
		$this->getSectionItems( $content, '' );
		wfProfileOut( __METHOD__ );
	}

	function getJsonItem( $titleName, $ns, $pageId ) {
		$title = Title::makeTitle( $ns, $titleName );
		list( $image_id, $image_url ) = CuratedContentSpecialController::findImageIfNotSet( 0, $pageId );
		return [
			'title' => $ns . ':' . $title->getFullText(),
			'label' => $title->getFullText(),
			'image_id' => $image_id,
			'article_id' => $pageId,
			'type' => 'category',
			'image_url' => $image_url
		];
	}

	/**
	 * @brief Whenever data is saved in Curated Content Management Tool
	 * purge Varnish cache for it and Game Guides
	 *
	 * @return bool
	 */
	static function onCuratedContentSave() {
		self::purgeMethod( 'getList' );
		if ( class_exists( 'GameGuidesController' ) ) {
			GameGuidesController::purgeMethod( 'getList' );
		}
		return true;
	}
}

class CuratedContentWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}

class CuratedContentSectionNotFoundException extends NotFoundException {
	function __construct( $paramName ) {
		parent::__construct( "Section: '{$paramName}' was not found" );
	}
}
