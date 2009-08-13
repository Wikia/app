<?php
/*
 * @author Bartek Łapiński
 */

if(!defined('MEDIAWIKI')) {
        exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'Image Gallery (Add Images)',
        'author' => 'Bartek Łapiński',
);

$dir = dirname(__FILE__).'/';

$wgHooks['BeforeParserrenderImageGallery'][] = 'ImageGalleryBeforeParserrenderImageGallery';

function ImageGalleryBeforeParserrenderImageGallery( $parser, $ig ) {
        // todo render gallery
        return true;
}

