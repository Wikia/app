<?php

use \CommunityHeader\Wordmark;

class CommunityHeaderController extends WikiaController {

	public function init() {
	}

	public function index() {
		$this->wordmark = (new Wordmark())->getData();
	}
}
