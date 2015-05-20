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

use Wikia\Logger\WikiaLogger;

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
		$parentId = $wgRequest->getVal( 'parentId', 0 );

		$result = array(
			'error' => 1
		);

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return $result;
		}

		if (!ArticleComment::canComment()) {
			return $result;
		}

		$comment = ArticleComment::newFromId( $commentId );
		if ( $comment ) {
			$comment->load(true);
			if ( $comment->canEdit() ) {
				$text = self::getConvertedContent($wgRequest->getVal('wpArticleComment'));
				$commentId = $wgRequest->getText('id', false);
				$response = $comment->doSaveComment( $text, $wgUser, $title, $commentId );
				if ( $response !== false ) {
					$status = $response[0];
					$article = $response[1];

					return ArticleComment::doAfterPost($status, $article, $parentId );
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

				if (ArticleComment::isMiniEditorEnabled()) {
					$result['edgeCases'] = MiniEditorHelper::getEdgeCases();
				}

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
		global $wgRequest, $wgStylePath;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );
		$result = array('id' => $commentId);

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			$result['error'] = 1;
			return $result;
		}

		$canComment = ArticleCommentInit::userCanComment( $result, $title );

		if ( $canComment == true ) {
			$articleId = $wgRequest->getVal( 'article', false );

			$vars = array (
				'commentId' => $commentId,
				'isMiniEditorEnabled' => ArticleComment::isMiniEditorEnabled(),
				'stylePath' => $wgStylePath
			);

			$result['html'] = F::app()->getView('ArticleComments', 'Reply', $vars)->render();
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
		global $wgRequest, $wgUser, $wgLang;

		$articleId = $wgRequest->getVal( 'article', false );
		$parentId = $wgRequest->getVal( 'parentId' );
		$result = array( 'error' => 1 );
		$title = Title::newFromID( $articleId );

		if ( !$title ) {
			return $result;
		}

		if ( !ArticleComment::canComment( $title ) ) {
			return $result;
		}

		WikiaLogger::instance()->info( __METHOD__ . ' : Comment posted', [
			'skin' => $wgRequest->getVal( 'useskin' ),
			'articleId' => $articleId,
			'parentId' => $parentId,
		] );

		$response = ArticleComment::doPost( self::getConvertedContent($wgRequest->getVal('wpArticleComment')), $wgUser, $title, $parentId );

		if ( $response !== false ) {
			if (
				$title->getNamespace() == NS_USER_TALK &&
				$response[0] == EditPage::AS_SUCCESS_NEW_ARTICLE &&
				$title->getText() != $wgUser->getName()
			) {
				$user = User::newFromName( $title->getText() );

				if ( $user ) {
					$user->setNewtalk( true );
				}
			}

			$listing = ArticleCommentList::newFromTitle( $title );
			$countAll = $wgLang->formatNum( $listing->getCountAllNested() );
			$commentsHTML = $response[2]['text'];

			$result = array('text' => $commentsHTML, 'counter' => $countAll);

			if( F::app()->checkskin( 'wikiamobile' ) ) {
				$result['counterMessage'] = wfMessage( 'wikiamobile-article-comments-counter' )
					->params( $countAll )
					->text();
			}

			if ( $parentId ) {
				$result['parentId'] = $parentId;
			}

			return $result;
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
		global $wgRequest, $wgTitle;

		$page = $wgRequest->getVal('page', false);
		$articleId = $wgRequest->getVal('article', false);
		$wgTitle = Title::newFromID( $articleId );

		$error = 0;
		$text = $pagination = '';
		$method = 'CommentList';
		$isMobile = F::app()->checkSkin( 'wikiamobile' );

		if($isMobile){
			$method = 'WikiaMobile' . $method;
		} elseif ( F::app()->checkSkin( 'venus' ) ) {
			$method = 'Venus' . $method;
		}

		$title = Title::newFromID($articleId);
		if ( !$title ) {
			$error = 1;
		} else {
			$listing = ArticleCommentList::newFromTitle($title);
			$comments = $listing->getCommentPages(false, $page);
			$text = F::app()->getView('ArticleComments', $method, array('commentListRaw' => $comments, 'page' => $page, 'useMaster' => false))->render();
			$pagination = (!$isMobile) ? $listing->doPagination($listing->getCountAll(), count($comments), $page === false ? 1 : $page, $title) : '';
		}

		$result = array('error' => $error, 'text' => $text, 'pagination' => $pagination);

		return $result;
	}

	/**
	 * Handles converting wikitext to richtext and vice versa.
	 *
	 * @param string $text - the text to convert
	 * @return string - the converted text
	 */
	static public function getConvertedContent($content = '') {
		global $wgEnableMiniEditorExtForArticleComments, $wgRequest;
		if ($wgEnableMiniEditorExtForArticleComments && !empty($content)) {
			$convertToFormat = $wgRequest->getVal('convertToFormat', '');

			if (!empty($convertToFormat)) {
				$content = MiniEditorHelper::convertContent($content, $convertToFormat);
			}
		}

		return $content;
	}
}
