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

class ArticleCommentsAjax {
	/**
	 * axSave -- static hook/entry for ajax request save comment
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- json-ized array
	 */
	static public function axSave() {
		global $wgRequest, $wgUser;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );

		$result = array(
			'error' => 1
		);

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return $result;
		}

		$commentingAllowed = true;
		if (defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE) {
			$props = BlogArticle::getProps($title->getArticleID());
			$commentingAllowed = isset($props['commenting']) ? (bool)$props['commenting'] : true;
		}
		if (!$commentingAllowed) {
			return $result;
		}

		$comment = ArticleComment::newFromId( $commentId );
		if ( $comment ) {
			$comment->load(true);
			if ( $comment->canEdit() ) {
				$text = $wgRequest->getText('wpArticleComment', false);
				$commentId = $wgRequest->getText('id', false);
				$response = $comment->doSaveComment( $text, $wgUser, $title, $commentId );
				if ( $response !== false ) {
					$status = $response[0];
					$article = $response[1];
					wfLoadExtensionMessages('ArticleComments');
					return ArticleComment::doAfterPost($status, $article, $commentId);
				}
			}
		}

		return $result;
	}

	/**
	 * axEdit -- static hook/entry for ajax request post -- edit comment
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- html -> textarea
	 */
	static public function axEdit() {
		global $wgRequest;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );

		$result = array(
			'error'	=> 1,
			'id'	=> $commentId,
			'show'	=> false,
			'text'	=> ''
		);

		/**
		 * check owner of article
		 */
		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return $result;
		}

		/**
		 * edit comment
		 */
		$comment = ArticleComment::newFromId( $commentId );
		if ( $comment ) {
			$comment->load(true);
			if ( $comment->canEdit() ) {
				$result['error'] = 0;
				$result['show'] = true;
				$result['text'] = $comment->editPage();
				$result['emptyMsg'] = wfMsg('article-comments-empty-comment', $comment->getTitle()->getLocalUrl('redirect=no&action=delete'));
			}
		}

		return $result;
	}

	/**
	 * axReply -- static hook/entry for ajax request post -- reply a comment
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- html -> textarea
	 */
	static public function axReply() {
		global $wgRequest, $wgStylePath, $wgUser;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );
		$result = array('id' => $commentId);
		wfLoadExtensionMessages('ArticleComments');

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			$result['error'] = 1;
			return $result;
		}

		if (wfReadOnly()) {
			$result['error'] = 1;
			$result['msg'] = wfMsg('readonlytext');
		} elseif (!$wgUser->isAllowed('edit')) {
			$result['error'] = 2;
			$result['msg'] = wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl('returnto=' . $title->getPrefixedUrl()));
		} else {
			$articleId = $wgRequest->getVal( 'article', false );

			$vars = array (
				'commentId' => $commentId,
				'stylePath' => $wgStylePath
			);
			$result['html'] = wfRenderPartial('ArticleComments', 'Reply', $vars);
		}

		return $result;
	}

	/**
	 * axPost -- static hook/entry for ajax request post
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- json-ized array`
	 */
	static public function axPost() {
		global $wgRequest, $wgUser, $wgLang, $wgArticleCommentsMaxPerPage;

		$articleId = $wgRequest->getVal( 'article', false );
		$parentId = $wgRequest->getVal( 'parentId' );
		$page = $wgRequest->getVal( 'page', 1 );
		$showall = $wgRequest->getText( 'showall', false );

		$result = array(
			'error' => 1
		);

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return $result;
		}

		$commentingAllowed = true;
		if (defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE) {
			$props = BlogArticle::getProps($title->getArticleID());
			$commentingAllowed = isset($props['commenting']) ? (bool)$props['commenting'] : true;
		}

		if (!$commentingAllowed) {
			return $result;
		}

		$response = ArticleComment::doPost( $wgRequest->getText('wpArticleComment', false), $wgUser, $title, $parentId );
		//RT#44830
		if ($title->getNamespace() == NS_USER_TALK &&
		 $response !== false &&
		 $response[0] == EditPage::AS_SUCCESS_NEW_ARTICLE &&
		 $title->getText() != $wgUser->getName()) {
			$user = User::newFromName($title->getText());
			if ($user) {
				$user->setNewtalk(true);
			}
		}

		if ( $response !== false ) {

			$listing = ArticleCommentList::newFromTitle($title);

			$addedComment = ArticleComment::newFromArticle($response[1]);

			$parts = ArticleComment::explode($addedComment->getTitle()->getDBkey());

			if(count($parts['partsOriginal']) == 1) {
				// level1 comment
				$comments = array($response[1]->getID() => array('level1' => $addedComment));
			} else {
				// level2 comment
				$addedCommentParent = ArticleComment::newFromId($parentId);
				$comments = array($parentId => array('level1' => $addedCommentParent, 'level2' => array($response[1]->getID() => $addedComment)));
			}

			// a very ugly hack...
			global $wgArticleCommentsEnableVoting;
			$tmp_wgArticleCommentsEnableVoting = $wgArticleCommentsEnableVoting;
			$wgArticleCommentsEnableVoting = false;
			// RT#68254 RT#69919 RT#86385
			if (get_class($wgUser->getSkin()) == 'SkinOasis') {
				$commentsHTML = wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $comments, 'page' => $page, 'useMaster' => true));
				$countAll = $wgLang->formatNum($listing->getCountAllNested());
				$countDisplayed = $countAll;
				if (!$showall && ($countAll > $wgArticleCommentsMaxPerPage)) {
					$countDisplayed = $wgLang->formatNum($wgArticleCommentsMaxPerPage);
				}
				$counter = array(
				    'plain' =>		$countAll,
				    'header' =>		wfMsg('oasis-comments-header', $countAll),
				    'recent' =>		wfMsg('oasis-comments-showing-most-recent', $countDisplayed)
				);
			} else {
				$commentsHTML = wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $comments, 'page' => $page, 'useMaster' => false));
				$counter = wfMsg('article-comments-comments', $wgLang->formatNum($listing->getCountAllNested()));
			}
			$wgArticleCommentsEnableVoting = $tmp_wgArticleCommentsEnableVoting;
			// Owen removed pagination from results since we ajax one comment at a time now RT#141141
			$result = array('text' => $commentsHTML, 'counter' => $counter);
		}

		return $result;
	}

	/**
	 * axGetComments -- static hook/entry for ajax request for pagination
	 *
	 * @static
	 * @access public
	 *
	 * @return String - HTML
	 */
	static function axGetComments() {
		global $wgRequest, $wgUser;

		$page = $wgRequest->getVal('page', false);
		$articleId = $wgRequest->getVal('article', false);
		$error = 0;
		$text = $pagination = '';

		$title = Title::newFromID($articleId);
		if ( !$title ) {
			$error = 1;
		} else {
			wfLoadExtensionMessages('ArticleComments');
			$listing = ArticleCommentList::newFromTitle($title);
			$comments = $listing->getCommentPages(false, $page);
			$text = wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $comments, 'page' => $page, 'useMaster' => false));
			$pagination = $listing->doPagination($listing->getCountAll(), count($comments), $page === false ? 1 : $page, $title);
		}

		$result = array('error' => $error, 'text' => $text, 'pagination' => $pagination);

		return $result;
	}
}
