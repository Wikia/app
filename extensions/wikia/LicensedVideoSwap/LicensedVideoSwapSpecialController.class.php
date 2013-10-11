<?php

/**
 * LicensedVideoSwap
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LicensedVideoSwap', 'licensedvideoswap', true );
	}

	/**
	 * LicensedVideoSwap page
	 *
	 * @requestParam integer currentPage
	 * @responseParam integer currentPage
	 * @responseParam integer pages
	 * @responseParam array videoList
	 */
	public function index() {
		$user = $this->getUser();
		if ( !$user->isAllowed( 'licensedvideoswap' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		// Add assets to both LVS and LVS/History
		// TODO: move this to Assets Manager once we release this
		$this->response->addAsset( 'licensed_video_swap_js' );
		$this->response->addAsset( 'extensions/wikia/LicensedVideoSwap/css/LicensedVideoSwap.scss' );

		// See if there is a subpage request to handle (i.e. /History)
		$subpage = $this->getSubpage();

		if ( !$this->app->checkSkin( 'oasis' ) ) {
			$oasisURL = SpecialPage::getTitleFor( 'LicensedVideoSwap', $subpage )->getLocalURL( 'useskin=wikia' );
			$oasisLink = Xml::element( 'a', [ 'href' => $oasisURL ], wfMessage( 'lvs-click-here' ) );
			$this->wg->out->addHTML( wfMessage( 'lvs-no-monobook-support' )->rawParams( $oasisLink )->parse() );
			$this->skipRendering();
			return true;
		}

		if ( $subpage ) {
			$this->forward( __CLASS__, $subpage );
			return true;
		}

		// Setup messages for JS
		JSMessages::enqueuePackage('LVS', JSMessages::EXTERNAL);

		$this->wg->SupressPageSubtitle = true;

		// update h1 text and <title> element
		$this->getContext()->getOutput()->setPageTitle( wfMessage('lvs-page-title')->plain() );

		$currentPage = $this->getVal( 'currentPage', 1 );

		// list of videos
		$helper = new LicensedVideoSwapHelper();

		// Get the list of videos that have suggestions
		$this->videoList = $helper->getRegularVideoList( 'recent', $currentPage );
		$this->thumbWidth = LicensedVideoSwapHelper::THUMBNAIL_WIDTH;
		$this->thumbHeight = LicensedVideoSwapHelper::THUMBNAIL_HEIGHT;

		// Set up pagination
		$this->pagination = ''; //$helper->getPagination( $currentPage, 'recent' );
	}

	/**
	 * History page
	 */
	public function history() {
		$this->getContext()->getOutput()->setPageTitle( wfMessage('lvs-history-page-title')->text() );

		// Get the user preference skin, not the current skin of the page
		$skin = F::app()->wg->User->getOption( 'skin' );

		// for monobook users, specify wikia skin in querystring
		$queryArr = [];
		if ( $skin == "monobook" ) {
			$queryArr["useskin"] = "wikia";
		}

		$this->getContext()->getOutput()->setSubtitle( Wikia::link(SpecialPage::getTitleFor("LicensedVideoSwap"), wfMessage('lvs-page-header-back-link')->plain(), array('accesskey' => 'c'), $queryArr, 'known') );

		$this->recentChangesLink = Wikia::link( SpecialPage::getTitleFor( "RecentChanges" ) );
		$helper = new LicensedVideoSwapHelper();
		$this->videos = $helper->getUndoList( $this->getContext() );
	}

	/**
	 * See if a subpage is requested and return its name, otherwise return null
	 * @return null|string
	 */
	protected function getSubpage() {
		wfProfileIn(__METHOD__);

		$path = $this->getPar();
		$path_parts = explode('/', $path);

		if ( !empty($path_parts[0]) ) {
			$subpage = strtolower( $path_parts[0] );
			if ( method_exists($this, $subpage) ) {
				wfProfileOut(__METHOD__);
				return $subpage;
			}
		}

		wfProfileOut(__METHOD__);
		return null;
	}

	/**
	 * swap video
	 * @requestParam string videoTitle
	 * @requestParam string newTitle
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
			return;
		}

		// check user permission
		if ( !$this->wg->User->isAllowed( 'deletedtext' ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-permission' )->text();
			return;
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
		$helper->setPageStatusSwap( $articleId );

		// check if the new file exists
		$params = array(
			'controller' => 'VideoHandlerController',
			'method' => 'fileExists',
			'fileTitle' => $newTitle,
		);

		$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
		if ( empty( $response['fileExists'] ) ) {
			$helper->deletePageStatus( $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// remove local video
		$removeVideo = $this->sendRequest( 'VideoHandlerController', 'removeVideo', array( 'title' => $file->getName() ) );
		$result = $removeVideo->getVal( 'result', '' );
		if ( $result != 'ok' ) {
			$helper->deletePageStatus( $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = $removeVideo->getVal( 'msg', '' );
			return;
		}

		$sameTitle = ( $videoTitle == $newTitle );
		$swapValue['newTitle'] = $newTitle;

		// force to get new file for same title
		$newFile = $helper->getVideoFile( $newTitle, $sameTitle );

		// check if new file exists
		if ( empty( $newFile ) ) {
			$helper->deletePageStatus( $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// add premium video
		wfRunHooks( 'AddPremiumVideo', array( $newFile->getTitle() ) );

		$title = Title::newFromText( $videoTitle, NS_FILE );
		if ( !$sameTitle ) {
			// add redirect url
			$status = $helper->addRedirectLink( $title, $newFile->getTitle() );
			if ( !$status->isGood() ) {
				$helper->deletePageStatus( $articleId );
				$this->html = '';
				$this->result = 'error';
				$this->msg = $status->getMessage();
				return;
			}

			// set swap status
			$helper->setPageStatusSwap( $title->getArticleID(), $swapValue );
		} else {
			// set swap status
			$helper->setPageStatusSwapExact( $title->getArticleID(), $swapValue );
		}

		// remove old page status
		$helper->deletePageStatus( $articleId );

		// add to log
		$reason = wfMessage( 'lvs-log-summary', $file->getTitle()->getText(), $newFile->getTitle()->getText() )->text();
		$helper->addLog( $file->getTitle(), wfMessage( 'lvs-log-description' )->text(), $reason );

		// TODO: send request for tracking

		$currentPage = $this->getVal( 'currentPage', 1 );

		// get video list
		$use_master = true;
		$videoList = $helper->getRegularVideoList( 'recent', $currentPage, $use_master );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		//$this->html .= $helper->getPagination( $currentPage, 'recent' );
		$this->result = 'ok';

		$undoOptions = array(
			'class' => 'undo',
			'href' => '#',
			'data-video-title' => $videoTitle,
			'data-new-title' => $newTitle,
		);
		$undo = Xml::element( 'a', $undoOptions, wfMessage( 'lvs-undo-swap' )->text() );

		$this->msg = wfMessage( 'lvs-swap-video-success' )->rawParams( $undo )->parse();
	}

	/**
	 * keep video
	 * @requestParam string videoTitle
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

		// set the LVS status of this file page
		$articleId = $file->getTitle()->getArticleID();
		// TODO: get sugestions
		$value = array(
			'suggestions' => array(),
		);
		$helper->setPageStatusKeep( $articleId, $value );

		$currentPage = $this->getVal( 'currentPage', 1 );

		// Get list video of non-premium videos available to swap
		$use_master = true;
		$videoList = $helper->getRegularVideoList( 'recent', $currentPage, $use_master );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		//$this->html .= $helper->getPagination( $currentPage, 'recent' );
		$this->result = 'ok';

		$undoOptions = array(
			'class' => 'undo',
			'href' => '#',
			'data-video-title' => $videoTitle,
		);
		$undo = Xml::element( 'a', $undoOptions, wfMessage( 'lvs-undo-keep' )->text() );
		$this->msg = wfMessage( 'lvs-keep-video-success' )->rawParams( $undo )->parse();
	}

	/**
	 * restore video after swapping or keeping it
	 * @requestParam string videoTitle
	 * @requestParam string newTitle
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
		$file = $helper->getVideoFile( $videoTitle, true );

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

		// get the LVS status of this file page
		$articleId = $title->getArticleID();
		$pageStatus = $helper->getPageStatus( $articleId );
		if ( empty( $pageStatus ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-invalid-page-status' )->text();
			return;
		}

		if ( $pageStatus['status'] == LicensedVideoSwapHelper::STATUS_SWAP_EXACT ) {
			$status = $helper->undeletePage( $title, true );
		} else if ( $pageStatus['status'] == LicensedVideoSwapHelper::STATUS_SWAP_NORM ) {
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
					$this->msg = $result->getMessage();
					return;
				}
			}
		}

		// delete the LVS status of this file page
		$helper->deletePageStatus( $articleId );

		// add log for undo swapping video only
		if ( $pageStatus['status'] != LicensedVideoSwapHelper::STATUS_KEEP ) {
			$reason = wfMessage( 'lvs-log-restore', $file->getTitle()->getText() )->text();
			$helper->addLog( $file->getTitle(), 'licensedvideoswap_restore', $reason );
		}

		$currentPage = $this->getVal( 'currentPage', 1 );

		// get video list
		$use_master = true;
		$videoList = $helper->getRegularVideoList( 'recent', $currentPage, $use_master );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		//$this->html .= $helper->getPagination( $currentPage, 'recent' );
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
		$this->thumbWidth = LicensedVideoSwapHelper::THUMBNAIL_WIDTH;
		$this->thumbHeight = LicensedVideoSwapHelper::THUMBNAIL_HEIGHT;
	}
}
