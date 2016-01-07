<?php
/**
 * Class InsightsPopularPagesModel
 * A class specific to a subpage with a list of most visited pages on the wikia
 */
class InsightsPopularPagesModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'popularpages';

	private static $insightConfig = [
		'displayFixItMessage' => false
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new PopularPages();
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
