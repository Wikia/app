<?php
/**
 * NAME
 * 	Narayam
 *
 * SYNOPSIS
 *
 * INSTALL
 * 	Put this whole directory under your Mediawiki extensions directory
 * 	Then add this line to LocalSettings.php to load the extension
 *
 * 		require_once("$IP/extensions/Narayam.php");
 *
 *      Currently Vector and Monobook skins are supported
 *
 * AUTHOR
 * 	Junaid P V <http://junaidpv.in>
 *
 * @file
 * @ingroup extensions
 * @version 0.2
 * @copyright Copyright 2010 Junaid P V
 * @license GPLv3
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Narayam',
	'version' => 0.2,
	'author' => array( '[http://junaidpv.in Junaid P V]', 'Roan Kattouw' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Narayam',
	'descriptionmsg' => 'narayam-desc'
);

/* Configuration */

// Whether the input method should be active as default or not
$wgNarayamEnabledByDefault = true;

// Number of recently used input methods to be shown
$wgNarayamRecentItemsLength = 3;

// Whether the extension should load input methods in beta status
$wgNarayamUseBetaMapping = false;

// Array mapping language codes and scheme names to module names
// Custom schemes can be added here
$wgNarayamSchemes = array(
	'am' => array(
		'am' => array( 'ext.narayam.rules.am', 'beta' ),
	),
	'as' => array(
		'as' => 'ext.narayam.rules.as',
		'as-avro' => 'ext.narayam.rules.as-avro',
		'as-bornona' => 'ext.narayam.rules.as-bornona',
		'as-inscript' => 'ext.narayam.rules.as-inscript',
	),
	'bn' => array(
		'bn-avro' => 'ext.narayam.rules.bn-avro',
		'bn-inscript' => 'ext.narayam.rules.bn-inscript',
		'bn-nkb' => 'ext.narayam.rules.bn-nkb',
	),
	'brx' => array(
		'brx-inscript' => array( 'ext.narayam.rules.brx-inscript', 'beta' ),
	),
	'hne' => array(
		'hne-inscript' => array( 'ext.narayam.rules.hne-inscript', 'beta' ),
	),
	'de' => array(
		'de' => 'ext.narayam.rules.de',
	),
	'eo' => array(
		'eo' => 'ext.narayam.rules.eo',
	),
	'gom-deva' => array(
		'gom-deva' =>  array( 'ext.narayam.rules.gom-deva', 'beta' ),
		'gom-deva-inscript' => array( 'ext.narayam.rules.gom-deva-inscript', 'beta' ),
	),
	'gu' => array(
		'gu' => array( 'ext.narayam.rules.gu', 'beta' ),
		'gu-inscript' => array( 'ext.narayam.rules.gu-inscript', 'beta' ),
	),
	'he' => array(
		'he-standard-2011-extonly' =>  array( 'ext.narayam.rules.he-standard-2011-extonly', 'beta' ),
		'he-standard-2011' =>  array( 'ext.narayam.rules.he-standard-2011', 'beta' ),
	),
	'hi' => array(
		'hi' => 'ext.narayam.rules.hi',
		'hi-inscript' => 'ext.narayam.rules.hi-inscript',
	),
	'kn' => array(
		'kn' => 'ext.narayam.rules.kn',
		'kn-inscript' => 'ext.narayam.rules.kn-inscript',
	),
	'mai' => array(
		'mai-inscript' => array( 'ext.narayam.rules.mai-inscript', 'beta' ),
	),
	'ml' => array(
		'ml' => 'ext.narayam.rules.ml',
		'ml-inscript' => 'ext.narayam.rules.ml-inscript',
	),
	'mr' => array(
		'mr' => array( 'ext.narayam.rules.mr', 'beta' ),
		'mr-inscript' => array( 'ext.narayam.rules.mr', 'beta' ),
	),
	'ne' => array(
		'ne' => array( 'ext.narayam.rules.ne', 'beta' ),
		'ne-inscript' => array( 'ext.narayam.rules.ne-inscript', 'beta' ),
	),
	'or' => array(
		'or' => 'ext.narayam.rules.or',
		'or-lekhani' =>  array( 'ext.narayam.rules.or-lekhani', 'beta' ),
		'or-inscript' => 'ext.narayam.rules.or-inscript',
	),
	'pa' => array(
		'pa-inscript' => array( 'ext.narayam.rules.pa-inscript', 'beta' ),
		'pa-phonetic' => array( 'ext.narayam.rules.pa-phonetic', 'beta' ),
	),
	'rif' => array(
		'ber-tfng' => array( 'ext.narayam.rules.ber-tfng', 'beta' ),
	),
	'sa' => array(
		'sa' => 'ext.narayam.rules.sa',
		'sa-inscript' => 'ext.narayam.rules.sa-inscript',
	),
	'shi' => array(
		'ber-tfng' => array( 'ext.narayam.rules.ber-tfng', 'beta' ),
	),
	'si' => array(
		'si-singlish' => 'ext.narayam.rules.si-singlish',
		'si-wijesekara' => 'ext.narayam.rules.si-wijesekara',
	),
	'ta' => array(
		'ta' => 'ext.narayam.rules.ta',
		'ta-99' => 'ext.narayam.rules.ta-99',
		'ta-bamini' => array( 'ext.narayam.rules.ta-bamini', 'beta' ),
		'ta-inscript' =>  array( 'ext.narayam.rules.ta-inscript', 'beta' ),
	),
	'tcy' => array(
		'tcy' => array( 'ext.narayam.rules.tcy', 'beta' ),
	),
	'te' => array(
		'te' => array( 'ext.narayam.rules.te', 'beta' ),
		'te-inscript' => 'ext.narayam.rules.te-inscript',
	),
	'ur' => array(
		'ur' => array( 'ext.narayam.rules.ur', 'beta' ),
	),
	'ru' => array(
		'ru-standard' => array( 'ext.narayam.rules.ru-standard', 'beta' ),
	),
	'sah' => array(
		'sah-standard' => array( 'ext.narayam.rules.sah-standard', 'beta' ),
	),
);

/* Setup */

$dir = dirname( __FILE__ );

// Localization
$wgExtensionMessagesFiles['Narayam'] = $dir . '/Narayam.i18n.php';

// Register hook function
$wgHooks['BeforePageDisplay'][] = 'NarayamHooks::addModules';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'NarayamHooks::addConfig';
$wgHooks['MakeGlobalVariablesScript'][] = 'NarayamHooks::addVariables';
$wgHooks['GetPreferences'][] = 'NarayamHooks::addPreference';
$wgHooks['UserGetDefaultOptions'][] = 'NarayamHooks::addDefaultOptions';
$wgHooks['ResourceLoaderTestModules'][] = 'NarayamHooks::addTestModules';

// Autoloader
$wgAutoloadClasses['NarayamHooks'] = $dir . '/Narayam.hooks.php';

$wgNarayamPreferenceDefaultValue = true;

// ResourceLoader module registration
$narayamTpl = array(
	'localBasePath' => $dir,
	'remoteExtPath' => 'Narayam',
);
$wgResourceModules['ext.narayam'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.core'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.core.js',
	'styles' => 'resources/ext.narayam.core.css',
	'skinStyles' => array(
		'monobook' => 'resources/ext.narayam.core-monobook.css',
		'vector' => 'resources/ext.narayam.core-vector.css',
		'modern' => 'resources/ext.narayam.core-modern.css',
	),
	'messages' => array(
		'narayam-checkbox-tooltip',
		'narayam-menu',
		'narayam-menu-tooltip',
		'narayam-help',
		'narayam-toggle-ime',
		'narayam-more-imes',
		'narayam-am',
		'narayam-as',
		'narayam-as-avro',
		'narayam-as-bornona',
		'narayam-as-inscript',
		'narayam-bn-avro',
		'narayam-bn-inscript',
		'narayam-bn-nkb',
		'narayam-ber-tfng',
		'narayam-brx-inscript',
		'narayam-de',
		'narayam-eo',
		'narayam-gom-deva',
		'narayam-gom-deva-inscript',
		'narayam-gu',
		'narayam-gu-inscript',
		'narayam-he-standard-2011-extonly',
		'narayam-he-standard-2011',
		'narayam-hi',
		'narayam-hi-inscript',
		'narayam-hne-inscript',
		'narayam-mai-inscript',
		'narayam-kn',
		'narayam-kn-inscript',
		'narayam-ml',
		'narayam-ml-inscript' ,
		'narayam-mr',
		'narayam-mr-inscript',
		'narayam-ne',
		'narayam-ne-inscript',
		'narayam-or',
		'narayam-or-lekhani',
		'narayam-or-inscript',
		'narayam-pa-inscript',
		'narayam-pa-phonetic',
		'narayam-ru-standard',
		'narayam-sa',
		'narayam-sa-inscript',
		'narayam-sah-standard',
		'narayam-si-singlish',
		'narayam-si-wijesekara',
		'narayam-ta-99',
		'narayam-ta-inscript',
		'narayam-ta',
		'narayam-ta-bamini',
		'narayam-tcy',
		'narayam-te',
		'narayam-te-inscript',
		'narayam-ur',
	),
	'dependencies' => array(
		'mediawiki.util',
		'jquery.textSelection',
		'jquery.cookie',
	),
);
$wgResourceModules['ext.narayam.rules.am'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.am.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.as'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.as.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.as-avro'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.as-avro.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.as-bornona'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.as-bornona.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.as-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.as-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ber-tfng'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ber-tfng.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.bn-avro'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.bn-avro.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.bn-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.bn-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.bn-nkb'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.bn-nkb.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.de'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.de.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.brx-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.brx-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.eo'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.eo.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.he-standard-2011-extonly'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.he-standard-2011-extonly.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.he-standard-2011'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.he-standard-2011.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.hi'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.hi.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.hi-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.hi-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.kn'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.kn.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.kn-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.kn-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ml'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ml.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.mr'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.mr.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.mr-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.mr-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ml-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ml-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ne'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ne.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ne-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ne-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.or'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.or.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.or-lekhani'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.or-lekhani.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.or-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.or-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.pa-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.pa-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.pa-phonetic'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.pa-phonetic.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.sa'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.sa.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.sa-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.sa-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.si-singlish'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.si-singlish.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.si-wijesekara'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.si-wijesekara.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ta'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ta.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ta-99'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ta-99.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ta-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ta-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ta-bamini'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ta-bamini.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.te'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.te.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.te-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.te-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ur'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ur.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.gu'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.gu.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.gu-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.gu-inscript.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.ru-standard'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.ru-standard.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.sah-standard'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.sah-standard.js',
	'dependencies' => 'ext.narayam.core',
);
$wgResourceModules['ext.narayam.rules.hne-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.hne-inscript.js',
	'dependencies' => 'ext.narayam.rules.hi-inscript',
);
$wgResourceModules['ext.narayam.rules.gom-deva'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.gom-deva.js',
	'dependencies' => 'ext.narayam.rules.hi',
);
$wgResourceModules['ext.narayam.rules.gom-deva-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.gom-deva-inscript.js',
	'dependencies' => 'ext.narayam.rules.hi-inscript',
);
$wgResourceModules['ext.narayam.rules.mai-inscript'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.mai-inscript.js',
	'dependencies' => 'ext.narayam.rules.hi-inscript',
);
$wgResourceModules['ext.narayam.rules.tcy'] = $narayamTpl + array(
	'scripts' => 'resources/ext.narayam.rules.tcy.js',
	'dependencies' => 'ext.narayam.rules.kn',
);

