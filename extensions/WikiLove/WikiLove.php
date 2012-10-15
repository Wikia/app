<?php
/**
 * MediaWiki WikiLove extension
 * http://www.mediawiki.org/wiki/Extension:WikiLove
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * This program is distributed WITHOUT ANY WARRANTY.
 *
 * Heart icon by Mark James (Creative Commons Attribution 3.0 License)
 * Interface design by Brandon Harris
 */

/**
 * @file
 * @ingroup Extensions
 * @author Ryan Kaldari, Jan Paul Posma
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/WikiLove/WikiLove.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'WikiLove',
	'version' => '1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiLove',
	'author' => array(
		'Ryan Kaldari', 'Jan Paul Posma'
	),
	'descriptionmsg' => 'wikilove-desc',
);

// default user options
$wgWikiLoveGlobal  = false; // enable the extension for all users, removing the user preference
$wgWikiLoveTabIcon = true;  // use an icon for skins that support them (i.e. Vector)
$wgWikiLoveLogging = false; // enable logging of giving of WikiLove

// current directory including trailing slash
$dir = dirname( __FILE__ ) . '/';

// add autoload classes
$wgAutoloadClasses['ApiWikiLove']                 = $dir . 'ApiWikiLove.php';
$wgAutoloadClasses['ApiWikiLoveImageLog']         = $dir . 'ApiWikiLoveImageLog.php';
$wgAutoloadClasses['WikiLoveHooks']               = $dir . 'WikiLove.hooks.php';
$wgAutoloadClasses['WikiLoveLocal']               = $dir . 'WikiLove.local.php';

// i18n messages
$wgExtensionMessagesFiles['WikiLove']             = $dir . 'WikiLove.i18n.php';

// register hooks
$wgHooks['GetPreferences'][]                      = 'WikiLoveHooks::getPreferences';
$wgHooks['SkinTemplateNavigation'][]              = 'WikiLoveHooks::skinTemplateNavigation';
$wgHooks['SkinTemplateTabs'][]                    = 'WikiLoveHooks::skinTemplateTabs';
$wgHooks['BeforePageDisplay'][]                   = 'WikiLoveHooks::beforePageDisplay';
$wgHooks['LoadExtensionSchemaUpdates'][]          = 'WikiLoveHooks::loadExtensionSchemaUpdates';
$wgHooks['MakeGlobalVariablesScript'][]           = 'WikiLoveHooks::makeGlobalVariablesScript';

// api modules
$wgAPIModules['wikilove'] = 'ApiWikiLove';
$wgAPIModules['wikiloveimagelog'] = 'ApiWikiLoveImageLog';

$extWikiLoveTpl = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules/ext.wikiLove',
	'remoteExtPath' => 'WikiLove/modules/ext.wikiLove',
);

// messages for default options, because we want to use them in the default
// options module, but also for the user in the user options module
$wgWikiLoveOptionMessages = array(
	'wikilove-type-barnstars',
	'wikilove-type-food',
	'wikilove-type-kittens',
	'wikilove-type-makeyourown',
	'wikilove-barnstar-header',
	'wikilove-barnstar-select',
	'wikilove-barnstar-original-option',
	'wikilove-barnstar-original-desc',
	'wikilove-barnstar-original-title',
	'wikilove-barnstar-admins-option',
	'wikilove-barnstar-admins-desc',
	'wikilove-barnstar-admins-title',
	'wikilove-barnstar-antivandalism-option',
	'wikilove-barnstar-antivandalism-desc',
	'wikilove-barnstar-antivandalism-title',
	'wikilove-barnstar-diligence-option',
	'wikilove-barnstar-diligence-desc',
	'wikilove-barnstar-diligence-title',
	'wikilove-barnstar-diplomacy-option',
	'wikilove-barnstar-diplomacy-desc',
	'wikilove-barnstar-diplomacy-title',
	'wikilove-barnstar-goodhumor-option',
	'wikilove-barnstar-goodhumor-desc',
	'wikilove-barnstar-goodhumor-title',
	'wikilove-barnstar-brilliant-option',
	'wikilove-barnstar-brilliant-desc',
	'wikilove-barnstar-brilliant-title',
	'wikilove-barnstar-citation-option',
	'wikilove-barnstar-citation-desc',
	'wikilove-barnstar-citation-title',
	'wikilove-barnstar-civility-option',
	'wikilove-barnstar-civility-desc',
	'wikilove-barnstar-civility-title',
	'wikilove-barnstar-copyeditor-option',
	'wikilove-barnstar-copyeditor-desc',
	'wikilove-barnstar-copyeditor-title',
	'wikilove-barnstar-defender-option',
	'wikilove-barnstar-defender-desc',
	'wikilove-barnstar-defender-title',
	'wikilove-barnstar-editors-option',
	'wikilove-barnstar-editors-desc',
	'wikilove-barnstar-editors-title',
	'wikilove-barnstar-designers-option',
	'wikilove-barnstar-designers-desc',
	'wikilove-barnstar-designers-title',
	'wikilove-barnstar-half-option',
	'wikilove-barnstar-half-desc',
	'wikilove-barnstar-half-title',
	'wikilove-barnstar-minor-option',
	'wikilove-barnstar-minor-desc',
	'wikilove-barnstar-minor-title',
	'wikilove-barnstar-antispam-option',
	'wikilove-barnstar-antispam-desc',
	'wikilove-barnstar-antispam-title',
	'wikilove-barnstar-photographers-option',
	'wikilove-barnstar-photographers-desc',
	'wikilove-barnstar-photographers-title',
	'wikilove-barnstar-kindness-option',
	'wikilove-barnstar-kindness-desc',
	'wikilove-barnstar-kindness-title',
	'wikilove-barnstar-reallife-option',
	'wikilove-barnstar-reallife-desc',
	'wikilove-barnstar-reallife-title',
	'wikilove-barnstar-resilient-option',
	'wikilove-barnstar-resilient-desc',
	'wikilove-barnstar-resilient-title',
	'wikilove-barnstar-rosetta-option',
	'wikilove-barnstar-rosetta-desc',
	'wikilove-barnstar-rosetta-title',
	'wikilove-barnstar-special-option',
	'wikilove-barnstar-special-desc',
	'wikilove-barnstar-special-title',
	'wikilove-barnstar-surreal-option',
	'wikilove-barnstar-surreal-desc',
	'wikilove-barnstar-surreal-title',
	'wikilove-barnstar-teamwork-option',
	'wikilove-barnstar-teamwork-desc',
	'wikilove-barnstar-teamwork-title',
	'wikilove-barnstar-technical-option',
	'wikilove-barnstar-technical-desc',
	'wikilove-barnstar-technical-title',
	'wikilove-barnstar-tireless-option',
	'wikilove-barnstar-tireless-desc',
	'wikilove-barnstar-tireless-title',
	'wikilove-barnstar-writers-option',
	'wikilove-barnstar-writers-desc',
	'wikilove-barnstar-writers-title',
	'wikilove-type-food',
	'wikilove-food-select',
	'wikilove-food-baklava-option',
	'wikilove-food-baklava-desc',
	'wikilove-food-baklava-header',
	'wikilove-food-beer-option',
	'wikilove-food-beer-desc',
	'wikilove-food-beer-header',
	'wikilove-food-brownie-option',
	'wikilove-food-brownie-desc',
	'wikilove-food-brownie-header',
	'wikilove-food-bubbletea-option',
	'wikilove-food-bubbletea-desc',
	'wikilove-food-bubbletea-header',
	'wikilove-food-cheeseburger-option',
	'wikilove-food-cheeseburger-desc',
	'wikilove-food-cheeseburger-header',
	'wikilove-food-cookie-option',
	'wikilove-food-cookie-desc',
	'wikilove-food-cookie-header',
	'wikilove-food-coffee-option',
	'wikilove-food-coffee-desc',
	'wikilove-food-coffee-header',
	'wikilove-food-tea-option',
	'wikilove-food-tea-desc',
	'wikilove-food-tea-header',
	'wikilove-food-cupcake-option',
	'wikilove-food-cupcake-desc',
	'wikilove-food-cupcake-header',
	'wikilove-food-pie-option',
	'wikilove-food-pie-desc',
	'wikilove-food-pie-header',
	'wikilove-food-strawberries-option',
	'wikilove-food-strawberries-desc',
	'wikilove-food-strawberries-header',
	'wikilove-food-stroopwafels-option',
	'wikilove-food-stroopwafels-desc',
	'wikilove-food-stroopwafels-header',
	'wikilove-kittens-header',
);

// Because of bug 29608 we can't make a dependancy on a wiki module yet
// For now using 'using' to load the wiki module from within init.
$wgResourceModules += array(
	'ext.wikiLove.icon' => $extWikiLoveTpl + array(
		'styles' => 'ext.wikiLove.icon.css',
		'position' => 'top',
	),
	'ext.wikiLove.defaultOptions' => $extWikiLoveTpl + array(
		'scripts' => array(
			'ext.wikiLove.defaultOptions.js',
		),
		'messages' => $wgWikiLoveOptionMessages,
	),
	'ext.wikiLove.startup' => $extWikiLoveTpl + array(
		'scripts' => array(
			'ext.wikiLove.core.js',
		),
		'styles' => 'ext.wikiLove.css',
		'messages' => array(
			'wikilove-tab-text',
			'wikilove-dialog-title',
			'wikilove-select-type',
			'wikilove-get-started-header',
			'wikilove-get-started-list-1',
			'wikilove-get-started-list-2',
			'wikilove-get-started-list-3',
			'wikilove-add-details',
			'wikilove-image',
			'wikilove-select-image',
			'wikilove-header',
			'wikilove-title',
			'wikilove-enter-message',
			'wikilove-omit-sig',
			'wikilove-image-example',
			'wikilove-button-preview',
			'wikilove-preview',
			'wikilove-notify',
			'wikilove-button-send',
			'wikilove-err-header',
			'wikilove-err-title',
			'wikilove-err-msg',
			'wikilove-err-image',
			'wikilove-err-image-bad',
			'wikilove-err-image-api',
			'wikilove-err-sig',
			'wikilove-err-gallery',
			'wikilove-err-gallery-again',
			'wikilove-what-is-this',
			'wikilove-what-is-this-link',
			'wikilove-anon-warning',
			'wikilove-commons-text',
			'wikilove-commons-link',
			'wikilove-commons-url',
			'wikilove-err-preview-api',
			'wikilove-err-send-api',
			'wikilove-terms',
			'wikilove-terms-link',
			'wikilove-terms-url',
		),
		'dependencies' => array(
			'ext.wikiLove.defaultOptions',
			'jquery.ui.dialog',
			'jquery.ui.button',
			'jquery.localize',
			'jquery.elastic',
		),
	),
	'ext.wikiLove.local' => array(
		'class' => 'WikiLoveLocal',
	),
	'ext.wikiLove.init' => $extWikiLoveTpl + array(
		'scripts' => array(
			'ext.wikiLove.init.js',
		),
		'dependencies' => array(
			'ext.wikiLove.startup',
		),
	),
	'jquery.elastic' => array(
		'localBasePath' => dirname( __FILE__ ) . '/modules/jquery.elastic',
		'remoteExtPath' => 'WikiLove/modules/jquery.elastic',
		'scripts' => 'jquery.elastic.js',
	),
);
