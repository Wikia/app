<?php
/**
 * This scripts finds messages that are invalid or unused.
 *
 * @file
 */

require( dirname( __FILE__ ) . '/cli.inc' );

$dbr = wfGetDB( DB_SLAVE );
$rows = $dbr->select( array( 'page' ),
	array( 'page_title', 'page_namespace' ),
	array(
		'page_namespace' => $wgTranslateMessageNamespaces,
	),
	__METHOD__
);

$owners = array();
$keys = array();
$codes = Language::getLanguageNames();
$invalid = array();

foreach ( $rows as $row ) {
	list( $key, $code ) = TranslateUtils::figureMessage( $row->page_title );

	if ( !$code ) {
		$code = 'en';
	}

	$mg = TranslateUtils::messageKeyToGroup( $row->page_namespace, $key );
	$ns = $wgContLang->getNsText( $row->page_namespace );

	if ( is_null( $mg ) ) {
		$keys["$ns:$key"][] = $code;
		$owner = 'xx-unknown';
	} else {
		$owner = $mg;
	}

	if ( !isset( $codes[$code] ) ) {
		$invalid[$code][] = "[[$ns:$key/$code]]";
	}

	if ( !isset( $owners[$owner] ) ) {
		$owners[$owner] = 0;
	}

	$owners[$owner]++;
}

$rows->free();

ksort( $owners );

if ( count( $invalid ) ) {
	echo "==Invalid language codes==\n" . implode( ', ', array_keys( $invalid ) ) . "\n";

	foreach ( $invalid as $key => $pages ) {
		echo "# $key: " . implode( ', ', $pages ) . "\n";
	}
}

if ( count( $owners ) ) {
	echo "\n==Messages claimed==\n";

	foreach ( $owners as $o => $count ) {
		echo "# $o: $count\n";
	}
}

if ( count( $keys ) ) {
	echo "\n==Unclaimed messages==\n";

	foreach ( $keys as $page => $langs ) {
		echo "* $page: " . implode( ', ', $langs ) . "\n";
	}
}
