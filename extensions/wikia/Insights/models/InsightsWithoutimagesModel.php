<?php

class InsightsWithoutimagesModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'withoutimages';

	public function getDataProvider() {
		return new WithoutimagesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isItemFixed( Title $title ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'imagelinks', '*' , [ 'il_from' => $title->getArticleID() ] );
		if ( $row ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
