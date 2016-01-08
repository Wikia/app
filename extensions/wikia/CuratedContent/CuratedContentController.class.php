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

	// Make sure this is updated as in CuratedContent.js

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
		global $wgWikiaCuratedContent;

		wfProfileIn( __METHOD__ );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( empty( $wgWikiaCuratedContent ) ) {
			$this->getCategories();
		} else {
			$section = $this->request->getVal( 'section' );
			if ( empty( $section ) ) {
				$this->setSectionsInResponse( $wgWikiaCuratedContent );
				$this->setFeaturedContentInResponse( $wgWikiaCuratedContent );
			} else {
				$this->setSectionItemsInResponse( $wgWikiaCuratedContent, $section );
			}

			$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
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

		$allCategories = $items['query']['allcategories'];
		if ( !empty( $allCategories ) ) {

			$ret = [ ];
			$app = F::app();
			$categoryName = $app->wg->contLang->getNsText( NS_CATEGORY );

			foreach ( $allCategories as $value ) {
				if ( $value['size'] - $value['files'] > 0 ) {
					$ret[] = $this::getJsonItem(
						$value['*'],
						$categoryName,
						isset( $value['pageid'] ) ? (int) $value['pageid'] : 0
					);
				}
			}

			$this->response->setVal( 'items', $ret );

			if ( !empty( $items['query-continue'] ) ) {
				$this->response->setVal( 'offset', $items['query-continue']['allcategories']['acfrom'] );
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No Curated Content' );
		}

		wfProfileOut( __METHOD__ );
	}

	private function setSectionItemsInResponse( $content, $requestSection ) {
		$sectionItems = $this->getSectionItems( $content, $requestSection );
		if ( !empty( $sectionItems ) ) {
			$this->setSectionItemsResponse( 'items', $sectionItems );
		} else if ( $requestSection !== '' ) {
			throw new CuratedContentSectionNotFoundException( $requestSection );
		}
	}

	private function getSectionItems( $content, $requestSection ) {
		$return = [ ];

		foreach ( $content as $section ) {
			if ( $requestSection == $section['title'] && empty( $section['featured'] ) ) {
				$return = $section['items'];
			}
		}

		return $return;
	}

	private function setFeaturedContentInResponse( $content ) {
		$ret = $this->getFeaturedSection( $content );
		if ( !empty( $ret ) ) {
			$this->setSectionItemsResponse( 'featured', $ret );
		}
	}

	private function getFeaturedSection( $content ) {
		$return = [ ];
		foreach ( $content as $section ) {
			if ( $section['featured'] ) {
				$return = $section['items'];
			}
		}

		return $return;
	}

	/**
	 * @param $sectionName
	 * @param $ret
	 *
	 * @return mixed
	 */
	private function setSectionItemsResponse( $sectionName, $ret ) {
		foreach ( $ret as &$value ) {
			list( $imageId, $imageUrl ) = CuratedContentHelper::findImageIdAndUrl(
				$value['image_id'],
				$value['article_id']
			);
			$value['image_id'] = $imageId;
			$value['image_url'] = $imageUrl;
		}
		$this->response->setVal( $sectionName, $ret );
	}

	/**
	 * @param $content Array content of a wgWikiaCuratedContent
	 *
	 * @responseReturn Array sections List of sections on a wiki
	 * @responseReturn See getSectionItems
	 */
	private function setSectionsInResponse( $content ) {
		wfProfileIn( __METHOD__ );
		$this->response->setVal(
			'sections',
			$this->getSections( $content )
		);

		// there also might be some categories without SECTION, lets find them as well (optional section)
		$optionalSections = $this->getSectionItems( $content, '' );
		$this->setSectionItemsResponse( 'items', $optionalSections );
		wfProfileOut( __METHOD__ );
	}

	private function getSections( $content ) {
		wfProfileIn( __METHOD__ );
		$sections = array_reduce(
			$content,
			function ( $ret, $item ) {
				if ( $item['title'] !== '' && empty( $item['featured'] ) ) {
					$imageId = $item['image_id'] != 0 ? $item['image_id'] : null;
					$val = [
						'title' => $item['title'],
						'image_id' => $item['image_id'] != 0 ? $item['image_id'] : null,
						'image_url' => CuratedContentHelper::findImageUrl( $imageId )
					];

					if ( !empty( $item['image_id'] ) && array_key_exists( 'image_crop', $item ) ) {
						$val['image_crop'] = $item['image_crop'];
					}

					$ret[] = $val;
				}

				return $ret;
			}
		);

		wfProfileOut( __METHOD__ );

		return $sections;
	}

	function getJsonItem( $titleName, $ns, $pageId ) {
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
		global $wgCityId, $wgUser, $wgRequest;
		
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );

		if ( $wgUser->isAllowed( 'curatedcontent' ) ) {
			$data = $this->request->getArray( 'data', [ ] );
			$properData = [];
			$status = false;

			// strip excessive data used in mercury interface (added in self::getData method)
			foreach ( $data as $section ) {

				// strip node_type and image_url from section
				unset( $section['node_type'] );
				unset( $section['image_url'] );

				// fill label for featured and rename section.title to section.label
				if ( empty( $section['label'] ) && !empty( $section['featured'] ) ) {
					$section['title'] = wfMessage( 'wikiacuratedcontent-featured-section-name' )->text();
				} else {
					$section['title'] = $section['label'];
					unset( $section['label'] );
				}

				// strip node_type and image_url from items inside section and add it to new data
				if ( is_array( $section['items'] ) && !empty( $section['items'] ) ) {
					// strip node_type and image_url
					foreach ( $section['items'] as &$item ) {
						unset( $item['node_type'] );
						unset( $item['image_url'] );
					}

					$properData[] = $section;
				}
			}

			$helper = new CuratedContentHelper();
			$sections = $helper->processSections( $properData );
			$errors = ( new CuratedContentValidator )->validateData( $sections );

			if ( !empty( $errors ) ) {
				$this->response->setVal( 'errors', $errors );
			} else {
				$status = WikiFactory::setVarByName( 'wgWikiaCuratedContent', $wgCityId, $sections );
				wfWaitForSlaves();

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

	public function getData( ) {
		global $wgWikiaCuratedContent, $wgUser;

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );

		if ( $wgUser->isAllowed( 'curatedcontent' ) ) {
			$data = [];
			if ( !empty( $wgWikiaCuratedContent ) && is_array( $wgWikiaCuratedContent ) ) {
				foreach ( $wgWikiaCuratedContent as $section ) {
					// update information about node type
					$section['node_type'] = 'section';

					// rename $section['title'] to $section['label']
					$section['label'] = $section['title'];
					unset( $section['title'] );

					if ( !empty( $section['label'] ) && empty( $section['featured'] ) ) {
						// load image for curated content sections (not optional, not featured)
						$section['image_url'] = CuratedContentHelper::findImageUrl( $section['image_id'] );
					}

					foreach ( $section['items'] as $i => $item ) {
						// load image for all items
						$section['items'][$i]['image_url'] = CuratedContentHelper::findImageUrl( $item['image_id'] );

						// update information about node type
						$section['items'][$i]['node_type'] = 'item';
					}

					$data[] = $section;
				}
			}

			$this->response->setVal( 'data', $data );
		} else {
			$this->response->setCode( \Wikia\Service\ForbiddenException::CODE );
			$this->response->setVal( 'message', 'No permissions to access curated content' );
		}
	}

	private function getCuratedContentForWiki( $wikiID ) {
		$curatedContent = [ ];
		$value = WikiFactory::getVarValueByName( 'wgWikiaCuratedContent', $wikiID );
		$curatedContent['sections'] = $this->getSections( $value );
		$curatedContent['optional'] = $this->getSectionItems( $value, '' );
		$curatedContent['featured'] = $this->getFeaturedSection( $value );
		$curatedContent['categories'] = $this->getItemsFromSections( $value, $curatedContent['sections'] );

		return $curatedContent;
	}

	private function getItemsFromSections( $content, $sections ) {
		$items = [ ];
		if ( is_array( $sections ) ) {
			foreach ( $sections as $section ) {
				$categoriesForSection = $this->getSectionItems( $content, $section['title'] );
				foreach ( $categoriesForSection as $category ) {
					$items[] = $category;
				}
			}
		}
		return $items;
	}

	private function getCuratedContentQualityForWiki( $wikiID ) {
		$curatedContent = $this->getCuratedContentForWiki( $wikiID );
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
