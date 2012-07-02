<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FlagPage',
	'author' => 'Church of emacs',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FlagPage',
	'descriptionmsg' => 'flagarticle-desc',
	'version' => '0.1.2beta',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['FlagPage'] = $dir . 'FlagPage.body.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['FlagPageTabInstaller'] = $dir . 'FlagPage.hooks.php';
$wgExtensionMessagesFiles['FlagPage'] = $dir . 'FlagPage.i18n.php';
$wgExtensionMessagesFiles['FlagPageAlias'] = $dir . 'FlagPage.alias.php';
$wgSpecialPages['FlagPage'] = 'FlagPage'; # Let MediaWiki know about your new special page.
$wgHooks['SkinTemplateTabs'][] = array( new FlagPageTabInstaller(), 'insertTab' ); # Hook displays the "flag" tab on pages
$wgHooks['SkinTemplateNavigation'][] = array( new FlagPageTabInstaller(), 'insertTabVector' ); # The same, but with the new hook for vector

