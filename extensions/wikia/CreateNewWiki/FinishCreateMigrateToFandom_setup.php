<?php

// PLATFORM-3647 temp hack to be removed after the switch
// On the first article view, migrate the wiki to fandom.com domain

$dir = dirname(__FILE__).'/';

function wfMigrateWikiToFandomCom($title, $article, $output, $user, WebRequest $request, $wiki) {
	global $wgCityId, $wgServer, $wgWikiaBaseDomain, $wgFandomBaseDomain, $wgMigrateNewWikiToFandomCom;
	if ( $wgMigrateNewWikiToFandomCom )	{ // sanity check
		$url = parse_url( $wgServer );
		$host = WikiFactory::normalizeHost( $url['host'] );
		if ( wfGetBaseDomainForHost( $host ) === $wgWikiaBaseDomain ) {
			$host = str_replace( '.' . $wgWikiaBaseDomain, '.' . $wgFandomBaseDomain, $host );
			WikiFactory::setmainDomain( $wgCityId, $host, 'CreateNewWiki post-create migration' );
			WikiFactory::setVarByName( 'wgMigrateNewWikiToFandomCom', $wgCityId, false, 'Domain migration' );
		}
	}
	return true;
}

$wgHooks['AfterInitialize'][] = 'wfMigrateWikiToFandomCom';
