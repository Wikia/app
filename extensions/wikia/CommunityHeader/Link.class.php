<?php

namespace CommunityHeader;

class Link {
	public function __construct(Label $label, String $href) {
		$this->label = $label;
		$this->href = $href;
	}
}
