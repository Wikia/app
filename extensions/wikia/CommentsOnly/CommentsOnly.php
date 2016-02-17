<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/CommentsOnly/CommentsOnly.php" );
EOT;
	exit(1);
}

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'CommentsOnly',
	'author' => 'Wikia',
	'descriptionmsg' => 'comments-only-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CommentsOnly',
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['CommentsOnly'] = $dir . 'CommentsOnly.i18n.php';

$wgHooks['ArticleCommentCheck'][] = 'wfCOArticleCommentCheck';
$wgHooks['ArticleViewHeader'][] = 'wfCOArticleViewHeader';
$wgHooks['BeforePageDisplay'][] = 'wfCOBeforePageDisplay';
$wgHooks['CategorySelectArticlePage'][] = 'wfCOCategorySelectArticlePage';
$wgHooks['ParserFirstCallInit'][] = 'wfCOQuestionBox';
$wgHooks['PageHeaderIndexAfterExecute'][] = 'wfCOPageHeaderIndexAfterExecute';

$wgSpecialPages['NewCommentsOnlyQuestion'] = 'SpecialNewCommentsOnlyQuestion';

$wgAutoloadClasses['SpecialNewCommentsOnlyQuestion'] = $dir . 'SpecialNewCommentsOnlyQuestion.php';

// show/hide article comments
$wgArticleCommentsNamespaces[] = NS_FORUM;

// where to hide article contents and show only comments
$wgCommentsOnlyNamespaces[] = NS_FORUM;
function wfCOArticleCommentCheck(Title $title) {
	global $wgCommentsOnlyNamespaces;
	if ((in_array($title->getNamespace(), $wgCommentsOnlyNamespaces))
		&& (($title->getText() == 'Index') || $title->equals(Title::newMainPage()))
	) {
		return false;
	}
	return true;
}

function wfCOCheck($title = null) {
	global $wgTitle, $wgCommentsOnlyNamespaces;
	if ($title === null) {
		$title = $wgTitle;
	}
	return in_array($title->getNamespace(), $wgCommentsOnlyNamespaces)
		&& $title->exists()
		&& $title->getText() != "Index"
		&& !$title->equals(Title::newMainPage());
}

// show/hide article body
function wfCOArticleViewHeader(&$article, &$outputDone, $useParserCache) {
	if (wfCOCheck($article->mTitle)) {
		$outputDone = true;
	}
	return true;
}

// add css
function wfCOBeforePageDisplay(OutputPage &$out, &$sk) {
	global $wgExtensionsPath;
	if (wfCOCheck()) {
		$out->addExtensionStyle("$wgExtensionsPath/wikia/CommentsOnly/CommentsOnly.css");
	}
	return true;
}

// hide categories
function wfCOCategorySelectArticlePage() {
	return !wfCOCheck();
}

function wfCOQuestionBox(Parser &$parser) {
	$parser->setHook('questionbox', 'wfCOQuestionBoxRender');
	return true;
}

function wfCOQuestionBoxRender($input, $argv, Parser $parser) {
	global $wgUser;

	if (wfReadOnly() || !$wgUser->isAllowed('edit') || $wgUser->isBlocked( true, false )) {
		return '';
	}

	$submit = SpecialPage::getTitleFor("NewCommentsOnlyQuestion")->getLocalURL();
	$text = '';
	$width = 100; //TODO read params from input
	$label = wfMsgHtml('comments-only-new-thread');
	$output = <<<ENDFORM
<div class="questionbox">
<form name="questionbox" action="{$submit}" method="get" class="questionboxForm">
<input class="questionboxInput" name="question" type="text" value="{$text}" size="{$width}"/>
<input type='submit' name="create" class="questionboxButton" value="{$label}"/>
</form></div>
ENDFORM;
	return $parser->replaceVariables($output);
}

function wfCOPageHeaderIndexAfterExecute(&$controller, &$params) {
	if (wfCOCheck()) {
		if (isset($controller->content_actions['delete'])) {
			$action = $controller->content_actions['delete'];
			$action['text'] = wfMsgHtml('comments-only-delete-thread');
			$controller->actionName = 'delete';
			$controller->action = $action;
		} else {
			$controller->action = null;
			$controller->actionName = '';
		}

		$controller->dropdown = array();
		if ($controller->revisions) {
			global $wgTitle;
			$rev = $wgTitle->getFirstRevision();
			if ($rev) {
				$user = User::newFromId($rev->getUser());
				if ($user) {
					$controller->revisions = array('current' => array(
						'user' => $user->getName(),
						'link' => AvatarService::renderLink($user->getName()),
						'avatarUrl' => AvatarService::getAvatarUrl($user->getName()),
						'timestamp' => wfTimestamp(TS_ISO_8601, $rev->getTimestamp()),
					));
				}
			}
		}
	}
	return true;
}
