<?php

class HubService extends Service {
	private static $comscore_prefix = 'comscore_';

	// WF city_ids
	private static $corporate_sites = array(80433, 111264);

	/**
	 * Get proper category to report to Comscore for given cityId
	 * (wgTitle GLOBAL will be used in case the city is corporate wiki)
	 *
	 * @deprecated use getCategoryInfoForCity or getCategoryInfoForCurrentPage instead
	 *
	 * @param int $city_id city id
	 *
	 * @return stdClass ($row->cat_id $row->cat_name)
	 */
	public static function getComscoreCategory($cityId) {
		if (self::isCorporatePage($cityId) && $cityId == F::app()->wg->CityId) {
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

		if (self::isCorporatePage($cityId)) {
			$categoryId = self::getHubIdForCurrentPage();
		}

		if (empty($categoryId)) {
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

		if (self::isCorporatePage($cityId)) {
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
		return (self::isCorporatePage(F::app()->wg->CityId) && self::getHubIdForCurrentPage());
	}

	/**
	 * Check if given city is Wikia corporate city
	 */
	public static function isCorporatePage($cityId) {
		return (in_array($cityId, self::$corporate_sites));
	}

	public static function getHubIdForCurrentPage() {
		$categoryId = null;
		if (F::app()->wg->EnableWikiaHubsV2Ext) {
			$categoryId = self::getHubIdForCurrentPageV2();
		} elseif (F::app()->wg->EnableWikiaHubsExt) {
			$categoryId = self::getHubIdForCurrentPageV1();
		}
		return $categoryId;
	}

	private static function getHubIdForCurrentPageV1() {
		$baseText = F::app()->wg->Title->getBaseText();

		/** @var $tmpTitle Title */
		$tmpTitle = F::build('Title', array($baseText), 'newFromText');
		$hubsPages = F::app()->wg->WikiaHubsPages;

		if (!empty($hubsPages) && $tmpTitle instanceof Title) {
			$textTitle = $tmpTitle->getDBKey();
			if ($textTitle) {
				foreach ($hubsPages as $hubId => $hubText) {
					if( $textTitle == $hubText ) {
						return $hubId;
					}
				}
			}
		}

		return false;
	}

	private static function getHubIdForCurrentPageV2() {
		$hubsPages = F::app()->wg->WikiaHubsPages;
		$vertical = RequestContext::getMain()->getRequest()->getVal('vertical');
		$title = F::build('Title', array($vertical), 'newFromText');

		if ($title instanceof Title) {
			/* @var $title Title */
			$hubName = $title->getDbKey();

			if ($hubName) {
				foreach ($hubsPages as $hubId => $hubGroup) {
					if (in_array($hubName, $hubGroup)) {
						return $hubId;
					}
				}
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
