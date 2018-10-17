<?php

use Wikia\Rabbit\ConnectionBase;

/**
 * @package MediaWiki
 * @subpackage WikiStatusChangePublisher
 *
 */
class WikiStatusChangeHooks {

	/**
	 *
	 * @param  int $city_public
	 * @param  int $city_id
	 * @param  string $reason
	 *
	 * @return bool
	 */
	public static function onWikiFactoryPublicStatusChange( &$city_public, &$city_id, $reason ) {
		global $wgWikiStatusChangePublisher;

		$connectionBase = new ConnectionBase( $wgWikiStatusChangePublisher );

		$status = self::getStatus( $city_public );
		$routingKey = 'wiki.' . $city_id . ".status." . $status;

		$connectionBase->publish( $routingKey, [
			'wikiId' => $city_id,
			'reason' => $reason,
			'status' => $status,
		] );

		return true;
	}

	private static function getStatus( int $status ) {
		switch ( $status ) {
			case WikiFactory::CLOSE_ACTION:
				return "closed";
			case WikiFactory::PUBLIC_WIKI:
				return "opened";
			case WikiFactory::HIDE_ACTION:
				return "hidden";
		}
	}
}
