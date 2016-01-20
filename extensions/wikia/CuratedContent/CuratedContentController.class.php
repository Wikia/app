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

	const ASSETS_PATH = '/extensions/wikia/CuratedContent/assets/CuratedContentAssets.json';

	/**
	 * @var $mModel CuratedContentModel
	 */
	private $mModel = null;
	private $mPlatform = null;
	private $communityDataService = null;

	// Make sure this is updated as in CuratedContent.js
	function init() {
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
					)->getVal( 'items' )[$articleId];

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
		$this->response->setVal( 'html', $this->infoboxFixSectionReplace( $html['parse']['text']['*'] ) );

		wfProfileOut( __METHOD__ );
	}

	public function infoboxFixSectionReplace( $html ) {
		$matches = [ ];
		preg_match_all( "/<aside class=\"portable-infobox.+?>(.+?)<\\/aside>/ms", $html, $matches );
		if ( isset( $matches[1] ) ) {
			foreach ( $matches[1] as $to_replace ) {
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

		global $wgWikiaCuratedContent;
		//var_dump( $wgWikiaCuratedContent );die;

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$section = $this->request->getVal( 'section' );
		$limit = $this->request->getVal( 'limit', self::LIMIT * 2 );
		$offset = $this->request->getVal( 'offset', '' );

		$response = $this->communityDataService->getList( $section, $limit, $offset );

		//TODO: can we remove it from here?
		// OR AT LEAST USE ARRAY MAP
//		foreach ( $response as $sectionName => $sectionContent ) {
//			$this->response->setVal( $sectionName, $sectionContent );
//		}
		$this->response->setValues( $response );

		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		wfProfileOut( __METHOD__ );
	}

	public function getCuratedContentQuality() {
		$curatedContentQualityPerWiki = [ ];
		$curatedContentQualityTotal = [
			'totalNumberOfMissingImages' => 0,
			'totalNumberOfTooLongTitles' => 0,
			'totalNumberOfItems' => 0
		];
		$wikiID = $this->request->getInt( 'wikiID', null );
		$totalImages = $this->request->getBool( 'totalImages', false );
		$totalTitles = $this->request->getBool( 'totalTitles', false );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->getResponse()->setFormat( WikiaResponse::FORMAT_JSON );

		if ( empty( $wikiID ) ) {
			$wikiWithCC = WikiFactory::getListOfWikisWithVar(
				self::CURATED_CONTENT_WG_VAR_ID_PROD,
				"full",
				"LIKE",
				null,
				"true"
			);

			foreach ( $wikiWithCC as $wikiID => $wikiData ) {
				$quality = $this->getCuratedContentQualityForWiki( $wikiID );
				$curatedContentQualityTotal['totalNumberOfMissingImages'] += $quality['missingImagesCount'];
				$curatedContentQualityTotal['totalNumberOfTooLongTitles'] += $quality['tooLongTitlesCount'];
				$curatedContentQualityTotal['totalNumberOfItems'] += $quality['totalNumberOfItems'];
				$curatedContentQualityPerWiki[$wikiData['u']] = $quality;
			}

			if ( $totalImages ) {
				$this->response->setVal( 'item', $curatedContentQualityTotal['totalNumberOfMissingImages'] );
				$this->response->setVal( 'min', [ 'value' => 0 ] );
				$this->response->setVal( 'max', [ 'value' => $curatedContentQualityTotal['totalNumberOfItems'] ] );
			} else if ( $totalTitles ) {
				$this->response->setVal( 'item', $curatedContentQualityTotal['totalNumberOfTooLongTitles'] );
				$this->response->setVal( 'min', [ 'value' => 0 ] );
				$this->response->setVal( 'max', [ 'value' => $curatedContentQualityTotal['totalNumberOfItems'] ] );
			} else {
				$this->response->setVal( 'curatedContentQualityTotal', $curatedContentQualityTotal );
				$this->response->setVal( 'curatedContentQualityPerWiki', $curatedContentQualityPerWiki );
			}
		} else {
			$quality = $this->getCuratedContentQualityForWiki( $wikiID );
			$this->response->setVal( 'wikiQuality', $quality );
		}
	}

	public function setCuratedContentData( ) {
		global $wgUser, $wgRequest;
		
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );

		//if ( $wgUser->isAllowed( 'curatedcontent' ) ) {
		if (true) {
			$result = $this->communityDataService->setCuratedContent();
			$errors = $result['errors'];
			$status = $result['status'];

			if ( !empty( $errors ) ) {
				$this->response->setVal( 'errors', $errors );
			}
			$this->response->setVal( 'status', $status );

		} else {
			$this->response->setCode( \Wikia\Service\ForbiddenException::CODE );
			$this->response->setVal( 'message', 'No permissions to save curated content' );
		}
	}

	public function getData( ) {
		global $wgUser;

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );

		//if ( $wgUser->isAllowed( 'curatedcontent' ) ) {
		if (true) {
			$data = $this->communityDataService->getCuratedContentWithData();
			$this->response->setVal( 'data', $data );
		} else {
			$this->response->setCode( \Wikia\Service\ForbiddenException::CODE );
			$this->response->setVal( 'message', 'No permissions to access curated content' );
		}
	}

	private function getCuratedContentQualityForWiki( $wikiID ) {
		$curatedContent = ( new CuratedContentController( $wikiID ) )->getCuratedContent();
		$tooLongTitleCount = 0;
		$missingImagesCount = 0;
		$totalNumberOfItems = 0;
		if ( is_array( $curatedContent ) ) {
			foreach ( $curatedContent as $curatedContentModule => $items ) {
				foreach ( $items as $item ) {
					if ( $item['type'] == 'category' || $curatedContentModule == 'featured' ) {
						if ( strlen( $item['label'] ) > CuratedContentValidator::LABEL_MAX_LENGTH ) {
							$tooLongTitleCount++;
						}
					} else {
						if ( strlen( $item['title'] ) > CuratedContentValidator::LABEL_MAX_LENGTH ) {
							$tooLongTitleCount++;
						}
					}
					if ( empty( $item['image_id'] ) ) {
						$missingImagesCount++;
					}
					$totalNumberOfItems++;
				}
			}

			return [
				'tooLongTitlesCount' => $tooLongTitleCount,
				'missingImagesCount' => $missingImagesCount,
				'totalNumberOfItems' => $totalNumberOfItems
			];
		}
		return [ ];
	}

	public function getWikisWithCuratedContent() {
		$wikisList = WikiFactory::getListOfWikisWithVar(
			self::CURATED_CONTENT_WG_VAR_ID_PROD, 'array', '!=', []
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
