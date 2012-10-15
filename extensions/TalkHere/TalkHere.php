<?php
/**
 * TalkHere extension - shows the talk page on page, on each page; provides inline editor for adding comments.
 *
 * NOTE: $wgUseAjax = true; is required for inline editing.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'TalkHere',
	'version' => '2008-01-19',
	'author' => 'Daniel Kinzler',
	'url' => 'http://mediawiki.org/wiki/Extension:TalkHere',
	'descriptionmsg' => 'talkhere-desc',
);

$wgTalkHereNamespaces = null; //namespaces to apply TalkHere to.

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['TalkHere'] = $dir . 'TalkHere.i18n.php';

///// hook it up /////////////////////////////////////////////////////
$wgAutoloadClasses['TalkHereHooks'] = $dir . 'TalkHereHooks.php';
$wgAutoloadClasses['TalkHereEditPage'] = $dir . 'TalkHereHooks.php';

$wgHooks['BeforePageDisplay'][] = 'TalkHereHooks::onBeforePageDisplay';
$wgHooks['CustomEditor'][] = 'TalkHereHooks::onCustomEditor';
$wgHooks['EditPage::showEditForm:fields'][] = 'TalkHereHooks::onShowEditFormFields';
$wgHooks['ArticleViewFooter'][] = 'TalkHereHooks::onArticleViewFooter';

$wgAjaxExportList[] = 'wfTalkHereAjaxEditor';

function wfTalkHereAjaxEditor( $page, $section, $returnto ) {
	global $wgRequest, $wgTitle, $wgOut;

	$title = Title::newFromText( $page );
	if ( !$title ) {
		return false;
	}

	//fake editor environment
	$args = array(
		'wpTalkHere' => '1',
		'wpReturnTo' => $returnto,
		'action' => 'edit',
		'section' => $section
	);

	$wgRequest = new FauxRequest( $args );
	$wgTitle = $title;

	$article = Article::newFromTitle( $title, RequestContext::getMain() );
	$editor = new TalkHereEditPage( $article );

	//generate form
	$editor->importFormData( $wgRequest );
	$editor->showEditForm();

	$response = new AjaxResponse();
	$response->addText( $wgOut->getHTML() );
	$response->setCacheDuration( false ); //don't cache, because of tokens etc

	return $response;
}
