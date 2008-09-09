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
	'author' => '[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]',
	'description' => 'Poll extension for MediaWiki driven by Ajax requests'
);

$wgExtensionFunctions[] = "wfAjaxPollTag";
$wgExtensionMessagesFiles["AjaxPoll"] = dirname(__FILE__) . '/AjaxPoll.i18n.php';
#--- helper file
require_once( dirname(__FILE__) . '/AjaxPoll_body.php' );

/**
 * wfPollParserTag
 *
 * register the extension with the WikiText parser
 * the first parameter is the name of the new tag.
 * In this case it defines the tag <Poll> ... </Poll>
 * the second parameter is the callback function for
 * processing the text between the tags
 *
 * @access public
 * @author eloy
 * @global
 */
function wfAjaxPollTag() {
	global $wgParser, $wgOut, $wgJsMimeType, $wgScriptPath, $wgMergeStyleVersionJS;
	$rand = $wgMergeStyleVersionJS;

	$wgParser->setHook( "poll", array( "AjaxPollClass", "renderFromTag" ) );
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgScriptPath}/extensions/wikia/AjaxPoll/AjaxPoll.js?{$rand}\" ></script>" );
	$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgScriptPath}/extensions/wikia/AjaxPoll/AjaxPoll.css?{$rand}\" />" );
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

	return Wikia::json_encode( $poll->doSubmit( $wgRequest ) );
}
$wgAjaxExportList[] = "axAjaxPollSubmit";
