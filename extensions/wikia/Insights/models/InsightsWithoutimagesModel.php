<?php

/**
 * Class InsightsDeadendModel
 * A class specific to a subpage with a list of pages
 * without images.
 */
class InsightsWithoutimagesModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'withoutimages';

	public function getDataProvider() {
		return new WithoutimagesPage();
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
		$row = $dbr->selectRow( 'imagelinks', '*' , [ 'il_from' => $article->getID() ] );
		if ( $row ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $article->getTitle() );
		}
		return false;
	}
}
