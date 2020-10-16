<?php

namespace Wikia\CommunityHeader;

class Link {
	public $href;
	public $label;
	public $tracking;
	public $items;

	public function __construct( Label $label, string $href, string $tracking = '', array $items = []) {
		$this->label = $label;
		$this->href = $href;
		$this->tracking = $tracking;
		$this->items = $items;
	}
}
