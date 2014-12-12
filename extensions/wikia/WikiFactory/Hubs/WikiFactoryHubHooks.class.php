<?php

/**
 * class WikiFactoryHubHooks
 * Hooks connected to wiki hubs and verticals
 *
 * @author Damian Jozwiak <damian@wikia-inc.com>
 */
class WikiFactoryHubHooks extends WikiaModel {

	/**
	 * Gets list of wiki categories
	 *
	 * @param int $cityId CityId
	 * @return array - list of wiki categories
	 */
	public static function getWikiCategories( $cityId ) {
		$wikiCategories = [];
		$wikiFactoryHub = WikiFactoryHub::getInstance();

		$categories = $wikiFactoryHub->getWikiCategories( $cityId );
		foreach( $categories as $category ) {
			$wikiCategories[] = $category['cat_short'];
		}
		return $wikiCategories;
	}

	/**
	 * Hooks that export wiki vertical and categories on frontend
	 *
	 * @param Array $vars - (reference) js variables
	 * @param Array $scripts - (reference) js scripts
	 * @param Skin $skin - skins
	 * @return Boolean True - to continue hooks execution
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		global $wgCityId;
		$wikiFactoryHub = WikiFactoryHub::getInstance();

		$vars['wgWikiVertical'] = $wikiFactoryHub->getWikiVertical( $wgCityId )['short'];
		$vars['wgWikiCategories'] = self::getWikiCategories( $wgCityId );

		return true;
	}
}
