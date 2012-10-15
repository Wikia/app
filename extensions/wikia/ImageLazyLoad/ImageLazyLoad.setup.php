<?php
/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$app->registerClass( 'ImageLazyLoad', $dir . 'ImageLazyLoad.class.php' );

/* Hooks */
$app->registerHook( 'BeforePageDisplay', 'ImageLazyLoad', 'onBeforePageDisplay' );
$app->registerHook( 'ParserClearState', 'ImageLazyLoad', 'onParserClearState' );
$app->registerHook( 'ThumbnailImageHTML', 'ImageLazyLoad', 'onThumbnailImageHTML' );
$app->registerHook( 'ThumbnailVideoHTML', 'ImageLazyLoad', 'onThumbnailImageHTML' );

// galleries
$app->registerHook( 'GalleryBeforeRenderImage', 'ImageLazyLoad', 'onGalleryBeforeRenderImage' );