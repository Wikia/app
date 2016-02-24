<?php

/**
 * Class InsightsPagesWithoutInfoboxModel
 * A class specific to a subpage with a list of pages
 * without an infobox on them, sorted by page views.
 */
class InsightsPagesWithoutInfoboxModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'pageswithoutinfobox';

	public $loopNotificationConfig = [
		'displayFixItMessage' => false,
	];

	public function getDataProvider() {
		return new PagesWithoutInfobox();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function arePageViewsRequired() {
		return true;
	}

	/**
	 * Get a type of a subpage only, we want a user to be directed to view.
	 * @return array
	 */
	public function getUrlParams() {
		return [];
	}

	public function hasAltAction() {
		return false;
	}

	public function isItemFixed( Title $title ) {
		return false;
	}
}
