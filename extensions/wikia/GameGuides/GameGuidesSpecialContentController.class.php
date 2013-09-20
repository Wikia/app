<?php

class GameGuidesSpecialContentController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'GameGuidesContent', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'gameguidescontent' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = wfMsg( 'wikiagameguides-content-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules([
			'jquery.autocomplete',
			'jquery.ui.sortable',
			'wikia.yui',
			'wikia.aim'
		]);

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getURL([
			'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss',
			'extensions/wikia/WikiaMiniUpload/css/WMU.scss'
		]);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL([
			'/extensions/wikia/GameGuides/js/GameGuidesContentManagmentTool.js',
			'/extensions/wikia/WikiaMiniUpload/js/WMU.js'
		]);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		JSMessages::enqueuePackage( 'GameGuidesContentMsg', JSMessages::INLINE );

		$this->response->setVal( 'descriptions', [
			wfMsg( 'wikiagameguides-content-description-categories' ),
			wfMsg( 'wikiagameguides-content-description-tag' ),
			wfMsg( 'wikiagameguides-content-description-organize' ),
			wfMsg( 'wikiagameguides-content-description-no-tag' )
		] );

		$this->response->setVal( 'addTag', wfMsg( 'wikiagameguides-content-add-tag' ) );
		$this->response->setVal( 'addCategory', wfMsg( 'wikiagameguides-content-add-category' ) );
		$this->response->setVal( 'save', wfMsg( 'wikiagameguides-content-save' ) );

		$this->response->setVal( 'tag_placeholder', wfMsg( 'wikiagameguides-content-tag' ) );
		$this->response->setVal( 'category_placeholder', wfMsg( 'wikiagameguides-content-category' ) );
		$this->response->setVal( 'name_placeholder', wfMsg( 'wikiagameguides-content-name' ) );


		$categoryTemplate = $this->sendSelfRequest( 'category' )->toString();
		$tagTemplate = $this->sendSelfRequest( 'tag' )->toString();

		$this->wg->Out->addJsConfigVars([
			'categoryTemplate' => $categoryTemplate,
			'tagTemplate' => $tagTemplate
		]);

		$tags = $this->wg->WikiaGameGuidesContent;

		if ( !empty( $tags ) ) {
			$list = '';

			foreach( $tags as $tag ) {
				$list .= $this->sendSelfRequest( 'tag', [
					'value' => $tag['title'],
					'image_id' => $tag['image_id']
				] );

				if ( !empty( $tag['categories'] ) ) {
					foreach( $tag['categories'] as $category ) {
						$list .= $this->sendSelfRequest( 'category', [
							'category_value' => $category['title'],
							'name_value' => !empty( $category['label'] ) ? $category['label'] : '',
							'image_id' => $category['image_id']
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

		$this->response->setVal( 'tag_placeholder', wfMsg( 'wikiagameguides-content-tag' ) );
	}

	public function category() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );
		$category = $this->request->getVal( 'category_value', '' );

		$this->response->setVal( 'category_value', $category );
		$this->response->setVal( 'name_value', $this->request->getVal('name_value'), '' );
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
		$this->response->setVal( 'category_placeholder', wfMsg( 'wikiagameguides-content-category' ) );
		$this->response->setVal( 'name_placeholder', wfMsg( 'wikiagameguides-content-name' ) );
	}

	public function save(){
		if ( !$this->wg->User->isAllowed( 'gameguidescontent' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->setFormat( 'json' );

		$tags = $this->request->getArray( 'tags' );
		$err = [];

		if( !empty( $tags ) ) {
			foreach ( $tags as &$tag ) {

				$tag['image_id'] = (int) $tag['image_id'];

				if( !empty( $tag['categories'] ) ) {

					foreach ( $tag['categories'] as &$cat ) {

						$catTitle = $cat['title'];

						$cat['image_id'] = (int) $cat['image_id'];

						$category = Category::newFromName( $catTitle );
						//check if categories exists
						if ( !( $category instanceof Category ) || $category->getPageCount() === 0 ) {
							$err[] = $catTitle;
						} else if ( empty( $err ) ) {
							$cat['id'] = $category->getTitle()->getArticleID();
						}
					}
				}
			}

			if ( !empty( $err ) ) {
				$this->response->setVal( 'error', $err );
				return true;
			}
		}

		$status = WikiFactory::setVarByName( 'wgWikiaGameGuidesContent', $this->wg->CityId, $tags );
		$this->response->setVal( 'status', $status );

		if ( $status ) {
			wfRunHooks( 'GameGuidesContentSave' );
		}

		return true;
	}

	public function getImage( $id = 0 ){
		$file = $this->request->getVal( 'file' );

		$url = '';

		if( !empty( $file ) ) {
			$img = Title::newFromText( $file );

			if( !empty( $img ) && $img instanceof Title ) {
				$id = $img->getArticleID();
			}
		}

		if( $id != 0 ) {
			$is = new ImageServing( [ $id ] , 50, 50 );
			$thumbnail = $is->getImages( 1 );

			if( !empty( $thumbnail ) ) {
				$url = $thumbnail[$id][0]['url'];
			}
		}

		$this->response->setVal( 'url', $url );
		$this->response->setVal( 'id', $id );

		return $url;
	}

	//This should appear on WikiFeatures list only when GG extension is turned on and be visible only to staff
	static public function onWikiFeatures(){
		$wg = F::app()->wg;

		if ( $wg->User->isAllowed( 'gameguidescontent-switchforadmins' ) ) {
			$wg->append(
				'wgWikiFeatures',
				'wgGameGuidesContentForAdmins',
				'normal'
			);
		}

		return true;
	}
}
