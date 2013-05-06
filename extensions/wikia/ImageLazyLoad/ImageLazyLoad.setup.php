<?php
/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses[ 'ImageLazyLoad'] =  $dir . 'ImageLazyLoad.class.php' ;

/* Hooks */
$wgHooks['BeforePageDisplay'][] = 'ImageLazyLoad::onBeforePageDisplay';
$wgHooks['ParserClearState'][] = 'ImageLazyLoad::onParserClearState';
$wgHooks['ThumbnailImageHTML'][] = 'ImageLazyLoad::onThumbnailImageHTML';
$wgHooks['ThumbnailVideoHTML'][] = 'ImageLazyLoad::onThumbnailImageHTML';

// galleries
$wgHooks['GalleryBeforeRenderImage'][] = 'ImageLazyLoad::onGalleryBeforeRenderImage';