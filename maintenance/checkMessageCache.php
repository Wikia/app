<?php

// Run from /usr/wikia/slot1/current/maintenance with $sudo SERVER_ID=177 php checkMessageCache.php true
// first parameter if true, sets primary list of languages

require_once( dirname( __FILE__ ) . '/commandLine.inc' );

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

$messageCacheDir = './messageCache';

$primaryOnly = isset($argv[0]) && $argv[0] === 'true';

$langs = [ 'en', 'pl', 'de', 'es', 'fr', 'it', 'ja', 'nl', 'pt', 'ru', 'zh-hans', 'zh-tw' ];

if ( !$primaryOnly ) {
	$codes = array_keys( Language::getLanguageNames( true ) );
	$codes = array_filter( $codes,
		function ( $item ) use ( $langs ) {
			return !in_array( $item, $langs );
		} );
	sort( $codes );

	$langs = array_merge( $langs, $codes );
}

$langs_count = count($langs);
$localizationsCacheFoldersPostfix = [ 'new', 'orig' ];
$i = 0;

if (!is_dir($messageCacheDir)) {
	mkdir($messageCacheDir, 0775) or exit ('Was not able to create the result directory');
}


foreach ( $localizationsCacheFoldersPostfix as $cachePostfix ) {
	echo 'checking \'' . $cachePostfix . '\' message cache' . PHP_EOL;

	foreach ( $langs as $languageCode ) {
		$lang = Language::factory( $languageCode );
		$mc = $lang->getLocalisationCache();

		echo $i++ . '/' . $langs_count . ': ' . $languageCode . PHP_EOL;

		/** @var $reader CdbReader_DBA */
		// production/sandbox
		//     $reader = dba_open( '/usr/wikia/slot1/current/cache/messages/l10n_cache-' . $languageCode . '.cdb', 'r', 'cdb' );

		$reader = dba_open( '/tmp/messagecache-' . $cachePostfix .  '/l10n_cache-' . $languageCode . '.cdb', 'r', 'cdb' );

		$firstKey = dba_firstkey( $reader );
		if ( startsWith( $firstKey, 'messages:' ) ) {
			$messages = [ $firstKey => dba_fetch( $firstKey, $reader ) ];
		} else {
			$messages = [ ];
		}
		while ( $currentKey = dba_nextkey( $reader ) ) {
			if ( startsWith( $currentKey, 'messages:' ) ) {
				$messages [$currentKey] = unserialize( dba_fetch( $currentKey, $reader ) );
			}
		}
		ksort( $messages );

		//foreach ($messages as $k => $m) echo "\t" . $k . PHP_EOL;

		file_put_contents( $messageCacheDir . '/messageCache-' . $cachePostfix .  '.dump.' . $languageCode . '.php', serialize( $messages ) );
	}
}
