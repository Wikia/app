<?php
# MediaWiki Verbatim extension
# Syntax: <verbatim>mediawikimessage</verbatim> includes [[MediaWiki:Mediawikimessage]] verbatim.

$wgHooks['ParserFirstCallInit'][] = "wfVerbatimExtension";

/**
 * @param Parser $parser
 * @return bool
 */
function wfVerbatimExtension( $parser ) {
    // register the extension with the WikiText parser
    // the first parameter is the name of the new tag. In this case it defines the tag <example> ... </example>
    // the second parameter is the callback function for processing the text between the tags
    $parser->setHook( "verbatim", "renderVerbatim" );
    return true;
}

// The callback function for converting the input text to HTML output
function renderVerbatim( $input ) {
	global $wgEditInterfaceWhitelist, $wgVerbatimBlacklist;

	$formattedInput = ucfirst( trim( $input ) );
	// Begin wikia change
	if (
		( !empty( $wgEditInterfaceWhitelist )
			&& in_array( $formattedInput, $wgEditInterfaceWhitelist ) )
		|| ( !empty( $wgVerbatimBlacklist )
			&& in_array( $formattedInput, $wgVerbatimBlacklist ) )
		|| preg_match( '!\.(?:css|js)$!u', $formattedInput )
		|| startsWith( $formattedInput, Wikia::CUSTOM_INTERFACE_PREFIX, /* $case = */ false )
		|| startsWith( $formattedInput, Wikia::EDITNOTICE_INTERFACE_PREFIX, /* $case = */ false )
		|| startsWith( $formattedInput, Wikia::TAG_INTERFACE_PREFIX, /* $case = */ false )
	) {
		// Do not allow transclusion into Verbatim tags
		return '';
	}
	// End wikia change

    return str_replace("\n",'',wfMsg(trim($input)));
}
