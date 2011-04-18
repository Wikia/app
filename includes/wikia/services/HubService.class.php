<?php

class HubService extends Service {
//	private static $comscore_prefix = 'comscore_';

	/**
	 * get proper category to report to Comscore for cityId
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return StdObject ($row->cat_id $row->cat_name) or false
	 */
	public static function getComscoreCategory($cityId) {

		$catInfo = WikiFactory::getCategory($cityId);
//		if (empty($catInfo)) {
//
//		}
//		else {
//			// look for Comscore tag
//			$wftags = new WikiFactoryTags();
//			$tags = $wftags->getTags();
//			if (is_array($tags['byname'])) {
//				foreach ($tags['byname'] as $tagName) {
//					if (startsWith($tagName, self::$comscore_prefix, false)) {
//						$catName = substr($tagName, strlen(self::$comscore_prefix));
//						//@todo get category by name
//						break;
//					}
//				}
//			}
//			switch ($catInfo->cat_id) {
//				case 2:	// gaming
//				case 3:	// entertainment
//				case 4: // corporate
//					break;
//				default:
//			}
//		}
		if (empty($catInfo) || ($catInfo->cat_id != 2 && $catInfo->cat_id != 3 && $catInfo->cat_id != 4)) {	// 2: Gaming. 3: Entertainment. 4: Corporate
			// Force hub to Lifestyle
			$lifestyleHub = WikiFactoryHub::getInstance()->getCategory(WikiFactoryHub::CATEGORY_ID_LIFESTYLE);
			$catInfo = null;
			$catInfo->cat_id = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
			$catInfo->cat_name = $lifestyleHub['name'];
		}

		return $catInfo;
	}

}
