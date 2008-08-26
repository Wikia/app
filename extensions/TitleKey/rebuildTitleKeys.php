<?php

require_once dirname( dirname( dirname( __FILE__ ) ) ) . "/maintenance/commandLine.inc";

// In case we want to do offline initialization...
if( !class_exists( 'TitleKey' ) ) {
	require dirname( __FILE__ ) . '/TitleKey_body.php';
}

if( isset( $options['help'] ) ) {
	echo "Rebuilds titlekey table entries for all pages in DB.\n";
	echo "Usage:\n";
	echo "  php extensions/TitleKey/rebuildTitleKeys.php [--start=<page_id>]\n";
} else {
	$start = intval( @$options['start'] );
	echo "Rebuilding titlekey table...\n";
	TitleKey::populateKeys( $start );
}