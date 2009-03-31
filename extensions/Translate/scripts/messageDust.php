<?php
$dir = dirname( __FILE__ ); $IP = "$dir/../..";
@include("$dir/../CorePath.php"); // Allow override
require_once( "$IP/maintenance/commandLine.inc" );


$dbr = wfGetDB( DB_SLAVE );
$rows = $dbr->select( array( 'page' ),
	array( 'page_title', 'page_namespace' ),
	array(
		'page_namespace'    => $wgTranslateMessageNamespaces,
	),
	__METHOD__
);

$owners = array();
$keys = array();
$codes = Language::getLanguageNames();
$invalid = array();

$index = TranslateUtils::messageIndex();
foreach ( $rows as $row ) {

	@list( $pieces, $code ) = explode('/', $wgContLang->lcfirst($row->page_title), 2);

	if ( !$code ) $code = 'en';

	$key = strtolower( $row->page_namespace . ':' . $pieces );

	$mg = @$index[$key];
	$ns = $wgContLang->getNsText( $row->page_namespace );
	if ( is_null($mg) ) {
		$keys["$ns:$pieces"][] = $code;
		$owner = 'xx-unknown';
	} else {
		$owner = $mg;
	}

	if ( !isset($codes[$code]) ) {
		$invalid[$code][] = "[[$ns:$pieces/$code]]";
		#echo "* [[$ns:$pieces/$code]]\n";
	}

	if ( !isset($owners[$owner]) ) $owners[$owner] = 0;
	$owners[$owner]++;
}
$rows->free();

ksort( $owners );

echo "==Invalid language codes==\n" . implode( ', ', array_keys( $invalid ) ) . "\n";
foreach ( $invalid as $key => $pages ) {
	echo "# $key: " . implode( ', ', $pages ) . "\n";
}
echo "\n==Messages claimed==\n";


foreach ( $owners as $o => $count ) {
	echo "# $o: $count\n";
}

echo "\n==Unclaimed messages==\n";

foreach ( $keys as $page => $langs ) {
	echo "* $page: " . implode( ', ', $langs ) . "\n";
}

