<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$dir = dirname( __FILE__ );

// Register extension credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Kieli',
	'version' => 2011-10-23,
	#'url' => 'http://www.mediawiki.org/wiki/Extension:Kieli',
	'descriptionmsg' => 'kieli-desc'
);

// Localization
$wgExtensionMessagesFiles['Kieli'] = $dir . '/Kieli.i18n.php';

// Register hook function
$wgHooks['BeforePageDisplay'][] = 'Kieli::addModules';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'Kieli::addConfig';

class Kieli {
	public static function addModules( $out, $skin ) {
		$out->addModules( 'ext.kieli' );
		return true;
	}

	public static function addConfig( &$vars ) {
		global $wgLang;
		$names = Language::getTranslatedLanguageNames( $wgLang->getCode() );
		$vars['wgKieliLanguages'] = $names;
		return true;
	}
}

$wgResourceModules['ext.kieli'] = array(
	'localBasePath' => $dir,
	'remoteExtPath' => 'Kieli',
	'scripts' => 'ext.kieli.js',
	'styles' => 'ext.kieli.css',
	'messages' => array( 'kieli-load' ),
	'dependencies' => array( 'mediawiki.Uri', 'jquery.ui.autocomplete' ),
);

