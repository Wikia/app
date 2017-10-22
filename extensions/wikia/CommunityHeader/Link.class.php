<?php

namespace Wikia\CommunityHeader;

class Link {
	public $href;
	public $label;
	public $tracking;

	public function __construct( Label $label, string $href, string $tracking = '') {
		$this->label = $label;
		$this->href = $href;
		$this->tracking = $tracking;
	}
}
