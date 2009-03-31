<?php
/**
 * Extension:SubstAll - Fully expands all contained templates to final wikisyntax,
 * similar to the ExpandTemplates extension by Tim Starling.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Chad Horohoe <innocentkiller@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionMessagesFiles['SubstAll'] = dirname(__FILE__) . '/' . 'SubstAll.i18n.php';
$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'SubstAll',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SubstAll',
	'author'         => 'Chad Horohoe',
	'description'    => 'Creates a <nowiki><substall></nowiki> tag that fully substitutes all contained text to final wikitext (full template expansion).',
	'descriptionmsg' => 'substall-desc',
);
$wgHooks['ArticleSave'][] = "efSubstAll";
$wgRemoveCommentsOnSubstAll = true; // <!-- Remove comment tags from output? -->

function efSubstAll( &$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags ) {
	wfLoadExtensionMessages( 'SubstAll' );
	$hook = wfMsgForContentNoTrans('substall-hook');
	if ( wfEmptyMsg('substall-hook', $hook ) )
		$hook = 'substall'; // Default to english if the local language isn't defined.
	$hook = trim( $hook ); // Pesky newlines and such
	$regex = '/\<' . $hook . '\>(.+?)\<\/' . $hook . '\>/';
	$text = preg_replace_callback( $regex, 'efSubstAllCallback', $text );
	return true;
}

function efSubstAllCallback( $matches ) {
	global $wgRemoveCommentsOnSubstAll, $wgParser, $wgTitle;
	$options = new ParserOptions;
	$options->setRemoveComments( $wgRemoveCommentsOnSubstAll );
	$matches[1] = $wgParser->preprocess( $matches[1], $wgTitle, $options );
	return $matches[1];
}
