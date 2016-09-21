<?php

class CuratedContentSpecialController extends WikiaSpecialPageController {
	private $helper;
	private $communityDataService;

	public function __construct() {
		global $wgCityId;

		$this->helper = new CuratedContentHelper();
		$this->communityDataService = new CommunityDataService( $wgCityId );
		parent::__construct( 'CuratedContent', '', false );
	}

	public function index() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

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
			wfMessage( 'wikiacuratedcontent-content-description-items' )->plain(),
			wfMessage( 'wikiacuratedcontent-content-description-supported-items-for-sections' )->plain(),
			wfMessage( 'wikiacuratedcontent-content-description-tag-needs-image' )->plain(),
			wfMessage( 'wikiacuratedcontent-content-description-section' )->plain(),
			wfMessage( 'wikiacuratedcontent-content-description-organize' )->plain(),
			wfMessage( 'wikiacuratedcontent-content-description-no-section' )->plain(),
			wfMessage( 'wikiacuratedcontent-content-description-items-input' )->text(),
		] );

		$this->response->setVal( 'addSection', wfMessage( 'wikiacuratedcontent-content-add-section' )->plain() );
		$this->response->setVal( 'addItem', wfMessage( 'wikiacuratedcontent-content-add-item' )->plain() );
		$this->response->setVal( 'save', wfMessage( 'wikiacuratedcontent-content-save' )->plain() );

		$this->response->setVal( 'section_placeholder', wfMessage( 'wikiacuratedcontent-content-section' )->plain() );
		$this->response->setVal( 'item_placeholder', wfMessage( 'wikiacuratedcontent-content-item' )->plain() );
		$this->response->setVal( 'name_placeholder', wfMessage( 'wikiacuratedcontent-content-name' )->plain() );

		$itemTemplate = $this->sendSelfRequest( 'item' )->toString();
		$sectionTemplate = $this->sendSelfRequest( 'section' )->toString();


		$this->wg->Out->addJsConfigVars( [
			'itemTemplate' => $itemTemplate,
			'sectionTemplate' => $sectionTemplate
		] );

		if ( $this->communityDataService->hasData() ) {
			$list = '';

			$featuredSection = $this->buildSection( $this->communityDataService->getFeatured() );
			foreach ( $this->communityDataService->getNonFeaturedSections() as $section ) {
				$list .= $this->buildSection( $section );
			}
			if ( !isset( $featuredSection ) ) {
				// add featured section if not yet exists
				$featuredSection = $this->sendSelfRequest( 'featuredSection' );
			}
			// prepend featured section
			$list = $featuredSection . $list;

			$this->response->setVal( 'list', $list );
		} else {
			$this->response->setVal( 'featured', $this->sendSelfRequest( 'featuredSection' ) );
			$this->response->setVal( 'section', $sectionTemplate );
			$this->response->setVal( 'item', $itemTemplate );
		}

		return true;
	}

	public function featuredSection() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$imageId = $this->request->getVal( 'image_id', 0 );
		$imageCrop = $this->request->getArray( 'image_crop', [ ] );

		$this->response->setVal( 'value', wfMessage( 'wikiacuratedcontent-featured-section-name' )->plain() );
		$this->response->setVal( 'image_id', $imageId );
		$this->response->setVal( 'image_crop', $this->helper->encodeCrop( $imageCrop ) );
		$this->response->setVal( 'image_url', CuratedContentHelper::getImageUrl( $imageId ) );
		if ( !empty( $imageId ) ) {
			$this->response->setVal( 'image_set', true );
		}
	}

	public function section() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$imageId = $this->request->getVal( 'image_id', 0 );
		$imageCrop = $this->request->getArray( 'image_crop', [ ] );

		$this->response->setVal( 'value', $this->request->getVal( 'value', '' ) );
		$this->response->setVal( 'image_id', $imageId );
		$this->response->setVal( 'image_crop', $this->helper->encodeCrop( $imageCrop ) );
		$this->response->setVal( 'image_url', CuratedContentHelper::getImageUrl( $imageId ) );
		if ( !empty( $imageId ) ) {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'section_placeholder', wfMessage( 'wikiacuratedcontent-content-section' )->plain() );
	}

	public function item() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$imageId = $this->request->getVal( 'image_id', 0 );
		$imageCrop = $this->request->getArray( 'image_crop', [ ] );
		$item = $this->request->getVal( 'item_value', '' );

		$this->response->setVal( 'item_value', $item );
		$this->response->setVal( 'name_value', $this->request->getVal( 'name_value', '' ) );
		$this->response->setVal( 'image_id', $imageId );


		if ( empty( $imageId ) && !empty( $item ) ) {
			// $imageId is 0 - that means it should be taken from item
			$imageId = CuratedContentHelper::findFirstImageTitleFromArticle( $item );
			$imageCrop = [ ];
		}
		if ( !empty( $imageId ) ) {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'image_url', CuratedContentHelper::getImageUrl( $imageId ) );
		$this->response->setVal( 'image_crop', $this->helper->encodeCrop( $imageCrop ) );
		$this->response->setVal( 'item_placeholder', wfMessage( 'wikiacuratedcontent-content-item' )->plain() );
		$this->response->setVal( 'name_placeholder', wfMessage( 'wikiacuratedcontent-content-name' )->plain() );
	}

	public function save() {
		global $wgCityId, $wgUser;
		if ( !$wgUser->isAllowed( 'curatedcontent' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->setFormat( 'json' );

		$sections = $this->helper->processSectionsFromSpecialPage( $this->request->getArray( 'sections', [ ] ) );
		$errors = ( new CuratedContentSpecialPageValidator )->validateData( $sections );

		if ( !empty( $errors ) ) {
			$this->response->setVal( 'error', $errors );
			$this->response->setVal( 'status', false );
		} else {
			$status = ( new CommunityDataService( $wgCityId ) )->setCuratedContent( $sections );
			$this->response->setVal( 'status', $status );

			if ( !empty( $status ) ) {
				wfRunHooks( 'CuratedContentSave', [ $sections ] );
			}
		}
		return true;
	}

	private function buildSection( $section ) {
		$result = '';
		$sectionTemplate = 'section';
		if ( isset( $section[ 'featured' ] ) && $section[ 'featured' ] ) {
			$sectionTemplate = 'featuredSection';
		}
		$result .= $this->sendSelfRequest( $sectionTemplate, [
			'value' => $section[ 'label' ],
			'image_id' => $section[ 'image_id' ],
			'image_crop' => !empty( $section[ 'image_crop' ] ) ? $section[ 'image_crop' ] : [ ],
		] );
		if ( !empty( $section[ 'items' ] ) ) {
			foreach ( $section[ 'items' ] as $item ) {
				$result .= $this->sendSelfRequest( 'item', [
					'item_value' => $item[ 'title' ],
					'name_value' => !empty( $item[ 'label' ] ) ? $item[ 'label' ] : '',
					'image_id' => $item[ 'image_id' ],
					'image_crop' => !empty( $item[ 'image_crop' ] ) ? $item[ 'image_crop' ] : [ ],
				] );
			}
		}
		return $result;
	}
}
