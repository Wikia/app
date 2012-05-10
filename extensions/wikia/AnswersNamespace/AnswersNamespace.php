<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AnswersNamespace/AnswersNamespace.php" );
EOT;
        exit( 1 );
}


define( 'NS_QUESTION', 112 );
define( 'NS_QUESTION_TALK', 113 );

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['AnswersNamespace'] = $dir . 'AnswersNamespace.i18n.php';
$wgExtensionNamespacesFiles['AnswersNamespace'] = $dir . 'AnswersNamespace.namespaces.php';
wfLoadExtensionNamespaces('AnswersNamespace', array( NS_QUESTION, NS_QUESTION_TALK ) );

$wgAjaxExportList[] = 'getQuestionSuggest';

$wgAutoloadClasses['AskYourQuestionController'] = $dir . 'AskYourQuestionController.php';
$wgAutoloadClasses['Question'] = $dir . 'Question.php';
$wgAutoloadClasses['QuestionPageController'] = $dir . 'QuestionPageController.php';
$wgAutoloadClasses['SpecialCreateQuestion'] = $dir . 'SpecialCreateQuestion.php';

$wgAvailableRights[] = 'ask-questions';
$wgGroupPermissions['*']['ask-questions'] = false;
$wgGroupPermissions['user']['ask-questions'] = true;

$wgHooks['ArticleCommentAfterPost'][] = 'wfANArticleCommentAfterPost';
$wgHooks['ArticleCommentsIndexAfterExecute'][] = 'wfANArticleCommentsIndexAfterExecute';
$wgHooks['BeforePageDisplay'][] = 'wfANBeforePageDisplay';
$wgHooks['BodyIndexAfterExecute'][] = 'wfANBodyIndexAfterExecute';
$wgHooks['GetRailModuleList'][] = 'wfANGetRailModuleList';
$wgHooks['userCan'][] = 'wfANuserCan';

$wgSpecialPages['CreateQuestion'] = 'SpecialCreateQuestion';

$wgContentNamespaces[] = NS_QUESTION;

// show article comments - these are used as answers
$wgArticleCommentsNamespaces[] = NS_QUESTION;

function getQuestionSuggest() {
	global $wgRequest;
	$query = urldecode( trim( $wgRequest->getText('query') ) );

	$srchres = PrefixSearch::titleSearch( $query, 10, array(NS_QUESTION) );
	array_walk( $srchres, create_function( '&$val', '$val = Title::newFromText($val)->getText();' ) );

	$res = new AjaxResponse();
	$res->setCacheDuration(60);
	$res->setContentType('application/json; charset=utf-8');
	$res->addText( Wikia::json_encode( array(
					'query' => $wgRequest->getText('query'),
					'suggestions' => $srchres,
					) ) );

	return $res;
}

// helper function
function wfANCheck( $title=null ) {
	global $wgTitle, $wgRequest, $wgOut;
	if( $title===null ) {
		$title = $wgTitle;
	}
	$action = $wgRequest->getVal( 'action', 'view' );

	return ( $action == 'view' )
		&& ( $title->getNamespace() == NS_QUESTION );
}

// move from un-answered to answered category
function wfANArticleCommentAfterPost( $status, &$articleComment) {
	global $wgContLang;

	$unansweredCat = Title::newFromText( wfMsgForContent('unanswered-category'), NS_CATEGORY );
	$answeredCat = Title::newFromText( wfMsgForContent('answered-category'), NS_CATEGORY );

	$article = new Article( ArticleComment::newFromArticle( $articleComment )->getArticleTitle()->getSubjectPage() );
	$content = $article->getContent();
	$content = str_ireplace( '[['.$unansweredCat->getPrefixedText().']]' , '', $content );
	if( strpos( $content, $answeredCat->getPrefixedText() ) === false ) {
		$content .= "\n".'[['.$answeredCat->getPrefixedText().']]';
	}
	if( $content != $article->getContent() ) {
		$article->doEdit($content, wfMsgForContent("new-question"), EDIT_UPDATE);
	}
	
	return true;
}

// display post new comment box at the top
function wfANArticleCommentsIndexAfterExecute( &$moduleObject, &$params ) {
	if( wfANCheck() ) {
		$moduleObject->getResponse()->getView()->setTemplatePath( dirname(__FILE__).'/templates/AnswersNamespaceComments_Index.php' );
	}
	return true;
}

// add css
function wfANBeforePageDisplay( &$out, &$sk ) {
	if( wfANCheck() ) {
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL("extensions/wikia/AnswersNamespace/AnswersNamespace.scss") );
	}
	return true;
}

// display comments before categories
function wfANBodyIndexAfterExecute( &$moduleObject, &$params ) {
	if( wfANCheck() ) {
		$moduleObject->headerModuleName = 'QuestionPage';
		$moduleObject->getResponse()->getView()->setTemplatePath( dirname(__FILE__).'/templates/AnswersNamespaceBody_Index.php' );
	}
	return true;
}

// ask a question module
function wfANGetRailModuleList( &$railModuleList ) {
	$railModuleList[1499] = array( 'AskYourQuestion', 'RailModule', null );
	return true;
}

// permissions
function wfANuserCan( &$title, &$user, $action, &$result ) {
	if( $action == 'edit' && $title->getNamespace() == NS_QUESTION ) {
		return $user->isAllowed( 'ask-question');
	}
	return true;
}
