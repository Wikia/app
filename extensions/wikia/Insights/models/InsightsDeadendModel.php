<?php

/**
 * Class InsightsDeadendModel
 * A class specific to a subpage with a list of pages
 * without any links to other articles.
 */
class InsightsDeadendModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'deadendpages';

	public function getDataProvider() {
		return new DeadendPagesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
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
