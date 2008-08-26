<?php

# Guard against direct invocation from the web, print a friendly help message
#
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
<html><body>
<p>This is the Parser_function example extension. To enable it, put the 
following in your LocalSettings.php:</p>
<pre>
    require_once( "\$IP/extensions/examples/Parser_function.php" );
</pre></body></html>
EOT;
	exit( 1 );
}

# Define a setup function
$wgExtensionFunctions[] = 'wfExampleParserFunction_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]       = 'wfExampleParserFunction_Magic';

function wfExampleParserFunction_Setup() {
	global $wgParser;
	# Set a function hook associating the "example" magic word with our function
	$wgParser->setFunctionHook( 'example', 'wfExampleParserFunction_Render' );
}

function wfExampleParserFunction_Magic( &$magicWords, $langCode ) {
	# Add the magic word
	# The first array element is case sensitivity, in this case it is not case sensitive
	# All remaining elements are synonyms for our parser function
	$magicWords['example'] = array( 0, 'example' );
	return true;
}

function wfExampleParserFunction_Render( &$parser, $param1 = '', $param2 = '' ) {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output should be wikitext too
	return "param1 is $param1 and param2 is $param2";
}


