<?php

/* 
   This is the main entry point for DPL installations
   --------------------------------------------------
   
	In your LocalSettings.php you write:
   
        require_once( "$IP/extensions/DynamicPageList/DynamicPageList.php" );
		
	DPL has many features. If you do not want to enable all of them
	you can define the "Level of Functional Richness" you want to offer to your users.
	Make the following call in your LocalSettings.php after the require_once() statement:
	
        ExtDynamicPageList::setFunctionalRichness(  <n>  );
		
	where <n> is a number between 0 and 4.  
		
	If your wiki has been using Extension:Intersection you must UNINSTALL that 
	extension before you can use DynamicPageList (DPL).

	DPL is downward compatible with Extension:Intersection. It registers 
	the tag <DynamicPageList> and behaves exactly like ExtensionIntersection
	(without any additional functionality).

	Note that there are subtle differences in the default settings for order and ordermethod
	between <DynamicPageList> and <DPL>. Therefore you cannot always expect the same result
	if you change these tags.

	If your wiki has been using Extension:Intersection you may want to install
	DPL in parallel to that extension before you replace Extension:Intersection by DPL.
	In this case you must require_once("DynamicPageListMigration.php") instead of the current file
	in your LocalSettings.php.
	  
	Some functions of DPL are quite useful but if abused (by error or bad intention) they may put severe load
	on your server / database. For wikis up to 10.000 pages this is normally not a problem, 
	but with larger wikis some care is advisable.

	By default the RichnessLevel is set to 4 (= activate whole set of functions).

	Use a different value if you do not feel comfortable with this:
	-  level=0 will not allow any additional functionality (compared to Extension:Intersection).
	-  level=1 brings a series of improvements which will not affect performance
	-  level=2 brings some additional features which are roughly on the same level of database load
			   as the basic functionality; also contains content transclusion (which may require
               the DPL-cache on huge websites)
	-  level=3 brings more new features: selection based on regular expressions, queries on
	           revision level
	-  level=4 adds a few additional features which are useful for private websites (like batch updates)
               but should not be made available on huge public websites.
				
*/

// we register the tag <dpl> and function #dpl
// we also register the tag <DynamicPageList> because DPL is downward compatible with Extension:Intersection
// This means that your LocalSettings.php MUST NO LONGER include Extension:Intersection;

if( !defined( 'MEDIAWIKI' ) ) {
    die( 'This is not a valid entry point to MediaWiki.' );
}

$wgExtensionFunctions[]        = array( 'ExtDynamicPageList', 'setupDPL' );
$wgHooks['LanguageGetMagic'][] = 'ExtDynamicPageList__languageGetMagic';

$wgExtensionMessagesFiles['DynamicPageList'] =  dirname( __FILE__ ) . '/DynamicPageList.i18n.php';

$DPLVersion = '2.3.0';

$wgExtensionCredits['parserhook'][] = array(
	'path' 				=> __FILE__,
	'name' 				=> 'DynamicPageList (third party)',
	'author' 			=>  '[http://de.wikipedia.org/wiki/Benutzer:Algorithmix Gero Scholz]',
	'url' 				=> 'https://www.mediawiki.org/wiki/Extension:DynamicPageList_(third-party)',
	'descriptionmsg' 	=> 'dpl-desc',
  	'version' 			=> $DPLVersion
  );

require_once( 'DPLSetup.php' );

ExtDynamicPageList::$DPLVersion = $DPLVersion;

// use full functionality by default
ExtDynamicPageList::setFunctionalRichness(4);

