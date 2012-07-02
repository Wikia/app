<?php
 
/**
 * Used to add Woopra Live Stat Tracking to your MediaWiki Instllation
 *
 * @file
 * @ingroup Extensions
 * @author Shane
 * @copyright © 2008-2009 FrakMedia! Productions, http://www.frakmedia.net/main/woopra
 * @license GNU General Public Licence 2.0 or later
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
        echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
        die( 1 );
}

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Woopra'] = $dir . 'Woopra.i18n.php';
 
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
        'name' => 'Woopra Live Stats Tracking',
        'author' => array( 'Shane' ),
        'version' => '1.1.0',
        'url' => 'https://www.mediawiki.org/wiki/Extension:Woopra',
	'descriptionmsg' => 'woopra-desc',
);
 
$wgHooks['BeforePageDisplay'][] = 'fnWoopraJavascript';

$wgWoopraSitekey = false;

function fnWoopraJavascript($out)
{
        global $wgUser, $wgWoopraSitekey;
 
		if ( $wgWoopraSitekey === false )
			return true;
 
        $html = "<script type=\"text/javascript\">\r\n";
        $html .= "woopra_id = '" . Xml::escapeJsString( $wgWoopraSitekey ) . "';\r\n";
 
        if (!$wgUser->isAnon())
        {
                $html .= "var woopra_array = new Array();\r\n";
                $html .= "woopra_array['name'] = '" .  Xml::escapeJsString( $wgUser->getRealName() ) . "';\r\n";
                $html .= "woopra_array['Email'] = '" . Xml::escapeJsString( $wgUser->getEmail() ) . "';\r\n";
                // Add custom tracking code here!
        }
        $html .= "</script>\r\n";
        $html .= "<script type=\"text/javascript\" src=\"http://static.woopra.com/js/woopra.js\"></script>";
 
        $out->addScript($html);
        return true;
}
