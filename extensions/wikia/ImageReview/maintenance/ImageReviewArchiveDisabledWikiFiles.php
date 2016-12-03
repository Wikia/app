<?php

require( '../../../../maintenance/commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );

$res = $dbr->select( 'city_list', 'city_id', array( 'city_public' => 0 ) );

while ( $row = $dbr->fetchRow( $res ) ) {
	echo "Archiving images from wiki ID {$row->city_id}...";

	ImageReviewHooks::onWikiFactoryPublicStatusChange( 0, $row->city_id, '' );

	echo "[done]\n";
}
