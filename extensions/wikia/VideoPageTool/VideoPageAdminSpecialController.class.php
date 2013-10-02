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
		$assets = $program->getAssetsBySection( $section );
		if ( empty( $assets ) ) {
			$videos = $helper->getDefaultValuesBySection( $section );
		} else {
			foreach( $assets as $order => $asset ) {
				$videos[$order] = $asset->getAssetData();
			}
		}

		if ( $this->request->wasPosted() ) {
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
		} else {
			if ( empty( $success ) ) {
				$result = '';
				$msg = '';
			} else {
				$result = 'ok';
				$msg = wfMessage( 'videopagetool-success-save' )->plain();
			}
		}

		$this->result = $result;
		$this->msg = $msg;

		$this->leftMenuItems = $leftMenuItems;
		$this->moduleView = $this->app->renderView( 'VideoPageAdminSpecial', $section, array( 'videos' => $videos, 'date' => $date, 'language' => $language ) );

		$this->section = $section;
		// TODO: not sure if these are needed in edit(), just in the sub views like "featured" etc.
		$this->date = $date;
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
				return false;
			}

			// get all sections
			$helper = new VideoPageToolHelper();
			$sections = array_keys( $helper->getSections() );

			// validate program
			if ( !$program->isPublishable( $sections ) ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'videopagetool-error-program-not-ready' )->plain();
				return false;
			}

			// publish program
			$status = $program->publishProgram();
			if ( !$status->isGood() ) {
				$this->result = 'error';
				$this->msg = $status->getMessage();
				return false;
			}

			// redirect to Special:VideoPageTool
			$url = SpecialPage::getTitleFor( 'VideoPageAdmin' )->getLocalURL();
			$msg = wfMessage( 'videopagetool-success-publish' )->plain();
			NotificationsController::addConfirmation( $msg, NotificationsController::CONFIRMATION_CONFIRM );
			$this->getContext()->getOutput()->redirect( $url );
			return true;
		}
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
		// check permission
		if ( !$this->wg->User->isAllowed( 'videopagetool' ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-permission' )->plain();
			return false;
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

		$info = VideoPageToolProgram::getPrograms( $language, date( 'Y-m-d', $startTime ), date( 'Y-m-d', $endTime ) );

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
			$this->msg = wfMessage( 'videohandler-unknown-title' )->plain();
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

	public function executeHeader($data) {
		/*
		 * TODO: imported function from SpecialMarketingToolbox, not sure if we need it
		 */

		// $optionalDataKeys = array('date', 'moduleName', 'sectionName', 'verticalName',
		// 	'regionName', 'lastEditor', 'lastEditTime');

		// foreach ($optionalDataKeys as $key) {
		// 	if (isset($data[$key])) {
		// 		$this->$key = $data[$key];
		// 	}
		// }

		$this->dashboardHref = SpecialPage::getTitleFor('VideoPageTool')->getLocalURL();
	}

}
