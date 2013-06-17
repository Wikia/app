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
	const NUM_SUGGESTIONS = 5;

	public function __construct() {
		parent::__construct( 'LicensedVideoSwap', '', false );
	}

	public function init() {
		$this->response->addAsset( 'extensions/wikia/LicensedVideoSwap/css/LicensedVideoSwap.scss' );
		$this->response->addAsset( 'extensions/wikia/LicensedVideoSwap/js/LicensedVideoSwap.js' );
		$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/css/Dropdown.scss' );
		$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/js/Dropdown.js' );
	}

	/**
	 * LicensedVideoSwap page
	 *
	 * @requestParam string sort [recent/popular/trend]
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
		$this->getContext()->getOutput()->setPageTitle( wfMessage('lvs-page-title')->text() );

		$selectedSort = $this->getVal( 'sort', 'recent' );
		$currentPage = $this->getVal( 'currentPage', 1 );

		// list of videos
		$videoList = $this->getRegularVideoList( $selectedSort, $currentPage );
		$this->videoList = $videoList;
		$this->thumbWidth = self::THUMBNAIL_WIDTH;
		$this->thumbHeight = self::THUMBNAIL_HEIGHT;


		// Set up pagination
		$this->currentPage = $currentPage;
		$videoHelper = new LicensedVideoSwapHelper();
		$this->totalVideos = $videoHelper->getUnswappedVideoTotal();

		$pagination = '';
		$linkToSpecialPage = SpecialPage::getTitleFor("LicensedVideoSwap")->escapeLocalUrl();

		if ( $this->totalVideos > self::VIDEOS_PER_PAGE ) {
			$pages = Paginator::newFromArray( array_fill( 0, $this->totalVideos, '' ), self::VIDEOS_PER_PAGE );
			$pages->setActivePage( $this->currentPage - 1 );

			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?currentPage=%s&sort='.$selectedSort );
		}
		$this->pagination = $pagination;

		// sort options
		$videoHelper = new VideoHandlerHelper();
		$options = $videoHelper->getSortOptions();
		$this->contentHeaderSortOptions = array(
			'label' =>  wfMessage('specialvideos-sort-by')->text(), // TODO: abstract this message
			'selectedSort' => $selectedSort,
			'sortOptions' => $videoHelper->getTemplateSelectOptions( $options, $selectedSort ),
			'sortMsg' => $options[$selectedSort],
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
			$readableTitle = preg_replace('/_/', ' ', $videoInfo['title']);
			$suggestions = $this->getVideoSuggestions($readableTitle);

			$videoDetail = $helper->getVideoDetail( $videoInfo, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, self::POSTED_IN_ARTICLES );
			if ( !empty($videoDetail) ) {
				$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );

				$videoDetail['videoPlayButton'] = $playButton;
				$videoDetail['videoOverlay'] = $videoOverlay;
				$videoDetail['videoSuggestions'] = $suggestions;

				$seeMoreLink = SpecialPage::getTitleFor("WhatLinksHere")->escapeLocalUrl();
				$seeMoreLink .= '/' . $this->app->wg->ContLang->getNsText( NS_FILE ). ':' . $videoDetail['title'];

				$videoDetail['seeMoreLink'] = $seeMoreLink;


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
		$videoRows = $app->sendRequest('WikiaSearchController',
									'searchVideosByTitle',
									array('title' => $videoTitle))
						 ->getData();

		// Reuse code from VideoHandlerHelper
		$helper = new VideoHandlerHelper();

		// Get the play button image to overlay on the video
		$playButton = WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );

		$videos = array();
		$count = 0;
		foreach ($videoRows as $videoInfo) {
			$videoDetail = $helper->getVideoDetail( $videoInfo,
													self::THUMBNAIL_WIDTH,
													self::THUMBNAIL_HEIGHT,
													self::POSTED_IN_ARTICLES );
			if ( empty($videoDetail) ) {
				break;
			}

			$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );
			$videoDetail['videoPlayButton'] = $playButton;
			$videoDetail['videoOverlay'] = $videoOverlay;

			$videos[] = $videoDetail;

			$count++;
			if ( $count >= self::NUM_SUGGESTIONS ) {
				break;
			}
		}

		// The first video in the array is the top choice.
		$this->videos = $videos;
		return $videos;
	}

	/**
	 * swap video
	 * @requestParam string videoTitle
	 * @requestParam string newTitle
	 * @requestParam string sort [recent/popular/trend]
	 * @requestParam integer currentPage
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam string html
	 */
	public function swapVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );
		$newTitle = $this->request->getVal( 'newTitle', '' );

		// validate action
		$validAction = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $validAction->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = $msg;
		}

		// check user permission
		if ( !$this->wg->User->isAllowed( 'deletedtext' ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-permission' )->text();
		}

		$helper = new LicensedVideoSwapHelper();
		$file = $helper->getVideoFile( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// check if the file is swapped
		$articleId = $file->getTitle()->getArticleID();
		if ( $helper->isSwapped( $articleId ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-already-swapped' )->text();
			return;
		}

		// check if the file is premium
		if ( !$file->isLocal() ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-permission' )->text();
			return;
		}

		// set swap status
		wfSetWikiaPageProp( WPP_LVS_STATUS, $articleId, LicensedVideoSwapHelper::STATUS_SWAP_EXACT );

		// check if the new file exists
		$params = array(
			'controller' => 'VideoHandlerController',
			'method' => 'fileExists',
			'fileTitle' => $newTitle,
		);

		$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
		if ( empty( $response['fileExists'] ) ) {
			wfDeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// remove local video
		$removeVideo = $this->sendRequest( 'VideoHandlerController', 'removeVideo', array( 'title' => $file->getName() ) );
		$result = $removeVideo->getVal( 'result', '' );
		if ( $result != 'ok' ) {
			wfDeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = $removeVideo->getVal( 'msg', '' );
			return;
		}

		$sameTitle = ( $videoTitle == $newTitle );

		// force to get new file for same title
		$newFile = $helper->getVideoFile( $newTitle, $sameTitle );

		// check if new file exists
		if ( empty( $newFile ) ) {
			wfDeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// add premium video
		wfRunHooks( 'AddPremiumVideo', array( $newFile->getTitle() ) );

		if ( !$sameTitle ) {
			// add redirect url
			$title = Title::newFromText( $videoTitle, NS_FILE );
			$status = $helper->addRedirectLink( $title, $newFile->getTitle() );
			if ( !$status->isGood() ) {
				wfDeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );
				$this->html = '';
				$this->result = 'error';
				$this->msg = $status->getMessage();
				return;
			}

			// set swap status
			wfSetWikiaPageProp( WPP_LVS_STATUS, $articleId, LicensedVideoSwapHelper::STATUS_SWAP_NORM );
		}

		// add to log
		$reason = wfMessage( 'lvs-log-swap', $file->getTitle()->getText(), $newFile->getTitle()->getText() )->text();
		$helper->addLog( $file->getTitle(), 'licensedvideoswap_swap', $reason );

		// TODO: send request for tracking

		$selectedSort = $this->getVal( 'sort', 'recent' );
		$currentPage = $this->getVal( 'currentPage', 1 );

		// get video list
		$videoList = $this->getRegularVideoList( $selectedSort, $currentPage );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		$this->result = 'ok';

		$fileUrl = $newFile->getTitle()->getLocalURL();
		$undo = Xml::element( 'a', array( 'class' => 'undo-swap', 'href' => '' ), wfMessage( 'lvs-undo-swap' )->text() );
		$this->msg = wfMessage( 'lvs-swap-video-success', $fileUrl, $undo )->text();
	}

	/**
	 * keep video
	 * @requestParam string videoTitle
	 * @requestParam string sort [recent/popular/trend]
	 * @requestParam integer currentPage
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam string html
	 */
	public function keepVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );

		// validate action
		$response = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $response->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = $msg;
		}

		// check user permission
		if ( !$this->wg->User->isAllowed( 'undelete' ) || !$this->wg->User->isAllowed( 'deletedtext' ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-permission' )->text();
		}

		$helper = new LicensedVideoSwapHelper();
		$file = $helper->getVideoFile( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// set the status of this file page
		$articleId = $file->getTitle()->getArticleID();
		wfSetWikiaPageProp( WPP_LVS_STATUS, $articleId, LicensedVideoSwapHelper::STATUS_KEEP );

		$selectedSort = $this->getVal( 'sort', 'recent' );
		$currentPage = $this->getVal( 'currentPage', 1 );

		// get video list
		$videoList = $this->getRegularVideoList( $selectedSort, $currentPage );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		$this->result = 'ok';

		$undo = Xml::element( 'a', array( 'class' => 'undo-keep', 'href' => '' ), wfMessage( 'lvs-undo-keep' )->text() );
		$this->msg = wfMessage( 'lvs-keep-video-success', $undo )->parse();
	}

	/**
	 * restore video
	 * @requestParam string videoTitle
	 * @requestParam string newTitle
	 * @requestParam string sort [recent/popular/trend]
	 * @requestParam integer currentPage
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam string html
	 */
	public function restoreVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );

		// validate action
		$response = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $response->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = $msg;
		}

		$helper = new LicensedVideoSwapHelper();
		$file = $helper->getVideoFile( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		$title = Title::newFromText( $videoTitle, NS_FILE );
		if ( !$title instanceof Title ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// get the status of this file page
		$articleId = $title->getArticleID();
		$pageStatus = wfGetWikiaPageProp( WPP_LVS_STATUS, $articleId );
		if ( empty( $pageStatus ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-invalid-page-status' )->text();
			return;
		}

		if ( $pageStatus == LicensedVideoSwapHelper::STATUS_SWAP_EXACT ) {
			$status = $helper->undeletePage( $title );
		} else if ( $pageStatus == LicensedVideoSwapHelper::STATUS_SWAP_NORM ) {
			$newTitle = $this->request->getVal( 'newTitle', '' );
			$article = Article::newFromID( $title->getArticleID() );
			$redirect = $article->getRedirectTarget();
			if ( $article->isRedirect() && !empty( $redirect ) && $redirect->getDBKey() == $newTitle ) {
				$status = $helper->undeletePage( $title );
				if ( !$status->isOK() ) {
					$this->html = '';
					$this->result = 'error';
					$this->msg = $status->getMessage();
					return;
				}

				$result = $helper->removeRedirectLink( $article );
				if ( !$result->isOK() ) {
					$this->html = '';
					$this->result = 'error';
					$this->msg = $status->getMessage();
					return;
				}
			}
		}

		// delete the status of this file page
		wfDeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );

		// add log for undo swapping video only
		if ( $pageStatus != LicensedVideoSwapHelper::STATUS_KEEP ) {
			$reason = wfMessage( 'lvs-log-restore', $file->getTitle()->getText() )->text();
			$helper->addLog( $file->getTitle(), 'licensedvideoswap_restore', $reason );
		}

		$selectedSort = $this->getVal( 'sort', 'recent' );
		$currentPage = $this->getVal( 'currentPage', 1 );

		// get video list
		$videoList = $this->getRegularVideoList( $selectedSort, $currentPage );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		$this->result = 'ok';
		$this->msg = wfMessage( 'lvs-restore-video-success' )->text();
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
			$this->msg = wfMessage( 'videos-error-not-logged-in' )->text();
			return;
		}

		// check for blocked user
		if ( $this->wg->User->isBlocked() ) {
			$this->msg = wfMessage( 'videos-error-blocked-user' )->text();
			return;
		}

		// check for empty title
		if ( empty( $videoTitle ) ) {
			$this->msg = wfMessage( 'videos-error-empty-title' )->text();
			return;
		}

		// check for read only mode
		if ( wfReadOnly() ) {
			$this->msg = wfMessage( 'videos-error-readonly' )->text();
			return;
		}

		$this->msg = null;
	}

	// TODO: probably make this use mustache
	public function row() {
		$this->videoList = $this->getVal( 'videoList', array() );
		$this->thumbWidth = self::THUMBNAIL_WIDTH;
		$this->thumbHeight = self::THUMBNAIL_HEIGHT;
	}

	public function contentHeaderSort() {
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);

		$this->label = $this->getVal('label');
		$this->sortMsg = $this->getVal('sortMsg');
		$this->sortOptions = $this->getVal('sortOptions');
		$this->containerId = $this->getVal('containerId');
		$this->blankImgUrl = $this->wg->BlankImgUrl;
	}

}
