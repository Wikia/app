<?php

# short util to find the key language.i18n.php will use for a particular phrase
# php getkey.php <"phrase to try"> [optional mediawiki language code]

$phrase = $argv[1];
require_once( "language.php" );

print "phrase: $phrase\n";
print "translatewiki.net key: " . WDLanguage::safe( $phrase ) . "\n";
$language = new WDLanguage();
print "translation:\n";
print "- default: " . $language->translate( $phrase ) . "\n";
if ( array_key_exists( 2, $argv ) ) {
	$language = new WDLanguage( $argv[2] );
	print "- " . $argv[2] . ": " . $language->translate( $phrase ) . "\n";
}

?>
