<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * This tag extension creates <define> and <display> tags that can be used to display
 * wikicode somewhere in the same page other than where it is initially defined.
 *
 * See http://www.mediawiki.org/wiki/Extension:DelayedDefinition for details.
**/

$wgHooks['ParserFirstCallInit'][] = 'wfDelayedDefinition';

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'DelayedDefinition',
	'version'        => '0.5.0',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:DelayedDefinition',
	'author'         => 'Robert Rohde',
	'description'    => 'Allow for wikicode to be defined separately from where it is displayed',
	'descriptionmsg' => 'delaydef-desc',
);
$dir = dirname( __FILE__ );
$wgAutoloadClasses['ExtDelayedDefinition'] = $dir . '/DelayedDefinition_body.php';
$wgExtensionMessagesFiles['DelayedDefinition'] = $dir . '/DelayedDefinition.i18n.php';

// Load the classes, which then attaches the parser hooks, etc.
function wfDelayedDefinition( &$parser ) {
	new ExtDelayedDefinition( $parser );
	return true;
}
