<?php

/**
 * parser tag for Comments all comments for article
 */

# Define a setup function
$wgExtensionFunctions[] = 'efBlogCommentsTag_Setup';
# Add a hook to initialise the magic word
$wgHooks[ "LanguageGetMagic" ][] = 'efBlogCommentsTag_Magic';
$wgHooks[ "ArticleFromTitle" ][] = "efBlogCommentsArticleFromTitle";

function efBlogCommentsTag_Setup() {
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

function efBlogCommentsTag_Render( &$parser ) {
	$args = func_get_args();
    return print_r( $args, 1 );
}

function efBlogCommentsArticleFromTitle( &$title, &$article ) {

	/**
	 * check if namespaces we care
	 */
	if( ! in_array( $title->getNamespace(), array( NS_BLOG_ARTICLE_TALK )  ) ){
		return true;
	}

	/**
	 * check if title is subpage, if it is subpage do nothing so far
	 */
	if( !$title->isSubpage() ) {
		return true;
	}

	/**
	 * check if article exists
	 */


	/**
	 * ... and eventually
	 */
	return true;
}
