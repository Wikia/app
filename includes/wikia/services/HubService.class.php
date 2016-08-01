<?php

class HubService extends Service {

	private static $comscore_prefix = 'comscore_';

	protected static $canonicalCategoryNames = [
		WikiFactoryHub::CATEGORY_ID_GAMING => 'Games',
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'Entertainment',
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'Lifestyle',
		WikiFactoryHub::CATEGORY_ID_CORPORATE => 'Wikia',
	];

	/**
	 * Given category id (from Wiki Factor or from configuration variable)
	 * return one of selected category ids:
	 *
	 *   WikiFactoryHub::CATEGORY_ID_GAMING,
	 *   WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
	 *   WikiFactoryHub::CATEGORY_ID_LIFESTYLE or
	 *   WikiFactoryHub::CATEGORY_ID_CORPORATE
	 *
	 * @param integer $categoryId category id
	 *
	 * @return integer
	 */
	public static function getCanonicalCategoryId( $categoryId ) {
		// Some simplification of data coming from database
		switch ( $categoryId ) {
			// Valid categories:
			case WikiFactoryHub::CATEGORY_ID_GAMING:
			case WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT:
			case WikiFactoryHub::CATEGORY_ID_LIFESTYLE:
			case WikiFactoryHub::CATEGORY_ID_CORPORATE:
				return $categoryId;

			// Music mark as entertainment:
			case WikiFactoryHub::CATEGORY_ID_MUSIC:
				return WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT;

			// Every other category as lifestyle
			default:
				return WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
		}
	}

	/**
	 * Get current wikia's Cannonical Category name
	 *
	 * @return string current Cannonical Category's Name
	 */
	public static function getCurrentWikiaVerticalName() {
		global $wgCityId;

		if ( empty( $wgCityId ) ) {
			return '';
		}

		$categoryId = WikiFactoryHub::getInstance()->getCategoryId( $wgCityId );

		return empty( $categoryId )
			? ''
			: self::$canonicalCategoryNames[self::getCanonicalCategoryId( $categoryId )];
	}

	/**
	 * Get comscore vertical name for given cityId.
	 * For Lifestyle and Gaming and etc return their names.
	 * For Other return 'lifestyle'.
	 *
	 * @param integer $cityId
	 *
	 * @return string
	 */
	public static function getVerticalNameForComscore( $cityId ) {

		$vertical = WikiFactoryHub::getInstance()->getWikiVertical( $cityId )['short'];

		if ( $vertical == "other" ) {
			return "lifestyle";
		} else {
			return $vertical;
		}
	}

	/**
	 * Look for a comscore_zzz tag
	 * @param integer $cityId
	 * @return hash of category data { id, name, url, short, deprecated, active }
	 */
	public static function getComscoreCategoryOverride( $cityId ) {

		$wftags = new WikiFactoryTags( $cityId );
		$tags = $wftags->getTags();
		if ( is_array( $tags ) ) {
			foreach ( $tags as $name ) {
				if ( startsWith( $name, self::$comscore_prefix, false ) ) {
					$catName = substr( $name, strlen( self::$comscore_prefix ) );
					return $catName;
				}
			}
		}
		return null;
	}

	/**
	 * Get category info for given cityId
	 *
	 * @param integer $cityId
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getCategoryInfoForCity( $cityId ) {
		return self::constructCategoryInfoFromCategoryId( self::getCategoryIdForCity( $cityId ) );
	}

	/**
	 * Get category info for current page
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getCategoryInfoForCurrentPage() {
		$cityId = F::app()->wg->CityId;
		$categoryId = self::getCategoryIdForCity( $cityId );

		return self::constructCategoryInfoFromCategoryId( $categoryId );
	}

	/**
	 * Get legacy category id for given cityId
	 * An Ad Tag in WF with a value of comscore_(category) will override this
	 *
	 * @param integer $cityId
	 *
	 * @return integer $categoryId
	 */
	private static function getCategoryIdForCity( $cityId ) {
		$categoryId = null;

		// Warning: this returns the "legacy" category_id only
		$category = WikiFactory::getCategory( $cityId );
		if ( $category ) {
			$categoryId = $category->cat_id;
		}

		// Check for a tag named comscore_foo and use that if "foo" exists as a category
		// Some comscore tags don't match up with the old categories, but if it does, use the override
		$comscoreCategoryOverride = HubService::getComscoreCategoryOverride ( $cityId );
		if ( $comscoreCategoryOverride ) {
			$category = WikiFactoryHub::getInstance()->getCategoryByName( $comscoreCategoryOverride );
			if ( $category ) {
				$categoryId = $comscoreCategoryOverride['id'];
			}
		}

		return $categoryId;
	}

	private static function constructCategoryInfoFromCategoryId( $categoryId ) {
		// Default fall-through value is "lifestyle", which probably isn't correct in many cases
		$categoryId = self::getCanonicalCategoryId( $categoryId );
		$categoryRow = WikiFactoryHub::getInstance()->getCategory( $categoryId );
		$categoryInfo = new stdClass();
		$categoryInfo->cat_id = $categoryId;
		$categoryInfo->cat_name = $categoryRow['name'];

		return $categoryInfo;
	}

}
