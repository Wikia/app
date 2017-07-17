<?php

namespace Wikia\CommunityHeader;

use \SiteStats;

class Counter {
	public $label;
	public $value;
	public $trackingLabel = 'counter';

	public function __construct() {
		$value = SiteStats::articles();
		$this->value =  \RequestContext::getMain()->getLanguage()->formatNum( $value );

		if( $value === 1 ) {
			$labelKey = 'community-header-page';
		} else {
			$labelKey = 'community-header-pages';
		}
		$this->label = new Label( $labelKey, Label::TYPE_TRANSLATABLE_TEXT );
	}
}
