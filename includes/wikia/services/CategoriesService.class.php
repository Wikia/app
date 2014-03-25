<?php
class CategoriesService extends Service {

	const CACHE_TTL = 3600;

	private $mBlacklist = null;
	private $mHiddenCats = null;

	public function __construct() {
	}

	/**
	 * Load blacklist from $wgBiggestCategoriesBlacklist and "categoryblacklist" message
	 *
	 * @author macbre
	 */
	private function getBlacklist() {
		global $wgBiggestCategoriesBlacklist;
		wfProfileIn(__METHOD__);

		// already loaded
		if (!is_null($this->mBlacklist)) {
			wfProfileOut(__METHOD__);
			return $this->mBlacklist;
		}

		$this->mBlacklist = array_merge(
			$wgBiggestCategoriesBlacklist,
			explode("\n", wfMsgForContent('categoryblacklist'))
		);

		// prepare list for being applied as a filter
		foreach($this->mBlacklist as &$entry) {
			$entry = str_replace( ' ', '_', trim( strtolower($entry), '* ' ) );
		}

		wfProfileOut(__METHOD__);
		return $this->mBlacklist;
	}

	/**
	 * Get list of all hidden categories
	 *
	 * @author macbre
	 */
	private function getHiddenCategories() {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		// already loaded
		if (!is_null($this->mHiddenCats)) {
			wfProfileOut(__METHOD__);
			return $this->mHiddenCats;
		}

		// try cache
		$mkey = wfMemcKey('services', 'categories', 'hidden');
		$this->mHiddenCats = $wgMemc->get($mkey);

		if (empty($this->mHiddenCats)) {
			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->select(
				array('page', 'page_props'),
				array('page_title'),
				array(
					'page_id = pp_page',
					'page_namespace' => NS_CATEGORY,
					'pp_propname' => 'hiddencat'
				),
				__METHOD__,
				[
					'LIMIT' => 666
				]
			);

			$this->mHiddenCats = array();

			while ($row = $res->fetchObject()) {
				$this->mHiddenCats[] = $row->page_title;
			}

			$wgMemc->set($mkey, $this->mHiddenCats, self::CACHE_TTL);
		}

		wfProfileOut(__METHOD__);
		return $this->mHiddenCats;
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

		$blacklist = $this->getBlacklist();

		foreach($blacklist as $entry) {
			if ( (!empty($entry)) && (strpos($category, $entry) !== false) ) {
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

		// remove "false" entries and recalculate numeric keys
		$categories = array_values( array_filter($categories) );

		wfProfileOut(__METHOD__);
		return $categories;
	}

	/**
	 * Checks whether given category is hidden
	 *
	 * @see http://meta.wikimedia.org/wiki/Help:Category#Hidden_categories
	 * @author macbre
	 */
	public function isCategoryHidden($category) {
		wfProfileIn(__METHOD__);

		$hiddenCats = $this->getHiddenCategories();

		foreach($hiddenCats as $entry) {
			if ($category == $entry) {
				wfProfileOut(__METHOD__);
				return true;
			}
		}

		wfProfileOut(__METHOD__);
		return false;
	}
}
