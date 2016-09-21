<?php

/**
 * Class InsightsPagesWithoutInfoboxModel
 * A class specific to a subpage with a list of pages
 * without an infobox on them, sorted by page views.
 */
class InsightsPagesWithoutInfoboxModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'pageswithoutinfobox';

	private static $insightConfig = [
		InsightsConfig::PAGEVIEWS => true
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new PagesWithoutInfobox();
	}

	/**
	 * Get a type of a subpage only, we want a user to be directed to view.
	 * @return array
	 */
	public function getUrlParams() {
		return [];
	}

	public function isItemFixed( Title $title ) {
		return false;
	}
}
