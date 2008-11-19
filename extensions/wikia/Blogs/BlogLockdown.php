<?php

/**
 * BlogLockdown extension - implements restrictions on blog namespaces
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author
 * @licence GNU General Public Licence 2.0 or later
 *
 *
 * Based on Lockdown extension from Daniel Kinzler, brightbyte.de
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgHooks['userCan'][] = 'BlogLockdown::userCan';

class BlogLockdown {

	public static function userCan( $title, $user, $action, &$result ) {

	}
}
