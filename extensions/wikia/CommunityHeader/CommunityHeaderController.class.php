<?php

use \CommunityHeader\Sitename;
use \CommunityHeader\Wordmark;
use \CommunityHeader\Counter;
use \CommunityHeader\WikiButtons;
use \CommunityHeader\Navigation;

class CommunityHeaderController extends WikiaController {

	public function init() {
	}

	public function index() {
		$this->sitename = new Sitename();
		$this->wordmark = new Wordmark();
		$this->counter = new Counter();
		$this->wikiButtons = new WikiButtons();
		$this->navigation = new Navigation();
	}
}
