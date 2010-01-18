<?php

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

define('DESCRIPTION_VERSION', '0.1');

$wgExtensionFunctions[] = 'DescriptionSetup';
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Description',
	'version' => DESCRIPTION_VERSION,
	'author' => 'Evan Prodromou',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Description',
	'description' => 'Adds a description meta-tag to MW pages');

function DescriptionSetup() {
	
	global $wgHooks;
	
	$wgHooks['ArticleViewHeader'][] = 'DescriptionArticleViewHeader';
}

function DescriptionArticleViewHeader(&$article, &$outputDone = null, &$pcache = null) {
	global $wgOut;
	
	$desc = "Wiki coverage on " . $article->mTitle->getText() . ". The latest quotes, charts, news, analyst research, historical returns, message board, due diligence, technical analysis, fundamentals...";
	
	if (!is_null($desc)) {
		$wgOut->addMeta('description', htmlspecialchars($desc));
	}
	
	return TRUE;
}


