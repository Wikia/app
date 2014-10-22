<?php

$wgExtensionCredits['other'][] = array(
	'name'				=> 'article.json',
	'version'			=> '0.1',
	'descriptionmsg'	=> 'Extension that extracts from an article as much as we can to send it as an json to a client',
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['ArticleAsJson'] =  $dir . 'ArticleAsJson.class.php';

//hooks
$wgHooks['ImageBeforeProduceHTML'][] = 'ArticleAsJson::onImageBeforeProduceHTML';
$wgHooks['GalleryBeforeProduceHTML'][] = 'ArticleAsJson::onGalleryBeforeProduceHTML';
$wgHooks['PageRenderingHash'][] = 'ArticleAsJson::onPageRenderingHash';
$wgHooks['ParserAfterTidy'][] = 'ArticleAsJson::onParserAfterTidy';
$wgHooks['Parser::showEditLink'][] = 'ArticleAsJson::onShowEditLink';
