<?php

/**
 * SpecialVideos
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosSpecialController extends WikiaSpecialPageController {

	const VIDEOS_PER_PAGE = 24;
	const VIDEOS_PER_PAGE_MOBILE = 12;

	public function __construct() {
		parent::__construct( 'Videos', '', false );
	}

	public function init() {
		$this->response->addAsset( 'special_videos_css_monobook' );
		$this->response->addAsset( 'special_videos_js' );
		$this->response->addAsset( 'special_videos_css' );
	}

	/**
	 * Videos page
	 * @requestParam string sort [ recent/popular/trend/premium ]
	 * @requestParam integer page - page number
	 * @requestParam string category
	 * @requestParam string msg - GlobalNotification message
	 * @requestParam string msgTitle - for GlobalNotification
	 * @requestParam string provider
	 * @responseParam integer addVideo [0/1]
	 * @responseParam string pagination
	 * @responseParam string sortMsg - selected option (sorting)
	 * @responseParam array sortingOptions - sorting options
	 * @responseParam array videos - list of videos
	 */
	public function index() {
		$this->wg->SupressPageSubtitle = true;

		// enqueue i18n message for javascript
		JSMessages::enqueuePackage( 'SpecialVideos', JSMessages::INLINE );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMsg( 'specialvideos-page-title' ) );
		$this->getContext()->getOutput()->setHTMLTitle( wfMsg( 'specialvideos-html-title' ) );

		// For search engines
		$this->getContext()->getOutput()->setRobotPolicy( "index,follow" );

		$specialVideos = new SpecialVideosHelper();

		// Add meta description tag to HTML source
		$this->getContext()->getOutput()->addMeta( 'description', $specialVideos->getMetaTagDescription() );

		// Sorting/filtering dropdown values
		$sort = $this->request->getVal( 'sort', 'trend' );
		$page = $this->request->getVal( 'page', 1 );
		$category = $this->request->getVal( 'category', '' );
		// Filter on a comma separated list of providers if given.
		$providers = $this->request->getVal( 'provider', '' );

		// Add GlobalNotification message after adding a new video. We can abstract this later if we want to add more types of messages
		$msg = $this->request->getVal( 'msg', '' );

		if ( !empty( $msg ) ) {
			$msgTitle = $this->request->getVal( 'msgTitle', '' );
			$msgTitle = urldecode( $msgTitle );

			NotificationsController::addConfirmation( wfMessage( $msg, $msgTitle )->parse(), NotificationsController::CONFIRMATION_CONFIRM );
		}

		// Variable to display the "add video" link at the end of the results
		$addVideo = 1;

		// get videos
		$params = [
			'sort' => $sort,
			'page' => $page,
			'category' => $category,
			'provider' => $providers,
		];
		$response = $this->sendSelfRequest( 'getVideos', $params );
		$videos = $response->getVal( 'videos', [] );

		// get total videos
		$mediaService = new MediaQueryService();
		if ( $sort == 'premium' ) {
			$totalVideos = $mediaService->getTotalPremiumVideos();
		} elseif ( $category ) {
			$totalVideos = $mediaService->getTotalVideosByCategory( $category );
		} else {
			$totalVideos = $mediaService->getTotalVideos();
		}
		$totalVideos = $totalVideos + 1; // adding 'add video' placeholder to video array count

		// get sorting options
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$sortingOptions = $specialVideos->getSortOptionsMobile();
		} else {
			$sortingOptions = array_merge( $specialVideos->getSortOptions(), $specialVideos->getFilterOptions() );
		}

		if ( !array_key_exists( $sort, $sortingOptions ) ) {
			$sort = 'recent';
		}

		// Set up pagination
		$pagination = '';
		$linkToSpecialPage = SpecialPage::getTitleFor("Videos")->escapeLocalUrl();
		if ( $totalVideos > self::VIDEOS_PER_PAGE ) {
			$pages = Paginator::newFromArray( array_fill( 0, $totalVideos, '' ), self::VIDEOS_PER_PAGE );
			$pages->setActivePage( $page - 1 );

			$categoryPagination = $category ? "&category=$category" : "";
			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?page=%s&sort='.$sort.$categoryPagination );
			// check if we're on the last page
			if ( $page < $pages->getPagesCount() ) {
				// we're not so don't show the add video placeholder
				$addVideo = 0;
			}
		}

		// The new trending in <category> options have a slightly different key format
		$sortKey = $sort.( empty($category) ? '' : ":$category" );

		$this->addVideo = $addVideo;
		$this->pagination = $pagination;
		$this->sortMsg = $sortingOptions[$sortKey]; // selected sorting option to display in drop down
		$this->sortingOptions = $sortingOptions; // populate the drop down
		$this->videos = $videos;

		// permission checking for video removal
		$this->isRemovalAllowed = ( $this->wg->User->isAllowed( 'specialvideosdelete' ) && $this->app->checkSkin( 'oasis' ) );

		/*
		 * Check to see if user is part of videoupload
		 * For the purpose of hiding the appropriate UI elements
		 * Current elements affected: last page of results in Special:Videos
		 */
		$this->showAddVideoBtn = $this->wg->User->isAllowed( 'videoupload' );
	}

	/**
	 * Get videos
	 * @requestParam string sort [ recent/popular/trend/premium ]
	 * @requestParam integer page - page number
	 * @requestParam string category
	 * @requestParam string provider
	 * @responseParam array videos - list of videos
	 */
	public function getVideos() {
		$sort = $this->request->getVal( 'sort', 'trend' );
		$page = $this->request->getVal( 'page', 1 );
		$category = $this->request->getVal( 'category', '' );
		$providers = $this->request->getVal( 'provider', '' );

		if ( !is_numeric( $page ) ) {
			$page = 1;
		}

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$limit = self::VIDEOS_PER_PAGE_MOBILE;
			$providers = $this->wg->WikiaMobileSupportedVideos;
		} else {
			$limit = self::VIDEOS_PER_PAGE;
			$providers = empty( $providers ) ? [] : explode( ',', $providers );
		}

		$specialVideos = new SpecialVideosHelper();
		$videos = $specialVideos->getVideos( $sort, $limit, $page, $providers, $category );

		$this->videos = $videos;
	}

}

