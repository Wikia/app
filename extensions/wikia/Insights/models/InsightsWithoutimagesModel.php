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
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'imagelinks', '*' , [ 'il_from' => $title->getArticleID() ] );
		if ( $row ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
