<?php

# ElmEasyRef 0.8.2b
# Add popup field to display reference's content
# When user click on reference he would be not jumped down to "References" section.
# Text will be shown in popup field
#
# Extension do not provide <ref> tags, you should use extension like Cite


# @addtogroup 
# @author Elancev Michael
# @copyright © 2011 by Elancev Michael
# @licence 


if( !defined( 'MEDIAWIKI' ) ) {
  echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
  die();
}

# Lang
$wgExtensionMessagesFiles['ElmEasyRef'] = dirname( __FILE__ ) . '/ElmEasyRef.i18n.php';

# Options

// If debug mode is on (true), debug messages will be enabled and uncompressed version of js-script will be attached
$wgElmEasyRefDebugMode = false;

// Full path to additional css file, which can change styles of referencefield.css
$wgElmEasyRefAddCSS = '';

// Field metrics
$wgElmEasyRefMetrics = array(
    // Min size of popup field
    'min_width'  => 140,
    'min_height' => 40,

    // Size of collapsed popup field
    'col_width'  => 400,
    'col_height' => 140,

    // Size of expanded popup field (Max size)
    // Note: popup apear in collapsed mode first.
    //       Expanded mode is for large references and opened with "More button"
    'exp_width'  => 400,
    'exp_height' => 380
);

// Animation properties
$wgElmEasyRefAnimation = array(
    // If true, enable apear animation
    'enable' => true,
    // Interval delay
    'delay'  => 50,
    // How long width and height will grow up
    'stepw'  => 2,
    'steph'  => 3     
);

// bodyContent: ID of element which contain articles body
$wgElmEasyRefBodyContentId = 'bodyContent';


// Regular expression to retrieve number of reference (for links look like: [123])
// (with no / /)
$wgElmEasyRefNum_rp = '(<.*?>)';    // strip that first
$wgElmEasyRefNum_mt = '([0-9]+)';   // search

# Hooks

$wgHooks['BeforePageDisplay'][] = 'elmEasyRefOutput';


# Credits

$wgExtensionCredits['other'][] = array(
        'path' => __FILE__,
        'name' => "ElmEasyRef",
        'descriptionmsg' => 'elm-easyref-desc',
        'version' => '0.8.2b',
        'author' => "Elancev Michael",
        'url' => "http://www.mediawiki.org/wiki/Extension:ElmEasyRef",
);


# Output hook

function elmEasyRefOutput( OutputPage $outputPage, $skin ) {

    global $wgScriptPath;

    // Options
    global $wgElmEasyRefAddCSS, 
           $wgElmEasyRefDebugMode,
           $wgElmEasyRefBodyContentId,
           $wgElmEasyRefAnimation,
           $wgElmEasyRefMetrics,
           $wgElmEasyRefNum_rp,
           $wgElmEasyRefNum_mt;

    // Register css for popup field
    $outputPage->addLink(
        array(
        'rel'   => 'stylesheet',
        'type'  => 'text/css',
        'href'  => $wgScriptPath . '/extensions/ElmEasyRef/css/referencefield.css'
        )
    );

    // Additonal css if setted
    if ( $wgElmEasyRefAddCSS ) {
        $outputPage->addLink(
            array(
                'rel'   => 'stylesheet',
                'type'  => 'text/css',
                'href'  => $wgElmEasyRefAddCSS
            )
        );
    }

    // Register js-script file
    $src = '/extensions/ElmEasyRef/js/elmEasyRef';
    if ( !$wgElmEasyRefDebugMode ){
        $src .= '-min';
    }
    $outputPage->addScript( Html::linkedScript( $wgScriptPath . $src . '.js' ) );

    // Settings
    $settings = '';
    if ( $wgElmEasyRefDebugMode ){
        $settings .= 'elmEasyRef.debug = true;';
    }
    if ( $wgElmEasyRefBodyContentId ){
        $settings .= 'elmEasyRef.bodyContentId = ' . Xml::encodeJsVar($wgElmEasyRefBodyContentId) . ';';
    }
    if ( $wgElmEasyRefNum_rp ){
        $settings .= 'elmEasyRef.regRefNum_rp = /' . $wgElmEasyRefNum_rp . '/;';
    }
    if ( $wgElmEasyRefNum_mt ){
        $settings .= 'elmEasyRef.regRefNum_mt = /' . $wgElmEasyRefNum_mt . '/;';
    }
    if ( $wgElmEasyRefAnimation ){
        foreach ( $wgElmEasyRefAnimation as $prop => $val ) {
            $settings .= 'elmEasyRef.animation.' . $prop . ' = ' . Xml::encodeJsVar($val) . ';';
        }
    }
    if ( $wgElmEasyRefMetrics ){
        foreach ( $wgElmEasyRefMetrics as $prop => $val ) {
            $settings .= 'elmEasyRef.fieldm.' . $prop . ' = ' . Xml::encodeJsVar($val) . ';';
        }
    }
    $msg = wfMsgExt( 'elm-easyref-ref', 'parseinline' );
    $settings .= 'elmEasyRef.messages.elm_easyref_ref = ' . Xml::encodeJsVar($msg) . ';';
    $msg = wfMsgExt( 'elm-easyref-close', 'parseinline' );
    $settings .= 'elmEasyRef.messages.elm_easyref_close = ' . Xml::encodeJsVar($msg) . ';';
    
    $outputPage->addInlineScript(
                '$( function() {' .
                    $settings . 'elmEasyRef.prepare();'.
                '} );'
            );

    return true;
}


