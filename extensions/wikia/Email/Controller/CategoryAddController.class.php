<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;

class CategoryAddController extends EmailController {

	/** @var \Title */
	private $categoryPage;

	/** @var \Title */
	private $pageAddedToCategory;

	/**
	 * To prevent flooding users with category add emails, we're
	 * going to throttle how many we send for now. See SOC-1358
	 */
	const THROTTLE_PERIOD = 1800; // 30 mins
	const EMAILS_PER_THROTTLE_PERIOD = 10;

	public function initEmail() {
		$pageTitle = $this->request->getVal( 'pageTitle' );
		$titleNamespace = $this->request->getVal( 'namespace', NS_MAIN );
		$pageAddedToCategoryId = $this->getVal( 'childArticleID' );

		$this->categoryPage = \Title::newFromText( $pageTitle, $titleNamespace );
		$this->pageAddedToCategory = \Title::newFromID( $pageAddedToCategoryId );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	protected function assertValidParams() {
		$this->assertValidCategoryPage();
		$this->assertValidPageAddedToCategory();
	}

	/**
	 * @throws \Email\Check
	 */
	protected function assertValidCategoryPage() {
		if ( !$this->categoryPage instanceof \Title ) {
			throw new Check( "Invalid value passed for categoryPageId (param: childArticleId)" );
		}
	}

	/**
	 * @throws \Email\Check
	 */
	protected function assertValidPageAddedToCategory() {
		if ( !$this->pageAddedToCategory instanceof \Title ) {
			throw new Check( "Invalid value passed for pageAddedToCategory (param: pageTitle)" );
		}

		if ( !$this->pageAddedToCategory->exists() ) {
			// Check master DB just in case the page was just created and it
			// hasn't been replicated to the slave yet
			if ( $this->pageAddedToCategory->getArticleID( \Title::GAID_FOR_UPDATE ) == 0 ) {
				throw new Check( "pageAddedToCategory doesn't exist." );
			}
		}
	}

	public function assertCanEmail() {
		parent::assertCanEmail();
		$this->assertEmailsNotThrottled();
	}

	private function assertEmailsNotThrottled() {
		global $wgMemc;
		$emailsSent = (int) $wgMemc->get( $this->getTargetUserCacheKey() );
		if ( $emailsSent >=  self::EMAILS_PER_THROTTLE_PERIOD ) {
			throw new Check( 'Attempt to send too many emails' );
		}
	}

	protected function afterSuccess() {
		$this->incrementEmailsSentCount();
	}

	private function incrementEmailsSentCount() {
		global $wgMemc;
		$emailsSent = $wgMemc->get( $this->getTargetUserCacheKey() );
		if ( !is_int( $emailsSent ) ) {
			$wgMemc->set( $this->getTargetUserCacheKey(), 0, time() + self::THROTTLE_PERIOD );
		}

		$wgMemc->incr( $this->getTargetUserCacheKey() );
	}

	private function getTargetUserCacheKey() {
		return $this->targetUser->getId() . ":sentCategoryAddEmailCount";
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'detailsHeader' => $this->pageAddedToCategory->getPrefixedText(),
			'details' => $this->getDetails(),
			'buttonLink' => $this->pageAddedToCategory->getFullURL(),
			'buttonText' => $this->getMessage( 'emailext-categoryadd-see-article')->text(),
			'contentFooterMessages' => [
				$this->getContentFooterMessages()
			],
			'hasContentFooterMessages' => true,
		] );
	}

	protected function getSubject() {
		$pageName = $this->pageAddedToCategory->getPrefixedText();
		$categoryName = $this->categoryPage->getText();
		return $this->getMessage( 'emailext-categoryadd-subject', $pageName, $categoryName )->text();
	}

	protected function getSummary() {
		$pageName = $this->pageAddedToCategory->getPrefixedText();
		$pageUrl = $this->pageAddedToCategory->getFullURL();
		$categoryName = $this->categoryPage->getText();
		$categoryUrl = $this->categoryPage->getFullURL();
		return $this->getMessage(
			'emailext-categoryadd-details',
			$pageUrl, $pageName,
			$categoryUrl, $categoryName
		)->parse();
	}

	protected function getDetails() {
		$article = \Article::newFromTitle( $this->pageAddedToCategory, \RequestContext::getMain() );
		$service = new \ArticleService( $article );
		$snippet = $service->getTextSnippet();

		return $snippet;
	}

	protected function getContentFooterMessages() {
		return $this->getMessage( 'emailext-categoryadd-see-all-pages',
			$this->categoryPage->getFullURL(),
			$this->categoryPage->getText()
		)->parse();
	}

	protected function getFooterMessages() {
		$footerMessages = [
			$this->getMessage( 'emailext-unfollow-text',
				$this->categoryPage->getFullURL( 'action=unwatch' ),
				$this->categoryPage->getPrefixedText() )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

	public static function getEmailSpecificFormFields() {
		$form = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'pageTitle',
					'label' => "Category Page",
					'tooltip' => "The Category Page which was added to, eg 'Category:CoolCategoryPage' "
				],
				[
					'type' => 'hidden',
					'name' => 'namespace',
					'value' => NS_CATEGORY
				],
				[
					'type' => 'text',
					'name' => 'childArticleID',
					'label' => "ID of the Page Added",
					'tooltip' => 'The ID of the page added to the category'
				],
			]
		];

		return $form;

	}
}
