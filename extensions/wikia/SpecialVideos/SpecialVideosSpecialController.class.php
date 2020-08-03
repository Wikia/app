<?php

/**
 * SpecialVideos
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Videos', '', false );
	}

	/**
	 * Videos page
	 * @requestParam integer page - page number
	 * @requestParam string category
	 * @requestParam string msg - BannerNotifications message
	 * @requestParam string msgTitle - for BannerNotifications
	 * @requestParam string provider
	 * @responseParam integer addVideo [0/1]
	 * @responseParam string pagination
	 * @responseParam string loadMore (For mobile only)
	 * @responseParam array videos - list of videos
	 * @responseParam string message
	 */
	public function index() {
		$this->wg->SuppressPageSubtitle = true;

		$this->response->addAsset( 'special_videos_js' );
		$this->response->addAsset( 'special_videos_css' );

		// enqueue i18n message for javascript
		JSMessages::enqueuePackage( 'SpecialVideos', JSMessages::INLINE );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'specialvideos-page-title' )->text() );
		$this->getContext()->getOutput()->setHTMLTitle( wfMessage( 'specialvideos-html-title' )->text() );

		// For search engines
		$this->getContext()->getOutput()->setRobotPolicy( "index,follow" );

		$helper = new SpecialVideosHelper();

		// Add meta description tag to HTML source
		$this->getContext()->getOutput()->addMeta( 'description', $helper->getMetaTagDescription() );

		$page = $this->request->getInt( 'page', 1 );
		$category = $this->request->getVal( 'category', '' );
		// Filter on a comma separated list of providers if given.
		$providers = $this->request->getVal( 'provider', '' );

		// Add BannerNotifications message after adding a new video.
		// We can abstract this later if we want to add more types of messages
		$msg = $this->request->getVal( 'msg', '' );

		if ( !empty( $msg ) ) {
			$msgTitle = $this->request->getVal( 'msgTitle', '' );
			$msgTitle = urldecode( $msgTitle );

			BannerNotificationsController::addConfirmation(
				wfMessage( $msg, $msgTitle )->parse(),
				BannerNotificationsController::CONFIRMATION_CONFIRM
			);
		}

		if ( !is_numeric($page) ) {
			$page = 1;
		}

		// Variable to display the "add video" link at the end of the results
		$addVideo = 1;

		// get videos
		$helper = new SpecialVideosHelper();
		$videos = $helper->getVideos( $page, $providers, $category, [
			'getThumbnail' => true
		] );

		$message = '';
		$pagination = $helper->getPagination( [
			'page' => $page,
			'category' => $category,
			'provider' => $providers
		], $addVideo );
		$paginationBar = $pagination[ 'body' ];
		$this->wg->Out->addHeadItem( 'Pagination', $pagination[ 'head' ] );

		$this->addVideo = $addVideo;
		$this->pagination = $paginationBar;
		$this->videos = $videos;
		$this->message = $message;

		// permission checking for video removal
		$this->isRemovalAllowed = ( $this->wg->User->isAllowed( 'specialvideosdelete' ) && $this->app->checkSkin( 'oasis' ) );

		/*
		 * Check to see if user is part of videoupload
		 * For the purpose of hiding the appropriate UI elements
		 * Current elements affected: last page of results in Special:Videos
		 */
		$this->showAddVideoBtn = $this->wg->User->isAllowed( 'videoupload' );
	}

	/**
	 * Get videos
	 * @requestParam integer page - page number
	 * @requestParam string category
	 * @requestParam string provider
	 * @responseParam array videos - list of videos
	 */
	public function getVideos() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$page = $this->request->getInt( 'page', 1 );
		$category = $this->request->getVal( 'category', '' );
		$providers = $this->request->getVal( 'provider', '' );
		$getThumbnail = $this->request->getVal( 'getThumbnail', true );

		$options = ['getThumbnail'=> $getThumbnail ];

		$helper = new SpecialVideosHelper();
		$videos = $helper->getVideos( $page, $providers, $category, $options );

		$this->videos = $videos;
	}

}

