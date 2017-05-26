<?php

use \CommunityHeader\Sitename;
use \CommunityHeader\Wordmark;

class CommunityHeaderController extends WikiaController {

	public function init() {
	}

	public function index() {
		$this->sitename = new Sitename();
		$this->wordmark = new Wordmark();
	}
}
