<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/CommentsOnly/CommentsOnly.php" );
EOT;
        exit( 1 );
}

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['CommentsOnly'] = $dir . 'CommentsOnly.i18n.php';

$wgHooks['ArticleCommentCheck'][] = 'wfCOArticleCommentCheck';
$wgHooks['ArticleViewHeader'][] = 'wfCOArticleViewHeader';
$wgHooks['BeforePageDisplay'][] = 'wfCOBeforePageDisplay';
$wgHooks['CategorySelect:beforeDisplayingView'][] = 'wfCOCategorySelectBeforeDisplayingView';
$wgHooks['ParserFirstCallInit'][] = 'wfCOQuestionBox';
$wgHooks['HistoryDropdownIndexAfterExecute'][] = 'wfCOHistoryDropdownIndexAfterExecute';
$wgHooks['HistoryDropdownPreviousEditsBeforeExecute'][] = 'wfCOHistoryDropdownPreviousEditsBeforeExecute';
$wgHooks['PageHeaderIndexAfterExecute'][] = 'wfCOPageHeaderIndexAfterExecute';

$wgSpecialPages['NewCommentsOnlyQuestion'] = 'SpecialNewCommentsOnlyQuestion';

$wgAutoloadClasses['SpecialNewCommentsOnlyQuestion'] = $dir . 'SpecialNewCommentsOnlyQuestion.php';

// show/hide article comments
$wgArticleCommentsNamespaces[] = NS_FORUM;

// where to hide article contents and show only comments
$wgCommentsOnlyNamespaces[] = NS_FORUM;
function wfCOArticleCommentCheck( $title ) {
	global $wgCommentsOnlyNamespaces;
	if( ( in_array( $title->getNamespace(), $wgCommentsOnlyNamespaces ) )
	 && ( ( $title->getText() == 'Index' ) || $title->equals( Title::newMainPage() ) ) ) {
		return false;
	}
	return true;
}

function wfCOCheck( $title=null ) {
	global $wgTitle, $wgCommentsOnlyNamespaces;
	if( $title===null ) {
		$title = $wgTitle;
	}
	return in_array( $title->getNamespace(), $wgCommentsOnlyNamespaces )
		&& $title->exists()
		&& $title->getText() != "Index"
		&& !$title->equals( Title::newMainPage() );
}

// show/hide article body
function wfCOArticleViewHeader( &$article, &$outputDone, &$useParserCache ) {
	if( wfCOCheck( $article->mTitle ) ) {
		$outputDone = true;
	}
	return true;
}

// add css
function wfCOBeforePageDisplay( &$out, &$sk ) {
	global $wgExtensionsPath, $wgStyleVersion;
	if( wfCOCheck() ) {
		$out->addExtensionStyle( "$wgExtensionsPath/wikia/CommentsOnly/CommentsOnly.css?$wgStyleVersion" );
	}
	return true;
}

// hide categories
function wfCOCategorySelectBeforeDisplayingView() {
	return !wfCOCheck();
}

function wfCOQuestionBox( &$parser ) {
	$parser->setHook( 'questionbox', 'wfCOQuestionBoxRender' );
	return true;
}

function wfCOQuestionBoxRender( $input, $argv, &$parser ) {
	global $wgUser;

	if( wfReadOnly() || !$wgUser->isAllowed('edit') || $wgUser->isBlocked() ) {
		return '';
	}

	wfLoadExtensionMessages('CommentsOnly');
	$submit = SpecialPage::getTitleFor("NewCommentsOnlyQuestion")->getLocalURL();
	$text = '';
	$width = 100; //TODO read params from input
	$label =  wfMsgHtml('comments-only-new-thread');
	$output = <<<ENDFORM
<div class="questionbox">
<form name="questionbox" action="{$submit}" method="get" class="questionboxForm">
<input class="questionboxInput" name="question" type="text" value="{$text}" size="{$width}"/>
<input type='submit' name="create" class="questionboxButton" value="{$label}"/>
</form></div>
ENDFORM;
	return $parser->replaceVariables( $output );
}

function wfCOHistoryDropdownIndexAfterExecute( &$moduleObject, &$params ) {
	if( wfCOCheck() ) {
		global $wgTitle;
		if( $wgTitle->getNamespace() == NS_FORUM ) {
			$moduleObject->forumHome = true;
		}
		$moduleObject->templatePath = dirname(__FILE__).'/templates/HistoryDropdown_Index.php';
		wfLoadExtensionMessages('CommentsOnly');
	}
	return true;
}

function wfCOHistoryDropdownPreviousEditsBeforeExecute( &$moduleObject, &$params ) {
	return !wfCOCheck();
}

function wfCOPageHeaderIndexAfterExecute( &$moduleObject, &$params ) {
	if( wfCOCheck() ) {
		wfLoadExtensionMessages('CommentsOnly');
		if( isset( $moduleObject->content_actions['delete'] ) ) {
			$moduleObject->action = $moduleObject->content_actions['delete'];
			$moduleObject->action['text'] = wfMsgHtml('comments-only-delete-thread');
			$moduleObject->actionName = 'delete';
		} else {
			$moduleObject->action = null;
			$moduleObject->actionName = '';
		}
		$moduleObject->dropdown = array();
		if( $moduleObject->revisions ) {
			global $wgTitle;
			$rev = $wgTitle->getFirstRevision();
			if($rev) {
				$user = User::newFromId( $rev->getUser() );
				if($user) {
					$moduleObject->revisions = array( 'current' => array(
								'user' => $user->getName(),
								'link' => AvatarService::renderLink( $user->getName() ),
								'avatarUrl' => AvatarService::getAvatarUrl( $user->getName() ),
								'timestamp' => wfTimestamp( TS_ISO_8601, $rev->getTimestamp() ),
								) );
				}
			}
		}
	}
	return true;
}
