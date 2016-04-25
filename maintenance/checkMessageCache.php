<?php


require_once( dirname( __FILE__ ) . '/commandLine.inc' );

$mc = MessageCache::singleton();

foreach ( Language::getLanguageNames() as $languageCode => $languageName ) {
	$codes = $mc->getAllMessageKeys( $languageCode );
	$sample[$languageCode] = [];
	foreach ( $codes as $code ) {
		$sample[$languageCode][$code] = $mc->get( $code );
	}

	file_put_contents('./messageCache.dump.php',serialize($sample));
}

