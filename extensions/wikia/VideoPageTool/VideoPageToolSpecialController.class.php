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
		$this->response->addAsset('videopagetool_js');
		$this->response->addAsset('videopagetool_css');

		$leftMenuItems = [
			[
				'href' => '/wiki/Special:MarketingToolbox/editHub?moduleId=1&date=1376265600&region=en&verticalId=2&sectionId=1',
				'selected' => '1',
	            'title' => 'Slider',
	            'anchor' => 'Slider',
			],
		];

		$this->leftMenuItems = $leftMenuItems;
	}

	/**
	 * VideoPageTool page
	 * on GET, calendar template will render
	 * on POST, form template will render
	 * @requestParam string region (on POST)
	 * @requestParam string date [yyyy-mm-dd] (on POST)
	 * @requestParam string section [featured/trending/fan] (on POST)
	 * @responseParam array regions - list of regions
	 * @responseParam string region - current region
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function index() {
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

		if ( $this->wg->request->wasPosted() ) {
			$section = $this->getVal( 'section', 'featured' );

			$this->section = $section;
		} else {
			$regions = array(
				'en' => 'English',
			);
			$this->regions = $regions;

			$response = $this->sendSelfRequest( 'getCalendarInfo', array( 'region' => $region, 'date' => $date ) );
			$this->calendarInfo = $response->getVal( 'info', array() );
			$this->result = $response->getVal( 'result', '' );
			$this->msg = $response->getVal( 'msg', '' );
		}

		$this->date = $date;
		$this->region = $region;
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

}

