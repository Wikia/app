<?php

class InsightsUncategorizedModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'uncategorizedpages';

	public function getDataProvider() {
		return new UncategorizedPagesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isItemFixed( Title $title ) {
		$categories = $title->getParentCategories( true );
		if ( !empty( $categories ) ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
