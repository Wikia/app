<?php

/**
 * Class InsightsWantedpagesModel
 * A class specific to a subpage with a list of pages
 * that do not exist and have been referred to.
 */
class InsightsWantedpagesModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'wantedpages';

	private static $insightConfig = [
		InsightsConfig::DISPLAYFIXITMSG => true,
		InsightsConfig::WHATLINKSHERE => true,
		InsightsConfig::WHATLINKSHEREMSG => 'insights-wanted-by'
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		if( $title->getArticleID() !== 0 ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
