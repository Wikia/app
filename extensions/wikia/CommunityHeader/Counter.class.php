<?php

namespace Wikia\CommunityHeader;

use DesignSystemCommunityHeaderModel;

class Counter {
	public $label;
	public $value;
	public $trackingLabel = 'counter';

	public function __construct( DesignSystemCommunityHeaderModel $model ) {
		$counterModel = $model->getArticlesCounter();
		$this->value =  $counterModel['value'];
		$this->label = new Label( $counterModel['label']['key'], $counterModel['label']['type'] );
	}
}
