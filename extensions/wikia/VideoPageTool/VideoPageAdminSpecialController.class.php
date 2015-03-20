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
		if ( !$this->getUser()->isAllowed( 'videopagetool' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->wg->SupressPageSubtitle = true;

		JSMessages::enqueuePackage( 'VideoPageTool', JSMessages::EXTERNAL );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'videopagetool-page-title' )->plain() );

		$language = $this->getVal( 'language', VideoPageToolHelper::DEFAULT_LANGUAGE );

		$this->response->addAsset( 'videopageadmin_scss' );
		$this->response->addAsset( 'videopageadmin_css' );

		$subpage = $this->getSubpage();
		if ( !empty( $subpage ) ) {
			$this->response->addAsset( 'videopageadmin_edit_js' );
			$this->forward( __CLASS__, $subpage );
			return true;
		}

		$this->response->addAsset( 'videopageadmin_dashboard_js' );
		$helper = new VideoPageToolHelper();
		$this->languages = $helper->getLanguages();
		$this->language = $language;
	}

	/**
	 * Edit program assets given a language (region), program date and page section
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

		// get program assets. VPT needs a program object for each request. It first checks if one already exists for
		// that language and date. If one doesn't, it creates a new one. It then uses that program to pull the
		// associated assets. If it's a new program, it won't have any assets yet created. To help the user, we
		// grab the assets from the the last saved program and use those as the default assets for this new program.
		$assets = $program->getAssetsBySection( $section );
		if ( empty( $assets ) ) {
			$latestProgram = VideoPageToolProgram::loadProgramNearestDate( $language, $date );
			if ( !empty( $latestProgram ) ) {
				$assets = $latestProgram->getAssetsBySection( $section );
			}
		}

		$publishDate = null;
		$publishedBy = null;
		if ( $program->isPublished() ) {
			$publishDate = $program->getPublishDate();
			$publishedBy = $program->getPublishedBy();
		} else if ( isset( $latestProgram ) && $latestProgram->isPublished() ) {
			$publishDate = $latestProgram->getPublishDate();
			$publishedBy = $latestProgram->getPublishedBy();
		}

		if ( $publishedBy ) {
			// Translate user id into username
			$publishedBy = User::newFromId( $publishedBy )->getName();
		}

		$lastSavedOn = 0;
		$savedBy = null;
		// get asset data
		$videos = array();
		if ( empty( $assets ) ) {
			// get default assets
			$videos = $helper->getDefaultValuesBySection( $section );
		} else {
			// Override defaults so we always show a lightbox in the admin pages
			$thumbOptions = [ 'noLightbox' => false ];

			// Saved on and saved by data are saved on a per asset basis, therefore it's necessary to loop through each
			// asset to make sure we're using the latest saved information.
			foreach ( $assets as $order => $asset ) {
				/** @var VideoPageToolAsset $asset */
				$videos[$order] = $asset->getAssetData( $thumbOptions );
				if ( $asset->getUpdatedAt() > $lastSavedOn ) {
					$lastSavedOn = $asset->getUpdatedAt();
					$savedBy = $asset->getUpdatedBy();
				}
			}

			$savedBy = User::newFromId( $savedBy )->getName();
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
					BannerNotificationsController::addConfirmation( $msg, BannerNotificationsController::CONFIRMATION_CONFIRM );
					$this->getContext()->getOutput()->redirect( $url );
					return false;
				}
			// save assets
			} else {
				$formValues = $this->request->getParams();
				$errMsg = '';

				// use displayTitle field to get required rows
				$requiredRows = $helper->getRequiredRows( $section, $formValues );

				$data = $program->formatFormData( $section, $requiredRows, $formValues, $errMsg );

				// Add blank records so $data is the same length as $assets.
				// This ensures the old assets are removed from DB if they were removed from the input form
				for ( $i = count( $data ) + 1; $i <= count( $assets ); $i++ ) {
					$data[$i] = [];
				}

				if ( empty( $errMsg ) ) {
					$status = $program->saveAssetsBySection( $section, $data );
					if ( $status->isGood() ) {
						$nextUrl = $helper->getNextMenuItemUrl( $leftMenuItems ).'&success=1';
						$this->getContext()->getOutput()->redirect( $nextUrl );
						return false;
					} else {
						$result = 'error';
						$msg = $status->getMessage();
					}
				} else {
					// update original asset data
					foreach ( $data as $order => $row ) {
						foreach ( $row as $name => $value ) {
							$videos[$order][$name] = $value;

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

		// add default values if the number of assets is less than number of rows that needed to be shown
		$defaultValues = array_pop( $helper->getDefaultValuesBySection( $section, 1 ) );
		for ( $i = count( $videos ) + 1; $i <= $helper->getRequiredRowsMax( $section ); $i++ ) {
			$videos[$i] = $defaultValues;
		}

		$this->result = $result;
		$this->msg = $msg;

		$this->leftMenuItems = $leftMenuItems;
		$this->moduleView = $this->app->renderView( 'VideoPageAdminSpecial', $section, array( 'videos' => $videos, 'date' => $date, 'language' => $language ) );
		$this->publishButton = ( $program->isPublishable( array_keys( $sections ) ) ) ? '' : 'disabled';
		$this->publishUrl = $this->wg->Title->getLocalURL( array('date' => $date, 'language' => $language) );
		$this->programDate = $program->getFormattedPublishDate();

		$this->section = $section;
		$this->language = $language;
		$this->lastSavedOn = $lastSavedOn;
		$this->savedBy = $savedBy;
		$this->publishDate = $publishDate;
		$this->publishedBy = $publishedBy;
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
	 * @requestParam string date [timestamp]
	 * @requestParam string language
	 * @requestParam array videos
	 * @responseParam string date [timestamp]
	 * @responseParam string language
	 * @responseParam array videos
	 */
	public function featured() {
		$this->videos = $this->getVal( 'videos', array() );
		$this->date = $this->getVal( 'date' );
		$this->language = $this->getVal( 'language' );
	}

	/**
	 * Category videos template
	 * @requestParam string date [timestamp]
	 * @requestParam string language
	 * @requestParam array video
	 * @responseParam string date [timestamp]
	 * @responseParam string language
	 * @responseParam array $categories
	 */
	public function category() {
		$this->categories = $this->getVal( 'videos', array() );
		$this->date = $this->getVal( 'date' );
		$this->language = $this->getVal( 'language' );
	}

	/**
	 * Fan videos template
	 * @requestParam string date [timestamp]
	 * @requestParam string language
	 * @requestParam array videos
	 * @responseParam string date [timestamp]
	 * @responseParam string language
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
		$this->date = $this->getVal( 'date' );
		$this->language = $this->getVal( 'language' );
	}

	/**
	 * Get video data for a featured video
	 * @requestParam string url
	 * @requestParam string altThumbKey
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam array video
	 */
	public function getFeaturedVideoData() {
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
			// Use the default thumb options from Featured Assets since that's the only type of
			// asset this controller returns.
			$thumbOptions = VideoPageToolAssetFeatured::$defaultThumbOptions;
			$thumbOptions['noLightbox'] = false;
			$helper = new VideoPageToolHelper();
			$video = $helper->getVideoData( $matches[1], $altThumbTitle, null, null, $thumbOptions );
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

	/**
	 * Get videos by category
	 * @requestParam string categoryName
	 * @responseParam string $result [ok/error]
	 * @responseParam string $msg - result message
	 * @responseParam array thumbnails - the list of videos in the category
	 * @responseParam integer total - the number of videos in the category
	 * @responseParam string url - the url of the category page
	 * @responseParam string seeMoreLabel
	 */
	public function getVideosByCategory() {
		$categoryName = $this->getVal( 'categoryName', '' );

		if ( empty( $categoryName ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-invalid-category' )->plain();
			return;
		}

		$title = Title::newFromText( $categoryName, NS_CATEGORY );
		if ( empty( $title ) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videopagetool-error-unknown-category' )->plain();
			return;
		}

		$helper = new VideoPageToolHelper();

		$this->result = 'ok';
		$this->msg = '';
		$this->thumbnails = $helper->getVideosByCategory( $title );
		$this->total = $helper->getVideosByCategoryCount( $title );
		$this->url = $title->escapeLocalURL();
		$this->seeMoreLabel = wfMessage( 'videopagetool-see-more-label' )->plain();
	}

	/*
	 * Render header
	 */

	public function header() {
		$this->language = Language::getLanguageName( $this->getVal( 'language' ) );
		$this->section = ucfirst( $this->getVal( 'section' ) );
		$this->dashboardHref = SpecialPage::getTitleFor('VideoPageAdmin')->getLocalURL();
		$this->lastSavedOn = $this->getVal( 'lastSavedOn' );
		$this->savedBy = $this->getVal( 'savedBy' );
		$this->publishDate = $this->getVal( 'publishDate' );
		$this->publishedBy = $this->getVal( 'publishedBy' );
		$this->programDate = $this->getVal( 'programDate' );
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

		// check if user is allowed
		if ( !$this->wg->User->isAllowed( 'videopagetool' ) ) {
			$errMsg = wfMessage( 'videopagetool-error-permission' )->plain();
			return false;
		}

		return true;
	}

}
