<?php
/**
 * A Special Page extension that displays Wiki Google Webtools stats.
 * This page can be accessed from Special:Datalag
 * @addtogroup Extensions
 *
 * @author Andrew Yasinsky <andrewy@wikia.com>
 */

if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Datalag/Datalag.php" );
EOT;
	exit( 1 );
}

$wgAjaxExportList[] = 'datalagAjax';
$wgAjaxExportList[] = 'datalagsAjax';

function datalagAjax() {
	$host = 'none'; $lag = 0;
	$lb = wfGetLB();
	
	if( $lb->getServerCount() > 1 ) {
		list( $host, $lag ) = $lb->getMaxLag();
	}

	return new AjaxResponse( Wikia::json_encode( array( 
							'maxlag_host' => $host,
							'maxlag_sec' => $lag
							) 
	) );
}

function datalagsAjax() {
	$res = 'none';
	$lb = wfGetLB();

	if( $lb->getServerCount() > 1 ) {
		$res = $lb->getLagTimes();
	}

	return new AjaxResponse( Wikia::json_encode( array( 'lagdata' => $res ) ) );
}
