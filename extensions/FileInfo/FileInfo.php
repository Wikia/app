<?php

// Stub extension created a couple years ago
// (c) Brion Vibber 2007-2011
// GPLv2 blah blah

// @todo add other file metadata types via {{#fileinfo:...}}

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FileInfoMagic'] = $dir . 'FileInfo.i18n.magic.php';

# Define a setup function
$wgExtensionFunctions[] = 'efFilesizeParserFunction_Setup';

function efFilesizeParserFunction_Setup() {
	global $wgParser;
	# Set a function hook associating the "filesize" magic word with our function
	$wgParser->setFunctionHook( 'filesize', 'efFilesizeParserFunction_Render' );
}

function efFilesizeParserFunction_Render( &$parser, $filename = '' ) {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output should be wikitext too
	$file = wfFindFile( $filename );
	if( $file && $file->exists() ) {
		global $wgContLang;
		return $wgContLang->formatSize( $file->getSize() );
	} else {
		return '';
	}
}
