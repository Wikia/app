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

// Load needed classes
$wgAutoloadClasses['AbstractLyricsApiHandler'] = $dir . '/LyricsHandlers/AbstractLyricsApiHandler.class.php';
$wgAutoloadClasses['SolrLyricsApiHandler'] = $dir . '/LyricsHandlers/SolrLyricsApiHandler.class.php';
$wgAutoloadClasses['LyricsApiController'] = $dir . '/LyricsApiController.class.php';

// Add new API controller to API controllers list
$wgWikiaApiControllers['LyricsApiController'] = $dir . '/LyricsApiController.class.php';

require_once( $dir . '/LyricsApiConstants.php' );

require_once( $IP . '/lib/vendor/Solarium/Autoloader.php' );
