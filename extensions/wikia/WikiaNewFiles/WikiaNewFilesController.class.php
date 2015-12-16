<?php

/**
 * @ingroup SpecialPage
 */
class WikiaNewFilesController extends WikiaSpecialPageController {
	const DEFAULT_LIMIT = 48;
	const PAGE_PARAM = 'page';

	public function __construct() {
		parent::__construct( 'Newimages', '', true, false, 'default', true /* includable */ );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return $this->msg( 'wikianewfiles-title' )->text();
	}

//	private function getPaginatorUrl( $limit, $pageArgs ) {
//		if ( $limit === self::DEFAULT_LIMIT ) {
//			$par = false;
//		} else {
//			$par = $limit;
//		}
//
//		unset( $pageArgs[self::PAGE_PARAM] );
//
//		$url = $this->specialPage->getTitle( $par )->getLocalURL( http_build_query( $pageArgs ) );
//		$separator = ( strpos( $url, '?' ) === false ) ? '?' : '&';
//
//		return $url . $separator . self::PAGE_PARAM . '=%s';
//	}

	public function index() {
		$request = $this->getRequest();

		$this->setHeaders();

		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );

		// The param to the special page is overriding the default limit of 48 images per page
		// We don't allow it to be more than the default limit though
		$par = $request->getInt( self::PAR );
		if ( $par > 0 ) {
			$limit = min( $par, self::DEFAULT_LIMIT );
		} else {
			$limit = self::DEFAULT_LIMIT;
		}

		$pageNumber = $request->getInt( self::PAGE_PARAM );
		$pageNumber = max( $pageNumber, 1 );

		// Parse request vars
//		$pageArgs = [];
//		$hidebots = $request->getBool( 'hidebots', true );
//		if ( $hidebots === false ) {
//			$pageArgs['hidebots'] = 0;
//		}
//		$paginatorUrl = $this->getPaginatorUrl( $limit, $pageArgs );

		$paginatorUrl = '?page=%s';

		// Fetch data from DB
		$newFilesModel = new WikiaNewFilesModel( /*$hidebots*/ );
		$images = $newFilesModel->getImagesPage( $limit, $pageNumber );
		$imageCount = $newFilesModel->getImageCount();

		// Pagination
		$paginator = Paginator::newFromArray( $imageCount, $limit );
		$paginator->setActivePage( $pageNumber - 1 );
		$this->wg->Out->addHeadItem( 'Paginator', $paginator->getHeadItem( $paginatorUrl ) );

		// Hook for ContentFeeds::specialNewImagesHook
		wfRunHooks( 'SpecialNewImages::beforeDisplay', array( $images ) );

		// Construct gallery
		$gallery = new WikiaNewFilesGallery( $newFilesModel, $this->specialPage->getSkin() );
		$gallery->addImages( $images );

		// View
		$this->setVal( 'gallery', $gallery );
		$this->setVal( 'showUi', !$this->including() );
		$this->setVal( 'noImages', !$imageCount );
		$this->setVal( 'emptyPage', count( $images ) === 0 );
		$this->setVal( 'pagination', $paginator->getBarHTML( $paginatorUrl ) );
	}
}
