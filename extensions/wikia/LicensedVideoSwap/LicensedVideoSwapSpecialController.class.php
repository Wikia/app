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
		/** @var User $user */
		$user = $this->getUser();
		if ( !$user->isAllowed( 'licensedvideoswap' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		// set last visit date
		$user->setOption( LicensedVideoSwapHelper::USER_VISITED_DATE, wfTimestamp() );
		$user->saveSettings();

		$helper = new LicensedVideoSwapHelper();

		// clear cache for total new videos for the user
		$helper->invalidateCacheTotalNewVideos( $user->getId() );

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

		$file = WikiaFileHelper::getVideoFileFromTitle( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		$helper = new LicensedVideoSwapHelper();

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
		$helper->setPageStatusInfo( $articleId );

		// check if the new file exists
		$params = array(
			'controller' => 'VideoHandlerController',
			'method' => 'fileExists',
			'fileTitle' => $newTitle,
		);

		$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
		if ( empty( $response['fileExists'] ) ) {
			$helper->deletePageStatusInfo( $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// remove local video
		$removeVideo = $this->sendRequest( 'VideoHandlerController', 'removeVideo', array( 'title' => $file->getName() ) );
		$result = $removeVideo->getVal( 'result', '' );
		if ( $result != 'ok' ) {
			$helper->deletePageStatusInfo( $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = $removeVideo->getVal( 'msg', '' );
			return;
		}

		$isSameTitle = ( $videoTitle->getDBKey() == $newTitle );
		$swapValue['newTitle'] = $newTitle;

		// force to get new file for same title
		$newFile = WikiaFileHelper::getVideoFileFromTitle( $newTitle, $isSameTitle );

		// check if new file exists
		if ( empty( $newFile ) ) {
			$helper->deletePageStatusInfo( $articleId );
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		// add premium video
		wfRunHooks( 'AddPremiumVideo', array( $newFile->getTitle() ) );

		$title = Title::newFromText( $videoTitle->getDBKey(), NS_FILE );
		if ( !$isSameTitle ) {
			// add redirect url
			$status = $helper->addRedirectLink( $title, $newFile->getTitle() );
			if ( !$status->isGood() ) {
				$helper->deletePageStatusInfo( $articleId );
				$this->html = '';
				$this->result = 'error';
				$this->msg = $status->getMessage();
				return;
			}

			// set swap status
			$helper->setPageStatusSwap( $title->getArticleID(), $articleId );
			$helper->setPageStatusInfoSwap( $title->getArticleID(), $swapValue );
		} else {
			// set swap status
			$helper->setPageStatusSwapExact( $title->getArticleID(), $articleId );
			$helper->setPageStatusInfoSwapExact( $title->getArticleID(), $swapValue );
		}

		// remove old page status
		$helper->deletePageStatus( $articleId );
		$helper->deletePageStatusInfo( $articleId );

		// move suggestion data to new article
		$helper->moveSuggestionData( $articleId, $title->getArticleID() );

		// add to log
		$reason = wfMessage( 'lvs-log-swap', $file->getTitle()->getText(), $newFile->getTitle()->getText() )->text();
		$helper->addLog( $file->getTitle(), 'licensedvideoswap_swap', $reason );

		// clear cache for total new videos
		$helper->invalidateCacheTotalNewVideos();

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
			'data-video-title' => $videoTitle->getDBKey(),
			'data-new-title' => $newTitle->getDBKey(),
		);
		$undo = Xml::element( 'a', $undoOptions, wfMessage( 'lvs-undo-swap' )->text() );

		$this->msg = wfMessage( 'lvs-swap-video-success' )->rawParams( $undo )->parse();
	}

	/**
	 * keep video
	 * @requestParam string videoTitle
	 * @requestParam integer currentPage
	 * @requestParam string forever [true/false]
	 * @requestParam array suggestions
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam string html
	 */
	public function keepVideo() {
		$videoTitle = $this->request->getVal( 'videoTitle', '' );
		$forever = $this->request->getVal( 'forever', '' );
		$suggestions = $this->request->getVal( 'suggestions', array() );
		$currentPage = $this->getVal( 'currentPage', 1 );

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

		$file = WikiaFileHelper::getVideoFileFromTitle( $videoTitle );

		// check if file exists
		if ( empty( $file ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		$helper = new LicensedVideoSwapHelper();

		// set the LVS status of this file page
		$articleId = $file->getTitle()->getArticleID();
		if ( $helper->isKeptForever( $articleId ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-already-kept-forever' )->text();
			return;
		}

		// get valid suggestions
		$suggestTitles = $helper->getValidVideos( $suggestions );

		// get videos that have been suggested (kept videos)
		$historicalSuggestions = $helper->getHistoricalSuggestions( $articleId );

		// combine suggested videos and current suggestions
		$value['suggested'] = array_unique( array_merge( $historicalSuggestions, $suggestTitles ) );

		// set keep status
		$isForever = ( $forever == 'true' );
		$helper->setPageStatusKeep( $articleId, $isForever );
		$helper->setPageStatusInfoKeep( $articleId, $value, $isForever );

		// clear cache for total new videos
		$helper->invalidateCacheTotalNewVideos();

		// Get list video of non-premium videos available to swap
		$use_master = true;
		$videoList = $helper->getRegularVideoList( 'recent', $currentPage, $use_master );

		$this->html = $this->app->renderView( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList ) );
		//$this->html .= $helper->getPagination( $currentPage, 'recent' );
		$this->result = 'ok';

		$undoOptions = array(
			'class' => 'undo',
			'href' => '#',
			'data-video-title' => $videoTitle->getDBkey(),
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

		$file = WikiaFileHelper::getVideoFileFromTitle( $videoTitle, true );

		// check if file exists
		if ( empty( $file ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-error-video-no-exist' )->text();
			return;
		}

		$helper = new LicensedVideoSwapHelper();

		// get the LVS status of this file page
		$articleId = $videoTitle->getArticleID();
		$pageStatusInfo = $helper->getPageStatusInfo( $articleId );
		if ( empty( $pageStatusInfo['status'] ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage( 'lvs-error-invalid-page-status' )->text();
			return;
		}

		if ( $helper->isStatusSwapExact( $pageStatusInfo['status'] ) ) {
			$status = $helper->undeletePage( $videoTitle, true );
			if ( !$status->isOK() ) {
				$this->html = '';
				$this->result = 'error';
				$this->msg = $status->getMessage();
				return;
			}
		} else if ( $helper->isStatusSwapNorm( $pageStatusInfo['status'] ) ) {
			$newTitle = $this->request->getVal( 'newTitle', '' );

			/** @var WikiPage $article */
			$article = Article::newFromID( $videoTitle->getArticleID() );
			$redirect = $article->getRedirectTarget();
			if ( $article->isRedirect() && !empty( $redirect ) && $redirect->getDBKey() == $newTitle ) {
				$status = $helper->undeletePage( $videoTitle );
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

		// clear the LVS status of this file page
		$helper->clearPageStatus( $articleId );

		// delete the LVS status info of this file page
		$helper->deletePageStatusInfo( $articleId );

		// add log for undo swapping video only
		if ( !$helper->isStatusKeep( $pageStatusInfo['status'] ) ) {
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
			$this->msg = wfMessage( 'videos-error-not-logged-in' )->plain();
			return;
		}

		// check for blocked user
		if ( $this->wg->User->isBlocked() ) {
			$this->msg = wfMessage( 'videos-error-blocked-user' )->plain();
			return;
		}

		// check if user is allowed
		if ( !$this->wg->User->isAllowed( 'licensedvideoswap' ) ) {
			$this->msg = wfMessage( 'lvs-error-permission-access' )->plain();
			return;
		}

		// check for empty title
		if ( empty( $videoTitle ) ) {
			$this->msg = wfMessage( 'videos-error-empty-title' )->plain();
			return;
		}

		// check for read only mode
		if ( wfReadOnly() ) {
			$this->msg = wfMessage( 'videos-error-readonly' )->plain();
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

	/**
	 * Controller that is called when a user plays a video on the LVS.  Note that we mostly
	 * care about the non-premium video that could be swapped rather than the premium video that
	 * was played.  This is because all the metadata is stored against the non-premium video.
	 *
	 * @requestParam string videoTitle The title of the non-premium video that could be swapped
	 * @requestParam string premiumTitle The title of the video that was played
	 * @return bool Whether the controller was successful or not
	 */
	public function playVideo() {
		// Get the non-premium title
		$videoTitle = $this->getVal( 'videoTitle' );
		if ( empty($videoTitle) ) {
			return false;
		}

		// validate action
		$response = $this->sendRequest( 'LicensedVideoSwapSpecial', 'validateAction', array( 'videoTitle' => $videoTitle ) );
		$msg = $response->getVal( 'msg', '' );
		if ( !empty( $msg ) ) {
			$this->html = '';
			$this->result = 'error';
			$this->msg = $msg;
		}

		// Get the list of videos already played
		/** @var User $user */
		$user = $this->getUser();
		$visitedList = $user->getOption( LicensedVideoSwapHelper::USER_VISITED_LIST );
		if ( $visitedList ) {
			$visitedList = unserialize( $visitedList );
		} else {
			$visitedList = [];
		}

		// Update the list of played videos
		$visitedList[$videoTitle] = 1;
		$visitedTitles = array_keys($visitedList);

		// Remove any videos that don't exist for swapping anymore
		$helper = new LicensedVideoSwapHelper();
		$intersection = array_flip( $helper->intersectUnswappedVideo( $visitedTitles ) );

		// Go through each title in this user's list of played videos.  We're looking for the
		// video titles that don't appear in the intersection.  These titles no longer
		// need to be saved in this user property.
		foreach ( $visitedTitles as $title ) {
			// If this title doesn't appear in the intersection, remove it from the list
			if ( !isset($intersection[$title]) ) {

				unset($visitedList[$title]);
			}
		}

		// set last visit date
		$user->setOption( LicensedVideoSwapHelper::USER_VISITED_LIST, serialize($visitedList) );
		$user->saveSettings();

		return true;
	}
}
