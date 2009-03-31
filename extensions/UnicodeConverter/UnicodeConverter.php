<?php

# This is a simple example of a special page module
# Given a string in UTF-8, it converts it to HTML entities suitable for
# an ISO 8859-1 web page.

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "Unicode Converter extension";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Unicode Converter',
	//'version' => '1.1',
	'author' => 'Tim Starling',
	'description' => 'A simple example of a special page module. Given a string in UTF-8, it converts it to HTML entities suitable for an ISO 8859-1 web page',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UnicodeConvertor',
	'descriptionmsg' => 'unicodeconverter-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['UnicodeConverter'] = $dir . 'UnicodeConverter.i18n.php';
$wgExtensionAliasesFiles['UnicodeConverter'] = $dir . 'UnicodeConverter.alias.php';
$wgAutoloadClasses['SpecialUnicodeConverter'] = $dir . 'UnicodeConverter_body.php';
$wgSpecialPages['UnicodeConverter'] = 'SpecialUnicodeConverter';
