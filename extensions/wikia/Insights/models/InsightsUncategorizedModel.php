<?php

/**
 * Class InsightsUncategorizedModel
 * A class specific to a subpage with a list of pages
 * without categories.
 */
class InsightsUncategorizedModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'uncategorizedpages';

	public function getDataProvider() {
		return new UncategorizedPagesPage();
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
		$categories = $title->getParentCategories( true );
		if ( !empty( $categories ) ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
