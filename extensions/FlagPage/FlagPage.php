<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FlagPage',
	'author' => 'Church of emacs',
	'url' => 'http://www.mediawiki.org/wiki/Extension:FlagPage',
	'description' => 'Flag article with predefined templates',
	'descriptionmsg' => 'flagarticle-desc',
	'version' => '0.1.1beta',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['FlagPage'] = $dir . 'FlagPage.body.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['FlagPageTabInstaller'] = $dir . 'FlagPage.hooks.php';
$wgExtensionMessagesFiles['FlagPage'] = $dir . 'FlagPage.i18n.php';
$wgExtensionAliasesFiles['FlagPage'] = $dir . 'FlagPage.alias.php';
$wgSpecialPages['FlagPage'] = 'FlagPage'; # Let MediaWiki know about your new special page.
$wgHooks['SkinTemplateTabs'][] = array( new FlagPageTabInstaller(), 'insertTab' ); # Hook displays the "flag" tab on pages
