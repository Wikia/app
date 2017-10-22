<?php
use Wikia\Paginator\Paginator;

/**
 * @ingroup SpecialPage
 */
class WikiaNewFilesSpecialController extends WikiaSpecialPageController {
	const DEFAULT_LIMIT = 48;
	const PAGE_PARAM = 'page';

	public function __construct() {
		parent::__construct( 'Images', '', false );
	}

	public function index() {
		$this->setHeaders();

		$output = $this->getContext()->getOutput();
		$request = $this->getRequest();

		$this->wg->SuppressPageSubtitle = true;

		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );

		$pageNumber = $request->getInt( self::PAGE_PARAM );
		$pageNumber = max( $pageNumber, 1 );

		// Fetch data from DB
		$newFilesModel = new WikiaNewFilesModel();
		$images = $newFilesModel->getImagesPage( self::DEFAULT_LIMIT, $pageNumber );
		$imageCount = $newFilesModel->getImageCount();

		// Pagination
		$url = $this->specialPage->getFullTitle()->getFullURL();
		$paginator = new Paginator( $imageCount, self::DEFAULT_LIMIT, $url );
		$paginator->setActivePage( $pageNumber );
		$output->addHeadItem( 'Paginator', $paginator->getHeadItem() );

		// Hook for ContentFeeds::specialNewImagesHook
		Hooks::run( 'SpecialNewImages::beforeDisplay', array( $images ) );

		// Construct gallery
		$gallery = new WikiaNewFilesGallery( $this->specialPage->getSkin() );
		$gallery->addImages( $images );

		// View
		$this->response->setValues( [
			'gallery' => $gallery,
			'noImages' => !$imageCount,
			'emptyPage' => count( $images ) === 0,
			'pagination' => $paginator->getBarHTML(),
		] );
	}
}
