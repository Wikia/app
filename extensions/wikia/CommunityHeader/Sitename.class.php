<?php

namespace Wikia\CommunityHeader;

use DesignSystemCommunityHeaderModel;
use Sanitizer;

class Sitename {
	public $titleText;
	public $url;
	public $trackingLabel;

	public function __construct( DesignSystemCommunityHeaderModel $model ) {
		$sitenameData = $model->getSiteNameData();

		$this->titleText = new Label( $sitenameData['title']['value'] );
		$this->url = $sitenameData['href'];
		$this->trackingLabel = $sitenameData['tracking_label'];
	}
}
