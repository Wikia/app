<?php

namespace Wikia\IndexingPipeline;

class MySQLMetricEventProducer {
	protected static $pipe;
	const ROUTE = 'mainpage._output._warehouse';

	public static function send( $pageId ) {
		self::getPipeline()->publish(
			self::prepareRoute(),
			self::prepareMessage( $pageId )
		);
	}

	/**
	 * @desc create message with cityId, pageId and
	 * updated mainpage_b
	 *
	 * @param $pageId
	 * @return \stdClass
	 */
	public static function prepareMessage( $pageId ) {
		global $wgCityId;
		$msg = new \stdClass();
		$msg->id = sprintf( '%s_%s', $wgCityId, $pageId );

		$update = new \stdClass();
		$matches_mv = new \stdClass();
		$matches_mv->mainpage_b = "true";

		$update->matches_mv = $matches_mv;
		$msg->update = $update;

		return $msg;
	}

	/**
	 * @return string
	 */
	public static function prepareRoute() {
		return self::ROUTE;
	}

	/**
	 * @return \Wikia\IndexingPipeline\ConnectionBase
	 */
	protected static function getPipeline() {
		global $wgMySQLMetricWorker;

		if ( !isset( self::$pipe ) ) {
			self::$pipe = new ConnectionBase( $wgMySQLMetricWorker );
		}

		return self::$pipe;
	}
}
