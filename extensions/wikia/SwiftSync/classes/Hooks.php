<?php
/**
 * Class definition for Wikia\SwiftSync\Hooks
 */
namespace Wikia\SwiftSync;

/**
 * SwiftFileBackend helper class to sync stored/removed/renamed file with local FS
 *
 * @author moli
 * @package SwiftSync
 */
class Hooks {

	/* save image into local repo */
	public static function doStoreInternal( $params, \Status $status ) {

		Queue::newFromParams( $params )->add();

		return true;
	}

	public static function doCopyInternal( $params, \Status $status ) {

		Queue::newFromParams( $params )->add();

		return true;
	}

	public static function doDeleteInternal( $params, \Status $status ) {

		if ( !empty( $params['src'] ) && ( strpos( $params['src'], '/images/thumb' ) !== false ) ) {
			return true;
		}

		if ( empty( $params['op']  ) ) {
			$params['op'] = 'delete';
		}

		Queue::newFromParams( $params )->add();

		return true;
	}

	public static function SyncFileToDC( $source, $dest) {

		Queue::newFromParams( [
			'city_id' => 0,
			'op' => 'store',
			'src' => $source,
			'dst' => $dest
		] )->add();

		return true;
	}
}
