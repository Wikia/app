<?php

/**
 * parser tag for Comments all comments for article
 */

# Define a setup function
$wgExtensionFunctions[] = 'efBlogCommentsTag_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]       = 'efBlogCommentsTag_Magic';

function efBlogCommentsTag() {
        global $wgParser;
        # Set a function hook associating the "example" magic word with our function
        $wgParser->setFunctionHook( 'bloglistcomments', 'efBlogCommentsTag_Render' );
}

function efBlogCommentsTag_Magic( &$magicWords, $langCode ) {
        # Add the magic word
        # The first array element is case sensitive, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['bloglistcomments'] = array( 0, 'bloglistcomments' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

function efBlogCommentsTag_Render( &$parser, $param1 = '', $param2 = '' ) {
        # The parser function itself
        # The input parameters are wikitext with templates expanded
        # The output should be wikitext too
        $output = "param1 is $param1 and param2 is $param2";
        return $output;
}
