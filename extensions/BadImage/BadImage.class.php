<?php
/**
 * Class for manipulating the bad_image table
 *
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence Copyright holder allows use of the code for any purpose
 */

class BadImageList {
	public static function check( $name ) {
		wfProfileIn( __METHOD__ );
		static $titles = array();
		if ( !isset( $titles[$name] ) ) {
			global $wgMemc, $wgBadImageCache;
			$res = $wgMemc->get( BadImageList::key( $name ) );
			if ( $res && $wgBadImageCache ) {
				$titles[$name] = $res == 'yes';
			} else {
				$titles[$name] = BadImageList::checkReal( $name );
				BadImageList::cache( $name, $titles[$name] );
			}
		}
		wfProfileOut( __METHOD__ );
		return $titles[$name];
	}

	private static function checkReal( $name ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->selectField( 'bad_images', 'COUNT(*)', array( 'bil_name' => $name ), __METHOD__ );
		return $res > 0;
	}

	public static function add( $name, $user, $reason ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'bad_images', array( 'bil_name' => $name, 'bil_user' => $user, 'bil_timestamp' => $dbw->timestamp(), 'bil_reason' => $reason ), __METHOD__, 'IGNORE' );
		$wgMemc->delete( BadImageList::key( $name ) );
		wfProfileOut( __METHOD__ );
	}

	public static function remove( $name ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'bad_images', array( 'bil_name' => $name ), __METHOD__ );
		$wgMemc->delete( BadImageList::key( $name ) );
		wfProfileOut( __METHOD__ );
	}

	private static function cache( $name, $value ) {
		global $wgMemc;
		$wgMemc->set( BadImageList::key( $name ), $value ? 'yes' : 'no', 900 );
	}

	private static function key( $name ) {
		return wfMemcKey( 'badimage', $name );
	}
}
