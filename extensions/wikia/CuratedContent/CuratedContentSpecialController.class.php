<?php

class CuratedContentSpecialController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'CuratedContent', '', false );
	}

	public function index() {
		if ( !$this->wg->User->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
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
			wfMsg( 'wikiaCuratedContent-content-description-categories' ),
			wfMsg( 'wikiaCuratedContent-content-description-tag' ),
			wfMsg( 'wikiaCuratedContent-content-description-organize' ),
			wfMsg( 'wikiaCuratedContent-content-description-no-tag' )
		] );

		$this->response->setVal( 'addTag', wfMsg( 'wikiaCuratedContent-content-add-tag' ) );
		$this->response->setVal( 'addCategory', wfMsg( 'wikiaCuratedContent-content-add-category' ) );
		$this->response->setVal( 'save', wfMsg( 'wikiaCuratedContent-content-save' ) );

		$this->response->setVal( 'tag_placeholder', wfMsg( 'wikiaCuratedContent-content-tag' ) );
		$this->response->setVal( 'category_placeholder', wfMsg( 'wikiaCuratedContent-content-category' ) );
		$this->response->setVal( 'name_placeholder', wfMsg( 'wikiaCuratedContent-content-name' ) );


		$categoryTemplate = $this->sendSelfRequest( 'category' )->toString();
		$tagTemplate = $this->sendSelfRequest( 'tag' )->toString();

		$this->wg->Out->addJsConfigVars( [
			'categoryTemplate' => $categoryTemplate,
			'tagTemplate' => $tagTemplate
		] );

		$tags = $this->wg->WikiaCuratedContent;

		if ( !empty( $tags ) ) {
			$list = '';

			foreach ( $tags as $tag ) {
				$list .= $this->sendSelfRequest( 'tag', [
					'value' => $tag[ 'title' ],
					'image_id' => $tag[ 'image_id' ]
				] );

				if ( !empty( $tag[ 'categories' ] ) ) {
					foreach ( $tag[ 'categories' ] as $category ) {
						$list .= $this->sendSelfRequest( 'category', [
							'category_value' => $category[ 'title' ],
							'name_value' => !empty( $category[ 'label' ] ) ? $category[ 'label' ] : '',
							'image_id' => $category[ 'image_id' ]
						] );
					}
				}
			}

			$this->response->setVal( 'list', $list );
		} else {
			$this->response->setVal( 'tag', $tagTemplate );
			$this->response->setVal( 'category', $categoryTemplate );
		}

		return true;
	}

	public function tag() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );

		$this->response->setVal( 'value', $this->request->getVal( 'value' ), '' );
		$this->response->setVal( 'image_id', $id );
		$this->response->setVal( 'image_url', $this->getImage( $id ) );
		if ( $id != 0 ) {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'tag_placeholder', wfMsg( 'wikiaCuratedContent-content-tag' ) );
	}

	public function category() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );
		$category = $this->request->getVal( 'category_value', '' );

		$this->response->setVal( 'category_value', $category );
		$this->response->setVal( 'name_value', $this->request->getVal( 'name_value' ), '' );
		$this->response->setVal( 'image_id', $id );


		if ( $id == 0 && $category != '' ) {
			$cat = Title::newFromText( $category, NS_CATEGORY );

			if ( $cat instanceof Title ) {
				$id = $cat->getArticleID();
			}
		} else {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'image_url', $this->getImage( $id ) );
		$this->response->setVal( 'category_placeholder', wfMsg( 'wikiaCuratedContent-content-category' ) );
		$this->response->setVal( 'name_placeholder', wfMsg( 'wikiaCuratedContent-content-name' ) );
	}

	public function save() {
		if ( !$this->wg->User->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->setFormat( 'json' );

		$tags = $this->request->getArray( 'tags' );
		$err = [ ];

		if ( !empty( $tags ) ) {
			foreach ( $tags as &$tag ) {

				$tag = $this->parseImageIdToInt( $tag );

				if ( !empty( $tag[ 'categories' ] ) ) {
					foreach ( $tag[ 'categories' ] as &$row ) {
						$row = $this->parseImageIdToInt( $row );
						$type = $this->extractType( $row[ 'title' ] );
						$row[ 'type' ] = $type;
						$title = $this->getTitle( $row, $type );

						switch ( $type ) {
							case 'category':
								$this->getCategoryPageId( $title, $err, $row );
								break;
						}
					}
				}
			}

			if ( !empty( $err ) ) {
				$this->response->setVal( 'error', $err );
				return true;
			}
		}
		$status = WikiFactory::setVarByName( 'wgWikiaCuratedContent', $this->wg->CityId, $tags );
		$this->response->setVal( 'status', $status );

		if ( $status ) {
			wfRunHooks( 'CuratedContentSave' );
		}

		return true;
	}

	public function getImage( $id = 0 ) {
		$file = $this->request->getVal( 'file' );

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

	//This should appear on WikiFeatures list only when GG extension is turned on and be visible only to staff
	static public function onWikiFeatures() {
		$wg = F::app()->wg;

		if ( $wg->User->isAllowed( 'CuratedContent-switchforadmins' ) ) {
			$wg->append(
				'wgWikiFeatures',
				'wgCuratedContentForAdmins',
				'normal'
			);
		}

		return true;
	}

	/**
	 * @param $row
	 * @return mixed
	 */
	public function parseImageIdToInt( $row ) {
		$row[ 'image_id' ] = (int)$row[ 'image_id' ];
		return $row;
	}


	private function extractType( $title ) {
		$type = strtolower( strstr( $title, ':', true ) );
		$validTypes = [ 'category' ];
		if ( in_array( $type, $validTypes ) ) {
			return $type;
		}
		return false;
	}

	/**
	 * @param $title
	 * @param $err
	 * @param $row
	 */
	private function getCategoryPageId( $title, &$err, &$row ) {
		$catTitle = $title;
		$category = Category::newFromName( $catTitle );
		//check if categories exists and have any pages
		if ( !( $category instanceof Category ) || $category->getPageCount() === 0 ) {
			$err[ ] = $catTitle;
		} else if ( empty( $err ) ) {
			$row[ 'id' ] = $category->getTitle()->getArticleID();
		}
	}

	/**
	 * @param $row
	 * @param $type
	 * @return string
	 */
	private function getTitle( $row, $type ) {
		$title = $row[ 'title' ];
		if ( $type ) {
			$title = substr( $row[ 'title' ], strlen( $type ) + 1 );
		};
		return $title;
	}
}
