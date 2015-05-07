<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Email\Fatal;

abstract class CommentController extends EmailController {

	/** @var \Title */
	protected $title;

	/** @var \Title */
	protected $commentTitle;

	public function initEmail() {
		// This title is for the article being commented upon
		$titleText = $this->request->getVal( 'pageTitle' );
		$titleNamespace = $this->request->getVal( 'namespace' );

		$this->title = \Title::newFromText( $titleText, $titleNamespace );

		// This revision ID is for the comment that was left
		$commentRevID = $this->getVal( 'currentRevId', false );
		if ( $commentRevID ) {
			$rev = \Revision::newFromId( $commentRevID, \Revision::USE_MASTER_DB );

			if ( $rev ) {
				$this->commentTitle = $rev->getTitle( \Revision::USE_MASTER_DB );
			}
		}

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
		$this->assertValidCommentTitle();
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
	 * @throws \Email\Check
	 */
	private function assertValidCommentTitle() {
		if ( !$this->commentTitle instanceof \Title ) {
			throw new Check( "Could not find comment for revision ID given by currentRevId" );
		}

		if ( !$this->title->exists() ) {
			throw new Check( "Comment doesn't exist." );
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
		$articleTitle = $this->title->getText();
		return wfMessage( $this->getSubjectKey(), $articleTitle )
			->inLanguage( $this->targetLang )
			->text();
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
		$article = \Article::newFromTitle( $this->commentTitle, \RequestContext::getMain() );
		$service = new \ArticleService( $article );
		$snippet = $service->getTextSnippet();

		return $snippet;
	}

	protected function getCommentLabel() {
		return wfMessage( 'emailext-comment-link-label')
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getCommentLink() {
		$comment = $this->commentTitle;
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

	protected function getCommentSectionLink() {
		$url = $this->title->getFullURL( '#WikiaArticleComments' );

		return wfMessage( 'emailext-comment-view-all', $url )
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getEmailSpecificAdminForm() {
		$form = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'pageTitle',
					'isRequired' => true,
					'label' => "Title of the article"
				],
				[
					'type' => 'text',
					'name' => 'currentRevId',
					'isRequired' => true,
					'label' => "current rev id"
				],
			]
		];

		return $form;
	}
}

class ArticleCommentController extends CommentController {
	protected function getSubjectKey() {
		return 'emailext-articlecomment-summary';
	}

	protected function getSummaryKey() {
		return 'emailext-articlecomment-summary';
	}
}

class BlogCommentController extends CommentController {
	protected function getSubjectKey() {
		return 'emailext-blogcomment-summary';
	}

	protected function getSummaryKey() {
		return 'emailext-blogcomment-summary';
	}
}
