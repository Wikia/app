<?php
/**
 * TalkHere extension - shows the talk page on page, on each page; provides inline editor for adding comments.
 *
 * NOTE: $wgUseAjax = true; is required for inline editing.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'TalkHere',
	'version' => '2008-01-19',
	'author' => 'Daniel Kinzler',
	'url' => 'http://mediawiki.org/wiki/Extension:TalkHere',
	'description' => 'Puts the talk page into the article page',
	'descriptionmsg' => 'talkhere-desc',
);

$wgTalkHereNamespaces = NULL; //namespaces to apply TalkHere to.

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['TalkHere'] = $dir . 'TalkHere.i18n.php';

///// hook it up /////////////////////////////////////////////////////
$wgAutoloadClasses['TalkHereArticle'] = $dir . 'TalkHereArticle.php';
$wgAutoloadClasses['TalkHereEditTarget'] = $dir . 'TalkHereArticle.php';

$wgExtensionFunctions[] = 'wfTalkHereExtension';

$wgHooks['ArticleFromTitle'][] = 'wfTalkHereArticleFromTitle';
$wgHooks['CustomEditor'][] = 'wfTalkHereCustomEditor';
$wgHooks['EditPage::showEditForm:fields'][] = 'wfTalkHereShowEditFormFields';

$wgAjaxExportList[] = 'wfTalkHereAjaxEditor';

function wfTalkHereExtension( ) {
	global $wgOut, $wgScriptPath, $wgJsMimeType, $wgUseAjax;

	$wgOut->addLink(
		array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'href' => $wgScriptPath . '/extensions/TalkHere/TalkHere.css'
		)
	);

	if ( $wgUseAjax ) $wgOut->addScript(
		"<script type=\"{$wgJsMimeType}\" src=\"{$wgScriptPath}/extensions/TalkHere/TalkHere.js\">" .
		"</script>\n"
	);
}

function wfTalkHereArticleFromTitle( &$title, &$article ) {
	global $wgRequest, $wgTalkHereNamespaces;

	if (isset($title->noTalkHere)) return true; //stop recursion

	$action    = $wgRequest->getVal( 'action'    );
	$oldid     = $wgRequest->getVal( 'oldid'     );
	$diff      = $wgRequest->getVal( 'diff'      );

	if ($action == 'purge') $action = NULL; //"purge" is not considered an action in this context

	if ( $action || $oldid || $diff ) return true;

	$ns = $title->getNamespace();

	if ( !Namespace::isTalk($ns) && Namespace::canTalk($ns) && $title->exists()
		&& ( !$wgTalkHereNamespaces || in_array($ns, $wgTalkHereNamespaces) ) ) {
		$tns = Namespace::getTalk($ns);
		$talk = Title::makeTitle($tns, $title->getDBkey());

		if ($talk && $talk->userCan('read')) {
			$t = clone $title;
			$t->noTalkHere = true; //stop recursion

			$a = MediaWiki::articleFromTitle( $t );
			$article = new TalkHereArticle( $a, $talk );
		}
	}

	return true;
}

function mangleEditForm( &$out, $returnto = false, $ajax = false ) { //HACK! too bad we need this :(
	global $wgUser;
	$sk = $wgUser->getSkin();

	$html = $out->getHTML();

	if ( $returnto ) { //re-target cancel link
		$cancel = $sk->makeLink( $returnto, wfMsgExt('cancel', array('parseinline')) );
		$html = preg_replace( '!<a[^<>]+>[^<>]+</a>( *\| *<a target=["\']helpwindow["\'])!smi', $cancel . '\1', $html );
	}
	else  {
		$html = preg_replace( '!<a[^<>]+>[^<>]+</a> *\| *(<a target=["\']helpwindow["\'])!smi', '\1', $html );
	}

	$out->clearHTML();
	$out->addHTML($html);
}

function wfTalkHereCustomEditor( &$article, &$user ) {
	global $wgRequest, $wgOut;

	$action = $wgRequest->getVal( 'action' );
	$oldid = $wgRequest->getVal( 'oldid' );
	$returnto = $wgRequest->getVal( 'wpReturnTo' );
	$talkhere = $wgRequest->getVal( 'wpTalkHere' );
	if (!$talkhere || $action != 'submit' || !$returnto || $oldid) return true; //go on as normal

	$to = Title::newFromText($returnto);
	if (!$to) return true; //go on as normal

	//use a wrapper to override redirection target
	$a = new TalkHereEditTarget( $article, $to );
	$editor = new EditPage( $a );
	$editor->submit();

	mangleEditForm( $wgOut, $returnto ); //HACK. This sucks.
	return false;
}

function wfTalkHereShowEditFormFields( &$editor, &$out ) {
	global $wgRequest;

	$returnto = $wgRequest->getVal( 'wpReturnTo' );
	$talkhere = $wgRequest->getVal( 'wpTalkHere' );

	if ($talkhere && $returnto) {
		$out->addHTML('<input type="hidden" value="1" name="wpTalkHere" id="wpTalkHere" />');
		$out->addHTML('<input type="hidden" value="'.htmlspecialchars($returnto).'" name="wpReturnTo" id="wpReturnTo" />');
	}

	return true;
}

function wfTalkHereAjaxEditor( $page, $section, $returnto ) {
	global $mediaWiki, $wgRequest, $wgTitle, $wgArticle, $wgOut;

	$wgTitle = Title::newFromText($page);
	if ( !$wgTitle ) return false;

	//fake editor environment
	$args = array( 'wpTalkHere' => '1',
			'wpReturnTo' => $returnto,
			'action' => 'edit',
			'section' => $section );

	$wgRequest = new FauxRequest( $args );
	$wgArticle = $mediaWiki->initializeArticle( $wgTitle, $wgRequest );
	$editor = new EditPage( $wgArticle );

	//generate form
	$editor->importFormData( $wgRequest );
	$editor->showEditForm();

	mangleEditForm( $wgOut, false, true ); //HACK. This sucks.

	$response = new AjaxResponse();
	$response->addText( $wgOut->getHTML() );
	$response->setCacheDuration( false ); //don't cache, because of tokens etc

	return $response;
}
