<?php

include( '/usr/wikia/source/trunk/maintenance/commandLine.inc' );

$basePath = '/usr/wikia/source/trunk/extensions/wikia/';

$filesRaw = $basePath . 'CreatePage/CreatePage.i18n.php';

$files = explode( "\n", $filesRaw );

$dbr = wfGetDB( DB_SLAVE );

foreach ( $files as $file ) {
	$file = trim( $file );

	echo "Handling file: " . $file . "\n";

	# clear state
	$messages  = array();
	$collected = array();

	# include file here
	include_once( $file );

	# should never happen ;)
	if ( empty( $messages ) )
		continue;

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
}
