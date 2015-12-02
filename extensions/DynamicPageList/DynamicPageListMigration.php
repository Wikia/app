<?php
/*
   This is a side entry point for Extension:DPL which is intended for migration purpose ONLY
   -----------------------------------------------------------------------------------------

   If your wiki has been using Extension:Intersection you can require_once() this file
   to install Extension:DPL in PARALLEL to Extension:Intersection.

   In your LocalSettings.php you write:

        require_once( "$IP/extensions/DynamicPageList/DynamicPageListMigration.php" );

   In this case DPL will NOT register the <DynamicPageList> tag.
   Instead it will register a tag named <Intersection> which behaves like <DynamicPageList>.

   You can test the compatibility by modifying some of your pages which use Extension:Intersection.
   Just _temporarily_ replace the tag <DynamicPageList> (which is used by Extension:Intersection)
   in a page by <Intersection> and you should not see any difference.

   This will help you to make testing and transition as smooth as possible.

   Once you have made sure that DPL works fine you should UNINSTALL Extension:Intersection
   and switch to the standard entry point 'DynamicPageList.php'.

   This will open the door to a rich set of additional functionality.
   You can decide how much of that additional functionality you want to offer to your users.
   See the documentation in DynamicPageList.php for more details.

*/

if (!defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}


// we do NOT register the tag <dpl> or the function #dpl
// we do NOT register the tag <DynamicPageList> - so this extension CAN CO-EXIST with Extension:Intersection
// instead we register the tag <Intersection> - so you can test in parallel
// The <Intersection> tag is configured in a way to be compatible wit Extension:INtersection.
// A call to ExtDynamicPageList::setFunctionalRichness(n) with n>0 will provide additional functionality
// for the <Intersection> tag; so you can try out additional features without bothering anyone.

$wgExtensionFunctions[]        = array( 'ExtDynamicPageList', 'setupMigration' );

$wgHooks['LanguageGetMagic'][] = 'ExtDynamicPageList__languageGetMagic';

$DPLVersion = '2.3.0';

$wgExtensionCredits['parserhook'][] = array(
	'path' 				=> __FILE__,
	'name' 				=> 'DynamicPageList',
	'author' 			=>  '[http://de.wikipedia.org/wiki/Benutzer:Algorithmix Gero Scholz]',
	'url' 				=> 'https://www.mediawiki.org/wiki/Extension:DynamicPageList_(third-party)',
	'descriptionmsg' 	=> 'dpl-desc',
  	'version' 			=> $DPLVersion
  );

require_once( 'DPLSetup.php' );

$wgMessagesDirs['DynamicPageList'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['DynamicPageList'] = dirname(__FILE__).'/DynamicPageList.i18n.php';

ExtDynamicPageList::$DPLVersion = $DPLVersion;

// be extremely restrictive by default: do not allow anything that goes beyond Extension:Intersection
// can be extended by a different call to this function in LocalSettings.php after the require_once()
ExtDynamicPageList::setFunctionalRichness(0);
