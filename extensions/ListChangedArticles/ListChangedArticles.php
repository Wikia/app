<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "ListChangeArticles extension";
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ListChangedArticles'] = $dir . 'ListChangedArticles_body.php';
$wgSpecialPages['ListChangedArticles'] = 'ListChangedArticles';
