<?php

class InsightsDeadendModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'Deadendpages';

	public function getDataProvider() {
		return new DeadendPagesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isItemFixed( Article $article ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'pagelinks', '*' , [ 'pl_from' => $article->getID() ] );
		if ( $row ) {
			return $this->removeFixedItem( self::INSIGHT_TYPE, $article->getTitle() );
		}
		return false;
	}
}
