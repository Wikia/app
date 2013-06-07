<?php

/**
 * LicensedVideoSwap
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapSpecialController extends WikiaSpecialPageController {

	const VIDEOS_PER_PAGE = 10;
	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	const POSTED_IN_ARTICLES = 100;

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

		// Setup messages for JS
		// TODO: once 'back to roots' branch is merged, use JSMessages::enqueuePackage
		F::build('JSMessages')->enqueuePackage('LVS', JSMessages::EXTERNAL);

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

		// Reuse code from VideoHandlerHelper
		$helper = new VideoHandlerHelper();

		// Go through each video and add additional detail needed to display the video
		$videos = array();
		foreach ( $videoList as $videoInfo ) {
//			$readableTitle = preg_replace('/_/', ' ', $videoInfo['title']);
//			$this->getVideoSuggestions($readableTitle);

			$videoDetail = $helper->getVideoDetail( $videoInfo, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, self::POSTED_IN_ARTICLES );
			if ( !empty($videoDetail) ) {
				$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );

				$videoDetail['videoPlayButton'] = $playButton;
				$videoDetail['videoOverlay'] = $videoOverlay;

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
	public function getVideoSuggestions( $title = '' ) {
		$videoTitle = $this->getVal( 'videoTitle', $title );

		$app = F::App();
		$videos = $app->sendRequest('WikiaSearchController',
									'searchVideosByTitle',
									array('title' => $videoTitle))
					  ->getData();

		// The first video in the array is the top choice.
		$this->videos = $videos;
	}

	/**
	 * swap video
	 * @requestParam string videoTitle
	 * @requestParam string newTitle
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array|null video
	 */
	public function swapVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );
		$newTitle = $this->request->getVal( 'newTitle', '' );

		// validate action
		$response = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $response->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $msg;
		}

		$helper = new LicensedVideoSwapHelper();
		$file = $helper->getVideoFile( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// check if the file is premium
		if ( !$file->isLocal() ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'lvs-error-permission' )->text();
			return;
		}

		// check if the new file exists
		$params = array(
			'controller' => 'VideoHandlerController',
			'method' => 'fileExists',
			'fileTitle' => $newTitle,
		);

		$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
		if ( empty( $response['fileExists'] ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		if ( $videoTitle == $newTitle ) {
			// remove local video
			$response = $this->sendRequest( 'VideoHandlerController', 'removeVideo', array( 'title' => $file->getName() ) );
			$result = $response->getVal( 'result', '' );
			if ( $result != 'ok' ) {
				$this->video = null;
				$this->result = 'error';
				$this->msg = $response->getVal( 'msg', '' );
				return;
			}

			// set swap status
			$helper->setSwapExactStatus( $file->getTitle()->getArticleID() );

			// force to get new file
			$newFile = $helper->getVideoFile( $newTitle, true );

			// add premium video
			wfRunHooks( 'AddPremiumVideo', array( $newFile->getTitle() ) );
		} else {
			$newFile = $helper->getVideoFile( $newTitle );

			// check if new file exists
			if ( empty( $newFile ) ) {
				$this->video = null;
				$this->result = 'error';
				$this->msg = $this->wf->Message( 'videohandler-error-video-no-exist' )->text();
				return;
			}
		}

		// TODO: send request for tracking
		$video = array();
		$this->video = $video;
		$this->result = 'ok';
		$this->msg = $this->wf->Message( 'lvs-swap-video-success' )->text();
	}

	/**
	 * skip video
	 * @requestParam string videoTitle
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array|null video
	 */
	public function skipVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );

		// validate action
		$response = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $response->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $msg;
		}

		$helper = new LicensedVideoSwapHelper();
		$file = $helper->getVideoFile( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// set the status of this file page to skipped
		$articleId = $file->getTitle()->getArticleID();
		$this->wf->SetWikiaPageProp( WPP_LVS_STATUS, $articleId, LicensedVideoSwapHelper::STATUS_SKIP );

		$video = array();
		$this->video = $video;
		$this->result = 'ok';
		$this->msg = $this->wf->Message( 'lvs-skip-video-success' )->text();
	}

	/**
	 * restore skipped video
	 * @requestParam string videoTitle
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array|null video
	 */
	public function restoreSkippedVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );

		// validate action
		$response = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $response->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $msg;
		}

		$helper = new LicensedVideoSwapHelper();
		$file = $helper->getVideoFile( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->video = null;
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// delete the status of this file page
		$articleId = $file->getTitle()->getArticleID();
		$this->wf->DeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );

		$video = array();
		$this->video = $video;
		$this->result = 'ok';
		$this->msg = $this->wf->Message( 'lvs-restore-skipped-video-success' )->text();
	}

	/**
	 * validate action
	 * @requestParam string videoTitle
	 * @responseParam string|null msg - error message
	 */
	public function validateAction() {
		$videoTitle = $this->getVal( 'videoTitle', '' );

		// check for logged in user
		if ( !$this->wg->User->isLoggedIn() ) {
			$this->msg = $this->wf->Message( 'videos-error-not-logged-in' )->text();
			return;
		}

		// check for blocked user
		if ( $this->wg->User->isBlocked() ) {
			$this->msg = $this->wf->Message( 'videos-error-blocked-user' )->text();
			return;
		}

		// check for empty title
		if ( empty( $videoTitle ) ) {
			$this->msg = $this->wf->Message( 'videos-error-empty-title' )->text();
			return;
		}

		// check for read only mode
		if ( $this->wf->ReadOnly() ) {
			$this->msg = $this->wf->Message( 'videos-error-readonly' )->text();
			return;
		}

		$this->msg = null;
	}

	// TODO: probably make this use mustache
	public function row() {

	}

}
