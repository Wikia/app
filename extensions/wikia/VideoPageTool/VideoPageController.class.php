<?php

class VideoPageController extends WikiaController {
	public static $defaultWikiID = 298117;
	public static $defaultArticleName = 'VideoHomePage';

	/**
	 * Display the Video Home Page
	 */
	public function index() {

	}

	public static function onVideoWiki( $wikiID = null ) {
		$wikiID = empty($wikiID) ? F::app()->wg->CityId : $wikiID;
		return $wikiID == self::$defaultWikiID;
	}

	public static function onHomePage( $articleName = '' ) {
		if (empty($articleName)) {
			$title = F::app()->wg->Title;
			if ( ! $title instanceof Title ) {
				return false;
			}

			$articleName = $title->getDBkey();
		}

		return $articleName == self::$defaultArticleName;
	}
}