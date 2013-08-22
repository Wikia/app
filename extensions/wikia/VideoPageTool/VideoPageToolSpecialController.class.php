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
	 * @requestParam string region
	 * @requestParam string date [yyyy-mm-dd]
	 * @responseParam array regions - list of regions
	 * @responseParam string region - current region
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

		JSMessages::enqueuePackage( 'VideoToolPage', JSMessages::EXTERNAL );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'videopagetool-page-title' )->plain() );

		$date = $this->getVal( 'date', date( 'Y-M-d' ) );
		$region = $this->getVal( 'region', 'en' );

		$subpage = $this->getSubpage();
		if ( !empty( $subpage ) ) {
			$this->forward( __CLASS__, $subpage );
			return true;
		}

		$regions = array(
			'en' => 'English',
		);
		$this->regions = $regions;
		$this->region = $region;

		$response = $this->sendSelfRequest( 'getCalendarInfo', array( 'region' => $region, 'date' => $date ) );
		$this->calendarInfo = $response->getVal( 'info', array() );
		$this->result = $response->getVal( 'result', '' );
		$this->msg = $response->getVal( 'msg', '' );
	}

	/**
	 * Edit page
	 * @requestParam string region
	 * @requestParam string date [yyyy-mm-dd]
	 * @requestParam string section [featured/trending/fan]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function edit() {
		$date = $this->getVal( 'date', date( 'Y-M-d' ) );
		$region = $this->getVal( 'region', 'en' );
		$section = $this->getVal( 'section', VideoPageToolHelper::DEFAULT_SECTION );

		$helper = new VideoPageToolHelper();

		// validate section - set to DEFAULT_SECTION if not exists
		$sections = $helper->getSections();
		if ( !array_key_exists( $section, $sections ) ) {
			$section = VideoPageToolHelper::DEFAULT_SECTION;
		}

		$videos = array();

		$this->leftMenuItems = $helper->getLeftMenuItems( $section );
		$this->moduleView = $this->app->renderView( 'VideoPageToolSpecial', $section, array( 'videos' => $videos ) );

		$this->section = $section;
		$this->date = $date;
		$this->region = $region;
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
	 * @requestParam string region
	 * @requestParam string date [yyyy-mm-dd]
	 * @responseParam array info [array( date => status ); status = 0 (not published)/ 1 (published)]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function getCalendarInfo() {
		if ( !$this->wg->User->isAllowed( 'videopagetool' ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-permission' )->plain();
			return false;
		}

		$date = $this->getVal( 'date', date( 'Y-M-d' ) );
		$region = $this->getVal( 'region', 'en' );

		$info = array(
			'2013-08-08' => 1,
			'2013-08-12' => 2,
			'2013-08-14' => 2,
			'2013-08-15' => 1,
		);

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
		$videos[] = array(
			'videoTitle' => 'Video Title',
			'videoKey' => 'Video_Title',
			'videoThumb' => '',
			'displayTitle' => 'Display Title',
			'description' => 'description...',
		);

		$this->videos = $videos;
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

}

