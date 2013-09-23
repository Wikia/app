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
	 */
	public function index() {
		$this->response->addAsset('videohomepage_js');
		$this->response->addAsset('videohomepage_scss');

		$program = $this->getProgram();

		$this->curProgram = $program;

		if ( $program instanceof VideoPageToolProgram && $program->exists() ) {
			$this->haveCurrentProgram = true;
			$this->featuredContent = $this->sendSelfRequest('handleFeatured');
			$this->categoryContent = $this->sendSelfRequest('handleCategory');
			$this->fanContent = $this->sendSelfRequest('handleFan');
			$this->popularContent = $this->sendSelfRequest('handlePopular');
		} else {
			$this->haveCurrentProgram = false;
		}

		$this->partners = $this->buildPartnerCategoryUrls();
	}

	/**
	 * @description Builds slug and localized URLs for each of our partner category pages
	 * @return array
	 */
	public function buildPartnerCategoryUrls() {
		$partners = array();
		// keys are lowercase as they are used to compose CSS & i18n keys
		$partners[ 'anyclip' ] = array( 'label' => 'AnyClip' );
		$partners[ 'ign' ] = array( 'label' => 'IGN' );
		$partners[ 'iva' ] = array( 'label' => 'IVA' );
		$partners[ 'screenplay' ] = array( 'label' => 'Screenplay' );
		$partners[ 'ooyala' ] = array( 'label' => 'Ooyala' );
		$partners[ 'realgravity' ] = array( 'label' => 'RealGravity' );

		// get localized namespace
		$catNamespaceString = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );

		foreach( $partners as &$partner ) {
			$partner['url'] = Title::newFromText( $catNamespaceString . ':' . $partner['label'] )->getFullUrl();
		}

		// sort by keys, views need to be alphabetized
		ksort($partners);

		return $partners;
	}

	/**
	 * Return display content for any of the supported modules, one of:
	 *
	 *  - featured
	 *  - category
	 *  - fan
	 *  - popular
	 *
	 * Example controller request:
	 *
	 *   /wikia.php?controller=VideoHomePageController&method=getModule&moduleName=category
	 *
	 * @requestParam moduleName - The name of the module to display
	 * @return bool
	 */
	public function getModule( ) {
		$name = $this->getVal('moduleName', '');
		$handler = 'handle'.ucfirst(strtolower($name));

		if ( method_exists( __CLASS__, $handler ) ) {
			$this->forward( __CLASS__, $handler );
			return true;
		} else {
			$this->html = '';
			$this->result = 'error';
			$this->msg = wfMessage('videopagetool-error-invalid-module')->plain();
			return false;
		}
	}

	/**
	 * Displays the featured module
	 */
	public function handleFeatured() {
		$this->overrideTemplate( self::MODULE_FEATURED );
		$program = $this->getProgram();

		if ( $program ) {
			$this->assets = $program->getAssetsBySection( self::MODULE_FEATURED );
		} else {
			// Set an empty array for the template if there isn't a program
			$this->assets = array();
		}
	}

	/**
	 * Displays the category module
	 */
	public function handleCategory() {
		$this->overrideTemplate( self::MODULE_CATEGORY );
		$program = $this->getProgram();

		if ( $program ) {
			$this->assets = $program->getAssetsBySection( self::MODULE_CATEGORY );
		} else {
			// Set an empty array for the template if there isn't a program
			$this->assets = array();
		}
	}

	/**
	 * Displays the fan module
	 */
	public function handleFan() {
		$this->overrideTemplate( self::MODULE_FAN );
		$program = $this->getProgram();

		if ( $program ) {
			$this->assets = $program->getAssetsBySection( self::MODULE_FAN );
		} else {
			// Set an empty array for the template if there isn't a program
			$this->assets = array();
		}
	}

	/**
	 * Displays the popular module
	 */
	public function handlePopular() {
		$this->overrideTemplate( self::MODULE_POPULAR );

	}
}
