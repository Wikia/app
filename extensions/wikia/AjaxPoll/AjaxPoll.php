<?php

/**
 * AJAX Poll extension for MediaWiki based on the work by Eric David
 *
 * licensed under the GFDL http://wikipoll.free.fr/mediawiki-1.6.5/index.php?title=Source_code
 * <Poll>
 * [Option]
 *  Question
 *  Answer 1
 *  Answer 2
 *  ...
 *  Answer n
 * </Poll>
 *
 */
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'AjaxPoll',
	'author' => [
		'[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]',
		'Maciej Brencz',
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'
	],
	'version' => '1.2',
	'description' => 'Poll extension for MediaWiki driven by Ajax requests',
	'url' => 'http://help.wikia.com/wiki/Help:Polls'
);

$wgHooks['ParserFirstCallInit'][] = "wfAjaxPollTag";
$wgExtensionMessagesFiles["AjaxPoll"] = __DIR__ . '/AjaxPoll.i18n.php';

/**
 * helper file
 */
require_once( __DIR__ . '/AjaxPoll_body.php' );

/**
 * additional table
 */
$wgHooks['LoadExtensionSchemaUpdates'][] = "AjaxPollClass::schemaUpdate";

/**
 * wfPollParserTag
 *
 * register the extension with the WikiText parser
 * the first parameter is the name of the new tag.
 * In this case it defines the tag <Poll> ... </Poll>
 * the second parameter is the callback function for
 * processing the text between the tags
 *
 * @param Parser $parser
 *
 * @access public
 * @author eloy
 * @global
 */
function wfAjaxPollTag( $parser ) {
	$parser->setHook( "poll", array( "AjaxPollClass", "renderFromTag" ) );
	return true;
}
/**
 * axAjaxPollSubmit
 *
 * entry point for ajax request submit
 *
 * @access public
 * @author eloy
 * @global
 */
function axAjaxPollSubmit() {
	global $wgRequest;

	$pool_id = $wgRequest->getVal( "wpPollId", null );
	$poll = AjaxPollClass::newFromId( $pool_id );

	return json_encode( $poll->doSubmit( $wgRequest ) );
}
$wgAjaxExportList[] = "axAjaxPollSubmit";
