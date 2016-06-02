<?php

// Run from /usr/wikia/slot1/current/maintenance with $sudo SERVER_ID=177 php checkMessageCache.php

require_once( dirname( __FILE__ ) . '/commandLine.inc' );
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

$langs = Language::getLanguageNames();
$langs_count = count($langs);
$i = 0;

foreach ( $langs as $languageCode => $languageName ) {
    $lang = Language::factory( $languageCode );
    $mc = $lang->getLocalisationCache();

    echo $i++ . '/' . $langs_count. ': ' . $languageCode . PHP_EOL;

    /** @var $reader CdbReader_DBA */
    // production/sandbox
     $reader = dba_open( '/usr/wikia/slot1/current/cache/messages/l10n_cache-' . $languageCode . '.cdb', 'r', 'cdb' );

    // devbox
//    $reader = dba_open( '/var/cache/mediawiki/l10n_cache-' . $languageCode . '.cdb', 'r', 'cdb' );

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
    ksort($messages);

    //foreach ($messages as $k => $m) echo "\t" . $k . PHP_EOL;

    file_put_contents( './messageCache.dump.' . $languageCode . '.php', serialize( $messages ) );
}

