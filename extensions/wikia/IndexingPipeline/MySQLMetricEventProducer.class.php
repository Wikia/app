<?php

namespace Wikia\IndexingPipeline;

class MySQLMetricEventProducer extends EventProducer {

	public static function send( $pageId, $revisionId, $eventName, $params = [ ] ) {
		self::publish( self::prepareRoute(),
			self::prepareMessage( $pageId, $revisionId, $params ) );
	}

	/**
	 * @desc create message with cityId and pageId fields
	 *
	 * @param $pageId
	 * @param $revisionId - not used
	 * @param $params - not used
	 * @return \stdClass
	 */
	protected static function prepareMessage( $pageId, $revisionId, $params ) {
		global $wgCityId;
		$msg = new stdClass();
		$msg->id = sprintf( '%s_%s', $wgCityId, $pageId );

		$update = new stdClass();
		$update->mainpagefilter_b = "1";

		$msg->update = $update;

		return $msg;
	}

	public static function prepareRoute() {
		$route = 'MySqlMetricWorker.1.1.#portable._output._warehouse';

		return $route;
	}

	protected static function getPipeline() {
		if ( !isset( self::$pipe ) ) {
			self::$pipe = new MySQLMetricWorkerConnectionBase();
		}

		return self::$pipe;
	}
}
