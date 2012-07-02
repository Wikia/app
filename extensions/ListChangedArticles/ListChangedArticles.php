<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "ListChangeArticles extension";
	exit(1);
}

$wgExtensionCredits['specialpage '][] = array(
	'path'           => __FILE__,
	'name'           => 'ListChangedArticles',
	'author'         => '',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ListChangedArticles',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ListChangedArticles'] = $dir . 'ListChangedArticles_body.php';
$wgSpecialPages['ListChangedArticles'] = 'ListChangedArticles';
