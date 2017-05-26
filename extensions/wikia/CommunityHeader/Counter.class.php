<?php
namespace CommunityHeader;

use \SiteStats;

class Counter {
	public function __construct() {
		$this->value = SiteStats::articles();
		$this->label = new Label( 'community-header-pages', Label::TYPE_TRANSLATABLE_TEXT );
	}
}
