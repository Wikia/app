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

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return array( 'error' => 1 );
		}

		$comment = ArticleComment::newFromId( $commentId );
		if ( $comment && $comment->canEdit() ) {
			$response = $comment->doSaveComment( $wgRequest, $wgUser, $title );
			if ( $response !== false ) {
				$status = $response[0];
				$article = $response[1];
				wfLoadExtensionMessages('ArticleComments');
				return ArticleComment::doAfterPost($status, $article, $commentId);
			}
		} else {
			return array( 'error' => 1 );
		}
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

		$commentId = $wgRequest->getVal( 'id', false );
		$articleId = $wgRequest->getVal( 'article', false );
		$error = 0;

		/**
		 * check owner of article
		 */
		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			$error = 1;
		}

		/**
		 * edit comment
		 */
		$comment = ArticleComment::newFromId( $commentId );
		if ( $comment && $comment->canEdit() ) {
			$status  = true;
			$text = $comment->editPage();
		} else {
			$status = false;
			$text = '';
			$error = 1;
		}

		$result = array(
			'id'	=> $commentId,
			'error'	=> $error,
			'show'	=> $status,
			'text'	=> $text
		);

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
		global $wgRequest, $wgStylePath;

		if (wfReadOnly()) {
			$result = array('error' => 1, 'msg' => wfMsg('readonlytext'));
		} else {
			$commentId = $wgRequest->getVal( 'id', false );
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
			$result = array('id' => $commentId, 'html' => $text);
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
		global $wgRequest, $wgUser, $wgArticleCommentsMaxPerPage;

		$articleId = $wgRequest->getVal( 'article', false );
		$parentId = $wgRequest->getVal( 'parentId' );
		$page = $wgRequest->getVal( 'page', 1 );
		$showall = $wgRequest->getText( 'showall', false );

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return array( 'error' => 1 );
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

		$result = array();
		if ( $response !== false ) {
			$status = $response[0];
			$article = $response[1];
			ArticleComment::doAfterPost($status, $article);

			$listing = ArticleCommentList::newFromTitle($title);
			$comments = $listing->getCommentPages(true, false);
			$countComments = count($comments);
			$countPages = ceil($countComments / $wgArticleCommentsMaxPerPage);
			if ($showall != 1) {
				$comments = array_slice($comments, ($page - 1) * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
			}
			$commentsHTML = ArticleCommentList::formatList($comments);
			$pagination = ArticleCommentList::doPagination($countComments, count($comments), $page, $title);

			$counter = wfMsg('article-comments-comments', $listing->getCountAllNested());

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
		global $wgRequest;

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
			$text = ArticleCommentList::formatList($comments);
			$pagination = ArticleCommentList::doPagination($listing->getCountAll(), count($comments), $page === false ? 1 : $page, $title);
		}

		$result = array('error' => $error, 'text' => $text, 'pagination' => $pagination);

		return $result;
	}
}