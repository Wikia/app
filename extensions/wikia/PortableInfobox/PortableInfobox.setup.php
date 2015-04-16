<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'parserhook' ][] = [
	'name' => 'Portable Infobox',
	'author' => [
		'Adam Robak',
		'Jacek Jursza',
		'Mateusz Rybarski',
		'Rafał Leszczyński',
		'Sebastian Marzjan'
	],
	'descriptionmsg' => 'portable-infobox-desc',
	'version' => 0.1,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PortableInfobox'
];

$wgAutoloadClasses[ 'InfoboxServiceConnector' ] = $dir . 'InfoboxServiceConnector.class.php';
$wgAutoloadClasses[ 'PortableInfoboxRenderService' ] = $dir . 'services/PortableInfoboxRenderService.class.php';
//die("XXXX: $dir");
// parser
$wgAutoloadClasses[ 'PortableInfoboxMarkupParserService' ] = $dir . 'services/PortableInfoboxMarkupParserService.class.php';

// autoloads values in the Wikia\PortableInfobox namespace
spl_autoload_register( function( $class ) {
	if ( substr_count( $class, 'Wikia\\PortableInfobox\\' ) > 0 ) {
		$class = preg_replace( '/\\\\?Wikia\\\\PortableInfobox\\\\/', '', $class );
		$file = __DIR__ . '/services/'.strtr( $class, '\\', '/' ).'.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
			return true;
		}
		return false;
	}
});

// controller classes
$wgAutoloadClasses[ 'PortableInfoboxParserTagController' ] = $dir . 'controllers/PortableInfoboxParserTagController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxHooks' ] = $dir . 'PortableInfoboxHooks.class.php';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'PortableInfoboxParserTagController::parserTagInit';
$wgHooks['BeforePageDisplay'][] = 'PortableInfoboxHooks::onBeforePageDisplay';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'PortableInfoboxHooks::onSkinAfterBottomScripts';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfobox' ] = $dir . 'PortableInfobox.i18n.php';
