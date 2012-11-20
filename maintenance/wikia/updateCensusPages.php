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
var_dump( is_readable( __DIR__ . '/../commandLine.inc' ) );
require __DIR__ . '/../commandLine.inc';
echo "command line loaded\n";
$oTitle = Title::newFromText('Dinosaur Minister');
var_dump($oTitle->getText());
CensusEnabledPagesUpdate::updatePages();
echo "end\n";
exit( 0 );
