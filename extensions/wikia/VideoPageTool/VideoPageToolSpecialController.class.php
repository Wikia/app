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

		$date = $this->getVal( 'date', date( 'Y-M-d' ) );
		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );
		$section = $this->getVal( 'section', VideoPageToolHelper::DEFAULT_SECTION );

		$helper = new VideoPageToolHelper();

		// validate section - set to DEFAULT_SECTION if not exists
		$sections = $helper->getSections();
		if ( !array_key_exists( $section, $sections ) ) {
			$section = VideoPageToolHelper::DEFAULT_SECTION;
		}

		if ($this->request->wasPosted()) {
			// Do form validation and saving here
			//$this->request->getParams();
		}

		$videos = array();

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

		$info = $helper->getPrograms( $language, date( 'Y-m-d', $startTime ), date( 'Y-m-d', $endTime ) );

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
		// TODO: this is way hard coded

		$videos = array (
			1 =>
			array (
				'videoTitle' => 'World War Z (2013) - Home Video Trailer 2 for World War Z',
				'videoKey' => 'World_War_Z_(2013)_-_Home_Video_Trailer_2_for_World_War_Z',
				'displayTitle' => 'World War Z (2013) - Home Video Trailer 2 for World War Z',
				'videoThumb' => '<a href="/wiki/File:World_War_Z_(2013)_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:100px;width:179px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" /></div><img alt="" src="http://images.saipetch.wikia-dev.com/__cb20130809003122/video151/images/thumb/a/a1/World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z/179px-World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z.jpg" width="179" height="100" data-video-name="World War Z (2013) - Home Video Trailer 2 for World War Z" data-video-key="World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="thumbnail" class="Wikia-video-thumb" /></a>',
				'description' => 'World War Z description here...',
				'displayTitleClass' => '',
				'updatedBy' => 'Saipetch',
				'updatedAt' => '2013-09-04 00:41:00',
			),
			2 =>
			array (
				'videoTitle' => 'Dark Souls 2 Announcement Trailer',
				'videoKey' => 'Dark_Souls_2_Announcement_Trailer',
				'displayTitle' => 'Dark Souls 2 Announcement Trailer',
				'videoThumb' => '<a href="/wiki/File:Dark_Souls_2_Announcement_Trailer" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:100px;width:179px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" /></div><img alt="" src="http://images.saipetch.wikia-dev.com/__cb20121210202318/video151/images/thumb/c/ca/Dark_Souls_2_Announcement_Trailer/179px-Dark_Souls_2_Announcement_Trailer.jpg" width="179" height="100" data-video-name="Dark Souls 2 Announcement Trailer" data-video-key="Dark_Souls_2_Announcement_Trailer" itemprop="thumbnail" class="Wikia-video-thumb" /></a>',
				'description' => 'Dark Souls description here...',
				'displayTitleClass' => '',
				'updatedBy' => 'Saipetch',
				'updatedAt' => '2013-09-04 00:41:00',
			),
			3 =>
			array (
				'videoTitle' => 'World War Z (2013) - Home Video Trailer 2 for World War Z',
				'videoKey' => 'World_War_Z_(2013)_-_Home_Video_Trailer_2_for_World_War_Z',
				'displayTitle' => 'World War Z (2013) - Home Video Trailer 2 for World War Z',
				'videoThumb' => '<a href="/wiki/File:World_War_Z_(2013)_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:100px;width:179px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" /></div><img alt="" src="http://images.saipetch.wikia-dev.com/__cb20130809003122/video151/images/thumb/a/a1/World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z/179px-World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z.jpg" width="179" height="100" data-video-name="World War Z (2013) - Home Video Trailer 2 for World War Z" data-video-key="World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="thumbnail" class="Wikia-video-thumb" /></a>',
				'description' => 'World War Z description here...',
				'displayTitleClass' => '',
				'updatedBy' => 'Saipetch',
				'updatedAt' => '2013-09-04 00:41:00',
			),
			4 =>
			array (
				'videoTitle' => 'World War Z (2013) - Home Video Trailer 2 for World War Z',
				'videoKey' => 'World_War_Z_(2013)_-_Home_Video_Trailer_2_for_World_War_Z',
				'displayTitle' => 'World War Z (2013) - Home Video Trailer 2 for World War Z',
				'videoThumb' => '<a href="/wiki/File:World_War_Z_(2013)_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:100px;width:179px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" /></div><img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="179" height="100" data-video-name="World War Z (2013) - Home Video Trailer 2 for World War Z" data-video-key="World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="thumbnail" class="Wikia-video-thumb lzy lzyPlcHld" data-src="http://images.saipetch.wikia-dev.com/__cb20130809003122/video151/images/thumb/a/a1/World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z/179px-World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z.jpg" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img src="http://images.saipetch.wikia-dev.com/__cb20130809003122/video151/images/thumb/a/a1/World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z/179px-World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z.jpg" width="179" height="100" data-video-name="World War Z (2013) - Home Video Trailer 2 for World War Z" data-video-key="World_War_Z_%282013%29_-_Home_Video_Trailer_2_for_World_War_Z" itemprop="thumbnail" class="Wikia-video-thumb" /></noscript></a>',
				'description' => 'World War Z description here...',
				'displayTitleClass' => '',
				'updatedBy' => 'Saipetch',
				'updatedAt' => '2013-09-04 00:41:00',
			),
			5 =>
			array (
				'videoTitle' => 'Dark Souls 2 Announcement Trailer',
				'videoKey' => 'Dark_Souls_2_Announcement_Trailer',
				'displayTitle' => 'Dark Souls 2 Announcement Trailer',
				'videoThumb' => '<a href="/wiki/File:Dark_Souls_2_Announcement_Trailer" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:100px;width:179px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" /></div><img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="179" height="100" data-video-name="Dark Souls 2 Announcement Trailer" data-video-key="Dark_Souls_2_Announcement_Trailer" itemprop="thumbnail" class="Wikia-video-thumb lzy lzyPlcHld" data-src="http://images.saipetch.wikia-dev.com/__cb20121210202318/video151/images/thumb/c/ca/Dark_Souls_2_Announcement_Trailer/179px-Dark_Souls_2_Announcement_Trailer.jpg" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img src="http://images.saipetch.wikia-dev.com/__cb20121210202318/video151/images/thumb/c/ca/Dark_Souls_2_Announcement_Trailer/179px-Dark_Souls_2_Announcement_Trailer.jpg" width="179" height="100" data-video-name="Dark Souls 2 Announcement Trailer" data-video-key="Dark_Souls_2_Announcement_Trailer" itemprop="thumbnail" class="Wikia-video-thumb" /></noscript></a>',
				'description' => 'Dark Souls description here...',
				'displayTitleClass' => '',
				'updatedBy' => 'Saipetch',
				'updatedAt' => '2013-09-04 00:41:00',
			),
		);

		$this->videos = $videos;
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

