<?php

/**
 * SpecialVideos
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Videos', '', false );
	}

	public function init() {
		$this->response->addAsset('special_videos_css_monobook');
		$this->response->addAsset('special_videos_js');
		$this->response->addAsset('special_videos_css');
	}

	/**
	 * Videos page
	 * @requestParam string sort [ recent/popular/trend/premium ]
	 * @requestParam integer page - page number
	 * @responseParam integer addVideo [0/1]
	 * @responseParam string pagination
	 * @responseParam string sortMsg - selected option (sorting)
	 * @responseParam array sortingOptions - sorting options
	 * @responseParam array videos - list of videos
	 */
	public function index() {
		$this->wg->SupressPageSubtitle = true;

		// enqueue i18n message for javascript
		JSMessages::enqueuePackage('SpecialVideos', JSMessages::INLINE);

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMsg('specialvideos-page-title') );
		$this->getContext()->getOutput()->setHTMLTitle( wfMsg('specialvideos-html-title') );

		// For search engines
		$this->getContext()->getOutput()->setRobotPolicy( "index,follow" );

		// Add meta description tag to HTML source
		$catInfo = HubService::getComscoreCategory($this->wg->CityId);

		$descriptionKey = 'specialvideos-meta-description';

		switch ( $catInfo->cat_id ) {
			case WikiFactoryHub::CATEGORY_ID_GAMING:
				$descriptionKey .= '-gaming';
				break;
			case WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT:
				$descriptionKey .= '-entertainment';
				break;
			case WikiFactoryHub::CATEGORY_ID_LIFESTYLE:
				$descriptionKey .= '-lifestyle';
				break;
			case WikiFactoryHub::CATEGORY_ID_CORPORATE:
				$descriptionKey .= '-corporate';
				break;
		}

		$this->getContext()->getOutput()->addMeta( 'description', wfMsg($descriptionKey, $this->wg->Sitename) );

		// Sorting/filtering dropdown values
		$sort = $this->request->getVal( 'sort', 'trend' );
		$page = $this->request->getVal( 'page', 1 );

		// Add GlobalNotification message after adding a new video. We can abstract this later if we want to add more types of messages
		$msg = $this->request->getVal( 'msg', '');

		if ( !empty( $msg ) ) {
			$msgTitle = $this->request->getVal( 'msgTitle', '');
			$msgTitle = urldecode($msgTitle);

			NotificationsController::addConfirmation( wfMessage( $msg, $msgTitle )->parse(), NotificationsController::CONFIRMATION_CONFIRM );
		}

		if ( !is_numeric($page) ) {
			$page = 1;
		}

		// Variable to display the "add video" link at the end of the results
		$addVideo = 1;

		// Filter on a comma separated list of providers if given.
		$providers = $this->request->getVal('provider', '');
		// Turn this into an array of providers if this parameters is set
		$providers = $providers ? explode(',', $providers) : null;

		$specialVideos = new SpecialVideosHelper();
		$videos = $specialVideos->getVideos( $sort, $page, $providers );

		$mediaService = new MediaQueryService();
		if ( $sort == 'premium' ) {
			$totalVideos = $mediaService->getTotalPremiumVideos();
		} else {
			$totalVideos = $mediaService->getTotalVideos();
		}
		$totalVideos = $totalVideos + 1; // adding 'add video' placeholder to video array count

		$videoHelper = new VideoHandlerHelper();
		$sortingOptions = array_merge( $videoHelper->getSortOptions(), $specialVideos->getFilterOptions() );
		if ( !array_key_exists( $sort, $sortingOptions ) ) {
			$sort = 'recent';
		}

		// Set up pagination
		$pagination = '';
		$linkToSpecialPage = SpecialPage::getTitleFor("Videos")->escapeLocalUrl();
		if ( $totalVideos > SpecialVideosHelper::VIDEOS_PER_PAGE ) {
			$pages = Paginator::newFromArray( array_fill( 0, $totalVideos, '' ), SpecialVideosHelper::VIDEOS_PER_PAGE );
			$pages->setActivePage( $page - 1 );

			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?page=%s&sort='.$sort );
			// check if we're on the last page
			if ( $page < $pages->getPagesCount() ) {
				// we're not so don't show the add video placeholder
				$addVideo = 0;
			}
		}

		foreach ( $videos as &$video ) {
			$video['byUserMsg'] = $specialVideos->getByUserMsg( $video['userName'], $video['userUrl'] );
			$video['postedInMsg'] = $specialVideos->getPostedInMsg( $video['truncatedList'], $video['isTruncated'] );
			$video['videoOverlay'] = WikiaFileHelper::videoInfoOverlay( SpecialVideosHelper::THUMBNAIL_WIDTH, $video['fileTitle'] );
			$video['videoPlayButton'] = WikiaFileHelper::videoPlayButtonOverlay( SpecialVideosHelper::THUMBNAIL_WIDTH, SpecialVideosHelper::THUMBNAIL_HEIGHT );
		}

		$this->thumbHeight = SpecialVideosHelper::THUMBNAIL_HEIGHT;
		$this->thumbWidth = SpecialVideosHelper::THUMBNAIL_WIDTH;
		$this->addVideo = $addVideo;
		$this->pagination = $pagination;
		$this->sortMsg = $sortingOptions[$sort]; // selected sorting option to display in drop down
		$this->sortingOptions = $sortingOptions; // populate the drop down
		$this->videos = $videos;

		// permission checking for video removal
		$this->isRemovalAllowed = ( $this->wg->User->isAllowed( 'specialvideosdelete' ) && $this->app->checkSkin( 'oasis' ) );

		/*
		 * Check to see if user is part of videoupload
		 * For the purpose of hiding the appropriate UI elements
		 * Current elements affected: last page of results in Special:Videos
		 */

		$this->showAddVideoBtn = $this->wg->User->isAllowed('videoupload');
	}
}

