<?php
/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */


$dir = dirname(__FILE__);
$wgAutoloadClasses['ImageLazyLoad'] = "$dir/ImageLazyLoad.class.php";


$app = F::app();
$app->registerHook( 'ThumbnailImageHTML', 'ImageLazyLoad', 'onThumbnailImageHTML' );
$app->registerHook( 'ThumbnailVideoHTML', 'ImageLazyLoad', 'onThumbnailImageHTML' );
$app->registerHook( 'ParserClearState', 'ImageLazyLoad', 'onParserClearState' );
$app->registerHook( 'BeforePageDisplay', 'ImageLazyLoad', 'onBeforePageDisplay' );

