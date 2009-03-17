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
	global $wgParser, $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgHooks;

	$wgParser->setHook( "poll", array( "AjaxPollClass", "renderFromTag" ) );

	// add JS
	$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AjaxPoll/AjaxPoll.js?{$wgStyleVersion}\" ></script>\n");

	// add CSS
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'wfAjaxPollAddCSS';
}

/**
 * wfAjaxPollAddCSS
 *
 * Adds extension CSS to <head> section
 *
 * @access public
 * @author macbre
 * @global
 */

function wfAjaxPollAddCSS(&$skin, &$tpl) {
	global $wgExtensionsPath, $wgStyleVersion;
	$tpl->data['headlinks'] .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/AjaxPoll/AjaxPoll.css?{$wgStyleVersion}\" />\n";
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

	return Wikia::json_encode( $poll->doSubmit( $wgRequest ) );
}
$wgAjaxExportList[] = "axAjaxPollSubmit";
