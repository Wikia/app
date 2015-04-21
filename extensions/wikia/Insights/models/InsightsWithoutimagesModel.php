<?php

class InsightsWithoutimagesModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'Withoutimages';

	public function getDataProvider() {
		return new WithoutimagesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isItemFixed( Article $article ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'imagelinks', '*' , [ 'il_from' => $article->getID() ] );
		if ( $row ) {
			return $this->removeFixedItem( self::INSIGHT_TYPE, $article->getTitle() );
		}
		return false;
	}
}
