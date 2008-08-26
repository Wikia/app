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
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

if( !defined( 'MEDIAWIKI' ) ) {
	die("This is the METIS extension");
}

$wgExtensionFunctions[] = 'efMetis';
$wgExtensionCredits['other'][] = array( 'name' => 'METIS', 'author' => 'Jens Frank' );

function efMetis() {
	global $wgHooks;
	#$wgHooks['BeforePageDisplay'][] = 'efMetisAddPixel';
	$wgHooks['ArticleViewHeader'][] = 'efMetisAddPixel';
}

function efMetisAddPixel( &$article ) {
	global $wgTitle, $wgOut;
	/* Only show the pixel for articles in the main namespace */

	if ( $wgTitle->getNamespace() == NS_MAIN ) {
		$dbr = wfGetDB( DB_SLAVE );
		$pixel = $dbr->selectField( 'metis', 'metis_pixel',
				array( 'metis_id' => $wgTitle->getArticleID() ),
				'efMetisAddPixel' );
		if ( !is_null( $pixel ) ) {
			$wgOut->addHTML( '<img src="' . $pixel . '" width="1" height="1" alt="">' );
		}

	}
	return true;
}

?>
