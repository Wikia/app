<?php
/**
 * Class VideoHomePageController
 */

class VideoHomePageController extends WikiaController {

	var $program;

	/**
	 * Get the current program object or load it if it hasn't been loaded yet
	 * @return object
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
		$this->response->addAsset('videohomepage_scss');
		$program = $this->getProgram();

		$this->curProgram = $program;

		if ( $program->exists() ) {
			$this->haveCurrentProgram = true;
			$this->featuredContent = $this->sendSelfRequest('handleFeatured');
			$this->categoryContent = $this->sendSelfRequest('handleCategory');
			$this->fanContent = $this->sendSelfRequest('handleFan');
			$this->popularContent = $this->sendSelfRequest('handlePopular');
		} else {
			$this->haveCurrentProgram = false;
		}
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
		$this->overrideTemplate( 'featured' );
		$program = $this->getProgram();

		$this->assets = $program->getAssetsBySection( 'featured' );
	}

	/**
	 * Displays the category module
	 */
	public function handleCategory() {
		$this->overrideTemplate( 'category' );
		$program = $this->getProgram();

		$this->assets = $program->getAssetsBySection( 'category' );
	}

	/**
	 * Displays the fan module
	 */
	public function handleFan() {
		$this->overrideTemplate( 'fan' );
		$program = $this->getProgram();

		$this->assets = $program->getAssetsBySection( 'fan' );
	}

	/**
	 * Displays the popular module
	 */
	public function handlePopular() {
		$this->overrideTemplate( 'popular' );

	}
}
