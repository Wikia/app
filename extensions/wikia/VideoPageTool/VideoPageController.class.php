<?php

class VideoPageController extends WikiaController {
	/**
	 * Display the Video Home Page
	 */
	public function index() {
		$this->response->addAsset('videohomepage_scss');
		$this->response->addAsset('videohomepage_js');
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
	 *   /wikia.php?controller=VideoPageController&method=getModule&moduleName=category
	 *
	 * @requestParam moduleName - The name of the module to display
	 * @return bool
	 */
	public function getModule( ) {
		$name = $this->getVal('moduleName', '');
		$handler = 'handle'.ucfirst(strtolower($name));

		if ( method_exists( __CLASS__, $handler ) ) {
			$this->overrideTemplate( $name );
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

	}

	/**
	 * Displays the category module
	 */
	public function handleCategory() {

	}

	/**
	 * Displays the fan module
	 */
	public function handleFan() {

	}

	/**
	 * Displays the popular module
	 */
	public function handlePopular() {

	}
}
