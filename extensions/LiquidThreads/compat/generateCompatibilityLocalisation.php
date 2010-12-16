<?php
// Utility script to generate an extension messages file for backwards-compatibility.

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

$messages = array(
	'htmlform-reset',
	'htmlform-submit',
	'htmlform-int-invalid',
	'htmlform-int-toolow',
	'htmlform-int-toohigh',
	'htmlform-select-badoption',
	'htmlform-selectorother-other',
	'htmlform-invalid-input',
);

$languages = array_keys( Language::getLanguageNames( false ) );
$data = array_fill_keys( $languages, array() );

foreach ( $messages as $msg ) {
	print "\nGetting localisation for $msg...";
	foreach ( $languages as $lang ) {
		$data[$lang][$msg] = $wgMessageCache->get( $msg, false, $lang );
		print " $lang ";
	}
	print "\n";
}

$originalData = $data;

print "Eliminating redundant data... ";

foreach ( $languages as $lang ) {
	$fallback = Language::getFallbackFor( $lang );

	print " [$lang from $fallback] ";
	$lastFallback = $lang;

	while ( $fallback && !isset( $originalData[$fallback] ) && $fallback != $lastFallback ) {
		$lastFallback = $fallback;
		$fallback = Language::getFallbackFor( $lang );
	}

	if ( $fallback && isset( $originalData[$fallback] ) ) {
		$fallbackData = $originalData[$fallback];

		$data[$lang] = array_diff_assoc( $originalData[$lang], $fallbackData );

		if ( !count( $data[$lang] ) )
			unset( $data[$lang] );
	}
}

print "\nSaving...\n";

$export = "<?php\n" .
			"// This file is generated automatically by generateCompatibilityLocalisation.php\n" .
			'$messages = ' . var_export( $data, true ) . ";\n";

file_put_contents( 'Lqt-compat.i18n.php', $export );

print "Done\n";
