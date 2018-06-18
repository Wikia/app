<?php
/**
 * Database load monitoring
 *
 * @file
 * @ingroup Database
 */

/**
 * An interface for database load monitoring
 *
 * @ingroup Database
 */
interface LoadMonitor {
	/**
	 * Construct a new LoadMonitor with a given LoadBalancer parent
	 *
	 * @param LoadBalancer $parent
	 */
	function __construct( $parent );

	/**
	 * Perform pre-connection load ratio adjustment.
	 * @param $loads array
	 * @param $group String: the selected query group
	 * @param $wiki String
	 */
	function scaleLoads( &$loads, $group = false, $wiki = false );

	/**
	 * Perform post-connection backoff.
	 *
	 * If the connection is in overload, this should return a backoff factor
	 * which will be used to control polling time. The number of threads
	 * connected is a good measure.
	 *
	 * If there is no overload, zero can be returned.
	 *
	 * A threshold thread count is given, the concrete class may compare this
	 * to the running thread count. The threshold may be false, which indicates
	 * that the sysadmin has not configured this feature.
	 *
	 * @param $conn DatabaseBase
	 * @param $threshold Float
	 */
	function postConnectionBackoff( $conn, $threshold );

}

class LoadMonitor_Null implements LoadMonitor {
	function __construct( $parent ) {
	}

	function scaleLoads( &$loads, $group = false, $wiki = false ) {
	}

	function postConnectionBackoff( $conn, $threshold ) {
	}

}

/**
 * Basic MySQL load monitor with no external dependencies
 * Uses memcached to cache the replication lag for a short time
 *
 * @ingroup Database
 */
class LoadMonitor_MySQL implements LoadMonitor {

	/**
	 * @var LoadBalancer
	 */
	var $parent;

	/**
	 * @param LoadBalancer $parent
	 */
	function __construct( $parent ) {
		$this->parent = $parent;
	}

	/**
	 * @param $loads
	 * @param $group bool
	 * @param $wiki bool
	 */
	function scaleLoads( &$loads, $group = false, $wiki = false ) {
	}

	/**
	 * @param $conn DatabaseMysqlBase
	 * @param $threshold
	 * @return int
	 */
	function postConnectionBackoff( $conn, $threshold ) {
		if ( !$threshold ) {
			return 0;
		}
		$status = $conn->getMysqlStatus("Thread%");
		if ( $status['Threads_running'] > $threshold ) {
			$server = $conn->getProperty( 'mServer' );
			wfLogDBError( "LB backoff from $server - Threads_running = {$status['Threads_running']}\n" );
			return $status['Threads_connected'];
		} else {
			return 0;
		}
	}
}
