<?php

namespace Wikia\IndexingPipeline;

abstract class EventProducer {
	const PRODUCER_NAME = 'MWEventsProducer';
	protected static $pipe;

	abstract public static function send( $pageId, $revisionId, $eventName, $params = [ ] );
	abstract protected static function getPipeline();

	/**
	 * @param $key
	 * @param $data
	 */
	protected static function publish( $key, $data ) {
		try {
			static::getPipeline()->publish( $key, $data );
		} catch ( Exception $e ) {
			WikiaLogger::instance()->error( $e->getMessage() );
		}
	}
}
