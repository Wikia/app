<?php
/**
 * optionToTable.php -- Convert old user_options-based
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * By Evan Prodromou <evan@wikitravel.org>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @addtogroup Extensions
 */

require_once( 'commandLine.inc' );
ini_set( "include_path", "/usr/share/php:" . ini_get( "include_path" ) );

require_once( "$IP/extensions/OpenID/Consumer.php" );

global $wgSharedDB, $wgDBprefix;
$tableName = "${wgDBprefix}user_openid";
if ( isset( $wgSharedDB ) ) {
	$tableName = "`$wgSharedDB`.$tableName";
}

$dbr = wfGetDB( DB_SLAVE );

$res = $dbr->select( array( 'user' ),
					array( 'user_name' ),
					array( 'user_options LIKE "%openid_url%"' ),
					'optionToTable',
					array( 'ORDER BY' => 'user_name' ) );

while ( $res && $row = $dbr->fetchObject( $res ) ) {
	$user = User::newFromName( $row->user_name );
	print( $user->getName() . ": " . $user->getOption( 'openid_url' ) . "\n" );
	OpenIDSetUserUrl( $user, $user->getOption( 'openid_url' ) );
}
$dbr->freeResult( $res );
