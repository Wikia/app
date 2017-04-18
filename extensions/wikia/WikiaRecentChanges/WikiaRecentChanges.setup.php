<?php
$wgExtensionCredits['specialpage'][] = [
	'name' => 'Fandom Recent Changes',
    'author' => 'Wikia',
    'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaRecentChanges',
    'description' => 'Customizes Special:RecentChanges with extra filter dropdowns'
];

spl_autoload_register( function ( $class ) {
	$prefix = 'RecentChanges\\';
	$dir = __DIR__ . '/src/';

	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$className = substr( $class, $len );
	$file = $dir . str_replace( '\\', '/', $className ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
} );

$wgSpecialPages['RecentChanges'] = \RecentChanges\SpecialPage::class;

$wgResourceModules['ext.wikia.RecentChanges'] = [
	'scripts' => 'WikiaRecentChanges.js',
    'styles' => 'RecentChanges.scss',
    'localBasePath' => __DIR__ . '/modules',
    'remoteExtPath' => 'wikia/WikiaRecentChanges'
];
