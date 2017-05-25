<?php

namespace Wikia\Tasks\Tasks;

class CategoryRefreshCountsTask extends BaseTask {

	/**
	 * Refresh the counts for a given category
	 *
	 * An offline version of Category::refreshCounts
	 *
	 * @see SUS-2050
	 *
	 * @param string $categoryName
	 * @return bool
	 */
	public function refresh( string $categoryName ) {
		$category = \Category::newFromName( $categoryName );
		return $category->refreshCounts();
	}

}
