<?php

class CuratedContentSpecialController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	const ARTICLE_ID_TAG = 'article_id';

	const ITEMS_TAG = 'items';

	const STR_ARTICLE = 'article';

	const STR_BLOG = 'blog';

	const STR_FILE = 'file';

	const ITEM_FUNCTION_NAME = 'item';

	public function __construct() {
		parent::__construct( 'CuratedContent', '', false );
	}

	public function index() {
		if ( !$this->wg->User->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = wfMsg( 'wikiaCuratedContent-content-title' );
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
			wfMsg( 'wikiaCuratedContent-content-description-items' ),
			wfMsg( 'wikiaCuratedContent-content-description-section' ),
			wfMsg( 'wikiaCuratedContent-content-description-organize' ),
			wfMsg( 'wikiaCuratedContent-content-description-no-tag' )
		] );

		$this->response->setVal( 'addSection', wfMsg( 'wikiaCuratedContent-content-add-section' ) );
		$this->response->setVal( 'addItem', wfMsg( 'wikiaCuratedContent-content-add-item' ) );
		$this->response->setVal( 'save', wfMsg( 'wikiaCuratedContent-content-save' ) );

		$this->response->setVal( 'section_placeholder', wfMsg( 'wikiaCuratedContent-content-section' ) );
		$this->response->setVal( 'item_placeholder', wfMsg( 'wikiaCuratedContent-content-item' ) );
		$this->response->setVal( 'name_placeholder', wfMsg( 'wikiaCuratedContent-content-name' ) );

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
				$list .= $this->sendSelfRequest( 'section', [
					'value' => $section[ 'title' ],
					'image_id' => $section[ 'image_id' ]
				] );

				if ( !empty( $section[ self::ITEMS_TAG ] ) ) {
					foreach ( $section[ self::ITEMS_TAG ] as $item ) {
						$list .= $this->sendSelfRequest( self::ITEM_FUNCTION_NAME, [
							'item_value' => $item[ 'title' ],
							'name_value' => !empty( $item[ 'label' ] ) ? $item[ 'label' ] : '',
							'image_id' => $item[ 'image_id' ]
						] );
					}
				}
			}

			$this->response->setVal( 'list', $list );
		} else {
			$this->response->setVal( 'section', $sectionTemplate );
			$this->response->setVal( 'item', $itemTemplate );
		}

		return true;
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

		$this->response->setVal( 'section_placeholder', wfMsg( 'wikiaCuratedContent-content-section' ) );
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
		$this->response->setVal( 'item_placeholder', wfMsg( 'wikiaCuratedContent-content-item' ) );
		$this->response->setVal( 'name_placeholder', wfMsg( 'wikiaCuratedContent-content-name' ) );
	}

	public function save() {
		if ( !$this->wg->User->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}
		$this->response->setFormat( 'json' );

		$sections = $this->request->getArray( 'sections' );
		$err = $this->saveLogic( $sections );

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

	//This should appear on WikiFeatures list only when extension is turned on and be visible only to staff
	static public function onWikiFeatures() {
		$wg = F::app()->wg;

		if ( $wg->User->isAllowed( 'curatedcontent-switchforadmins' ) ) {
			$wg->append(
				'wgWikiFeatures',
				'wgCuratedContentForAdmins',
				'normal'
			);
		}

		return true;
	}

	/**
	 * @param $sections
	 * @return array
	 */
	private function saveLogic( &$sections ) {
		$err = [ ];
		if ( !empty( $sections ) ) {
			foreach ( $sections as &$section ) {
				$section[ 'image_id' ] = (int)$section[ 'image_id' ];
				if ( !empty( $section[ self::ITEMS_TAG ] ) ) {
					foreach ( $section[ self::ITEMS_TAG ] as &$row ) {
						list( $articleId,
							$namespaceId,
							$type,
							$info,
							$imageId ) = $this->getInfoFromRow(
							$row );
						$row[ 'article_id' ] = $articleId;
						$row[ 'type' ] = $type;
//						$row[ 'image_url' ] = $imageUrl;
						$row[ 'image_id' ] = $imageId;
						if ( !empty( $info ) ) {
							$row[ 'video_info' ] = $info;
						}
					}
				}
			}
		}
		return $err;
	}


	private function getInfoFromRow( &$row ) {
		$title = Title::newFromText( $row[ 'title' ] );
		if ( !empty( $title ) ) {

			$articleId = $title->getArticleId();
			$namespaceId = $title->getNamespace();
			$type = $this->getType( $namespaceId );
			$image_id = (int)$row[ 'image_id' ];
			$info = [ ];

			if ( $type == self::STR_FILE ) {
				list( $type, $info ) = $this->getVideoInfo( $title );
			}
			if ( $image_id == 0 ) {
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

	private
	function getType( $namespaceId ) {
		switch ( $namespaceId ) {
			case NS_MAIN:
				return self::STR_ARTICLE;
				break;
			case 500:
				return self::STR_BLOG;
				break;
			case NS_CATEGORY:
				return self::ITEM_FUNCTION_NAME;
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
					'videoId' => $videoId ]
				];
			}
		}
		return [ null, null ];
	}

	public static function findImageIfNotSet( $imageId, $articleId ) {
		$imageTitle = null;
		if ( $imageId == 0 ) {
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
}
