<?php

class LocalNavigationHooks {

	/**
	 * Clear the local navigation cache every time the MediaWiki message is edited
	 *
	 * @param string $title name of the page changed.
	 * @param string $text new contents of the page
	 * @return bool return true
	 */
	public static function onMessageCacheReplace($title, $text) {
		if ( NavigationModel::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			$model = new NavigationModel();

			// clear the cache of the "old" local nav logic
			// it's still used when NavigationModel::parse() is called
			$model->clearMemc( $title );
		}

		return true;
	}
}
