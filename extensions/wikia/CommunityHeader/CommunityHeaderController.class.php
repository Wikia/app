<?php

use \CommunityHeader\Sitename;
use \CommunityHeader\Wordmark;
use \CommunityHeader\Counter;
use \CommunityHeader\WikiButton;
use \CommunityHeader\Label;

class CommunityHeaderController extends WikiaController {

	public function init() {
	}

	public function index() {
		$this->sitename = new Sitename();
		$this->wordmark = new Wordmark();
		$this->counter = new Counter();
		$this->wikiButtons = [
			// fixme content of this array should be defined in another class
			new WikiButton('/wiki/Special:CreatePage', new Label('community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT), null, 'wds-icons-add-new-page-small')
		];
	}
}
