<?php

class CuratedContentSpecialController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	const ARTICLE_ID_TAG = 'article_id';

	const STR_ARTICLE = 'article';
	const STR_BLOG = 'blog';
	const STR_FILE = 'file';
	const STR_CATEGORY = 'category';

	const ITEMS_TAG = 'items';
	const ITEM_FUNCTION_NAME = 'item';


	const DEFAULT_SECTION_TEMPLATE = 'section';

	const FEATURED_SECTION_TEMPLATE = 'featuredSection';

	public function __construct() {
		parent::__construct( 'CuratedContent', '', false );
	}

	public function index() {
		if ( !$this->wg->User->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = wfMessage( 'wikiacuratedcontent-content-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules( [
			'jquery.autocomplete',
			'jquery.ui.sortable',
			'wikia.yui',
			'wikia.aim'
		] );

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getURL( [
			'extensions/wikia/CuratedContent/css/CuratedContentManagmentTool.scss',
			'extensions/wikia/WikiaMiniUpload/css/WMU.scss'
		] );

		foreach ( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL( [
			'/extensions/wikia/CuratedContent/js/CuratedContentManagmentTool.js',
			'/extensions/wikia/WikiaMiniUpload/js/WMU.js'
		] );

		foreach ( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		JSMessages::enqueuePackage( 'CuratedContentMsg', JSMessages::INLINE );

		$this->response->setVal( 'descriptions', [
			wfMessage( 'wikiacuratedcontent-content-description-items' ),
			wfMessage( 'wikiacuratedcontent-content-description-supported-items-for-sections' ),
			wfMessage( 'wikiacuratedcontent-content-description-tag-needs-image' ),
			wfMessage( 'wikiacuratedcontent-content-description-section' ),
			wfMessage( 'wikiacuratedcontent-content-description-organize' ),
			wfMessage( 'wikiacuratedcontent-content-description-no-section' ),
			wfMessage( 'wikiacuratedcontent-content-description-items-input' )
		] );

		$this->response->setVal( 'addSection', wfMessage( 'wikiacuratedcontent-content-add-section' ) );
		$this->response->setVal( 'addItem', wfMessage( 'wikiacuratedcontent-content-add-item' ) );
		$this->response->setVal( 'save', wfMessage( 'wikiacuratedcontent-content-save' ) );

		$this->response->setVal( 'section_placeholder', wfMessage( 'wikiacuratedcontent-content-section' ) );
		$this->response->setVal( 'item_placeholder', wfMessage( 'wikiacuratedcontent-content-item' ) );
		$this->response->setVal( 'name_placeholder', wfMessage( 'wikiacuratedcontent-content-name' ) );

		$itemTemplate = $this->sendSelfRequest( self::ITEM_FUNCTION_NAME )->toString();
		$sectionTemplate = $this->sendSelfRequest( 'section' )->toString();


		$this->wg->Out->addJsConfigVars( [
			'itemTemplate' => $itemTemplate,
			'sectionTemplate' => $sectionTemplate
		] );


		$sections = $this->wg->WikiaCuratedContent;

		if ( !empty( $sections ) ) {
			$list = '';

			foreach ( $sections as $section ) {
				if ( isset( $section[ 'featured' ] ) && $section[ 'featured' ] ) {
					$featuredSection = $this->buildSection( $section );
				} else {
					$list .= $this->buildSection( $section );
				}
			}
			if ( !isset( $featuredSection ) ) {
				// add featured section if not yet exists
				$featuredSection = $this->sendSelfRequest( self::FEATURED_SECTION_TEMPLATE );
			}
			// prepend featured section
			$list = $featuredSection . $list;

			$this->response->setVal( 'list', $list );
		} else {
			$this->response->setVal( 'section', $sectionTemplate );
			$this->response->setVal( 'item', $itemTemplate );
		}

		return true;
	}

	public function featuredSection() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );

		$this->response->setVal( 'value', wfMessage( 'wikiacuratedcontent-featured-section-name' ) );
		$this->response->setVal( 'image_id', $id );
		$this->response->setVal( 'image_url', $this->getImage( $id ) );
		if ( $id != 0 ) {
			$this->response->setVal( 'image_set', true );
		}
	}

	public function section() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );

		$this->response->setVal( 'value', $this->request->getVal( 'value' ), '' );
		$this->response->setVal( 'image_id', $id );
		$this->response->setVal( 'image_url', $this->getImage( $id ) );
		if ( $id != 0 ) {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'section_placeholder', wfMessage( 'wikiacuratedcontent-content-section' ) );
	}

	/*
	 * referred by ITEM_FUNCTION_NAME
	 */
	public function item() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );
		$item = $this->request->getVal( 'item_value', '' );

		$this->response->setVal( 'item_value', $item );
		$this->response->setVal( 'name_value', $this->request->getVal( 'name_value' ), '' );
		$this->response->setVal( 'image_id', $id );


		if ( $id == 0 && $item != '' ) {
			$cat = Title::newFromText( $item, NS_CATEGORY );

			if ( $cat instanceof Title ) {
				$id = $cat->getArticleID();
			}
		} else {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'image_url', $this->getImage( $id ) );
		$this->response->setVal( 'item_placeholder', wfMessage( 'wikiacuratedcontent-content-item' ) );
		$this->response->setVal( 'name_placeholder', wfMessage( 'wikiacuratedcontent-content-name' ) );
	}

	public function save() {
		if ( !$this->wg->User->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}
		$this->response->setFormat( 'json' );

		$sections = $this->request->getArray( 'sections' );
		list( $sections, $err ) = $this->processSaveLogic( $sections );

		if ( !empty( $err ) ) {
			$this->response->setVal( 'error', $err );
			return true;
		}

		$status = WikiFactory::setVarByName( 'wgWikiaCuratedContent', $this->wg->CityId, $sections );
		$this->response->setVal( 'status', $status );

		if ( $status ) {
			wfRunHooks( 'CuratedContentSave' );
		}

		return true;
	}

	public function getImage( $id = 0 ) {
		$file = $this->request->getVal( self::STR_FILE );

		$url = '';

		if ( !empty( $file ) ) {
			$img = Title::newFromText( $file );

			if ( !empty( $img ) && $img instanceof Title ) {
				$id = $img->getArticleID();
			}
		}

		if ( $id != 0 ) {
			$is = new ImageServing( [ $id ], 50, 50 );
			$thumbnail = $is->getImages( 1 );

			if ( !empty( $thumbnail ) ) {
				$url = $thumbnail[ $id ][ 0 ][ 'url' ];
			}
		}

		$this->response->setVal( 'url', $url );
		$this->response->setVal( 'id', $id );

		return $url;
	}

	private function buildSection( $section ) {
		$result = '';
		$sectionTemplate = self::DEFAULT_SECTION_TEMPLATE;
		if ( isset( $section[ 'featured' ] ) && $section[ 'featured' ] ) {
			$sectionTemplate = self::FEATURED_SECTION_TEMPLATE;
		}
		$result .= $this->sendSelfRequest( $sectionTemplate, [
			'value' => $section[ 'title' ],
			'image_id' => $section[ 'image_id' ]
		] );
		if ( !empty( $section[ self::ITEMS_TAG ] ) ) {
			foreach ( $section[ self::ITEMS_TAG ] as $item ) {
				$result .= $this->sendSelfRequest( self::ITEM_FUNCTION_NAME, [
					'item_value' => $item[ 'title' ],
					'name_value' => !empty( $item[ 'label' ] ) ? $item[ 'label' ] : '',
					'image_id' => $item[ 'image_id' ]
				] );
			}
		}
		return $result;
	}

	/**
	 * @param $sections
	 * @return array
	 */
	private function processSaveLogic( $sections ) {
		$err = [ ];
		$sectionsAfterProcess = [ ];
		if ( !empty( $sections ) ) {
			foreach ( $sections as $section ) {
				list( $newSection, $sectionErr ) = $this->processTagBeforeSave( $section, $err );
				array_push( $sectionsAfterProcess, $newSection );
				$err = array_merge( $err, $sectionErr );
			}
		}
		return [ $sectionsAfterProcess, $err ];
	}

	/**
	 * @param $section
	 * @param $err
	 * @param string $sectionType
	 */
	private function processTagBeforeSave( $section, $err ) {
		$errFromTag = [ ];
		$section[ 'image_id' ] = (int)$section[ 'image_id' ];
		if ( !empty( $section[ self::ITEMS_TAG ] ) ) {
			list( $section, $sectionErr ) = $this->processSection( $section );
			if ( !empty( $sectionErr ) ) {
				$errFromTag = array_merge( $errFromTag, $sectionErr );
			}
		}
		return [ $section, $errFromTag ];
	}

	/**
	 * @param $section
	 */
	private function processSection( $section ) {
		$sectionErr = [ ];
		foreach ( $section[ self::ITEMS_TAG ] as &$row ) {
			list( $articleId, $namespaceId, $type, $info, $imageId ) = $this->getInfoFromRow( $row );
			$row[ 'article_id' ] = $articleId;
			$row[ 'type' ] = $type;
			$row[ 'image_id' ] = $imageId;
			if ( !empty( $info ) ) {
				$row[ 'video_info' ] = $info;
			}
			$reason = $this->checkForErrors( $row, $type, $articleId, $info, $section[ 'featured' ] );
			if ( !empty( $reason ) ) {
				$rowErr = [ ];
				$rowErr[ 'title' ] = $row[ 'title' ];
				$rowErr[ 'reason' ] = $reason;
				$sectionErr[ ] = $rowErr;
			}
		}
		return [ $section, $sectionErr ];
	}

	/**
	 * @param $row
	 * @param $type
	 * @param $articleId
	 * @param $info
	 * @return reason
	 */
	private function checkForErrors( $row, $type, $articleId, $info, $isFeatured ) {
		$reason = '';
		if ( empty( $row[ 'label' ] ) ) {
			$reason = 'emptyLabel';
		}

		if ( $type == null ) {
			$reason = 'notSupportedType';
		}

		if ( $type === 'video' ) {
			if ( empty( $info ) ) {
				$reason = 'videoNotHaveInfo';
			} elseif ( $this->isSupportedProviders( $info ) ) {
				$reason = 'videoNotSupportProvider';
			}
		}

		if ( !(bool)$isFeatured && $type !== 'category' ) {
			$reason = 'noCategoryInTag';
		}

		if ( $this->needsArticleId( $type ) && $articleId === 0 ) {
			$reason = 'articleNotFound';
		}
		return $reason;
	}

	private function getInfoFromRow( &$row ) {
		$title = Title::newFromText( $row[ 'title' ] );
		if ( !empty( $title ) ) {
			$articleId = $title->getArticleId();
			$namespaceId = $title->getNamespace();
			$type = $this->getType( $namespaceId );
			$image_id = (int)$row[ 'image_id' ];
			$info = [ ];

			switch ( $type ) {
				case self::STR_FILE :
					list( $type, $info ) = $this->getVideoInfo( $title );
					break;

				case self::STR_CATEGORY:
					$category = Category::newFromTitle( $title );
					if ( !empty( $category ) ) {
						$count = $category->getPageCount();
						if ( empty( $count ) ) {
							$type = 'emptyCategory';
						}
					}
					break;
			}
			if ( $image_id === 0 ) {
				$imageTitle = $this->findFirstImageTitleFromArticle( $articleId );
				if ( !empty( $imageTitle ) ) {
					$image_id = $imageTitle->getArticleId();
				}
			}

			return [
				$articleId,
				$namespaceId,
				$type,
				$info,
				$image_id
			];
		}
		return [ null, null, null, null, null ];
	}

	private function getType( $namespaceId ) {
		switch ( $namespaceId ) {
			case NS_MAIN:
				return self::STR_ARTICLE;
				break;
			case NS_BLOG_ARTICLE:
				return self::STR_BLOG;
				break;
			case NS_CATEGORY:
				return self::STR_CATEGORY;
				break;
			case NS_FILE:
				return self::STR_FILE;
				break;
			default:
				return null;
				break;
		}
	}

	private function getVideoInfo( $title ) {
		$mediaService = new MediaQueryService();
		$mediaInfo = $mediaService->getMediaData( $title );
		if ( !empty( $mediaInfo ) ) {
			if ( $mediaInfo[ 'type' ] === 'video' ) {
				$type = 'video';
				$provider = $mediaInfo [ 'meta' ][ 'provider' ];
				$thumbUrl = $mediaInfo [ 'thumbUrl' ];
				$videoId = $mediaInfo[ 'meta' ][ 'videoId' ];
				return [ $type, [
					'provider' => $provider,
					'thumb_url' => $thumbUrl,
					'videoId' => $videoId
				]
				];
			}
		}
		return [ null, null ];
	}

	public static function findImageIfNotSet( $imageId, $articleId = 0 ) {
		$imageTitle = null;
		if ( $imageId == 0 ) {
			$imageId = null;
			$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
		} else {
			$imageTitle = Title::newFromID( $imageId );
		}
		if ( !empty( $imageTitle ) ) {
			$url = self::getUrlFromImageTitle( $imageTitle );
			$imageId = $imageTitle->getArticleId();
		}

		return [ $imageId, $url ];
	}

	public static function findFirstImageTitleFromArticle( $articleId ) {
		$imageTitle = null;
		if ( !empty( $articleId ) ) {
			$is = new ImageServing( [ $articleId ] );
			$image = $is->getImages( 1 );
			if ( !empty( $image ) ) {
				$image_title_name = $image[ $articleId ][ 0 ][ 'name' ];
				if ( !empty( $image_title_name ) ) {
					$imageTitle = Title::newFromText( $image_title_name, NS_FILE );
				}
			}
		}
		return $imageTitle;
	}

	public static function getUrlFromImageTitle( $imageTitle ) {
		$imageUrl = null;
		if ( !empty( $imageTitle ) ) {
			$imageFile = wfFindFile( $imageTitle );
			if ( !empty( $imageFile ) ) {
				$imageUrl = $imageFile->getUrl();
			}
		}
		return $imageUrl;
	}

	/**
	 * @param $info
	 * @return bool
	 */
	private function isSupportedProviders( $info ) {
		$test = $info[ 'provider' ] !== 'youtube' && !startsWith( $info[ 'provider' ], 'ooyala' );
		return $test;
	}

	private function needsArticleId( $type ) {
		return $type != self::STR_CATEGORY;
	}
}
