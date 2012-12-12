<?php
/**
 * ImageTweaks
 *
 * @author Maciej Błaszkowski
 * @author Christian Williams
 * @author Federico "Lox" Lucignano <federco@wikia-inc.com>
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		"name" => "ImageSEO",
		"description" => "SEO tweaks for images in an article",
		"author" => array(
			'Maciej Błaszkowski',
			'Christian Williams',
			'Federico "Lox" Lucignano <federico@wikia-inc.com>'
		)
	),
	'other'
);

/**
 * classes
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/ImageTweaksHooks.class.php", 'ImageTweaksHooks' );

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/ImageTweaksService.class.php", 'ImageTweaksService' );

/**
 * hooks
 */
//hook into Linker::MakeImageLink2
$app->registerHook( 'ImageAfterProduceHTML', 'ImageTweaksHooks', 'onImageAfterProduceHTML' );

//hook into Linker::MakeThumbLink2
$app->registerHook( 'ThumbnailAfterProduceHTML', 'ImageTweaksHooks', 'onThumbnailAfterProduceHTML' );

//hook into ImageThumbnail::toHTML
$app->registerHook( 'ThumbnailImageHTML', 'ImageTweaksHooks', 'onThumbnailImageHTML' );

//hook into ThumbnailVideo::toHTML
$app->registerHook( 'ThumbnailVideoHTML', 'ImageTweaksHooks', 'onThumbnailVideoHTML' );
