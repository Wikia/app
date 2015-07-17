<?php
/**
 * Use Scribe queue to send purge requests to Fastly
 *
 * This class will enqueue all URLs and send list of unique URLs at the end of the request handling
 *
 * @author Eloy
 * @author macbre
 */

use Wikia\SFlow;
use Wikia\Logger\WikiaLogger;

class ScribePurge {

	const SCRIBE_KEY = 'varnish_purges';

	private static $urls = [];
	private static $urlsCount = 0;

	/**
	 * Add array of URLs to the purger queue
	 *
	 * @param Array $urlArr list of URLs to purge
	 * @throws WikiaException
	 */
	static function purge( $urlArr ) {
		global $wgEnableScribeReport;
		wfProfileIn( __METHOD__ );

		if ( empty( $wgEnableScribeReport ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		foreach ( $urlArr as $url ) {
			if ( !is_string( $url ) ) {
				throw new WikiaException( 'Bad purge URL' );
			}
			$url = SquidUpdate::expand( $url );
			$method = self::getPurgeCaller();

			wfDebug( "Purging URL $url from $method via Scribe\n" );
			wfDebug( "Purging backtrace: " . wfGetAllCallers( false ) . "\n" );

			// add to the queue, will be sent by onRestInPeace method
			self::$urls[ $url ] = [
				'url' => $url,
				'time' => time(),
				'method' => $method,
			];
			self::$urlsCount++;
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * This method is called via hook at the end of the request handling
	 *
	 * Make the list of unique URLs and send them to Fastly via Scribe queue
	 *
	 * @author macbre
	 *
	 * @return bool true - it's a hook
	 */
	static function onRestInPeace() {

		// don't process an empty queue
		if ( empty( self::$urls ) ) {
			return true;
		}

		wfProfileIn( __METHOD__ );
		$scribe = WScribeClient::singleton( self::SCRIBE_KEY );

		try {
			wfDebug( sprintf( "%s: sending %d unique URLs to the purger (%d items were queued in total)\n", __METHOD__, count( self::$urls ), self::$urlsCount ) );

			foreach ( self::$urls as $url => $data ) {
				wfDebug( sprintf( "%s: %s\n", __METHOD__, $url ) );

				// send to Scribe queue
				$scribe->send( json_encode( $data ) );

				// debugging data to be sent to both sFlow (for monitoring) and Kibana (for debugging)
				$context = [
					'url' => $data['url'],
					'method' => $data['method'],
				];

				// log purges using SFlow (BAC-1258)
				SFlow::operation( 'varnish.purge', $context );

				// log purges using Kibana (BAC-1317)
				WikiaLogger::instance()->info( 'varnish.purge', $context );
			}
		}
		catch ( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Return the name of the method (outside of the internal code) that triggered purge request
	 *
	 * @return string method name
	 */
	private static function getPurgeCaller() {
		return wfGetCallerClassMethod( [ __CLASS__, 'SquidUpdate', 'WikiPage', 'Article', 'Title', 'WikiaDispatchableObject' ] );
	}
}
