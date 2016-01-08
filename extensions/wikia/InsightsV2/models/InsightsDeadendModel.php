<?php

/**
 * Class InsightsDeadendModel
 * A class specific to a subpage with a list of pages
 * without any links to other articles.
 */
class InsightsDeadendModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'deadendpages';

	private static $insightConfig = [
		InsightsConfig::DISPLAYFIXITMSG => true,
		InsightsConfig::PAGEVIEWS => true
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new DeadendPagesPage();
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'pagelinks', '*' , [ 'pl_from' => $title->getArticleID() ] );
		if ( $row ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
