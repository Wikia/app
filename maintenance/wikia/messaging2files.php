<?php
putenv( 'SERVER_ID=4036' );
require_once( realpath( __DIR__ . '/../commandLine.inc' ) );

$USAGE =
	"Usage:\tphp messaging2files.php -f messages.i18n.php [[-v [--json]]\n" .
	"\toptions:\n" .
	"\t\t--help      show this message\n" .
	"\t\t-f          i18n file to which the messages from messaging will be imported\n" .
	"\t\t-v          display messages on the screen instead of writing to the file\n" .
	"\t\t--json      works ONLY with -v parameter returns messages in JSON format" .
	"\n";

$opts = getopt( 'f:v::', [ 'json' ] );
if( empty( $opts ) ) die( $USAGE );

$file = $opts['f'];
if( array_key_exists( 'f', $opts ) ) {
	if( !file_exists( $file ) ) {
		die( 'ERROR: The i18n file does not exist' . "\n" );
	}
} else {
	die( 'ERROR: No -f parameter passed' );
}

$noWrite = false;
if( array_key_exists( 'v', $opts ) ) {
	$noWrite = true;
}

$dbr = wfGetDB( DB_SLAVE );

$file = trim( $file );

echo "Handling file: " . $file . "\n";

# clear state
$messages  = array();
$collected = array();

# include file here
include_once( $file );

# should never happen ;)
if ( empty( $messages ) )
	die( 'No messages!' . "\n" );

foreach ( $messages['en'] as $key => $text ) {
	echo "Fetching articles from messaging for key = $key... ";

	$ucKey = ucfirst( $key );

	$query = "SELECT page_id AS id, page_title AS title FROM page WHERE page_namespace = 8 AND page_title LIKE '" .
                    $dbr->escapeLike( $ucKey ) . "/%'";

	$res = $dbr->query( $query );

	echo "Got " . $dbr->numRows( $res ) . " articles.\n";

	while ( $row = $dbr->fetchObject( $res ) ) {
		list( $cKey, $cLang ) = explode( '/', $row->title );
		$cKey = strtolower( $cKey );
		$oArticle = Article::newFromID( $row->id );
#			echo "Collected $cLang version of $cKey\n";
		$collected[$cLang][$cKey] = $oArticle->getContent();
	}
}

if( !$noWrite ) {
	$fh = fopen( $file, "a" );

	echo "\n*** WRITING TO FILE $file...\n";

	foreach ( $collected as $wLang => $wMessages ) {
		if ( !empty( $messages[$wLang] ) ) {
			continue;
		}

		echo "\tLang: $wLang\n";

		$langStart = "\n\n\$messages['$wLang'] = array(\n";
		fwrite( $fh, $langStart );

		foreach ( $wMessages as $msgKey => $msgText ) {
			# write a line to the file:
			# 'foo' => 'bar',
			$msgText = str_replace("'", "\'", $msgText );
			$msgLine = "\t'" . $msgKey . "' => '" . $msgText . "',\n";
			fwrite( $fh, $msgLine );
		}

		$langEnd = ");\n";
		fwrite( $fh, $langEnd );
	}

	echo "\nDONE!\n";

	fclose( $fh );
} else {
	echo "\n";

	$collected = array_merge( $messages, $collected );
	if( array_key_exists( 'json', $opts ) ) {
		$jsonOutput[ 'messages' ] = $collected;
		echo json_encode( $jsonOutput, JSON_UNESCAPED_UNICODE );
	} else {
		print_r( $collected );
	}

	echo "\nDONE!\n";
}
