<?php

$wgAjaxExportList [] = 'wfGetArticleJSON';
function wfGetArticleJSON($article_title){
	global $IP, $wgOut, $wgArticlePath, $wgServer;
	
	$wgArticlePath = $wgServer . $wgArticlePath;

	//I'm using an include taken from PEAR SERVICES_JSON
	//Change your instance here
	require_once( "$IP/extensions/wikia/JSON/JSON.php" );
	
	//construct mediawiki objects based on page title supplied
	$title = Title::newFromText($article_title);
	$article = new Article($title);
	
	if(! $article->exists() ){
		return "processJSON()";
	}
	
	$article_content = $article->getContent();
	$article_html = $wgOut->parse( $article_content, false );
	
	//cheap hack to fix non-existing wiki links
	$article_html = str_replace("<a href=\"/index.php?", "<a href=\"{$wgServer}/index.php?", $article_html);

	$article_a = array();
	$article_a["url"] = $title->getFullURL();
	$article_a["title"] = $title->getText();
	$article_a["last_edited"] = $article->getTimestamp();
	$article_a["html"] = $article_html;
	
	//Change JSON encode here
	$json = new Services_JSON();
	return "processJSON(" . $json->encode( $article_a ) . ")";
}
