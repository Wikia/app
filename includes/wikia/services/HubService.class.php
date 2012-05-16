<?php

class HubService extends Service {
	private static $comscore_prefix = 'comscore_';

	/**
	 * get proper category to report to Comscore for cityId
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return StdObject ($row->cat_id $row->cat_name) or false
	 */
	public static function getComscoreCategory($cityId) {
		$catInfo = null;

		// look for Comscore tag
		$wftags = new WikiFactoryTags($cityId);
		$tags = $wftags->getTags();
		if (is_array($tags)) {
			foreach ($tags as $id=>$name) {
				if (startsWith($name, self::$comscore_prefix, false)) {
					$catName = substr($name, strlen(self::$comscore_prefix));
					$category = WikiFactoryHub::getInstance()->getCategoryByName($catName);
					$catInfo = self::initCategoryInfo($category['id'], $category['name']);
					break;
				}
			}
		}

		if (empty($catInfo)) {
			$catInfo = WikiFactory::getCategory($cityId);
			if (empty($catInfo)) {
				$lifestyleHub = WikiFactoryHub::getInstance()->getCategory(WikiFactoryHub::CATEGORY_ID_LIFESTYLE);
				$catInfo = self::initCategoryInfo(WikiFactoryHub::CATEGORY_ID_LIFESTYLE, $lifestyleHub['name']);
			} else {
				global $wgWikiaHubsPages, $wgTitle;
				if(!empty($wgWikiaHubsPages) && $wgTitle instanceof Title ) {
					$reverseHubs = array_flip($wgWikiaHubsPages);
					$textTitle = $wgTitle->getDBKey();
					if(!empty($textTitle) && !empty($reverseHubs[$textTitle])) {
						$catInfo->cat_id = $reverseHubs[$textTitle];
						$catInfo->cat_name = $textTitle;
					}
				}

				switch ($catInfo->cat_id) {
					// leave these categories alone
					case WikiFactoryHub::CATEGORY_ID_GAMING:
					case WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT:
					case WikiFactoryHub::CATEGORY_ID_LIFESTYLE:
					case WikiFactoryHub::CATEGORY_ID_CORPORATE:
						$catId = $catInfo->cat_id;
						$catName = $catInfo->cat_name;
						break;
					// force category entertainment
					case WikiFactoryHub::CATEGORY_ID_MUSIC:
						$entertainmentHub = WikiFactoryHub::getInstance()->getCategory(WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT);
						$catId = WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT;
						$catName = $entertainmentHub['name'];
						break;
					// force category lifestyle
					default:
						$lifestyleHub = WikiFactoryHub::getInstance()->getCategory(WikiFactoryHub::CATEGORY_ID_LIFESTYLE);
						$catId = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
						$catName = $lifestyleHub['name'];
				}

				$catInfo = self::initCategoryInfo($catId, $catName);
			}

		}

		return $catInfo;
	}

	private static function initCategoryInfo($id, $name) {
		$catInfo->cat_id = $id;
		$catInfo->cat_name = $name;

		return $catInfo;
	}

}
