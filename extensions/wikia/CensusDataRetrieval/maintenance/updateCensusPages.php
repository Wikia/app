<?php
function my_error_handler( $errno, $errstr, $errfile = null, $errline = null, $errcontext = null ) {
        printf( "Error: %d: %s\n", $errno, $errstr );
}

set_error_handler( 'my_error_handler', E_ALL | E_STRICT );
error_reporting(E_ALL | E_STRICT );


/**
 * Updates infoboxes of Pages with Census data enabled
 *
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @since Nov 2012 | MediaWiki 1.19
 *
 */
require __DIR__ . '/../../../../maintenance/commandLine.inc';
$wgUser = User::newFromName('Wikia');

CensusEnabledPagesUpdate::updatePages();
exit( 0 );
