<?php
/**
 * Class VideoHomePageController
 */

class VideoHomePageController extends WikiaController {

	// Constants to represent some commonly used module descriptors
	const MODULE_FEATURED = 'featured';
	const MODULE_CATEGORY = 'category';
	const MODULE_POPULAR  = 'popular';
	const MODULE_FAN      = 'fan';

	var $program;

	/**
	 * Get the current program object or load it if it hasn't been loaded yet
	 * @return VideoPageToolProgram
	 */
	public function getProgram() {
		if ( !$this->program ) {
			$lang = F::App()->wg->LanguageCode;

			$this->program = VideoPageToolProgram::newProgramNearestToday( $lang );
		}

		return $this->program;
	}

	/**
	 * Display the Video Home Page
	 * @responseParam boolean haveProgram
	 * @responseParam string featuredContent
	 * @responseParam string categoryContent
	 * @responseParam string fanContent
	 * @responseParam string popularContent
	 */
	public function index() {
		OasisController::addBodyClass( 'WikiaVideo' );
		$this->response->addAsset( 'videohomepage_js' );
		$this->response->addAsset( 'videohomepage_scss' );

		$program = $this->getProgram();
		if ( $program instanceof VideoPageToolProgram && $program->exists() ) {
			$this->haveProgram = true;
			$this->featuredContent = $this->app->renderView( 'VideoHomePage', 'featured' );
//			$this->categoryContent = $this->app->renderView( 'VideoHomePage', 'category' );
//			$this->fanContent = $this->app->renderView( 'VideoHomePage', 'fan' );
//			$this->popularContent = $this->app->renderView( 'VideoHomePage', 'popular' );
		} else {
			$this->haveProgram = false;
		}
	}

	/**
	 * @description Builds slug and localized URLs for each of our partner category pages
	 * @responseParam array $partners
	 */
	public function partners() {
		$partners = array();
		// keys are lowercase as they are used to compose CSS & i18n keys
		$partners[ 'anyclip' ] = array( 'label' => 'AnyClip' );
		$partners[ 'ign' ] = array( 'label' => 'IGN' );
		$partners[ 'iva' ] = array( 'label' => 'IVA' );
		$partners[ 'screenplay' ] = array( 'label' => 'Screenplay' );
		$partners[ 'ooyala' ] = array( 'label' => 'Ooyala' );
		$partners[ 'realgravity' ] = array( 'label' => 'RealGravity' );

		foreach( $partners as &$partner ) {
			$partner['url'] = GlobalTitle::newFromText( $partner['label'], NS_CATEGORY, VideoHandlerHooks::VIDEO_WIKI )->getFullUrl();
		}

		// sort by keys, views need to be alphabetized
		ksort( $partners );

		$this->partners = $partners;
	}

	/**
	 * Displays the featured module
	 * @responseParam array $assets
	 */
	public function featured() {
		$helper = new VideoPageToolHelper();
		$this->assets = $helper->renderAssetsBySection( $this->getProgram(), self::MODULE_FEATURED );
	}

	/**
	 * Displays the category module
	 * @responseParam array $assets
	 */
	public function category() {
		$helper = new VideoPageToolHelper();
		$this->assets = $helper->renderAssetsBySection( $this->getProgram(), self::MODULE_CATEGORY );
	}

	/**
	 * Displays the fan module
	 * @responseParam array $assets
	 */
	public function fan() {
		$helper = new VideoPageToolHelper();
		$this->assets = $helper->renderAssetsBySection( $this->getProgram(), self::MODULE_FAN );
	}

	/**
	 * Displays the popular module
	 * @responseParam array $assets
	 */
	public function popular() {
		$this->assets = array();
	}

}
