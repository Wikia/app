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

class ScribePurge {

	/**
	 * Add array of URLs to the purger queue
	 *
	 * @param Array $urlArr list of URLs to purge
	 * @throws MWException
	 */
	static function purge( $urlArr ) {
		global $wgEnableScribeReport, $wgCityId;
		wfProfileIn( __METHOD__ );
		$key = 'varnish_purges';

		if ( empty( $wgEnableScribeReport ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		try {
			foreach ( $urlArr as $url ) {
				if ( !is_string( $url ) ) {
					throw new WikiaException( 'Bad purge URL' );
				}
				$url = SquidUpdate::expand( $url );
				$method = self::getPurgeCaller();

				wfDebug( "Purging URL $url from $method via Scribe\n" );
				wfDebug( "Purging backtrace: " . wfGetAllCallers( false ) . "\n" );
				$data = json_encode( [
					'url' => $url,
					'time' => time(),
					'method' => $method,
				] );
				WScribeClient::singleton( $key )->send( $data );

				// log purges using SFlow (BAC-1258)
				SFlow::operation( 'varnish.purge', [
					'city' => $wgCityId,
					'url' => $url,
					'method' => $method,
				] );
			}
		}
		catch ( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return the name of the method (outside of the internal code) that triggered purge request
	 *
	 * @return string method name
	 */
	private static function getPurgeCaller() {
		// analyze the backtrace to log the source of purge requests
		$backtrace = wfDebugBacktrace();
		$method = '';

		while ( $entry = array_shift( $backtrace ) ) {
			// ignore "internal" classes
			if ( empty( $entry['class'] ) || in_array( $entry['class'], [__CLASS__, 'SquidUpdate', 'WikiPage', 'Article', 'Title'] ) ) {
				continue;
			}

			$method = $entry['class'] . ':' . $entry['function'];
			break;
		}

		return $method;
	}
}
