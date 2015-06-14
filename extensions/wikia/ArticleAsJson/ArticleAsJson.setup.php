<?php

$wgExtensionCredits['other'][] = array(
	'name'				=> 'article.json',
	'version'			=> '0.1',
	'descriptionmsg'	=> 'articleasjson-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ArticleAsJson',
);

$dir = dirname(__FILE__) . '/';

//i18n
$wgExtensionMessagesFiles['ArticleAsJson'] = $dir . 'ArticleAsJson.i18n.php';

//classes
$wgAutoloadClasses['ArticleAsJson'] =  $dir . 'ArticleAsJson.class.php';
$wgAutoloadClasses['ArticleAsJsonParserException'] =  $dir . 'ArticleAsJsonParserException.class.php';

//hooks
$wgHooks['ImageBeforeProduceHTML'][] = 'ArticleAsJson::onImageBeforeProduceHTML';
$wgHooks['GalleryBeforeProduceHTML'][] = 'ArticleAsJson::onGalleryBeforeProduceHTML';
$wgHooks['PageRenderingHash'][] = 'ArticleAsJson::onPageRenderingHash';
$wgHooks['ParserAfterTidy'][] = 'ArticleAsJson::onParserAfterTidy';
$wgHooks['Parser::showEditLink'][] = 'ArticleAsJson::onShowEditLink';
$wgHooks['ParserLimitReport'][] = 'ArticleAsJson::reportLimits';
$wgHooks['PortableInfoboxNodeImage::getData'][] = 'ArticleAsJson::onPortableInfoboxNodeImageGetData';
