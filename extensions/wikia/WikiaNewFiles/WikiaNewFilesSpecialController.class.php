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

	/**
	 * If $wgAllowSpecialImagesInRobots is set, make the page discoverable by robots and cached.
	 * If not set, the regular policy applies: page is not cached and disallowed for robots.
	 * Logged in users should see the page non-cached.
	 */
	private function setupCachingAndRobots() {
		global $wgAllowSpecialImagesInRobots, $wgUser;

		if ( !empty( $wgAllowSpecialImagesInRobots ) ) {
			if ( !empty( $wgUser ) && !$wgUser->isLoggedIn() ) {
				$this->getContext()->getOutput()->setRobotPolicy( 'index,follow' );
				$this->setVarnishCacheTime( WikiaResponse::CACHE_VERY_SHORT );
			}
		}
	}

	public function index() {
		$this->setHeaders();
		$this->setupCachingAndRobots();

		$output = $this->getContext()->getOutput();
		$request = $this->getRequest();

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
		$url = $this->specialPage->getFullTitle()->getFullURL();
		$paginator = new Paginator( $imageCount, self::DEFAULT_LIMIT, $url );
		$paginator->setActivePage( $pageNumber );
		$output->addHeadItem( 'Paginator', $paginator->getHeadItem() );

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
			'pagination' => $paginator->getBarHTML(),
		] );
	}
}
