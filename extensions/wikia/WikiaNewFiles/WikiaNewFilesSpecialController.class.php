<?php

/**
 * @ingroup SpecialPage
 */
class WikiaNewFilesSpecialController extends WikiaSpecialPageController {
	const DEFAULT_LIMIT = 48;
	const PAGE_PARAM = 'page';

	public function __construct() {
		parent::__construct( 'Newimages', '', false );
	}

	public function index() {
		$this->setHeaders();
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'wikianewfiles-title' ) );
		$this->wg->SupressPageSubtitle = true;

		$request = $this->getRequest();

		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );

		$pageNumber = $request->getInt( self::PAGE_PARAM );
		$pageNumber = max( $pageNumber, 1 );

		// Fetch data from DB
		$newFilesModel = new WikiaNewFilesModel();
		$images = $newFilesModel->getImagesPage( self::DEFAULT_LIMIT, $pageNumber );
		$imageCount = $newFilesModel->getImageCount();

		// Pagination
		$paginatorUrl = '?page=%s';
		$paginator = Paginator::newFromArray( $imageCount, self::DEFAULT_LIMIT );
		$paginator->setActivePage( $pageNumber - 1 );
		$this->getOutput()->addHeadItem( 'Paginator', $paginator->getHeadItem( $paginatorUrl ) );

		// Hook for ContentFeeds::specialNewImagesHook
		wfRunHooks( 'SpecialNewImages::beforeDisplay', array( $images ) );

		// Construct gallery
		$gallery = new WikiaNewFilesGallery( $this->specialPage->getSkin() );
		$gallery->addImages( $images );

		// View
		$this->setVal( 'gallery', $gallery );
		$this->setVal( 'showUi', !$this->including() );
		$this->setVal( 'noImages', !$imageCount );
		$this->setVal( 'emptyPage', count( $images ) === 0 );
		$this->setVal( 'pagination', $paginator->getBarHTML( $paginatorUrl ) );
	}
}
