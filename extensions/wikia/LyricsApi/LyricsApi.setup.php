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
	'description' => 'Extension enabled on lyrics.wikia.com which provides an entry point for different parties, so they can get data about: an artist, an album, a song.',
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

