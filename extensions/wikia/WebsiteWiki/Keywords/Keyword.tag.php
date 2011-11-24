<?php

$wgHooks['ParserFirstCallInit'][] = "keymarkExtension";

function keymarkExtension( $parser ) {
    # register the extension with the WikiText parser
    # the first parameter is the name of the new tag.
    # In this case it defines the tag <example> ... </example>
    # the second parameter is the callback function for
    # processing the text between the tags
    $parser->setHook( "keywords", "renderKeypage" );
    return true;
}

# The callback function for converting the input text to HTML output
function renderKeypage( $input, $argv, $parser ) {
	global $wgContLang;

	$tokens   = explode( ",", trim( html_entity_decode( $input, ENT_QUOTES, "UTF-8" ) ) );
	$keywords = array();
	$output   = "";

	foreach( $tokens as $keyword ) {
		$keyword = substr( $wgContLang->lc( trim( $keyword ) ), 0, 80 );
		if( strlen( $keyword ) ) {
			$keywords[] = Wikia::linkTag(
				Title::makeTitle( NS_SPECIAL, sprintf( "Keyword/%s", $wgContLang->lc( $keyword ) )  )->getLocalURL(),
				$keyword
			);
		}
	}

	$keywords = array_unique( $keywords );
	Wikia::log( __METHOD__, "info", " Number of keywords: " . count( $keywords ) );

	if( count( $keywords ) ) {
		$output .= Xml::openElement( "span",  array( "class" => "small" ) );
		$output .= implode( ", ", $keywords );
		$output .= Xml::closeElement( "span" );
	}

	return $output;
}
