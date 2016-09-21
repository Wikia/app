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
	 * @return String -- json-ized array
	 */
	static public function axSave() {
		global $wgRequest, $wgUser, $wgTitle;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );
		$parentId = $wgRequest->getVal( 'parentId', 0 );

		$errorResult = [ 'error' => 1 ];

		// Return with error if we can't find the article
		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return $errorResult;
		}

		// Return with error if we can't comment on the current title (wgTitle)
		if ( !ArticleComment::userCanCommentOn( $wgTitle ) ) {
			return $errorResult;
		}

		// Return with error if we can't create a new article comment
		$comment = ArticleComment::newFromId( $commentId );
		if ( empty( $comment ) ) {
			return $errorResult;
		}

		// Return with error if we can't load the data for this comment
		if ( !$comment->load( true ) ) {
			return $errorResult;
		}

		// Return with error if we can't edit this comment
		if ( !$comment->getTitle()->userCan( 'edit' ) ) {
			return $errorResult;
		}

		$text = self::getConvertedContent( $wgRequest->getVal( 'wpArticleComment' ) );
		$commentId = $wgRequest->getText( 'id', false );
		$response = $comment->doSaveComment( $text, $wgUser, $title, $commentId );
		if ( $response === false ) {
			return $errorResult;
		}

		$status = $response[0];
		$article = $response[1];

		return ArticleComment::doAfterPost( $status, $article, $parentId );
	}

	/**
	 * axEdit -- static hook/entry for ajax request post -- edit comment
	 *
	 * @return String -- html -> textarea
	 */
	static public function axEdit() {
		global $wgRequest;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );

		$result = [
			'error'	=> 1,
			'id'	=> $commentId,
			'show'	=> false,
			'text'	=> ''
		];

		// Check owner of article
		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			return $result;
		}

		// Edit comment
		$comment = ArticleComment::newFromId( $commentId );
		if ( empty( $comment ) ) {
			return $result;
		}

		if ( !$comment->load( true ) ) {
			return $result;
		}

		if ( !$comment->getTitle()->userCan( 'edit' ) ) {
			return $result;
		}

		$result['error'] = 0;
		$result['show'] = true;
		$result['text'] = $comment->editPage();

		if ( ArticleComment::isMiniEditorEnabled() ) {
			$result['edgeCases'] = MiniEditorHelper::getEdgeCases();
		}

		$result['emptyMsg'] = wfMessage(
			'article-comments-empty-comment',
			$comment->getTitle()->getCanonicalURL( 'redirect=no&action=delete' )
		)->parse();

		return $result;
	}

	/**
	 * axReply -- static hook/entry for ajax request post -- reply a comment
	 *
	 * @return String -- html -> textarea
	 */
	static public function axReply() {
		global $wgRequest, $wgStylePath;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );
		$result = [ 'id' => $commentId ];

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			$result['error'] = 1;
			return $result;
		}

		$canComment = ArticleComment::userCanCommentOn( $title );

		if ( $canComment == true ) {
			$vars = [
				'commentId' => $commentId,
				'isMiniEditorEnabled' => ArticleComment::isMiniEditorEnabled(),
				'stylePath' => $wgStylePath
			];

			$result['html'] = F::app()->getView( 'ArticleComments', 'Reply', $vars )->render();
		}

		return $result;
	}

	/**
	 * axPost -- static hook/entry for ajax request post
	 *
	 * @return String -- json-ized array`
	 */
	static public function axPost() {
		global $wgRequest, $wgUser, $wgLang;

		$result = [ 'error' => 1 ];

		try {
			$wgRequest->assertValidWriteRequest( $wgUser );
		} catch ( \BadRequestException $bre ) {
			$result['msg'] = wfMessage( 'sessionfailure' )->escaped();
			return $result;
		}

		$articleId = $wgRequest->getVal( 'article', false );
		$parentId = $wgRequest->getVal( 'parentId' );

		$title = Title::newFromID( $articleId );

		if ( !$title || !ArticleComment::userCanCommentOn( $title, $wgUser ) ) {
			return $result;
		}

		$response = ArticleComment::doPost( self::getConvertedContent( $wgRequest->getVal( 'wpArticleComment' ) ), $wgUser, $title, $parentId );
		WikiaLogger::instance()->info( __METHOD__ . ' : Comment posted', [
			'skin' => $wgRequest->getVal( 'useskin' ),
			'articleId' => $articleId,
			'parentId' => $parentId,
		] );

		if ( $response === false ) {
			return $result;
		}

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

		/** @var Language $wgLang */
		$countAll = $wgLang->formatNum( $listing->getCountAllNested() );
		$commentsHTML = $response[2]['text'];

		$result = [
			'text' => $commentsHTML,
			'counter' => $countAll
		];

		if ( F::app()->checkskin( 'wikiamobile' ) ) {
			$result['counterMessage'] = wfMessage( 'wikiamobile-article-comments-counter' )
				->params( $countAll )
				->escaped();
		}

		if ( $parentId ) {
			$result['parentId'] = $parentId;
		}

		return $result;
	}

	/**
	 * axGetComments -- static hook/entry for ajax request for pagination
	 *
	 * @return String - HTML
	 */
	static public function axGetComments() {
		global $wgRequest, $wgTitle;

		$page = $wgRequest->getVal( 'page', false );
		$articleId = $wgRequest->getVal( 'article', false );
		$wgTitle = Title::newFromID( $articleId );

		$error = 0;
		$text = $pagination = '';
		$method = 'CommentList';
		$app = F::app();
		$isMobile = $app->checkSkin( 'wikiamobile' );

		if ( $isMobile ) {
			$method = 'WikiaMobile' . $method;
		}

		$title = Title::newFromID( $articleId );
		if ( !$title ) {
			$error = 1;
		} else {
			$listing = ArticleCommentList::newFromTitle( $title );
			$comments = $listing->getCommentPages( false, $page );
			$text = $app->getView( 'ArticleComments', $method, [ 'commentListRaw' => $comments, 'page' => $page, 'useMaster' => false ] )->render();
			$pagination = ( !$isMobile ) ? $listing->doPagination( $listing->getCountAll(), count( $comments ), $page === false ? 1 : $page, $title ) : '';
		}

		$result = [ 'error' => $error, 'text' => $text, 'pagination' => $pagination ];

		return $result;
	}

	/**
	 * Handles converting wikitext to richtext and vice versa.
	 *
	 * @param string $content - the text to convert
	 *
	 * @return string - the converted text
	 */
	static public function getConvertedContent( $content = '' ) {
		global $wgEnableMiniEditorExtForArticleComments, $wgRequest;
		if ( $wgEnableMiniEditorExtForArticleComments && !empty( $content ) ) {
			$convertToFormat = $wgRequest->getVal( 'convertToFormat', '' );

			if ( !empty( $convertToFormat ) ) {
				$content = MiniEditorHelper::convertContent( $content, $convertToFormat );
			}
		}

		return $content;
	}
}
