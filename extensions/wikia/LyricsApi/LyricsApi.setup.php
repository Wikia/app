<?php
/**
 * Lyrics API
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Evgeniy 'aquilax' Vasilev
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['api'][] = array(
	'name' => 'Lyrics API',
	'description' => 'Lyrics API',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Evgeniy "aquilax" Vasilev',
	),
	'version' => 1.0
);

$wgAutoloadClasses['AbstractLyricsApiHandler'] = $dir . '/LyricsHandlers/AbstractLyricsApiHandler.class.php';
$wgAutoloadClasses['MockLyricsApiHandler'] = $dir . '/LyricsHandlers/MockLyricsApiHandler.class.php';
$wgAutoloadClasses['LyricsApiController'] = $dir . '/LyricsApiController.class.php';

$wgWikiaApiControllers['LyricsApiController'] = "{$dir}/LyricsApiController.class.php";
