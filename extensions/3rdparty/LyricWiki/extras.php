<?php
/**********************************************************************************

Copyright (C) 2006 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LyricWiki (http://lyrics.wikia.com)

***********************************************************************************

Version 0.1.0	2008-03
* Initial coding - teknomunk

***********************************************************************************/

function getDebugBacktrace($NL = "<BR>")
{
     $dbgTrace = debug_backtrace();
     $dbgMsg = $NL."Debug backtrace begin:$NL";
     foreach($dbgTrace as $dbgIndex => $dbgInfo)
     {
         $dbgMsg .= "\t at $dbgIndex  ".$dbgInfo['file']." (line {$dbgInfo['line']}) -> {$dbgInfo['function']}()$NL";
     }
     $dbgMsg .= "Debug backtrace end".$NL;
     echo $dbgMsg;
 }



function sandboxParse($wikiText)
{
	global $wgTitle, $wgParser, $wgVersion;

	// temporarily replace the global parser
	$old_wgParser = $wgParser;
	$wgParser = new Parser();
	$myParserOptions = new ParserOptions();

	// Setup extension functions for new parser.  This allows things like ParserFunctions to work 1.11.1 or greater
	// THIS DOES NOT WORK IN 1.7.1 AT ALL!!!!
	if ( version_compare( $wgVersion, "1.11.1", '>=' ) )
	{
		/**
		 * Wikia change - begin (@author: macbre)
		 * Commented out due to BugId:6864
		foreach ( $wgExtensionFunctions as $func )
		{
			$profName = __METHOD__.'-extensions-'.strval( $func );
			wfProfileIn( $profName );
			call_user_func( $func );
			wfProfileOut( $profName );
		};
		* Wikia change - end
		*/

		$myParserOptions->setRemoveComments(true);
	}

	// use some sensible defaults
	$myParserOptions->setTidy(true);

	// do the parsing
	wfRunHooks( 'custom_SandboxParse', array( &$wikiText ) );
	$wgTitle = (empty($wgTitle) ? new Title() : $wgTitle);
	$result = $wgParser->parse($wikiText, $wgTitle, $myParserOptions); /* @var $result ParserOutput */
	$result = $result->getText();

	// restore the global parser
	$wgParser = $old_wgParser;

	// give the result
	return $result;
}

////
// Sends a read-only mySQL query and assumes that there will be one result.
// Returns that result if available, empty string otherwise.
////
function lw_simpleQuery($queryString){
	$retVal = "";
	$db = wfGetDB(DB_SLAVE)->getProperty('mConn');

	// TODO: use Database class instead
	if($result = mysql_query($queryString,$db)){
		if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
			$row = mysql_fetch_row($result);
			$retVal = $row[0];
		}
	}
	return $retVal;
} // end lw_simpleQuery()
