<?php
 
/**
 * Used to add Woopra Live Stat Tracking to your MediaWiki Instllation
 *
 * @addtogroup Extensions
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
        'name' => 'Woopra Live Stats Tracking',
        'author' => array( 'Shane'),
        'version' => '1.0.0',
        'url' => 'http://www.mediawiki.org/wiki/Extension:Woopra',
        'description' => 'Allows for the [http://www.woopra.com/ Woopra Live Tracking Software] to work for your MediaWiki installation',
	'descriptionmsg' => 'woopra-desc',
);
 
$wgHooks['BeforePageDisplay'][] = 'fnWoopraJavascript';
 
function fnWoopraJavascript($out)
{
        global $wgUser, $wgWoopraSitekey;
 
        $html = "<script type=\"text/javascript\">\r\n";
        $html .= "woopra_id = '" . $wgWoopraSitekey . "';\r\n";
 
        if (!$wgUser->isAnon())
        {
                $html .= "var woopra_array = new Array();\r\n";
                $html .= "woopra_array['name'] = '" . $wgUser->getRealName() . "';\r\n";
                $html .= "woopra_array['Email'] = '" . $wgUser->getEmail() . "';\r\n";
                // Add custom tracking code here!
        }
        $html .= "</script>\r\n";
        $html .= "<script type=\"text/javascript\" src=\"http://static.woopra.com/js/woopra.js\"></script>";
 
        $out->addScript($html);
        return true;
}
