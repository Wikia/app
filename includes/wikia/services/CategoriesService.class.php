<?php
class CategoriesService extends Service {

	private $mBlacklist = null;

	public function __construct() {
		$this->loadBlacklist();
	}

	/**
	 * Load blacklist from $wgBiggestCategoriesBlacklist and "categoryblacklist" message
	 *
	 * @author macbre
	 */
	private function loadBlacklist() {
		global $wgBiggestCategoriesBlacklist;
		wfProfileIn(__METHOD__);

		$this->mBlacklist = array_merge(
			$wgBiggestCategoriesBlacklist,
			explode("\n", wfMsgForContent('categoryblacklist'))
		);

		// prepare list for being applied as a filter
		foreach($this->mBlacklist as &$entry) {
			$entry = str_replace( ' ', '_', trim( strtolower($entry), '* ' ) );
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Checks whether given category is on blacklist
	 *
	 * @author macbre
	 */
	public function isCategoryBlacklisted($category) {
		wfProfileIn(__METHOD__);

		// perfrom case insensitive check
		$category = strtolower($category);

		foreach($this->mBlacklist as $entry) {
			if (strpos($category, $entry) !== false) {
				wfProfileOut(__METHOD__);
				return true;
			}
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 * Helper method for filtering out blacklisted categories from provided list of categories
	 *
	 * @author macbre
	 */
	public static function filterOutBlacklistedCategories($categories) {
		wfProfileIn(__METHOD__);

		$service = new self();

		foreach($categories as &$category) {
			if ($service->isCategoryBlacklisted($category)) {
				$category = false;
			}
		}

		// remove "false" entries
		$categories = array_filter($categories);

		wfProfileOut(__METHOD__);
		return $categories;
	}
}
