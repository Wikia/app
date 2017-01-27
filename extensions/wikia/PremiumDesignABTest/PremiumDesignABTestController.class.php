<?php

class PremiumDesignABTestController extends WikiaController {

	public function header() {

	}

	public function A_header() {
		$this->headerModuleParams = [ 'showSearchBox' => false ];
	}

	public function B_header() {
		$this->headerModuleParams = [ 'showSearchBox' => false ];
	}

	public function pageheader() {

	}

	public function A_pageheader() {

	}
}
