<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Email\Fatal;

abstract class CommentController extends EmailController {

	/** @var \Title */
	protected $title;

	/** @var \Title */
	protected $latestComment;

	public function initEmail() {
		$titleText = $this->request->getVal( 'title' );
		$titleNamespace = $this->request->getVal( 'namespace' );

		$this->title = \Title::newFromText( $titleText, $titleNamespace );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidTitle() {
		if ( !$this->title instanceof \Title ) {
			throw new Check( "Invalid value passed for title" );
		}

		if ( !$this->title->exists() ) {
			throw new Check( "Title doesn't exist." );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'summary' => $this->getSummary(),
			'details' => $this->getDetails(),
			'buttonText' => $this->getCommentLabel(),
			'buttonLink' => $this->getCommentLink(),
			'contentFooterMessages' => [
				$this->getCommentSectionLink(),
			],
		] );
	}

	public function getSubject() {
		return wfMessage( $this->getSubjectKey() )->inLanguage( $this->targetLang )->text();
	}

	abstract protected function getSubjectKey();

	protected function getSalutation() {
		return wfMessage(
			'emailext-comment-salutation',
			$this->targetUser->getName()
		)->inLanguage( $this->targetLang )->text();
	}

	protected function getSummary() {
		$articleTitle = $this->title->getText();

		return wfMessage( $this->getSummaryKey(), $articleTitle )
			->inLanguage( $this->targetLang )
			->text();
	}

	abstract protected function getSummaryKey();

	protected function getDetails() {
		$comment = $this->getLatestComment();
		$articleID = $comment->getArticleID();

		$res = $this->sendRequest( 'ArticleSummary', 'blurb', [
			'ids' => $articleID,
		] )->getData();

		if ( empty( $res['summary'][$articleID] ) ) {
			return '';
		}

		return $res['summary'][$articleID]['snippet'];
	}

	protected function getCommentLabel() {
		return wfMessage( 'emailext-comment-link-label')
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getCommentLink() {
		$comment = $this->getLatestComment();
		return $comment->getCanonicalURL();
	}

	protected function getFooterMessages() {
		$parentUrl = $this->title->getCanonicalURL( 'action=unwatch' );
		$parentTitleText = $this->title->getPrefixedText();

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $parentUrl, $parentTitleText )
				->inLanguage( $this->targetLang )
				->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

	protected function getLatestComment() {
		if ( empty( $this->latestComment ) ) {
			$articleComment = \ArticleComment::latestFromTitle( $this->title );
			if ( empty( $articleComment ) ) {
				throw new Fatal( 'Could not find latest comment' );
			}
			$this->latestComment = $articleComment->getTitle();
		}

		return $this->latestComment;
	}

	protected function getCommentSectionLink() {
		$url = $this->title->getFullURL( '#WikiaArticleComments' );

		return wfMessage( 'emailext-comment-view-all', $url )
			->inLanguage( $this->targetLang )
			->parse();
	}
}

class ArticleCommentController extends CommentController {
	protected function getSubjectKey() {
		return 'emailext-articlecomment-subject';
	}

	protected function getSummaryKey() {
		return 'emailext-articlecomment-summary';
	}
}

class BlogCommentController extends CommentController {
	protected function getSubjectKey() {
		return 'emailext-blogcomment-subject';
	}

	protected function getSummaryKey() {
		return 'emailext-blogcomment-summary';
	}
}
