<?php


/**
 * @return string
 */
function oaiDatestamp( $timestamp, $granularity = 'YYYY-MM-DDThh:mm:ssZ' ) {
	$formats = array(
		'YYYY-MM-DD'           => '$1-$2-$3',
		'YYYY-MM-DDThh:mm:ssZ' => '$1-$2-$3T$4:$5:$6Z' );
	if( !isset( $formats[$granularity] ) ) {
		wfDebugDieBacktrace( 'oaiFormatDate given illegal output format' );
	}
	return preg_replace(
		'/^(....)(..)(..)(..)(..)(..)$/',
		$formats[$granularity],
		wfTimestamp( TS_MW, $timestamp ) );
}

function oaiDebugNode( $node, $die=false ) {
	$doc = new DOMDocument( '1.0', 'utf-8' );
	$node2 = $doc->importNode( $node, true );
	$doc->appendChild( $node2 );
	print $doc->saveXML() . "\n";
	if( $die ) {
		die( 1 );
	}
}

