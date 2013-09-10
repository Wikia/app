<?php

class VideoPageController extends WikiaController {
	/**
	 * Display the Video Home Page
	 */
	public function index() {

	}

	public function getModule( ) {
		$name = $this->getVal('moduleName', '');
		$handler = $name.'Handler';

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

	public function handleFeatured() {

	}

	public function handleLatest() {

	}

	public function handleFan() {

	}

	public function handlePopular() {

	}
}