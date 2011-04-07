<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgHooks['ParserFirstCallInit'][] = 'wfSetupVariables';

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Variables',
        'version' => '1.2.2',
        'url' => 'http://www.mediawiki.org/wiki/Extension:VariablesExtension',
        'author' => 'Rob Adams, Tom Hempel and Daniel Werner',
        'description' => 'Define page-scoped variables',
);

$wgHooks['LanguageGetMagic'][]       = 'wfVariablesLanguageGetMagic';

class ExtVariables {
    var $mVariables = array();

    function vardefine( &$parser, $expr = '', $value = '' ) {
        $this->mVariables[$expr] = $value;
        return '';
    }

    function vardefineecho( &$parser, $expr = '', $value = '' ) {
        $this->mVariables[$expr] = $value;
        return $value;
    }

    function varf( &$parser, $expr = '', $defaultVal = '' ) {
        if ( isset( $this->mVariables[$expr] ) && $this->mVariables[$expr] != '' ) {
            return $this->mVariables[$expr];
        } else {
            return $defaultVal;
        }
    }

    function varexists( &$parser, $expr = '' ) {
        return array_key_exists($expr, $this->mVariables);
    }
}

function wfSetupVariables( $parser ) {
    global $wgExtVariables, $wgHooks;

    if (empty($wgExtVariables)) {
    	$wgExtVariables = new ExtVariables;
    }

    $parser->setFunctionHook( 'vardefine', array( &$wgExtVariables, 'vardefine' ) );
    $parser->setFunctionHook( 'vardefineecho', array( &$wgExtVariables, 'vardefineecho' ) );
    $parser->setFunctionHook( 'var', array( &$wgExtVariables, 'varf' ) );
    $parser->setFunctionHook( 'varexists', array( &$wgExtVariables, 'varexists' ) );
    return true;
}

function wfVariablesLanguageGetMagic( &$magicWords, $langCode = 0 ) {
        require_once( dirname( __FILE__ ) . '/Variables.i18n.php' );
        foreach( efVariablesWords( $langCode ) as $word => $trans )
            $magicWords[$word] = $trans;
        return true;
}
