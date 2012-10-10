<?php

class InWikiExternalFormController  extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('Play');
	}

	public function index() {
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressSpotlights = true;
	}
}


