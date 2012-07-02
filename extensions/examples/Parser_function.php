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
$wgHooks['ParserFirstCallInit'][] = 'wfExampleParserFunction_Setup';
# Add a file to initialise the magic word
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Parser_functionMagic'] = $dir . 'Parser_function.i18n.magic.php';

function wfExampleParserFunction_Setup( $parser ) {
	# Set a function hook associating the "example" magic word with our function
	$parser->setFunctionHook( 'example', 'wfExampleParserFunction_Render' );
	return true;
}

function wfExampleParserFunction_Render( &$parser, $param1 = '', $param2 = '' ) {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output should be wikitext too
	return "param1 is $param1 and param2 is $param2";
}
