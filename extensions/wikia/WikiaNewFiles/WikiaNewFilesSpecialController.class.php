<?php

/**
 * @ingroup SpecialPage
 */
class WikiaNewFilesSpecialController extends WikiaSpecialPageController {
	const DEFAULT_LIMIT = 48;
	const PAGE_PARAM = 'page';
	const PAGINATOR_URL = '?page=%s';

	public function __construct() {
		parent::__construct( 'Newimages', '', false );
	}

	public function index() {
		$this->setHeaders();

		$output = $this->getContext()->getOutput();
		$request = $this->getRequest();

		$output->setPageTitle( wfMessage( 'wikianewfiles-title' ) );
		$this->wg->SupressPageSubtitle = true;

		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );

		$pageNumber = $request->getInt( self::PAGE_PARAM );
		$pageNumber = max( $pageNumber, 1 );

		// Fetch data from DB
		$newFilesModel = new WikiaNewFilesModel();
		$images = $newFilesModel->getImagesPage( self::DEFAULT_LIMIT, $pageNumber );
		$imageCount = $newFilesModel->getImageCount();

		// Pagination
		$paginator = Paginator::newFromArray( $imageCount, self::DEFAULT_LIMIT );
		$paginator->setActivePage( $pageNumber - 1 );
		$output->addHeadItem( 'Paginator', $paginator->getHeadItem( self::PAGINATOR_URL ) );

		// Hook for ContentFeeds::specialNewImagesHook
		wfRunHooks( 'SpecialNewImages::beforeDisplay', array( $images ) );

		// Construct gallery
		$gallery = new WikiaNewFilesGallery( $this->specialPage->getSkin() );
		$gallery->addImages( $images );

		// View
		$this->response->setValues( [
			'gallery' => $gallery,
			'noImages' => !$imageCount,
			'emptyPage' => count( $images ) === 0,
			'pagination' => $paginator->getBarHTML( self::PAGINATOR_URL ),
		] );
	}
}
