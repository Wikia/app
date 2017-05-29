<?php

namespace CommunityHeader;

class Link {
	public function __construct( Label $label, string $href, string $tracking = '') {
		$this->label = $label;
		$this->href = $href;
		$this->tracking = $tracking;
	}
}
