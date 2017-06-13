<?php

namespace Wikia\CommunityHeader;

class WikiButton {
	public $href;
	public $icon;
	public $label;
	public $title;
	public $tracking;

	public function __construct( $href, $label, $title, $icon, $tracking ) {
		$this->href = $href;
		$this->label = $label;
		$this->title = $title;
		$this->icon = $icon;
		$this->tracking = $tracking;
	}
}
