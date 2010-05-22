<?php
/**
 * this script should be run once a day
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 *
 */

ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

require_once( "commandLine.inc" );

if ( !function_exists( 'wfFounderEmailsInit' ) ) {
	require_once( dirname( __FILE__ ) . "/FounderEmails.php" );
	wfFounderEmailsInit();
}

FounderEmails::getInstance()->processEvents( 'daysPassed', true );
