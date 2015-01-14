<?php

/**
 * class WikiFactoryHubHooks
 * Hooks connected to wiki hubs and verticals
 *
 * @author Damian Jozwiak <damian@wikia-inc.com>
 */
class WikiFactoryHubHooks extends WikiaModel {

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
		$vars['wgWikiCategories'] = $wikiFactoryHub->getWikiCategoryNames( $wgCityId );

		return true;
	}
}
