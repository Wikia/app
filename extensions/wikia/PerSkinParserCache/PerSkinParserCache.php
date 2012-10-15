<?php
/**
 * Setup file for PerSkinParserCache extension
 * @package MediaWiki
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

//info
global $wgExtensionCredits;

$wgExtensionCredits['other'][] = array(
	"name" => "Per-skin Parser Cache",
	"description" => "Makes the MediaWiki parser cache wikitext on a per-skin basis.",
	"url" => "http://help.wikia.com/wiki/Help:PerSkinParserCache",
	"author" => array(
		'Federico "Lox" Lucignano <federico@wikia-inc.com>'
	)
);

//hooks
global $wgHooks;

$wgHooks[ 'PageRenderingHash' ][] = 'perSkinParserCache_onPageRenderingHash';

function perSkinParserCache_onPageRenderingHash( &$hash ){
	$skinClass = get_class( RequestContext::getMain()->getSkin() );

	if ( $skinClass != 'SkinOasis' ){
		$hash .= '!' . $skinClass;
	}

	//wfDebug( "PER_SKIN_PARSER_CACHE_HASH: $hash" );
	return true;
}
