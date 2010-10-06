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
		global $wgRequest, $wgUser, $wgTitle;

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
		if (defined('NS_BLOG_ARTICLE') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE) {
			$props = BlogArticle::getProps($wgTitle->getArticleID());
			$commentingAllowed = isset($props['commenting']) ? (bool)$props['commenting'] : true;
		}
		if (!$commentingAllowed) {
			return $result;
		}

		$comment = ArticleComment::newFromId( $commentId );
		if ( $comment ) {
			$comment->load();
			if ( $comment->canEdit() ) {
				$response = $comment->doSaveComment( $wgRequest, $wgUser, $title );
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
			$comment->load();
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
		global $wgRequest, $wgStylePath, $wgUser, $wgTitle;

		$commentId = $wgRequest->getVal( 'id', false );
		$result = array('id' => $commentId);

		if (wfReadOnly()) {
			$result['error'] = 1;
			$result['msg'] = wfMsg('readonlytext');
		} elseif (!$wgUser->isAllowed('edit')) {
			wfLoadExtensionMessages('ArticleComments');
			$result['error'] = 2;
			$result['msg'] = wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl('returnto=' . $wgTitle->getPrefixedUrl()));
		} else {
			$articleId = $wgRequest->getVal( 'article', false );

			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array(
					'commentId' => $commentId,
					'stylePath' => $wgStylePath
				)
			);
			wfLoadExtensionMessages('ArticleComments');
			$text = $template->execute( 'comment-reply' );
			$result['html'] = $text;
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
		global $wgRequest, $wgUser, $wgTitle, $wgLang, $wgArticleCommentsMaxPerPage;

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
		if (defined('NS_BLOG_ARTICLE') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE) {
			$props = BlogArticle::getProps($wgTitle->getArticleID());
			$commentingAllowed = isset($props['commenting']) ? (bool)$props['commenting'] : true;
		}
		if (!$commentingAllowed) {
			return $result;
		}

		$response = ArticleComment::doPost( $wgRequest, $wgUser, $title, $parentId );
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
			$status = $response[0];
			$article = $response[1];
			ArticleComment::doAfterPost($status, $article);

			$listing = ArticleCommentList::newFromTitle($title);
			$comments = $listing->getCommentPages(true, false);
			$countComments = count($comments);
			$countPages = ceil($countComments / $wgArticleCommentsMaxPerPage);
			if ($showall != 1 || $listing->getCountAllNested() > 200 /*see RT#64641*/) {
				$comments = array_slice($comments, ($page - 1) * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
			}

			$pagination = ArticleCommentList::doPagination($countComments, count($comments), $page, $title);

			// RT#68254
			if (get_class($wgUser->getSkin()) == 'SkinOasis') {
				// RT#69919
				$data = $listing->getData();
				$commentsHTML = wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $data['commentListRaw']));
				$counter = wfMsg('article-comments-comments', $wgLang->formatNum($listing->getCountAllNested()));
				$count = $wgLang->formatNum($listing->getCountAllNested());
				$counter = array(
				    'plain' =>		$count,
				    'header' =>		wfMsg('oasis-comments-header', $count),
				    'recent' =>		wfMsg('oasis-comments-showing-most-recent', $count)
				);
			} else {
				$commentsHTML = ArticleCommentList::formatList($comments);
				$counter = wfMsg('article-comments-comments', $wgLang->formatNum($listing->getCountAllNested()));
			}

			$result = array('text' => $commentsHTML, 'pagination' => $pagination, 'counter' => $counter);
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
			if (get_class($wgUser->getSkin()) == 'SkinOasis') {
				$text = wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $comments));
			} else {
				$text = ArticleCommentList::formatList($comments);
			}
			$pagination = ArticleCommentList::doPagination($listing->getCountAll(), count($comments), $page === false ? 1 : $page, $title);
		}

		$result = array('error' => $error, 'text' => $text, 'pagination' => $pagination);

		return $result;
	}
}