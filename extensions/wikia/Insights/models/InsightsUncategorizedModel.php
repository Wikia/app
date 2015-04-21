<?php

class InsightsUncategorizedModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'Uncategorizedpages';

	public function getDataProvider() {
		return new UncategorizedPagesPage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isItemFixed( Article $article ) {
		$title = $article->getTitle();
		$categories = $title->getParentCategories( true );
		if ( !empty( $categories ) ) {
			return $this->removeFixedItem( self::INSIGHT_TYPE, $title );
		}
		return false;
	}
}
