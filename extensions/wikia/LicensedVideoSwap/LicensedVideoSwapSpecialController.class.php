<?php

/**
 * LicensedVideoSwap
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LicensedVideoSwap', '', false );
	}

	public function init() {
		$this->response->addAsset( 'extensions/wikia/LicensedVideoSwap/js/LicensedVideoSwap.js' );
	}

	/**
	 * LicensedVideoSwap page
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
		$videoList = array();
		$this->videoList = $videoList;

		// pagination
		$this->currentPage = $currentPage;
		$this->pages = 10;

		// sort options
		$this->selectedSort = $selectedSort;
		$videoHelper = new LicensedVideoSwapHelper();
		$this->sortOptions = $videoHelper->getSortOption();
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