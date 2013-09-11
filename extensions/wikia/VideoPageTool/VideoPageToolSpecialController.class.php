<?php

/**
 * VideoPageTool
 * @author Garth Webb
 * @author Kenneth Kouot
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class VideoPageToolSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'VideoPageTool', '', false );
	}

	public function init() {

	}

	/**
	 * VideoPageTool page
	 * If no subpage, calendar template will render
	 * Otherwise, form template will render
	 * @requestParam string language
	 * @requestParam string date [yyyy-mm-dd]
	 * @responseParam array languages - list of languages
	 * @responseParam string language - current language
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function index() {
		$this->response->addAsset('videopagetool_js');
		$this->response->addAsset('videopagetool_scss');
		$this->response->addAsset('videopagetool_css');
		if ( !$this->getUser()->isAllowed( 'videopagetool' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->wg->SupressPageSubtitle = true;

		JSMessages::enqueuePackage( 'VideoPageTool', JSMessages::EXTERNAL );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'videopagetool-page-title' )->plain() );

		$date = $this->getVal( 'date', date( 'Y-M-d' ) );
		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );

		$subpage = $this->getSubpage();
		if ( !empty( $subpage ) ) {
			$this->forward( __CLASS__, $subpage );
			return true;
		}

		$helper = new VideoPageToolHelper();
		$this->languages = $helper->getLanguages();
		$this->language = $language;

		$response = $this->sendSelfRequest( 'getCalendarInfo', array( 'language' => $language ) );
		$this->calendarInfo = $response->getVal( 'info', array() );
		$this->result = $response->getVal( 'result', '' );
		$this->msg = $response->getVal( 'msg', '' );
	}

	/**
	 * Edit page
	 * @requestParam string language
	 * @requestParam string date [yyyy-mm-dd]
	 * @requestParam string section [featured/trending/fan]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function edit() {

		JSMessages::enqueuePackage( 'VideoPageTool', JSMessages::EXTERNAL );

		$date = $this->getVal( 'date', strtotime( date( 'Y-M-d' ) ) );
		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );
		$section = $this->getVal( 'section', VideoPageToolHelper::DEFAULT_SECTION );

		$helper = new VideoPageToolHelper();

		// validate section - set to DEFAULT_SECTION if not exists
		$sections = $helper->getSections();
		if ( !array_key_exists( $section, $sections ) ) {
			$section = VideoPageToolHelper::DEFAULT_SECTION;
		}

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
			$data = $program->formatFormData( $section, $formValues, $errMsg );
			if ( empty( $errMsg ) ) {
				$status = $program->saveAssetsBySection( $section, $data );
				if ( $status->isGood() ) {
					$this->result = 'ok';
					$this->msg = '';
				} else {
					$this->error = 'error';
					$this->msg = $status->getMessage();
				}
			} else {
				$this->error = 'error';
				$this->msg = $errMsg;
			}
		}

		$this->leftMenuItems = $helper->getLeftMenuItems( $section, $language, $date );
		$this->moduleView = $this->app->renderView( 'VideoPageToolSpecial', $section, array( 'videos' => $videos, 'date' => $date, 'language' => $language ) );

		$this->section = $section;
		// TODO: not sure if these are needed in edit(), just in the sub views like "featured" etc.
		$this->date = $date;
		$this->language = $language;
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
	 * Trending videos template
	 * @requestParam array videos
	 * @responseParam array videos
	 */
	public function trending() {
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
	 * get video data
	 * @requestParam string url
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array video
	 */
	public function getVideoData() {
		$url = $this->getVal( 'url', '' );

		$video = array();

		if ( empty( $url ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-invalid-video-url' )->plain();
			return;
		}

		if ( preg_match( '/.+\/wiki\/File:(.+)$/i', $url, $matches ) ) {
			$helper = new VideoPageToolHelper();
			$video = $helper->getVideoData( $matches[1] );
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
