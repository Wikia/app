<?php
/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */
 
$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'ImageLazyLoad',
	'author' => 'Piotr Bablok',
	'descriptionmsg' => 'imagelazyload-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ImageLazyLoad',
);

$dir = dirname(__FILE__) . '/';

//i18n
$wgExtensionMessagesFiles['ImageLazyLoad'] = $dir . 'i18n/ImageLazyLoad.i18n.php';

$wgAutoloadClasses[ 'ImageLazyLoad'] =  $dir . 'ImageLazyLoad.class.php' ;

/* Hooks */
$wgHooks['BeforePageDisplay'][] = 'ImageLazyLoad::onBeforePageDisplay';
$wgHooks['ParserClearState'][] = 'ImageLazyLoad::onParserClearState';
$wgHooks['MakeGlobalVariablesScript'][] = 'ImageLazyLoad::onMakeGlobalVariablesScript';
$wgHooks['ThumbnailImageHTML'][] = 'ImageLazyLoad::onThumbnailImageHTML';
$wgHooks['ThumbnailVideoHTML'][] = 'ImageLazyLoad::onThumbnailImageHTML';

// galleries
$wgHooks['GalleryBeforeRenderImage'][] = 'ImageLazyLoad::onGalleryBeforeRenderImage';