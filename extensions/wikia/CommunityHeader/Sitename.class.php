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
		// SUS-2975: Site name is user input, so it comes pre-escaped.
		// We must decode HTML entities present in the text to avoid double escaping.
		$siteName = Sanitizer::decodeCharReferences( $sitenameData['title']['value'] );

		$this->titleText = new Label( $siteName );
		$this->url = $sitenameData['href'];
		$this->trackingLabel = $sitenameData['tracking_label'];
	}
}
