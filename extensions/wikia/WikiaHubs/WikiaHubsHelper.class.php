<?php

/**
 * WikiaHubsHelper
 *
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsHelper {

	public static function onOutputPageMakeCategoryLinks(&$out, $categories, &$links) {
		if(!F::app()->wg->WikiaHubsPages) {
			return true;
		}

		$dbkey = $out->getContext()->getTitle()->getDBKey();
		if(in_array($dbkey,F::app()->wg->WikiaHubsPages)) {
			$categories = null;
			return false;
		}

		return true;
	}
	
	public static function onOutputPageBeforeHTML ( $out, $text ) {
		$category = HubService::getComscoreCategory(F::app()->wg->cityId);
		switch($category->cat_id) {
			case WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT:
				$categoryName = 'WikiaHubsEntertainment';
				break;
			case WikiFactoryHub::CATEGORY_ID_GAMING:
				$categoryName = 'WikiaHubsVideoGames';
				break;
			case WikiFactoryHub::CATEGORY_ID_LIFESTYLE:
				$categoryName = 'WikiaHubsLifestyle';
				break;
			default:
				$categoryName = 'Wikia';
				break;
		}
		OasisController::addBodyClass($categoryName);
		return true;
	}
}