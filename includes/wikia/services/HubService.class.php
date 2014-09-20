<?php

class HubService extends Service {
	private static $comscore_prefix = 'comscore_';

	protected static $canonicalCategoryNames = [
		WikiFactoryHub::CATEGORY_ID_GAMING        => 'Games',
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'Entertainment',
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE     => 'Lifestyle',
		WikiFactoryHub::CATEGORY_ID_CORPORATE     => 'Wikia',
	];

	/**
	 * Get proper category to report to Comscore for given cityId
	 * (wgTitle GLOBAL will be used in case the city is corporate wiki)
	 *
	 * @deprecated use getCategoryInfoForCity or getCategoryInfoForCurrentPage instead
	 *
	 * @param int $cityId The wiki ID
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getComscoreCategory($cityId) {
		if( WikiaPageType::isCorporatePage() && $cityId == F::app()->wg->CityId ) {
			// Page-level hub-related vertical checking only works locally
			return self::getCategoryInfoForCurrentPage();
		}
		return self::getCategoryInfoForCity($cityId);
	}

	/**
	 * Given category id (from Wiki Factor or from configuration variable)
	 * return one of selected category ids:
	 *
	 *   WikiFactoryHub::CATEGORY_ID_GAMING,
	 *   WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
	 *   WikiFactoryHub::CATEGORY_ID_LIFESTYLE or
	 *   WikiFactoryHub::CATEGORY_ID_CORPORATE
	 *
	 * @param int $categoryId category id
	 *
	 * @return int
	 */
	public static function getCanonicalCategoryId($categoryId) {
		// Some simplification of data coming from database
		switch ($categoryId) {
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
		return !empty( $categoryId )
			? self::$canonicalCategoryNames[ self::getCanonicalCategoryId( $categoryId ) ]
			: '' ;
	}

	/**
	 * Get category info for given cityId
	 *
	 * @param int $city_id city id
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getCategoryInfoForCity($cityId) {
		return self::constructCategoryInfoFromCategoryId( self::getCategoryIdForCity( $cityId ) );
	}

	/**
	 * Get category info for current page
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getCategoryInfoForCurrentPage() {
		$cityId = F::app()->wg->CityId;

		$categoryId = self::getCategoryIdForCity($cityId);

		return self::constructCategoryInfoFromCategoryId($categoryId);
	}

	/**
	 * Get category id for given cityId
	 *
	 * @param int $city_id city id
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	private static function getCategoryIdForCity($cityId) {
		$categoryId = null;

		if( WikiaPageType::isWikiaHomePage() && $cityId == F::app()->wg->CityId ) {
			$categoryId = WikiFactoryHub::CATEGORY_ID_CORPORATE;
		} else {
			$category = WikiFactory::getCategory($cityId);
			if ($category) {
				$categoryId = $category->cat_id;
			}
		}

		// Look for Comscore tag
		$wftags = new WikiFactoryTags($cityId);
		$tags = $wftags->getTags();
		if (is_array($tags)) {
			foreach ($tags as $name) {
				if (startsWith($name, self::$comscore_prefix, false)) {
					$catName = substr($name, strlen(self::$comscore_prefix));
					$category = WikiFactoryHub::getInstance()->getCategoryByName($catName);
					if ($category) {
						return $category['id'];
					}
				}
			}
		}

		return $categoryId;
	}

	private static function constructCategoryInfoFromCategoryId($categoryId) {
		$categoryId = self::getCanonicalCategoryId($categoryId);
		$categoryRow = WikiFactoryHub::getInstance()->getCategory($categoryId);
		$categoryInfo = new stdClass();
		$categoryInfo->cat_id = $categoryId;
		$categoryInfo->cat_name = $categoryRow['name'];
		return $categoryInfo;
	}

}
