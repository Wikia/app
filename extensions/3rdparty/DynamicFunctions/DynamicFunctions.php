<?php
/*

 Defines a subset of parser functions that must clear the cache to be useful.

 {{#arg:name}} Returns the value of the given URL argument.  Can also be called
               with a default value, which is returned if the given argument is
               undefined or blank: {{#arg:name|default}}

 {{#ip:}}      Returns the current user IP.

 {{#rand:a|b}} Returns a random value between a and b, inclusive.  Can
               also be called with a single value; {{#rand:6}} returns a
               random value between 1 and 6 (equivalent to a dice roll).

 {{#skin:}}    Returns the name of the current skin.

 Author: Algorithm [http://meta.wikimedia.org/wiki/User:Algorithm]
 Version 1.0 (5/21/06)

*/

$wgHooks['ParserFirstCallInit'][] = 'wfDynamicFunctions';
$wgExtensionCredits['parserhook'][] = array(
'name' => 'DynamicFunctions v1.0',
'url' => 'http://www.mediawiki.org/wiki/Extension:DynamicFunctions',
'author' => 'Ross McClure',
'description' => 'Defines an additional set of parser functions.'
);

$wgHooks['LanguageGetMagic'][] = 'wfDynamicFunctionsLanguageGetMagic';

/**
 * @param Parser $parser
 * @return bool
 */
function wfDynamicFunctions( $parser ) {
    global $wgExtDynamicFunctions;

    if (empty($wgExtDynamicFunctions)) {
    	$wgExtDynamicFunctions = new ExtDynamicFunctions();
    }

    $parser->setFunctionHook( 'arg', array( &$wgExtDynamicFunctions, 'arg' ) );
    $parser->setFunctionHook( 'ip', array( &$wgExtDynamicFunctions, 'ip' ) );
    $parser->setFunctionHook( 'rand', array( &$wgExtDynamicFunctions, 'rand' ) );
    $parser->setFunctionHook( 'skin', array( &$wgExtDynamicFunctions, 'skin' ) );
    return true;
}

function wfDynamicFunctionsLanguageGetMagic( &$magicWords, $langCode ) {
    switch ( $langCode ) {
    default:
            $magicWords['arg']    = array( 0, 'arg' );
            $magicWords['ip']     = array( 0, 'ip' );
            $magicWords['rand']   = array( 0, 'rand' );
            $magicWords['skin']   = array( 0, 'skin' );
    }
    return true;
}

class ExtDynamicFunctions
{

	/**
	 * @param Parser $parser
	 * @return bool
	 */
    function arg( &$parser, $name = '', $default = '' )
    {
        global $wgRequest;
        $parser->disableCache();
        return $wgRequest->getVal($name, $default);
    }

	/**
	 * @param Parser $parser
	 * @return bool
	 */
    function ip( &$parser )
    {
        $parser->disableCache();
        return wfGetIP();
    }

	/**
	 * @param Parser $parser
	 * @return bool
	 */
    function rand( &$parser, $a = 0, $b = 1 )
    {
        $parser->disableCache();
        return mt_rand( intval($a), intval($b) );
    }

	/**
	 * @param Parser $parser
	 * @return bool
	 */
    function skin( &$parser )
    {
        global $wgUser, $wgRequest;
        $parser->disableCache();
        return $wgRequest->getVal('useskin', $wgUser->getGlobalPreference('skin'));
    }
}

