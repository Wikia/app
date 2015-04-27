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
	 * @param Article $article
	 * @return bool
	 */
	public function isItemFixed( Article $article ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'pagelinks', '*' , [ 'pl_from' => $article->getID() ] );
		if ( $row ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $article->getTitle() );
		}
		return false;
	}
}
