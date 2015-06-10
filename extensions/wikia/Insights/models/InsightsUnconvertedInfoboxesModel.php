<?php

/**
 * Class InsightsNonportableInfoboxesModel
 * A class specific to a subpage with a list of pages
 * without categories.
 */
class InsightsUnconvertedInfoboxesModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'unconvertedinfoboxes';

	public function getDataProvider() {
		return new UnconvertedInfoboxesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isWlhLinkRequired() {
		return true;
	}

	public function wlhLinkMessage() {
		return 'insights-used-on';
	}

	public function arePageViewsRequired() {
		return false;
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		return !UnconvertedInfoboxesPage::isTitleWithNonportableInfobox( $title );
	}
}
