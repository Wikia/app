<?php

namespace Wikia\IndexingPipeline;

class MySQLMetricEventProducer extends EventProducer {
	const ROUTE = 'mainpage._output._warehouse';

	public static function send( $eventName, $pageId, $revisionId, $params = [ ] ) {
		self::publish(
			self::prepareRoute(),
			self::prepareMessage( $pageId )
		);
	}

	/**
	 * @desc create message with cityId, pageId and
	 * updated mainpagefilter_b
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
		$matches_mv->mainpagefilter_b = "1";

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
	 * @return \Wikia\IndexingPipeline\MySQLMetricWorkerConnectionBase
	 */
	protected static function getPipeline() {
		if ( !isset( self::$pipe ) ) {
			self::$pipe = new MySQLMetricWorkerConnectionBase();
		}

		return self::$pipe;
	}
}
