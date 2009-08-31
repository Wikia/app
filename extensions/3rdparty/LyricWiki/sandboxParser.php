<?php
/**********************************************************************************

Copyright (C) 2006 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

***********************************************************************************

Version 0.1.0	2008-03
* Initial coding - teknomunk

***********************************************************************************/

// add this system call for MediaWiki Versions less than 1.11.1
if ( version_compare( $wgVersion, "1.11.1", '<' ) )
{
	function wfLoadExtensionMessages( $extension )
	{
		global $wgMessageCache,$wgExtensionMessagesFiles;
		
		// Adapted from MediaWiki 1.11.1
		require( $wgExtensionMessagesFiles[$extension] );
		foreach( $messages as $lang => $msgs )
		{
			$wgMessageCache->addMessages( $msgs, $lang );
		};
	};
};

function sandboxParse($wikiText)
{
	global $wgTitle, $wgUser, $wgParser, $wgExtensionFunctions, $wgVersion;

	// temporarily replace the global parser
	$old_wgParser = $wgParser;
	$wgParser = new Parser();
	$myParserOptions = new ParserOptions();

	// Setup extension functions for new parser.  This allows things like ParserFunctions to work 1.11.1 or greater
	// THIS DOES NOT WORK IN 1.7.1 AT ALL!!!!
	if ( version_compare( $wgVersion, "1.11.1", '>=' ) )
	{
		foreach ( $wgExtensionFunctions as $func )
		{
			$profName = $fname.'-extensions-'.strval( $func );
			wfProfileIn( $profName );
			call_user_func( $func );
			wfProfileOut( $profName );
		};

		$myParserOptions->setRemoveComments(true);
	}

	// use some sensible defaults
	$myParserOptions->initialiseFromUser($wgUser);
	$myParserOptions->setTidy(true);

	// do the parsing
	$result = $wgParser->parse($wikiText, $wgTitle, $myParserOptions);

	// restore the global parser
	$wgParser = $old_wgParser;

	// give the result
	return $result->getText();
}

?>