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

		$this->getContext()->getOutput()->setPageTitle( $this->wf->Msg('specialvideos-page-title') );
		$this->getContext()->getOutput()->setHTMLTitle( $this->wf->Msg('specialvideos-html-title') );

		$this->getContext()->getOutput()->setRobotPolicy( "index,follow" );

		$sort = $this->request->getVal( 'sort', 'recent' );
		$page = $this->request->getVal( 'page', 1 );

		if ( !is_numeric($page) ) {
			$page = 1;
		}

		$addVideo = 1;

		$specialVideos = F::build( 'SpecialVideosHelper' );
		$videos = $specialVideos->getVideos( $sort, $page );

		$mediaService = F::build( 'MediaQueryService' );
		if ( $sort == 'premium' ) {
			$totalVideos = $mediaService->getTotalPremiumVideos();
		} else {
			$totalVideos = $mediaService->getTotalVideos();
		}
		$totalVideos = $totalVideos + 1; // plus one for 'add video' placeholder

		$sortingOptions = array_merge( $specialVideos->getSortingOptions(), $specialVideos->getFilterOptions() );

		// Set up pagination
		$pagination = '';
		$linkToSpecialPage = SpecialPage::getTitleFor("Videos")->escapeLocalUrl();
		if( $totalVideos > SpecialVideosHelper::VIDEOS_PER_PAGE ) {
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
			$video['videoOverlay'] = F::build( 'WikiaFileHelper', array( SpecialVideosHelper::THUMBNAIL_WIDTH, $video['fileTitle'] ), 'videoInfoOverlay' );
			$video['videoPlayButton'] = F::build( 'WikiaFileHelper', array( SpecialVideosHelper::THUMBNAIL_WIDTH, SpecialVideosHelper::THUMBNAIL_HEIGHT ), 'videoPlayButtonOverlay' );
		}

		$this->addVideo = $addVideo;
		$this->pagination = $pagination;
		$this->sortMsg = $sortingOptions[$sort]; // selected sorting option to display in drop down
		$this->sortingOptions = $sortingOptions; // populate the drop down 
		$this->videos = $videos;
	}

}
