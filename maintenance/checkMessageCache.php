<?php

require_once( dirname( __FILE__ ) . '/commandLine.inc' );
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

foreach ( Language::getLanguageNames() as $languageCode => $languageName ) {
    $lang = Language::factory( $languageCode );
    $mc = $lang->getLocalisationCache();

    /** @var $reader CdbReader_DBA */
    // production/sandbox
    $reader = dba_open( '/usr/wikia/slot1/current/cache/messages/l10n_cache-' . $languageCode . '.cdb', 'r', 'cdb' );

    // devbox
    //$reader = dba_open( '/var/cache/mediawiki/l10n_cache-' . $languageCode . '.cdb', 'r', 'cdb' );

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

    file_put_contents( './messageCache.dump.' . $languageCode . '.php', serialize( $messages ) );
}

