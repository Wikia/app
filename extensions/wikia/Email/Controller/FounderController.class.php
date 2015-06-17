<?php

namespace Email\Controller;

use Email\Check;
use Email\ControllerException;
use Email\EmailController;
use Wikia\Logger;

abstract class FounderController extends EmailController {

	/** @var \Title */
	protected $pageTitle;

	protected $previousRevId;
	protected $currentRevId;

	public function initEmail() {
		// This title is for the article being commented upon
		$titleText = $this->request->getVal( 'pageTitle' );
		$titleNamespace = $this->request->getVal( 'pageNs' );

		$this->pageTitle = \Title::newFromText( $titleText, $titleNamespace );

		$this->previousRevId = $this->request->getVal( 'previousRevId' );
		$this->currentRevId = $this->request->getVal( 'currentRevId' );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
		$this->assertValidRevisionIds();
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
	 * @throws \Email\Check
	 */
	private function assertValidRevisionIds() {
		if ( empty( $this->previousRevId ) ) {
			throw new Check( "Invalid value passed for previousRevId" );
		}

		if ( empty( $this->currentRevId ) ) {
			throw new Check( "Invalid value passed for currentRevId" );
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
			'diff' => $this->currentRevId,
			'oldid' => $this->previousRevId,
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
		$url = $this->pageTitle->getFullURL( [
			'diff' => $this->currentRevId,
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

class FounderActiveController extends FounderController {

	/**
	 * Define this and do nothing since we don't need the checks of our parent
	 */
	public function initEmail() {
		// NOOP
	}

	public function getSubject() {
		return $this->getMessage( 'emailext-founder-active-subject' )->text();
	}

	/**
	 * @template multiAvatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'avatarAndDetailsList' => $this->getChangeList(),
			'buttonText' => $this->getChangesLabel(),
			'buttonLink' => $this->getChangesLink(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-founder-active-footer-1' )->text(),
				$this->getMessage( 'emailext-founder-active-footer-2' )->text(),
			],
			'hasContentFooterMessages' => true
		] );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-founder-active-summary' )->parse();
	}

	private function getChangeList() {
		$changes = $this->getRecentActivity();
		$changeList = [];

		foreach ( $changes as $event ) {
			try {
				$eventUser = $this->getUserFromName( $event[ 'user' ] );
			} catch ( ControllerException $e ) {
				Logger\WikiaLogger::instance()->warning( 'User from recent activity not found', [
					'method' => __METHOD__,
					'username' => $event['user'],
				] );
				continue;
			}

			$changeList[] = [
				'editorProfilePage' => $eventUser->getUserPage()->getFullURL(),
				'editorUserName' => $eventUser->getName(),
				'editorAvatarURL' => $this->getAvatarURL( $eventUser ),
				'details' => $this->getDetails( $event ),
			];
		}

		return $changeList;
	}

	protected function getDetails( array $event ) {
		$titleKey = $event['title'];
		$ns = $event['ns'];
		$title = \Title::newFromText( $titleKey, $ns );

		$titleUrl = $title->getFullURL();
		$titleText = $title->getText();

		$msgKey = $event['type'] == 'new' ? 'emailext-founder-new-update' : 'emailext-founder-edit-update';
		return $this->getMessage( $msgKey, $titleUrl, $titleText )->parse();
	}

	private function getRecentActivity( $num = 5 ) {
		$wg = \F::app()->wg;

		$data = \ApiService::call( [
			'action' => 'query',
			'list' => 'recentchanges',
			'rctype' => implode( '|', [ 'new', 'edit' ] ),
			'rcprop' => implode( '|', [ 'user', 'title' ] ),
			'rcnamespace' => implode( '|', $wg->ContentNamespaces),
			'rcexcludeuser' => $this->targetUser->getName(),
			'rcshow' => implode( '|', [ '!minor', '!bot', '!anon', '!redirect' ] ),
			'rclimit' => $num,
			'rctoponly' => 1,
		] );

		if ( !empty( $data['query']['recentchanges'] ) ) {
			return $data['query']['recentchanges'];
		}

		return [];
	}

	protected function getChangesLabel() {
		return $this->getMessage( 'emailext-founder-active-link-label' )->parse();
	}

	protected function getChangesLink() {
		$title = \SpecialPage::getTitleFor( 'WikiActivity' );
		return $title->getFullURL();
	}

	protected function getFooterMessages() {
		return EmailController::getFooterMessages();
	}
}
