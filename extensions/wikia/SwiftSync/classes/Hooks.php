<?php
/**
 * Class definition for Wikia\SwiftSync\Hooks
 */
namespace Wikia\SwiftSync;

/**
 * SwiftFileBackend helper class to sync stored/removed/renamed file with local FS
 *
 * @author moli
 * @author macbre
 * @package SwiftSync
 */
class Hooks {

	/**
	 * Stack of DFS operation to be pushed to tasks queue when an upload is completed
	 *
	 * @var array
	 */
	private static $stack = [];

	/* save image into local repo */
	public static function doStoreInternal( array $params, \Status $status ) {

		// SUS-3826 | do not sync temporary files
		if ( self::isTempFile( $params['dst'] ) ) {
			return true;
		}

		if ( $status->isGood() ) {
			self::$stack[] =  self::normalizeParams( $params );
		}

		return true;
	}

	public static function doCopyInternal( array $params, \Status $status ) {

		if ( $status->isGood() ) {
			self::$stack[] =  self::normalizeParams( $params );
		}
		return true;
	}

	public static function doDeleteInternal( array $params, \Status $status ) {

		// SUS-3826 | do not sync temporary files
		if ( self::isTempFile( $params['src'] ) ) {
			return true;
		}

		if ( !empty( $params['src'] ) && ( strpos( $params['src'], '/images/thumb' ) !== false ) ) {
			return true;
		}

		if ( empty( $params['op']  ) ) {
			$params['op'] = 'delete';
		}

		if ( $status->isGood() ) {
			self::$stack[] =  self::normalizeParams( $params );
		}
		return true;
	}

	/**
	 * DFS operations triggered by the above hooks are now pushed to tasks queue.
	 *
	 * This hook is triggered at the end of request handling.
	 *
	 * @return bool
	 */
	public static function onRestInPeace() {
		if ( !empty( self::$stack ) ) {
			self::addTask( self::$stack );
		}

		self::$stack = [];
		return true;
	}

	/**
	 * Checks if a given file is a temporary one. It should be ignored and not synced.
	 *
	 * These files exist for quite short period of time and usually it's too late to sync them
	 * when ImageSync task is executed.
	 *
	 * @see SUS-3826
	 *
	 * @param string $path
	 * @return bool
	 */
	public static function isTempFile( string $path) : bool {
		// e.g. mwstore://swift-backend/easternlight/zh-tw/images/3/35/Temp_file_1516192811
		return preg_match('#/Temp_file_[\d_]+$#', $path);
	}

	/**
	 * Normalize provided parameters from file backend operation and queue a task via
	 * RabbitMQ /Celery
	 *
	 * @see SUS-3611
	 *
	 * @param array $params
	 */
	private static function addTask( array $params ) {
		$task = ImageSyncTask::newLocalTask();

		$task->call( 'synchronize', $params );
		$task->queue();
	}

	/**
	 * @param array $params
	 * @return array
	 */
	private static function normalizeParams( array $params ) {
		if ( !isset( $params[ 'dst' ] ) ) {
			if ( !empty( $params[ 'op' ] ) && ( $params[ 'op' ] == 'delete' ) ) {
				$params[ 'dst' ] = $params[ 'src' ];
			} else {
				$params[ 'dst' ] = '';
			}
		}

		if ( !isset( $params[ 'src' ] ) ) {
			$params[ 'src' ] = '';
		}

		return [
			'op' => $params[ 'op' ],
			'dst' => $params[ 'dst' ],
			'src' => $params[ 'src' ]
		];
	}
}
