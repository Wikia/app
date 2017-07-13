<?php

namespace Wikia\CommunityHeader;

use \DesignSystemCommunityHeaderModel;

class Sitename {
	public $titleText;
	public $url;
	public $tracking_label;

	public function __construct( DesignSystemCommunityHeaderModel $model) {
		$sitenameData = $model->getSiteNameData();

		$this->titleText = new Label($sitenameData['title']['value'] );
		$this->url = $sitenameData['href'];
		$this->tracking_label = $sitenameData['tracking_label'];
	}
}
