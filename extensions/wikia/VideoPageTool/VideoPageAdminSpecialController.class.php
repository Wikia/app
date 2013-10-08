<?php
/**
 * VideoPageAdminSpecialController
 * @author Garth Webb
 * @author Kenneth Kouot
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */

class VideoPageAdminSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'VideoPageAdmin', '', false );
	}

	public function init() {

	}

	/**
	 * VideoPageTool page
	 * If no subpage, calendar template will render
	 * Otherwise, form template will render
	 * @requestParam string language
	 * @responseParam array languages - list of languages
	 * @responseParam string language - current language
	 */
	public function index() {
		$this->response->addAsset('videopageadmin_js');
		$this->response->addAsset('videopageadmin_scss');
		$this->response->addAsset('videopageadmin_css');
		if ( !$this->getUser()->isAllowed( 'videopagetool' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->wg->SupressPageSubtitle = true;

		JSMessages::enqueuePackage( 'VideoPageTool', JSMessages::EXTERNAL );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'videopagetool-page-title' )->plain() );

		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );

		$subpage = $this->getSubpage();
		if ( !empty( $subpage ) ) {
			$this->forward( __CLASS__, $subpage );
			return true;
		}

		$helper = new VideoPageToolHelper();
		$this->languages = $helper->getLanguages();
		$this->language = $language;
	}

	/**
	 * Edit page
	 * @requestParam string language
	 * @requestParam string date [timestamp]
	 * @requestParam string section [featured/category/fan]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function edit() {
		JSMessages::enqueuePackage( 'VideoPageTool', JSMessages::EXTERNAL );

		$time = $this->getVal( 'date', time() );
		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );
		$section = $this->getVal( 'section', VideoPageToolHelper::DEFAULT_SECTION );
		$action = $this->getVal( 'action', '' );

		// for save message
		$success = $this->getVal( 'success', '' );

		$helper = new VideoPageToolHelper();

		// get date
		$date = strtotime( date( 'Y-M-d', $time ) );

		// validate section - set to DEFAULT_SECTION if not exists
		$sections = $helper->getSections();
		if ( !array_key_exists( $section, $sections ) ) {
			$section = VideoPageToolHelper::DEFAULT_SECTION;
		}

		// get left menu items
		$leftMenuItems = $helper->getLeftMenuItems( $section, $sections, $language, $date );

		$program = VideoPageToolProgram::newProgram( $language, $date );

		// get program assets
		$assets = $program->getAssetsBySection( $section );
		if ( empty( $assets ) ) {
			$publishedProgram = VideoPageToolProgram::newProgramNearestToday( $language, $date );
			if ( !empty( $publishedProgram ) ) {
				$assets = $publishedProgram->getAssetsBySection( $section );
			}
		}

		// get asset data
		if ( empty( $assets ) ) {
			// get default assets
			$videos = $helper->getDefaultValuesBySection( $section );
		} else {
			foreach( $assets as $order => $asset ) {
				$videos[$order] = $asset->getAssetData();
			}
		}

		$result = '';
		$msg = '';
		if ( $this->request->wasPosted() ) {
			// publish program
			if ( $action == 'publish' ) {
				$response =	$this->sendSelfRequest( $action, array( 'date' => $date, 'language' => $language ) );
				$msg = $response->getVal( 'msg', '' );
				$result = $response->getVal( 'result', '' );
				if ( $result == 'ok' ) {
					// redirect to Special:VideoPageAdmin
					$url = SpecialPage::getTitleFor( 'VideoPageAdmin' )->getLocalURL();
					$msg = wfMessage( 'videopagetool-success-publish' )->plain();
					NotificationsController::addConfirmation( $msg, NotificationsController::CONFIRMATION_CONFIRM );
					$this->getContext()->getOutput()->redirect( $url );
					return true;
				}
			// save assets
			} else {
				$formValues = $this->request->getParams();
				$errMsg = '';
				$requiredRows = VideoPageToolHelper::$requiredRows[$section];
				$data = $program->formatFormData( $section, $requiredRows, $formValues, $errMsg );
				if ( empty( $errMsg ) ) {
					$status = $program->saveAssetsBySection( $section, $data );
					if ( $status->isGood() ) {
						$nextUrl = $helper->getNextMenuItemUrl( $leftMenuItems ).'&success=1';
						$this->getContext()->getOutput()->redirect( $nextUrl );
						return true;
					} else {
						$result = 'error';
						$msg = $status->getMessage();
					}
				} else {
					// update original asset data
					foreach ( $data as $order => $row ) {
						foreach ( $row as $name => $value ) {
							if ( array_key_exists( $name, $videos[$order] ) && $videos[$order][$name] != $value ) {
								$videos[$order][$name] = $value;
							}

							// replace alternative thumbnail
							if ( $name == 'altThumbTitle' && array_key_exists( 'altThumbKey', $videos[$order] )
								&& $videos[$order]['altThumbKey'] != $value ) {
								$videos[$order] = $helper->replaceThumbnail( $videos[$order], $value );
							}
						}
					}
					$result = 'error';
					$msg = $errMsg;
				}
			}
		// save successfully
		} else if ( !empty( $success ) ) {
			$result = 'ok';
			$msg = wfMessage( 'videopagetool-success-save' )->plain();
		}

		$this->result = $result;
		$this->msg = $msg;

		$this->leftMenuItems = $leftMenuItems;
		$this->moduleView = $this->app->renderView( 'VideoPageAdminSpecial', $section, array( 'videos' => $videos, 'date' => $date, 'language' => $language ) );
		$this->publishButton = ( $program->isPublishable( array_keys( $sections ) ) ) ? '' : 'disabled';
		$this->publishUrl = $this->wg->Title->getLocalURL( array('date' => $date, 'language' => $language) );
		$this->publishDate = $program->getFormattedPublishDate();

		$this->section = $section;
		$this->language = $language;
	}

	/**
	 * Publish program
	 * @requestParam string language
	 * @requestParam string date [timestamp]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function publish() {
		$time = $this->getVal( 'date', time() );
		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );

		if ( $this->request->wasPosted() ) {
			$program = VideoPageToolProgram::newProgram( $language, $time );
			if ( !$program->exists() ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'videopagetool-error-unknown-program' )->plain();
				return;
			}

			// get all sections
			$helper = new VideoPageToolHelper();
			$sections = array_keys( $helper->getSections() );

			// validate program
			if ( !$program->isPublishable( $sections ) ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'videopagetool-error-program-not-ready' )->plain();
				return;
			}

			// publish program
			$status = $program->publishProgram();
			if ( !$status->isGood() ) {
				$this->result = 'error';
				$this->msg = $status->getMessage();
				return;
			}
		}

		$this->result = 'ok';
		$this->msg = '';
	}

	/**
	 * get subpage
	 * @return string|null $subpage
	 */
	protected function getSubpage() {
		$path = $this->getPar();
		$path_parts = explode( '/', $path );

		$subpage = null;
		if ( !empty( $path_parts[0] ) && method_exists( $this, $path_parts[0] ) ) {
			$subpage = $path_parts[0];
		}

		return $subpage;
	}

	/**
	 * get calendar info
	 * @requestParam string language
	 * @requestParam string startTime [timestamp]
	 * @requestParam string endTime [timestamp]
	 * @responseParam array info [array( date => status ); date = yyyy-mm-dd; status = 0 (not published)/ 1 (published)]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function getCalendarInfo() {
		$errMsg = '';
		if ( !$this->validateUser( $errMsg ) ) {
			$this->result = 'error';
			$this->msg = $errMsg;
			return;
		}

		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );
		$startTime = $this->getVal( 'startTime', strtotime( 'first day of this month' ) );
		$endTime = $this->getVal( 'endTime', strtotime( 'first day of next month' ) );

		$helper = new VideoPageToolHelper();

		// validate language
		$languages = $helper->getLanguages();
		if ( !array_key_exists( $language, $languages ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-invalid-language' )->plain();
			$this->info = array();
			return;
		}

		// validate date
		$sDate = getdate( $startTime );
		$eDate = getdate( $endTime );
		if ( !checkdate($sDate['mon'], $sDate['mday'], $sDate['year'] ) || !checkdate($eDate['mon'], $eDate['mday'], $eDate['year'] )  ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-invalid-date' )->plain();
			$this->info = array();
			return;
		}

		// Make sure the end date comes after the start date
		if ( $startTime > $endTime ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-invalid-date' )->plain();
			$this->info = array();
			return;
		}

		// Get the first day of the month for the requested start
		$requestTime = strtotime( 'first day of this month', $startTime );
		$requestDate = date( 'Y-m-d', $requestTime );

		// Get the first day of them month for the end date in the range
		$endDate = date( 'Y-m-d', strtotime( 'first day of this month', $endTime ) );

		// Get one month worth of data starting at $requestDate
		$info = VideoPageToolProgram::getProgramsForMonth( $language, $requestDate );

		// If we have more than one month to retrieve, keep fetching them.  We only fetch per
		// month so that we can easily determine what to invalidate when we update programs
		while ($requestDate != $endDate) {
			$requestTime = strtotime( 'first day of next month',  $requestTime);
			$requestDate = date( 'Y-m-d', $requestTime );
			$nextInfo = VideoPageToolProgram::getProgramsForMonth( $language, $requestDate );

			$info = array_merge($info, $nextInfo);
		}

		$this->result = 'ok';
		$this->msg = '';
		$this->info = $info;
	}

	/**
	 * Featured videos template
	 * @requestParam array videos
	 * @responseParam array videos
	 */
	public function featured() {
		$this->videos = $this->getVal( 'videos', array() );
		$this->date = $this->getVal( 'date' );
		$this->language = $this->getVal( 'language' );
	}

	/**
	 * Category videos template
	 * @requestParam array videos
	 * @responseParam array videos
	 */
	public function category() {
		$videos[] = array(
			'categoryName' => 'Category Name',
			'displayTitle' => 'Title',
		);
		$this->videos = $videos;
	}

	/**
	 * Fan videos template
	 * @requestParam array videos
	 * @responseParam array videos
	 */
	public function fan() {
		$videos[] = array(
			'videoTitle' => 'Video Title',
			'videoKey' => 'Video_Title',
			'videoThumb' => '',
			'displayTitle' => 'Display Title',
			'programTitle' => 'Progam Title',
			'programUrl' => '',
			'description' => 'description...',
		);
		$this->videos = $videos;
	}

	/**
	 * Get video data
	 * @requestParam string url
	 * @requestParam string altThumbKey
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array video
	 */
	public function getVideoData() {
		$errMsg = '';
		if ( !$this->validateUser( $errMsg ) ) {
			$this->result = 'error';
			$this->msg = $errMsg;
			return;
		}

		$url = $this->getVal( 'url', '' );
		$altThumbTitle = $this->getVal( 'altThumbKey', '' );

		$video = array();

		if ( empty( $url ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-invalid-video-url' )->plain();
			return;
		}

		$url = urldecode( $url );
		if ( preg_match( '/.+\/wiki\/File:(.+)$/i', $url, $matches ) ) {
			$helper = new VideoPageToolHelper();
			$video = $helper->getVideoData( $matches[1], $altThumbTitle );
		}

		if ( empty( $video ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-non-premium' )->plain();
			$this->video = $video;
		} else {
			$this->result = 'ok';
			$this->msg = '';
			$this->video = $video;
		}
	}

	/**
	 * Get image data
	 * @requestParam string imageTitle
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array $data [ array( 'thumbUrl' => $url, 'largeThumbUrl' => $url ) ]
	 */
	public function getImageData() {
		$errMsg = '';
		if ( !$this->validateUser( $errMsg ) ) {
			$this->result = 'error';
			$this->msg = $errMsg;
			return;
		}

		$imageTitle = $this->getVal( 'imageTitle', '' );

		if ( empty( $imageTitle ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-empty-title' )->plain();
			return;
		}

		$helper = new VideoPageToolHelper();
		$data = $helper->getImageData( $imageTitle );
		if ( empty( $data ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videohandler-unknown-title' )->plain();
		} else {
			$this->result = 'ok';
			$this->msg = '';
		}

		$this->data = $data;
	}

	/*
	 * Render header
	 */

	public function header($data) {
		$this->language = Language::getLanguageName( $this->getVal( 'language' ) );
		$this->section = ucfirst( $this->getVal( 'section' ) );
		$this->publishDate = $this->getVal( 'publishDate' );
		$this->dashboardHref = SpecialPage::getTitleFor('VideoPageAdmin')->getLocalURL();
	}

	/**
	 * Validate user
	 * @param string $errMsg
	 * @return boolean
	 */
	protected function validateUser( &$errMsg ) {
		// check for logged in user
		if ( !$this->wg->User->isLoggedIn() ) {
			$errMsg = wfMessage( 'videos-error-not-logged-in' )->text();
			return false;
		}

		// check for blocked user
		if ( $this->wg->User->isBlocked() ) {
			$errMsg = wfMessage( 'videos-error-blocked-user' )->text();
			return false;
		}

		// check if allow
		if ( !$this->wg->User->isAllowed( 'videopagetool' ) ) {
			$errMsg = wfMessage( 'videopagetool-error-permission' )->plain();
			return false;
		}

		return true;
	}

}
