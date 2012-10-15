<?php
# Copyright (C) 2007 Jens Frank <jeluf@gmx.de>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

if( !defined( 'MEDIAWIKI' ) ) {
	die("This is the METIS extension");
}

$wgExtensionCredits['other'][] = array(
	'name' => 'METIS',
	'path' => __FILE__,
	'author' => 'Jens Frank',
	'description' => 'Add support for METIS counting pixels',
);

#$wgHooks['BeforePageDisplay'][] = 'efMetisAddPixel';
$wgHooks['ArticleViewHeader'][] = 'efMetisAddPixel';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'efMetisSchemaUpdate';

function efMetisAddPixel( &$article ) {
	global $wgOut;
	/* Only show the pixel for articles in the main namespace */

	$title = $article->getTitle();
	if ( $title->getNamespace() == NS_MAIN ) {
		$dbr = wfGetDB( DB_SLAVE );
		$pixel = $dbr->selectField( 'metis', 'metis_pixel',
			array( 'metis_id' => $title->getArticleID() ),
			__FUNCTION__ );
		if ( !is_null( $pixel ) ) {
			$wgOut->addHTML( '<img src="' . $pixel . '" width="1" height="1" alt="">' );
		}

	}
	return true;
}

function efMetisSchemaUpdate( $updater = null ) {
	if ( $updater === null ) {
		global $wgDBtype, $wgExtNewTables;
		if ( $wgDBtype == 'mysql' ) {
			$wgExtNewTables[] = array( 'metis', dirname( __FILE__ ) . '/METIS.sql' );
		} elseif ( $wgDBtype == 'postgres' ) {
			$wgExtNewTables[] = array( 'metis', dirname( __FILE__ ) . '/METIS.pg.sql' );
		}
	} else {
		if ( $updater->getDB()->getType() == 'mysql' ) {
			$updater->addExtensionUpdate( array( 'addTable', 'metis', dirname( __FILE__ ) . '/METIS.sql', true ) );
		} elseif ( $updater->getDB()->getType() == 'postgres' ) {
			$updater->addExtensionUpdate( array( 'addTable', 'metis', dirname( __FILE__ ) . '/METIS.pg.sql', true ) );
		}
	}
	return true;
}
