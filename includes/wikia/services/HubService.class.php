<?php

class HubService extends Service {
	private static $comscore_prefix = 'comscore_';

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
		if( self::isCorporatePage() && $cityId == F::app()->wg->CityId ) {
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
	 * Get category info for given cityId
	 *
	 * @param int $city_id city id
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getCategoryInfoForCity($cityId) {
		return self::constructCategoryInfoFromCategoryId(self::getCategoryIdForCity($cityId));
	}

	/**
	 * Get category info for current page
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getCategoryInfoForCurrentPage() {
		$cityId = F::app()->wg->CityId;

		$categoryId = null;

		if( self::isCorporatePage() ) {
			$categoryId = self::getHubIdForCurrentPage();
		}

		if( empty($categoryId) ) {
			$categoryId = self::getCategoryIdForCity($cityId);
		}

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

		if( self::isCorporatePage() && $cityId == F::app()->wg->CityId ) {
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

	/**
	 * Check if current page is a Wikia hub
	 *
	 * @return bool
	 */
	public static function isCurrentPageAWikiaHub() {
		return ( self::isCorporatePage() && self::getHubIdForCurrentPage() );
	}

	/**
	 * Check if given city is Wikia corporate city
	 */
	public static function isCorporatePage() {
		return !empty( F::app()->wg->EnableWikiaHomePageExt );
	}

	private static function getHubIdForCurrentPage() {
		$categoryId = null;
		if (F::app()->wg->EnableWikiaHubsV2Ext) {
			$categoryId = self::getHubIdForCurrentPageV2();
		}
		return $categoryId;
	}

	private static function getHubIdForCurrentPageV2() {
		$baseText = F::app()->wg->Title->getBaseText();

		/** @var $tmpTitle Title */
		$tmpTitle = Title::newFromText($baseText);

		$hubsPages = F::app()->wg->WikiaHubsV2Pages;

		if ($tmpTitle instanceof Title) {
			/* @var $title Title */
			$hubName = $tmpTitle->getDbKey();

			if ($hubName) {
				return array_search($hubName, $hubsPages);
			}
		}
		return false;
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
