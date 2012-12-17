<?php

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

$dbr = wfGetDB( DB_SLAVE );

global $wgContentNamespaces, $wgTitle, $wgOut, $wgArticle;

$contentNamespaces = implode(', ', $wgContentNamespaces);

$res = $dbr->query("SELECT COUNT(*) AS `count` FROM `page` WHERE page_is_redirect = 0 AND page_namespace IN ({$contentNamespaces});");

$row = $res->fetchRow();

$count = $row['count'];

$slice = 1000;
for ( $i = 0; $i <= $count; $i += $slice )
{
	$sql = "SELECT page_id FROM page WHERE page_is_redirect = 0 AND page_namespace IN ({$contentNamespaces}) LIMIT {$i},$slice";
	
	$res = $dbr->query($sql);
	
	$counter = 0;
	while ($row = $res->fetchRow()) {
	
		$pageid = $row['page_id'];
		
		$page = F::build( 'Article', array( $pageid ), 'newFromID' );
		
		if(!($page instanceof Article)) {
			continue;
		}

		$wgArticle = $page;
		
		// hack: setting wgTitle as rendering fails otherwise
		$wgTitle = $page->getTitle();
		
		echo "\t{$wgTitle} (id: {$pageid}, ".$counter++." of batch ".((int) $i/$slice)." of ".((int) ($count / $slice)).")\n";
		
		// hack: setting action=render to exclude "Related Pages" and other unwanted stuff
		$page->doPurge();
		$page->render();
		unset($page);
		$wgOut->clearHTML();
		Backlinks::clearRows();
	}
	
}