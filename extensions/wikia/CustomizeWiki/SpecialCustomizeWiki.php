<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$sSpecialPage = "CustomizeWiki";
$wgExtensionCredits['specialpage'][] = array(
    "name" => $sSpecialPage,
    "description" => "Customize Wiki Options",
    "version" => '0.1',
    "url" => "http://www.wikia.com/",
    "author" => "Krzysztof Krzyżaniak (eloy)"
);

#--- messages file
require_once( dirname(__FILE__) . "/Special{$sSpecialPage}.i18n.php" );

#--- Base class for CustomizeModule
require_once( dirname(__FILE__) . "/CustomizeModule.php" );

#--- ajax functions
require_once( dirname(__FILE__) . "/Special{$sSpecialPage}_ajax.php" );


#--- permissions
$wgAvailableRights[] = strtolower($sSpecialPage);
$wgGroupPermissions['staff'][strtolower($sSpecialPage)] = true;
$wgGroupPermissions['sysop'][strtolower($sSpecialPage)] = true;


#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( $GLOBALS["IP"]."/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . "/Special{$sSpecialPage}_body.php", $sSpecialPage, "{$sSpecialPage}Page" );
$wgSpecialPageGroups[$sSpecialPage] = 'wiki';

/**
 * add customization modules
 * Order is important!
 */
extAddCustomizeModule( dirname(__FILE__) . "/modules/WelcomeCustomizeModule.php", "welcome", "WelcomeCustomizeModule" );
extAddCustomizeModule( dirname(__FILE__) . "/modules/SkinCustomizeModule.php", "skin", "SkinCustomizeModule" );
extAddCustomizeModule( dirname(__FILE__) . "/modules/LogoCustomizeModule.php", "logo", "LogoCustomizeModule" );
