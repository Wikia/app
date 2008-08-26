<?php
# MediaWiki Verbatim extension
# Syntax: <verbatim>mediawikimessage</verbatim> includes [[MediaWiki:Mediawikimessage]] verbatim.
	
$wgExtensionFunctions[] = "wfVerbatimExtension";

function wfVerbatimExtension() {
    global $wgParser;
    // register the extension with the WikiText parser
    // the first parameter is the name of the new tag. In this case it defines the tag <example> ... </example>
    // the second parameter is the callback function for processing the text between the tags
    $wgParser->setHook( "verbatim", "renderVerbatim" );
}

// The callback function for converting the input text to HTML output
function renderVerbatim( $input )
{
    return str_replace("\n",'',wfMsg(trim($input)));
}
?>
