<?php

include( '../../commandLine.inc' );

$languages = array_keys( Language::getLanguageNames() );

$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );

$res = $dbr->select( 'interwiki', '*' );

while ( $row = $dbr->fetchObject( $res ) ) {
	if ( in_array( $row->iw_prefix, $languages ) ) {
		echo 'Processing ' . $row->iw_prefix . "\n";
		$url = $row->iw_url;
		if ( strstr( $url, '$1' ) === false ) {
			echo "Got no $1\n";
			if ( strstr( $url, 'wikia.com' ) !== false ) {
				echo "updating...\n";
				$dbw->update(
						'interwiki',
						array( 'iw_url' => $url . $wgArticlePath ),
						array( 'iw_prefix' => $row->iw_prefix )
					    );
			}
		}
	}
}
