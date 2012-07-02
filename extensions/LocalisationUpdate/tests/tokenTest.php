<?php

$IP = strval( getenv( 'MW_INSTALL_PATH' ) ) !== ''
	? getenv( 'MW_INSTALL_PATH' )
	: realpath( dirname( __FILE__ ) . "/../../../" );

require_once( "$IP/maintenance/commandLine.inc" );

function evalExtractArray( $php, $varname ) {
	eval( $php );
	return @$$varname;
}

function confExtractArray( $php, $varname ) {
	try {
		$ce = new ConfEditor("<?php $php");
		$vars = $ce->getVars();
		$retval = @$vars[$varname];
	} catch( Exception $e ) {
		print $e . "\n";
		$retval = null;
	}
	return $retval;
}

function quickTokenExtractArray( $php, $varname ) {
	$reader = new QuickArrayReader("<?php $php");
	return $reader->getVar( $varname );
}


if( count( $args ) ) {
	$sources = $args;
} else {
	$sources =
		array_merge(
			glob("$IP/extensions/*/*.i18n.php"),
			glob("$IP/languages/messages/Messages*.php") );
}

foreach( $sources as $sourceFile ) {
	$rel = basename( $sourceFile );
	$out = str_replace( '/', '-', $rel );

	$sourceData = file_get_contents( $sourceFile );

	if( preg_match( '!extensions/!', $sourceFile ) ) {
		$sourceData = LocalisationUpdate::cleanupExtensionFile( $sourceData );
		$items = 'langs';
	} else {
		$sourceData = LocalisationUpdate::cleanupFile( $sourceData );
		$items = 'messages';
	}

	file_put_contents( "$out.txt", $sourceData );

	$start = microtime(true);
	$eval = evalExtractArray( $sourceData, 'messages' );
	$deltaEval = microtime(true) - $start;

	$start = microtime(true);
	$quick = quickTokenExtractArray( $sourceData, 'messages' );
	$deltaQuick = microtime(true) - $start;

	$start = microtime(true);
	$token = confExtractArray( $sourceData, 'messages' );
	$deltaToken = microtime(true) - $start;

	$hashEval = md5(serialize($eval));
	$hashToken = md5(serialize($token));
	$hashQuick = md5(serialize($quick));
	$countEval = count( (array)$eval);
	$countToken = count( (array)$token );
	$countQuick = count( (array)$quick );

	printf( "%s %s %d $items - %0.1fms - eval\n", $rel, $hashEval, $countEval, $deltaEval * 1000 );
	printf( "%s %s %d $items - %0.1fms - QuickArrayReader\n", $rel, $hashQuick, $countQuick, $deltaQuick * 1000 );
	printf( "%s %s %d $items - %0.1fms - ConfEditor\n", $rel, $hashToken, $countToken, $deltaToken * 1000 );

	if( $hashEval !== $hashToken || $hashEval !== $hashQuick ) {
		echo "FAILED on $rel\n";
		file_put_contents( "$out-eval.txt", var_export( $eval, true ) );
		file_put_contents( "$out-token.txt", var_export( $token, true ) );
		file_put_contents( "$out-quick.txt", var_export( $quick, true ) );
		#die("check eval.txt and token.txt\n");
	}
	echo "\n";
}

echo "ok\n";

