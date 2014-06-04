<?php

$wgExtensionCredits['other'][] = array(
	'name'				=> 'article.json',
	'version'			=> '0.1',
	'descriptionmsg'	=> 'Extension that tries to extract from an article as much as we can to send it as an json to a client',
);

$app = F::app();
$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['SimpleJson'] =  $dir . 'SimpleJson.class.php';

//hooks
$wgHooks['ImageBeforeProduceHTML'][] = 'SimpleJson::onImageBeforeProduceHTML';
$wgHooks['GalleryBeforeProduceHTML'][] = 'SimpleJson::onGalleryBeforeProduceHTML';
$wgHooks['PageRenderingHash'][] = 'SimpleJson::onPageRenderingHash';
