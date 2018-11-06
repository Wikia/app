<?php

/**
 * Fetches all pages which in the "Grand Exchange" with
 * a namespace of 112
 * Class GrandExchangePageFetcher
 */
class GrandExchangePageFetcher {

	const CATEGORY_NAME = "Grand Exchange";

	const RUNESCAPE_CITY_ID = 304;
	const OLDSCHOOL_RUNESCAPE_CITY_ID = 691244;

	const RUNESCAPE_NS_FILTER = 112;
	const OLDSCHOOL_RUNESCAPE_NS_FILTER = 114;

	/**
	 * @return array
	 * @throws Exception
	 */
	public function fetchAllGrandExchangePages() {
		$pages = [];
		$category = Category::newFromName( self::CATEGORY_NAME );
		$namespaceFilter = $this->getNameSpaceFilter();

		/** @var Title $page */
		foreach ( $category->getMembers() as $page ) {
			if ( $page->getNamespace() === $namespaceFilter ) {
				$pages[] = $page->getText();
			}
		}

		return $pages;
	}

	/**
	 * Item pages which need updating are found in different namespaces on the runescape
	 * and oldschoolrunescape wikis. Determine which namespace we should filter on based
	 * on which wiki we're running
	 * @return int
	 * @throws Exception
	 */
	private function getNameSpaceFilter() {
		global $wgCityId;

		if ( (int) $wgCityId === self::RUNESCAPE_CITY_ID ) {
			return self::RUNESCAPE_NS_FILTER;
		}

		if ( (int) $wgCityId === self::OLDSCHOOL_RUNESCAPE_CITY_ID ) {
			return self::OLDSCHOOL_RUNESCAPE_NS_FILTER;
		}

		throw new Exception( "this should only be run on a runescape wiki!" );
	}
}
