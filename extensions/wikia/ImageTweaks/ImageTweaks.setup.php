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
$wgAutoloadClasses['ImageTweaksHooks'] = "{$dir}/ImageTweaksHooks.class.php";

/**
 * services
 */
$wgAutoloadClasses['ImageTweaksService'] = "{$dir}/ImageTweaksService.class.php";

/**
 * hooks
 */
//hook into Linker::MakeImageLink2
$wgHooks['ImageAfterProduceHTML'][] = 'ImageTweaksHooks::onImageAfterProduceHTML';

//hook into Linker::MakeThumbLink2
$wgHooks['ThumbnailAfterProduceHTML'][] = 'ImageTweaksHooks::onThumbnailAfterProduceHTML';

//hook into ImageThumbnail::toHTML
$wgHooks['ThumbnailImageHTML'][] = 'ImageTweaksHooks::onThumbnailImageHTML';

//hook into ThumbnailVideo::toHTML
$wgHooks['ThumbnailVideoHTML'][] = 'ImageTweaksHooks::onThumbnailVideoHTML';
