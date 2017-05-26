<?php
namespace CommunityHeader;

class WikiButton {
	public function __construct( $href, $label, $title, $icon ) {
		$this->href = $href;
		$this->label = $label;
		$this->title = $title;
		$this->icon = $icon;
	}
}
