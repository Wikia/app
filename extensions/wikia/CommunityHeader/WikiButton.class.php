<?php

namespace Wikia\CommunityHeader;

class WikiButton {
	public function __construct( $href, $label, $title, $icon, $tracking ) {
		$this->href = $href;
		$this->label = $label;
		$this->title = $title;
		$this->icon = $icon;
		$this->tracking = $tracking;
	}
}
