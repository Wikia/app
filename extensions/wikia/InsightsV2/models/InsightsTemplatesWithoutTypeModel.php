<?php
/**
 * Class InsightsTemplatesWithoutTypeModel
 * A class specific to a subpage with a list of templates without type.
 */
class InsightsTemplatesWithoutTypeModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'templateswithouttype';

	private static $insightConfig = [
		InsightsConfig::WHATLINKSHERE => true
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new TemplatesWithoutTypePage();
	}

	/**
	 * Prevent adding default insight loop param as loop for this insights is not yet defined
	 * @return array
	 */
	public function getUrlParams() {
		return [];
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		// @TODO add logic once loop is added for this insight
		return false;
	}
}
