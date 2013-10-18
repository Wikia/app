<?php

/**
 * ArticleComments
 *
 * A ArticleComments extension for MediaWiki
 * Adding comment functionality on article pages
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia.inc>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-07-14
 * @copyright Copyright (C) 2010 Krzysztof Krzyżaniak, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ArticleComments/ArticleComments_setup.php");
 */


$wgExtensionCredits['other'][] = array(
	'name' => 'ArticleComments',
	'version' => '2.0',
	'author' => array('[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

define('ARTICLECOMMENTORDERCOOKIE_NAME', 'articlecommentorder');
define('ARTICLECOMMENTORDERCOOKIE_EXPIRE', 60 * 60 * 24 * 365);
define('ARTICLECOMMENT_PREFIX', '@comment-');

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['ArticleCommentInit'] = "$dir/classes/ArticleCommentInit.class.php";
$wgAutoloadClasses['ArticleComment'] = "$dir/classes/ArticleComment.class.php";
$wgAutoloadClasses['ArticleCommentList'] = "$dir/classes/ArticleCommentList.class.php";
$wgAutoloadClasses['ArticleCommentsAjax'] = "$dir/classes/ArticleCommentsAjax.class.php";
$wgAutoloadClasses['ArticleCommentsController'] = "$dir/modules/ArticleCommentsController.class.php";
$wgAutoloadClasses['CommentsIndex'] = "$dir/classes/CommentsIndex.class.php";

$wgExtensionMessagesFiles['ArticleComments'] = dirname(__FILE__) . '/ArticleComments.i18n.php';

$wgAvailableRights[] = 'commentmove';
$wgAvailableRights[] = 'commentedit';
$wgAvailableRights[] = 'commentdelete';

$wgGroupPermissions['sysop']['commentmove'] = true;
$wgGroupPermissions['sysop']['commentedit'] = true;
$wgGroupPermissions['sysop']['commentdelete'] = true;

if (!empty($wgEnableWallEngine) || !empty($wgEnableArticleCommentsExt) || !empty($wgEnableBlogArticles)) {

	$wgHooks['ArticleDelete'][] = 'ArticleCommentList::articleDelete';
	$wgHooks['ArticleDeleteComplete'][] = 'ArticleCommentList::articleDeleteComplete';
	$wgHooks['ArticleRevisionUndeleted'][] = 'ArticleCommentList::undeleteComments';
	$wgHooks['RecentChange_save'][] = 'ArticleComment::watchlistNotify';
	// recentchanges
	$wgHooks['ChangesListMakeSecureName'][] = 'ArticleCommentList::makeChangesListKey';
	$wgHooks['ChangesListInsertArticleLink'][] = 'ArticleCommentList::ChangesListInsertArticleLink';
	$wgHooks['WikiaRecentChangesBlockHandlerChangeHeaderBlockGroup'][] = 'ArticleCommentList::setHeaderBlockGroup';
	// special::watchlist
	$wgHooks['ComposeCommonSubjectMail'][] = 'ArticleComment::ComposeCommonMail';
	$wgHooks['ComposeCommonBodyMail'][] = 'ArticleComment::ComposeCommonMail';
	// TOC
	$wgHooks['Parser::InjectTOCitem'][] = 'ArticleCommentInit::InjectTOCitem';
	// omit captcha
	$wgHooks['ConfirmEdit::onConfirmEdit'][] = 'ArticleCommentList::onConfirmEdit';
	// redirect
	$wgHooks['ArticleFromTitle'][] = 'ArticleCommentList::ArticleFromTitle';
	// init
	$wgHooks['CustomArticleFooter'][] = 'ArticleCommentInit::ArticleCommentEnableMonaco';
	$wgHooks['BeforePageDisplay'][] = 'ArticleCommentInit::ArticleCommentAddJS';
	$wgHooks['SkinTemplateTabs'][] = 'ArticleCommentInit::ArticleCommentHideTab';
	// user talk comment and notify
	$wgHooks['UserMailer::NotifyUser'][] = 'ArticleCommentInit::ArticleCommentNotifyUser';
	// blogs
	$wgHooks['UndeleteComplete'][] = 'ArticleCommentList::undeleteComplete';
	// prevent editing not own comments
	$wgHooks['userCan'][] = 'ArticleCommentInit::userCan';
	// HAWelcome
	$wgHooks['HAWelcomeGetPrefixText'][] = 'ArticleCommentInit::HAWelcomeGetPrefixText';

	// added by Moli
	// special::movepage
	$wgHooks['SpecialMovepageAfterMove'][] = 'ArticleComment::moveComments';

	$wgHooks['ParserFirstCallInit'][] = 'ArticleComment::metadataParserInit';

	$wgHooks['WikiaMobileAssetsPackages'][] = 'ArticleCommentInit::onWikiaMobileAssetsPackages';

	$wgHooks['BeforePageDisplay'][] = 'ArticleCommentsController::onBeforePageDisplay';
	$wgHooks['SkinAfterContent'][] = 'ArticleCommentsController::onSkinAfterContent';

	// adding comment_index rows for articles
	$wgHooks['ArticleDoEdit'][] = 'CommentsIndex::onArticleDoEdit';

	// comments_index table
	$wgHooks['LoadExtensionSchemaUpdates'][] = 'CommentsIndex::onLoadExtensionSchemaUpdates';

	$wgHooks['FilePageImageUsageSingleLink'][] = 'ArticleCommentInit::onFilePageImageUsageSingleLink';
}

$wgHooks['BeforeDeletePermissionErrors'][] = 'ArticleComment::onBeforeDeletePermissionErrors';

//JSMEssages setup
JSMessages::registerPackage( 'ArticleCommentsCounter', array(
	'oasis-comments-header',
	'oasis-comments-showing-most-recent'
));

JSMessages::registerPackage( 'WikiaMobileComments', array(
	'wikiamobile-article-comments-replies',
	'wikiamobile-article-comments-view',
	'wikiamobile-article-comments-post',
	'wikiamobile-article-comments-post-reply',
	'wikiamobile-article-comments-login-post',
	'wikiamobile-article-comments-post-fail'
));

// Ajax dispatcher
$wgAjaxExportList[] = 'ArticleCommentsAjax';

function ArticleCommentsAjax() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('ArticleCommentsAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = ArticleCommentsAjax::$method();

		if (is_array($data)) {
			// send array as JSON
			$json = json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}

		wfProfileOut(__METHOD__);
		return $response;
	}
}
