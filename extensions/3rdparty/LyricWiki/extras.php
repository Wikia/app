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

function getDebugBacktrace($NL = "<BR>")
{
     $dbgTrace = debug_backtrace();
     $dbgMsg .= $NL."Debug backtrace begin:$NL";
     foreach($dbgTrace as $dbgIndex => $dbgInfo)
     {
         $dbgMsg .= "\t at $dbgIndex  ".$dbgInfo['file']." (line {$dbgInfo['line']}) -> {$dbgInfo['function']}()$NL";
     }
     $dbgMsg .= "Debug backtrace end".$NL;
     echo $dbgMsg;
 }


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
			$profName = __METHOD__.'-extensions-'.strval( $func );
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
	wfRunHooks( 'custom_SandboxParse', array( &$wikiText ) );
	$result = $wgParser->parse($wikiText, $wgTitle, $myParserOptions);
	$result = $result->getText();

	// restore the global parser
	$wgParser = $old_wgParser;

	// give the result
	return $result;
}

?>