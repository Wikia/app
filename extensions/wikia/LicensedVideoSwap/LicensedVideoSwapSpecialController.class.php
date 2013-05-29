<?php

/**
 * LicensedVideoSwap
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapSpecialController extends WikiaSpecialPageController {

	const VIDEOS_PER_PAGE = 10;
	const THUMBNAIL_WIDTH = 330;
	const THUMBNAIL_HEIGHT = 211;

	public function __construct() {
		parent::__construct( 'LicensedVideoSwap', '', false );
	}

	public function init() {
		$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/css/ContentHeaderSort.scss' );
		$this->response->addAsset( 'extensions/wikia/LicensedVideoSwap/css/LicensedVideoSwap.scss' );
		$this->response->addAsset( 'extensions/wikia/LicensedVideoSwap/js/LicensedVideoSwap.js' );
		$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/css/Dropdown.scss' );
		$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/js/Dropdown.js' );

	}

	/**
	 * LicensedVideoSwap page
	 *
	 * @requestParam string selectedSort [recent/popular/trend]
	 * @requestParam integer currentPage
	 * @responseParam string selectedSort
	 * @responseParam array sortOptions
	 * @responseParam integer currentPage
	 * @responseParam integer pages
	 * @responseParam array videoList
	 */
	public function index() {

		// update h1 text
		$this->getContext()->getOutput()->setPageTitle( $this->wf->Msg('lvs-page-title') );

		$selectedSort = $this->getVal( 'selectedSort', 'recent' );
		$currentPage = $this->getVal( 'currentPage', 1 );

		// list of videos
		$videoList = $this->getRegularVideoList( $selectedSort, $currentPage );
		$this->videoList = $videoList;
		$this->thumbWidth = self::THUMBNAIL_WIDTH;
		$this->thumbHeight = self::THUMBNAIL_HEIGHT;

		// pagination
		$this->currentPage = $currentPage;
		$this->pages = 10;

		// sort options
		$videoHelper = new LicensedVideoSwapHelper();
		$this->contentHeaderSortOptions = array(
			'label' =>  wfMessage('specialvideos-sort-by')->text(), // TODO: abstract this message
			'selectedSort' => $selectedSort,
			'sortOptions' => $videoHelper->getSortOption( $selectedSort ),
			'sortMsg' => $this->wf->Message( 'specialvideos-sort-latest' ), // TODO - get this dynamically
			'containerId' => 'sorting-dropdown',
		);
	}

	/**
	 * Get a list of non-premium video that is available to swap
	 *
	 * @param string $sort - The sort order for the video list (options: recent, popular, trend)
	 * @param int $page - Which page to display. Each page contains self::VIDEOS_PER_PAGE videos
	 * @return array - Returns a list of video metadata
	 */
	private function getRegularVideoList ( $sort, $page ) {
		wfProfileIn( __METHOD__ );

		// Get the play button image to overlay on the video
		$playButton = WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );

		// Get the list of videos that haven't been swapped yet
		$videoHelper = new LicensedVideoSwapHelper();
		$videoList = $videoHelper->getUnswappedVideoList( $sort, self::VIDEOS_PER_PAGE, $page );

		// Reuse code from SpecialVideosHelper
		$helper = new SpecialVideosHelper();

		// Go through each video and add additional detail needed to display the video
		$videos = array();
		foreach ( $videoList as $videoInfo ) {
			$videoDetail = $helper->getVideoDetail( $videoInfo );
			if ( !empty($videoDetail) ) {
				$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );
				$byUserMsg = $helper->getByUserMsg( $videoDetail['userName'], $videoDetail['userUrl'] );
				$postedInMsg = $helper->getPostedInMsg( $videoDetail['truncatedList'], $videoDetail['isTruncated'] );

				$videoDetail['videoPlayButton'] = $playButton;
				$videoDetail['videoOverlay'] = $videoOverlay;
				$videoDetail['byUserMsg'] = $byUserMsg;
				$videoDetail['postedInMsg'] = $postedInMsg;

				$videos[] = $videoDetail;
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * get video suggestions
	 * @requestParam string videoTitle
	 * @responseParam array videos
	 */
	public function getVideoSuggestions() {
		$videoTitle = $this->getVal( 'videoTitle', '' );

		// the first video in the array will be the top choice one.
		$videos = array();
		$this->videos = $videos;
	}

	/**
	 * swap video
	 * @requestParam string videoTitle
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array|null video
	 */
	public function swapVideo() {
		$videoTitle = $this->getVal( 'videoTitle', '' );

		if ( !$this->wg->User->isLoggedIn() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Msg( 'videos-error-not-logged-in' );
			return;
		}

		if ( $this->wg->User->isBlocked() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Msg( 'videos-error-blocked-user' );
			return;
		}

		$video = null;
		$result = 'error';
		$msg = $this->wf->Message( 'videohandler-error-video-no-exist' );

		$title = Title::newFromText( $videoTitle,  NS_FILE );
		if ( $title instanceof Title ) {
			$file = $this->wf->FindFile( $title );
			if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$video = array();
			}
		}

		$this->video = $video;
		$this->result = $result;
		$this->msg = $msg;
	}

	/**
	 * keep video
	 * @requestParam string videoTitle
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array|null video
	 */
	public function keepVideo() {
	}

}