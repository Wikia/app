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
	const LIMIT = 25;
	const CURATED_CONTENT_WG_VAR_ID_PROD = 1460;

	const NEW_API_VERSION = 1;

	const ASSETS_PATH = '/extensions/wikia/CuratedContent/assets/CuratedContentAssets.json';

	/**
	 * @var $mModel CuratedContentModel
	 */
	private $mModel = null;
	private $mPlatform = null;
	/** @var CommunityDataService */
	private $communityDataService;

	// Make sure this is updated as in CuratedContent.js
	public function init() {
		global $wgCityId;
		$requestedVersion = $this->request->getInt( 'ver', self::API_VERSION );
		$requestedRevision = $this->request->getInt( 'rev', self::API_REVISION );

		if ( $requestedVersion != self::API_VERSION || $requestedRevision != self::API_REVISION ) {
			throw new CuratedContentWrongAPIVersionException();
		}

		$this->mModel = new CuratedContentModel();
		$this->mPlatform = $this->request->getVal( 'os' );

		$this->communityDataService = new CommunityDataService( $wgCityId );
	}


	/**
	 * @brief Api entry point to get a page and globals and messages that are relevant to the page
	 *
	 * @example wikia.php?controller=CuratedContent&method=getPage&page={Title}
	 */
	public function getPage() {
		global $wgTitle;

		// This will always return json
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		// set mobile skin as this is based on it
		RequestContext::getMain()->setSkin( Skin::newFromKey( 'wikiamobile' ) );

		$titleName = $this->getVal( 'page' );

		$title = Title::newFromText( $titleName );

		if ( $title instanceof Title ) {
			RequestContext::getMain()->setTitle( $title );
			$wgTitle = $title;

			$revId = $title->getLatestRevID();
			$articleId = $title->getArticleID();

			if ( $revId > 0 ) {
				try {
					$relatedPages = $this->app->sendRequest(
						'RelatedPagesApi',
						'getList',
						[ 'ids' => [ $articleId ] ]
					)->getVal( 'items' )[ $articleId ];

					if ( !empty( $relatedPages ) ) {
						$this->response->setVal( 'relatedPages', $relatedPages );
					}
				} catch ( NotFoundApiException $error ) {
					// If RelatedPagesApi is not available don't throw it to app
				}

				$this->response->setVal(
					'html',
					$this->sendSelfRequest(
						'renderPage',
						[ 'page' => $titleName ]
					)->toString()
				);

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
			[
				'action' => 'parse',
				'page' => $titleName,
				'prop' => 'text',
				'redirects' => 1,
				'useskin' => 'wikiamobile'
			]
		);

		$this->response->setVal( 'globals', Skin::newFromKey( 'wikiamobile' )->getTopScripts() );
		$this->response->setVal( 'messages', JSMessages::getPackages( [ 'CuratedContent' ] ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		// TODO: Remove 'infoboxFixSectionReplace', it's temporary fix for mobile aps
		// See: DAT-2864 and DAT-2859
		$this->response->setVal( 'html', $this->infoboxFixSectionReplace( $html[ 'parse' ][ 'text' ][ '*' ] ) );

		wfProfileOut( __METHOD__ );
	}

	public function infoboxFixSectionReplace( $html ) {
		$matches = [ ];
		preg_match_all( "/<aside class=\"portable-infobox.+?>(.+?)<\\/aside>/ms", $html, $matches );
		if ( isset( $matches[ 1 ] ) ) {
			foreach ( $matches[ 1 ] as $to_replace ) {
				$new_markup = str_replace( '<section', '<div', $to_replace );
				$new_markup = str_replace( '</section', '</div', $new_markup );
				$html = str_replace( $to_replace, $new_markup, $html );
			}
		}

		return $html;
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

		// getPage sets cache for a response for 24 hours
		$page = $this->sendSelfRequest(
			'getPage',
			[ 'page' => $this->getVal( 'page' ) ]
		);

		$this->response->setVal( 'html', $page->getVal( 'html' ) );
		$this->response->setVal( 'js', $scripts );
		$this->response->setVal( 'css', $resources->styles );

		wfProfileOut( __METHOD__ );
	}

	public function getList() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !$this->communityDataService->hasData() ) {
			$this->getCategories();
		} else {
			$section = $this->request->getVal( 'section' );
			if ( empty( $section ) ) {
				$this->response->setVal( 'sections', array_map( function ( $section ) {
					$imageId = $section[ 'image_id' ] != 0 ? $section[ 'image_id' ] : null;
					$result = [
						'title' => $section[ 'label' ],
						'image_id' => $imageId,
						'image_url' => CuratedContentHelper::findImageUrl( $imageId )
					];
					if ( !empty( $section[ 'image_id' ] ) && isset( $section[ 'image_crop' ] ) ) {
						$result[ 'image_crop' ] = $section[ 'image_crop' ];
					}
					return $result;
				}, $this->communityDataService->getCurated() ) );
				$this->response->setVal( 'items',
					$this->extendItemsWithImages( $this->communityDataService->getOptionalItems() ) );
				$this->response->setVal( 'featured',
					$this->extendItemsWithImages( $this->communityDataService->getFeaturedItems() ) );
			} else {
				$filteredSectionItems = $this->extendItemsWithImages(
					$this->extractItemsFromSections( $this->communityDataService->getNonFeaturedSection( $section ) ) );
				if ( !empty( $filteredSectionItems ) ) {
					$this->response->setVal( 'items', $filteredSectionItems );
				} else {
					throw new CuratedContentSectionNotFoundException( $section );
				}
			}

			$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		}

		wfProfileOut( __METHOD__ );
	}

	public function getCuratedContentQuality() {
		$wikiID = $this->request->getInt( 'wikiID', null );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->getResponse()->setFormat( WikiaResponse::FORMAT_JSON );

		if ( empty( $wikiID ) ) {
			$wikiWithCC = WikiFactory::getListOfWikisWithVar(
				self::CURATED_CONTENT_WG_VAR_ID_PROD, "full", "LIKE", null, "true" );
			$curatedContentQualityPerWiki = [ ];
			foreach ( $wikiWithCC as $id => $data ) {
				$curatedContentQualityPerWiki[ $data[ 'u' ] ] = $id;
			}

			$curatedContentQualityPerWiki = array_map( function ( $id ) {
				return $this->getCuratedContentQualityForWiki( $id );
			}, $curatedContentQualityPerWiki );
			$curatedContentQualityTotal = $this->sumUpQualityStats( $curatedContentQualityPerWiki );

			if ( $this->request->getBool( 'totalImages', false ) ) {
				$this->response->setVal( 'item', $curatedContentQualityTotal[ 'missingImagesCount' ] );
				$this->response->setVal( 'min', [ 'value' => 0 ] );
				$this->response->setVal( 'max', [ 'value' => $curatedContentQualityTotal[ 'totalNumberOfItems' ] ] );
			} elseif ( $this->request->getBool( 'totalTitles', false ) ) {
				$this->response->setVal( 'item', $curatedContentQualityTotal[ 'tooLongTitlesCount' ] );
				$this->response->setVal( 'min', [ 'value' => 0 ] );
				$this->response->setVal( 'max', [ 'value' => $curatedContentQualityTotal[ 'totalNumberOfItems' ] ] );
			} else {
				$this->response->setVal( 'curatedContentQualityTotal', $curatedContentQualityTotal );
				$this->response->setVal( 'curatedContentQualityPerWiki', $curatedContentQualityPerWiki );
			}
		} else {
			$this->response->setVal( 'wikiQuality', $this->getCuratedContentQualityForWiki( $wikiID ) );
		}
	}

	public function setCuratedContentData() {
		global $wgCityId, $wgUser, $wgRequest;

		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );

		if ( $wgUser->isAllowed( 'curatedcontent' ) ) {
			$data = $this->request->getArray( 'data', [ ] );
			$properData = [ ];
			$status = false;

			// strip excessive data used in mercury interface (added in self::getData method)
			foreach ( $data as $section ) {

				// strip node_type and image_url from section
				unset( $section[ 'node_type' ] );
				unset( $section[ 'image_url' ] );

				// fill label for featured
				if ( empty( $section[ 'label' ] ) && !empty( $section[ 'featured' ] ) ) {
					$section[ 'label' ] = wfMessage( 'wikiacuratedcontent-featured-section-name' )->text();
				}

				// strip node_type and image_url from items inside section and add it to new data
				if ( is_array( $section[ 'items' ] ) && !empty( $section[ 'items' ] ) ) {
					// strip node_type and image_url
					foreach ( $section[ 'items' ] as &$item ) {
						unset( $item[ 'node_type' ] );
						unset( $item[ 'image_url' ] );
					}

					$properData[] = $section;
				}
			}

			$helper = new CuratedContentHelper();
			$sections = $helper->processSections( $properData );
			$errors = CuratedContentValidator::validateData( $sections );

			if ( !empty( $errors ) ) {
				$this->response->setVal( 'errors', $errors );
			} else {
				$community_data = $this->request->getArray( 'community_data', [ ] );
				if ( $community_data ) {
					$community_data[ 'community_data' ] = 'true';
					$sections[] = $community_data;
				}

				$status = ( new CommunityDataService( $wgCityId ) )->setCuratedContent( $sections );

				if ( !empty( $status ) ) {
					wfRunHooks( 'CuratedContentSave', [ $sections ] );
				}
			}
			$this->response->setVal( 'status', $status );

		} else {
			$this->response->setCode( \Wikia\Service\ForbiddenException::CODE );
			$this->response->setVal( 'message', 'No permissions to save curated content' );
		}
	}

	public function getData() {
		global $wgUser;

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );

		if ( $wgUser->isAllowed( 'curatedcontent' ) ) {
			$data = [ ];
			if ( $this->communityDataService->hasData() ) {
				// extend images
				$curated = array_map( function ( $section ) {
					$section[ 'image_url' ] = CuratedContentHelper::findImageUrl( $section[ 'image_id' ] );
					return $section;
				}, $this->communityDataService->getCurated() );

				$featured = $this->communityDataService->getFeatured();
				if ( !empty( $featured ) && !empty( $curated ) ) {
					$featured[ 'featured' ] = 'true';
					$curated[] = $featured;
				}
				$optional = $this->communityDataService->getOptional();
				if ( !empty( $optional ) && !empty( $curated ) ) {
					$curated[] = $optional;
				}

				$data = array_map( function ( $section ) {
					$section[ 'node_type' ] = 'section';
					$section[ 'items' ] = $this->extendItemsWithImages( $section[ 'items' ] );
					$section[ 'items' ] = $this->extendItemsWithType( $section[ 'items' ] );
					return $section;
				}, $curated );

				$community = $this->communityDataService->getCommunityData();
				if ( !empty( $community ) ) {
					$community[ 'community_data' ] = 'true';
					$data[] = $community;
				}

			}

			$this->response->setVal( 'data', $data );
		} else {
			$this->response->setCode( \Wikia\Service\ForbiddenException::CODE );
			$this->response->setVal( 'message', 'No permissions to access curated content' );
		}
	}

	public function getWikisWithCuratedContent() {
		$wikisList = WikiFactory::getListOfWikisWithVar(
			self::CURATED_CONTENT_WG_VAR_ID_PROD, 'array', '!=', [ ]
		);

		$this->response->setVal( 'ids_list', $wikisList );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function getImage() {
		$titleName = $this->request->getVal( 'title' );
		$imageSize = $this->request->getInt( 'size', 50 );
		$url = null;
		$imageId = 0;

		if ( !empty( $titleName ) ) {
			$title = Title::newFromText( $titleName );

			if ( !empty( $title ) && $title instanceof Title && $title->exists() ) {
				$imageId = $title->getArticleID();
			}
		}

		if ( !empty( $imageId ) ) {
			$url = CuratedContentHelper::getImageUrl( $imageId, $imageSize );
		}

		$this->response->setValues( [
			'url' => $url,
			'id' => $imageId
		] );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );
	}

	public function editButton() {
		if ( CuratedContentHelper::shouldDisplayToolButton() ) {
			$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
			$this->response->setVal(
				'editMobileMainPageMessage', wfMessage( 'wikiacuratedcontent-edit-mobile-main-page' )->text()
			);
		} else {
			return false; // skip rendering
		}
	}

	private function extractItemsFromSections( array $sections ) {
		return array_reduce( $sections, function ( $result, $item ) {
			return array_merge( $result, $item[ 'items' ] );
		}, [ ] );
	}

	private function extendItemsWithImages( array $items ) {
		return array_map( [ $this, 'extendWithImageData' ], $items );
	}

	private function extendWithImageData( $item ) {
		list( $item[ 'image_id' ], $item[ 'image_url' ] ) = CuratedContentHelper::findImageIdAndUrl(
			$item[ 'image_id' ],
			$item[ 'article_id' ]
		);
		return $item;
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
			WikiaResponse::CACHE_SHORT,
			function () use ( $limit, $offset ) {
				return ApiService::call(
					[
						'action' => 'query',
						'list' => 'allcategories',
						'redirects' => true,
						'aclimit' => $limit,
						'acfrom' => $offset,
						'acprop' => 'id|size',
						// We don't want empty items to show up
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
					$ret[] = $this::getJsonItem(
						$value[ '*' ],
						$categoryName,
						isset( $value[ 'pageid' ] ) ? (int)$value[ 'pageid' ] : 0
					);
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

	private function getJsonItem( $titleName, $ns, $pageId ) {
		$title = Title::makeTitle( $ns, $titleName );
		list( $imageId, $imageUrl ) = CuratedContentHelper::findImageIdAndUrl( null, $pageId );

		return [
			'title' => $ns . ':' . $title->getFullText(),
			'label' => $title->getFullText(),
			'image_id' => $imageId,
			'article_id' => $pageId,
			'type' => 'category',
			'image_url' => $imageUrl
		];
	}

	private function extendItemsWithType( $items ) {
		return array_map( function ( $item ) {
			$item[ 'node_type' ] = 'item';
			return $item;
		}, $items );
	}

	private function getCuratedContentQualityForWiki( $wikiID ) {
		$curatedContent = $this->getCuratedContentForWiki( $wikiID );
		if ( is_array( $curatedContent ) ) {
			$stats = [ ];
			foreach ( $curatedContent as $curatedContentModule => $items ) {
				$stats = array_merge( $stats, array_map( function ( $item ) use ( $curatedContentModule ) {
					return [
						'tooLongTitlesCount' => CuratedContentValidator::hasValidLabel( $item ) ? 1 : 0,
						'missingImagesCount' => empty( $item[ 'image_id' ] ) ? 1 : 0,
						'totalNumberOfItems' => 1
					];
				}, $items ) );
			}

			// sum up all calculation results
			return $this->sumUpQualityStats( $stats );
		}
		return [ ];
	}

	private function getCuratedContentForWiki( $wikiID ) {
		$curatedContent = [ ];
		$communityData = new CommunityDataService( $wikiID );
		$sections = $communityData->getCurated();
		$curatedContent[ 'sections' ] = array_map( function ( $section ) {
			$imageId = $section[ 'image_id' ] != 0 ? $section[ 'image_id' ] : null;
			return [
				'label' => $section[ 'label' ],
				'image_id' => $imageId,
				'image_url' => CuratedContentHelper::findImageUrl( $imageId )
			];
		}, $sections );
		$curatedContent[ 'optional' ] = $communityData->getOptionalItems();
		$curatedContent[ 'featured' ] = $communityData->getFeaturedItems();
		$curatedContent[ 'categories' ] = $this->extractItemsFromSections( $sections );

		return $curatedContent;
	}

	/**
	 * Sums up stats arrays with keys: tooLongTitlesCount, missingImagesCount, totalNumberOfItems
	 * @param array $stats
	 * @return array
	 */
	private function sumUpQualityStats( $stats ) {
		return array_reduce( $stats, function ( $accu, $item ) {
			foreach ( $item as $key => $value ) {
				$accu[ $key ] += $value;
			}
			return $accu;
		}, [ 'tooLongTitlesCount' => 0, 'missingImagesCount' => 0, 'totalNumberOfItems' => 0 ] );
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
