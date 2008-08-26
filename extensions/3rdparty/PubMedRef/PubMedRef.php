<?php

/* mybio.net extension + XSS fix */

# Example WikiMedia extension
# with WikiMedia's extension mechanism it is possible to define
# new tags of the form
# <TAGNAME> some text </TAGNAME>
# the function registered by the extension gets the text between the
# tags as input and can transform it into arbitrary HTML code.
# Note: The output is not interpreted as WikiText but directly
#       included in the HTML output. So Wiki markup is not supported.
# To activate the extension, include it from your LocalSettings.php
# with: include("extensions/YourExtensionName.php");

$wgExtensionFunctions[] = "wfPubMedExtension";

function wfPubMedExtension() {
    global $wgParser;
    # register the extension with the WikiText parser
    # the first parameter is the name of the new tag.
    # In this case it defines the tag <example> ... </example>
    # the second parameter is the callback function for
    # processing the text between the tags
    $wgParser->setHook( "pubmed", "renderPubMed" );
}

# The callback function for converting the input text to HTML output
function renderPubMed( $input, $argv, &$parser ) {
    # $argv is an array containing any arguments passed to the
    # extension like <example argument="foo" bar>..
    # Put this on the sandbox page:  (works in MediaWiki 1.5.5)
    #   <example argument="foo" argument2="bar">Testing text **example** in between the new tags</example>
    # $output = "Text passed into example extension: <br/>$input";
    $output = "<a href=\"http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?cmd=Search&db=PubMed&term=" . htmlspecialchars($input) . "\"><img src=\"http://www.mybio.net/wiki/images/7/77/Pubmed.gif\" alt=\"PubMed Reference: " . htmlspecialchars($argv["argument"]) . "  \"></a>";
    
    # $output = "<br/>[[http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?cmd=Search&db=PubMed&term=$input PubMed]]";
    
    # $output .= " <br/><a href=\"http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?cmd=Search&db=PubMed&term= " . $argv["argument"] . "\"";
    # $output .= " <br/> and the value for the arg 'argument2' is: " . $argv["argument2"];
    return $output;
}
