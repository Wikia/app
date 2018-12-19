<?php

/**
 * @package MediaWiki
 * @subpackage WikiStatusChangePublisher
 *
 */
class WikiStatusChangeHooks {

	/**
	 *
	 * At the time of writing triggered by WikiFactory->setPublicStatus.
	 *
	 * @param  int $city_public WikiFactory action
	 * @param  int $city_id
	 * @param  string $reason
	 *
	 * @return bool
	 */
	public static function onWikiFactoryPublicStatusChange( &$city_public, &$city_id, $reason, $user = null ) {
		$publisher = new WikiStatusChangePublisher();
		$publisher->publishWikiFactoryStatusChange( $city_id, $city_public, $reason, $user );

		return true;
	}

	/**
	 * At the time of writing triggered by either WikiFactory::Close->close_single_wiki.php or
	 * WikiFactory::Close->maintenance.php.
	 * @param $wiki
	 */
	public static function onWikiFactoryDoCloseWiki( $wiki ) {
		$publisher = new WikiStatusChangePublisher();
		$publisher->publishWikiStatusChangedToRemoved( $wiki->city_id,
			'triggered by WikiFactoryDoCloseWiki' );
	}

}
