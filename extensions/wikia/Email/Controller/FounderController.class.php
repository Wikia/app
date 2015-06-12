<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Email\Fatal;

abstract class FounderController extends EmailController {

	/** @var \Title */
	protected $pageTitle;

	public function initEmail() {
		// This title is for the article being commented upon
		$titleText = $this->request->getVal( 'pageTitle' );
		$titleNamespace = $this->request->getVal( 'pageNs' );

		$this->pageTitle = \Title::newFromText( $titleText, $titleNamespace );

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
		if ( !$this->pageTitle instanceof \Title ) {
			throw new Check( "Invalid value passed for title" );
		}

		if ( !$this->pageTitle->exists() ) {
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
			'buttonText' => $this->getChangesLabel(),
			'buttonLink' => $this->getChangesLink(),
			'contentFooterMessages' => [
				$this->getFooterEncouragement(),
				$this->getFooterArticleLink(),
				$this->getFooterAllChangesLink(),
			],
			'details' => $this->getDetails(),
			'hasContentFooterMessages' => true
		] );
	}

	public function getSubject() {
		$articleTitle = $this->pageTitle->getText();
		$name = $this->getCurrentUserName();

		return $this->getMessage( 'emailext-founder-subject', $articleTitle, $name )
			->text();
	}

	protected function getSummary() {
		$articleUrl = $this->pageTitle->getFullURL();
		$articleTitle = $this->pageTitle->getText();

		return $this->getMessage( 'emailext-founder-summary', $articleUrl, $articleTitle )
			->parse();
	}

	protected function getDetails() {
		$article = \Article::newFromTitle( $this->pageTitle, \RequestContext::getMain() );
		$service = new \ArticleService( $article );
		$snippet = $service->getTextSnippet();

		return $snippet;
	}

	protected function getChangesLabel() {
		return $this->getMessage( 'emailext-founder-link-label' )->parse();
	}

	protected function getChangesLink() {
		return $this->pageTitle->getFullURL( [
			'action' => 'history'
		] );
	}

	protected function getFooterMessages() {
		$parentUrl = $this->pageTitle->getFullURL( 'action=unwatch' );
		$parentTitleText = $this->pageTitle->getPrefixedText();

		$footerMessages = [
			$this->getMessage( 'emailext-unfollow-text', $parentUrl, $parentTitleText )
				->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

	protected function getFooterEncouragement() {
		$name = $this->getCurrentUserName();
		$profileUrl = $this->getCurrentProfilePage();

		return $this->getMessage( $this->getFooterEncouragementKey(), $profileUrl, $name )
			->parse();
	}

	protected function getFooterEncouragementKey() {
		return 'emailext-founder-encourage';
	}

	protected function getFooterArticleLink() {
		$articleTitle = $this->pageTitle->getText();
		$revId = $this->pageTitle->getLatestRevID( \Title::GAID_FOR_UPDATE );
		$url = $this->pageTitle->getFullURL( [
			'diff' => $revId,
		] );

		return $this->getMessage( 'emailext-founder-footer-article', $url, $articleTitle )
			->parse();
	}

	protected function getFooterAllChangesLink() {
		$articleTitle = $this->pageTitle->getText();
		$url = $this->pageTitle->getFullURL( [
			'action' => 'history'
		] );

		return $this->getMessage( 'emailext-founder-footer-all-changes', $url, $articleTitle )
			->parse();
	}

	/**
	 * Form fields required for this email for Special:SendEmail. See
	 * EmailController::getEmailSpecificFormFields for more info.
	 * @return array
	 */
	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'pageTitle',
					'label' => "Article Title",
					'tooltip' => "eg 'Rachel_Berry' (make sure it's on this wikia!)"
				],
				[
					'type' => 'hidden',
					'name' => 'namespace',
					'value' => NS_MAIN
				]
			]
		];

		return array_merge_recursive( $formFields, parent::getEmailSpecificFormFields() );
	}
}

class FounderEditController extends FounderController { }

class FounderMultiEditController extends FounderController {
	protected function getFooterEncouragementKey() {
		return 'emailext-founder-multi-encourage';
	}
}

class FounderAnonEditController extends FounderController {

	public function getSubject() {
		$articleTitle = $this->pageTitle->getText();

		return $this->getMessage( 'emailext-founder-anon-subject', $articleTitle )
			->text();
	}

	protected function getFooterEncouragement() {
		return $this->getMessage( 'emailext-founder-encourage' )
			->parse();
	}
}
