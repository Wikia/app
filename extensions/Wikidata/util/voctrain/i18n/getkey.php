<?php

#short util to find the key language.i18n.php will use for a particular phrase
# php getkey.php <"phrase to try"> [optional mediawiki language code]

$phrase=$argv[1];
require_once("language.php");

print "phrase: $phrase\n";
print "betawiki key: ".Language::safe($phrase)."\n";
$language=new Language();
print "translation:\n";
print "- default: " .$language->translate($phrase)."\n";
if (array_key_exists(2, $argv)) {
	$language=new Language($argv[2]);
	print "- ".$argv[2].": ".$language->translate($phrase)."\n";
}

?>
