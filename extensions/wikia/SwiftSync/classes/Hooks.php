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
	public static function doStoreInternal( array $params, \Status $status ) {

		if ( $status->isGood() ) {
			Queue::newFromParams( $params )->add();
		}

		return true;
	}

	public static function doCopyInternal( array $params, \Status $status ) {

		if ( $status->isGood() ) {
			Queue::newFromParams( $params )->add();
		}
		return true;
	}

	public static function doDeleteInternal( array $params, \Status $status ) {

		if ( !empty( $params['src'] ) && ( strpos( $params['src'], '/images/thumb' ) !== false ) ) {
			return true;
		}

		if ( empty( $params['op']  ) ) {
			$params['op'] = 'delete';
		}

		if ( $status->isGood() ) {
			Queue::newFromParams( $params )->add();
		}
		return true;
	}
}
