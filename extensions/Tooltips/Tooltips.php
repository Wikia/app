<?php
// Tooltips extension
// Adds the #tooltip parser function, which adds a tooltip to the enclosed text.
// Andrew Garrett, September 2010

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Tooltips',
	'version'        => '1.0',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Tooltips',
	'author'         => array( 'Andrew Garrett' ),
	'descriptionmsg' => 'tooltips-desc',
);

$wgExtensionMessagesFiles['Tooltips'] = dirname(__FILE__) . "/Tooltips.i18n.php";

$wgAutoloadClasses['Tooltips'] = dirname( __FILE__ ) . "/Tooltips.body.php";

// Parser Function Setup
$wgHooks['ParserFirstCallInit'][] = 'Tooltips::setupParserFunctions';
