<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;
use Email\ImageHelper;

abstract class FounderDigestController extends EmailController {

	const LAYOUT_CSS = "digestLayout.css";

	/** @var \Language */
	protected $language;
	protected $wikiId;
	protected $wikiName;
	protected $pageViews;

	public function initEmail() {
		$this->language = \Language::factory( $this->targetLang );
		$this->wikiId = $this->request->getVal( 'wikiId' );
		$this->pageViews = $this->request->getVal( 'pageViews' );
		$this->assertValidParams();
		// Get the name of the wiki, because this email is not associated with the current wiki
		$wikiObj = \WikiFactory::getWikiByID( $this->wikiId );
		$this->wikiName = empty( $wikiObj ) ? '' : $wikiObj->city_title;
		$this->pageViews = $this->language->formatNum( $this->pageViews );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-founder-digest-summary', $this->wikiName )->parse();
	}

	protected function assertValidParams() {
		$this->assertValidWikiId();
		$this->assertPageViewsSet();
	}

	/**
	 * Asserts that the wikiId parameter is valid
	 *
	 * @throws \Email\Check
	 */
	protected function assertValidWikiId() {
		if ( empty( $this->wikiId ) ) {
			throw new Check( 'Invalid value passed for `wikiId`' );
		}
	}

	/**
	 * Asserts that the `pageViews` value is passed
	 *
	 * @throws \Email\Check
	 */
	protected function assertPageViewsSet() {
		if ( empty( $this->pageViews ) && $this->pageViews !== '0' ) {
			throw new Check( 'Invalid value passed for `pageViews`' );
		}
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'wikiId',
					'label' => 'Wiki ID',
					'tooltip' => 'ID number of wiki community'
				],
				[
					'type' => 'text',
					'name' => 'pageViews',
					'label' => 'Page views',
					'tooltip' => 'Number of page views'
				]
			]
		];

		return array_merge_recursive( $formFields, parent::getEmailSpecificFormFields() );
	}
}

class FounderActivityDigestController extends FounderDigestController {

	protected $pageEdits;
	protected $newUsers;

	public function initEmail() {
		$this->pageEdits = $this->request->getVal( 'pageEdits' );
		$this->newUsers = $this->request->getVal( 'newUsers' );
		// Parent method is called here so that assertion of parameters is done at the right time
		parent::initEmail();
		$this->pageEdits = $this->language->formatNum( $this->pageEdits );
		$this->newUsers = $this->language->formatNum( $this->newUsers );
	}

	protected function getSubject() {
		return $this->getMessage( 'emailext-founder-activity-digest-subject', $this->wikiName )->parse();
	}

	/**
	 * @template digestLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->getButtonLink(),
			'details' => $this->getDetailsList(),
			'contentFooterMessages' => [
				$this->getCommunityFooterMessage()
			],
			'hasContentFooterMessages' => true
		] );
	}

	public function assertCanEmail() {
		parent::assertCanEmail();
		$this->assertSubscribedToCompleteDigest();
	}

	/**
	 * Asserts that the founder is subscribed to the complete digest.
	 *
	 * @throws \Email\Check
	 */
	protected function assertSubscribedToCompleteDigest() {
		if ( !$this->targetUser->getBoolOption( 'founderemails-complete-digest-' . $this->wikiId ) ) {
			throw new Check( 'Founder is not subscribed to complete digest.' );
		}
	}

	protected function assertValidParams() {
		parent::assertValidParams();
		$this->assertNewUsersSet();
		$this->assertPageEditsSet();
	}

	/**
	 * Asserts that the `newUsers` value is passed
	 *
	 * @throws \Email\Check
	 */
	protected function assertNewUsersSet() {
		if ( empty( $this->newUsers ) && $this->newUsers !== '0' ) {
			throw new Check( 'Invalid value passed for `newUsers`' );
		}
	}

	/**
	 * Asserts that the `pageEdits` value is passed
	 *
	 * @throws \Email\Check
	 */
	protected function assertPageEditsSet() {
		if ( empty( $this->pageEdits ) && $this->pageEdits !== '0' ) {
			throw new Check( 'Invalid value passed for `pageEdits`' );
		}
	}

	/**
	 * Returns list of details for the digest
	 *
	 * @return array
	 */
	protected function getDetailsList() {
		return [
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Page-views.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-founder-digest-views-header', $this->pageViews )->parse(),
				'details' => $this->getMessage( 'emailext-founder-digest-views-description-1' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Number-of-edits.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-founder-digest-edits-header', $this->pageEdits )->parse(),
				'details' => $this->getMessage( 'emailext-founder-digest-edits-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'New-users.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-founder-digest-users-header', $this->newUsers )->parse(),
				'details' => $this->getMessage( 'emailext-founder-digest-users-description' )->text()
			] 
		];
	}

	public function getButtonText() {
		return $this->getMessage( 'emailext-founder-activity-digest-link-label' )->text();
	}

	public function getButtonLink() {
		return \GlobalTitle::newFromText( 'WikiActivity', NS_SPECIAL, $this->wikiId )->getFullURL();
	}

	protected function getCommunityFooterMessage() {
		return $this->getMessage( 'emailext-founder-activity-digest-footer' )->parse();
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'newUsers',
					'label' => 'New users',
					'tooltip' => 'Number of new visitors to the wiki'
				],
				[
					'type' => 'text',
					'name' => 'pageEdits',
					'label' => 'Page edits',
					'tooltip' => 'Number of edits made to the wiki by users'
				]
			]
		];

		return array_merge_recursive( $formFields, parent::getEmailSpecificFormFields() );
	}
}

class FounderPageViewsDigestController extends FounderDigestController {

	protected function getSubject() {
		return $this->getMessage( 'emailext-founder-views-digest-subject', $this->wikiName )->parse();
	}

	/**
	 * @template digestLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->getButtonLink(),
			'details' => $this->getDetailsList(),
			'hasContentFooterMessages' => false
		] );
	}

	public function assertCanEmail() {
		parent::assertCanEmail();
		$this->assertNotSubscribedToCompleteDigest();
		$this->assertSubscribedToPageViewsDigest();
	}

	/**
	 * Checks if the founder is subscribed to the complete digest. If they are, don't send a page views
	 * digest, which is included in the complete digest.
	 *
	 * @throws \Email\Check
	 */
	protected function assertNotSubscribedToCompleteDigest() {
		if ( $this->targetUser->getBoolOption( 'founderemails-complete-digest-' . $this->wikiId ) ) {
			throw new Check( 'Founder is subscribed to complete digest and should not receive page views digest.' );
		}
	}

	/**
	 * Asserts that the founder is subscribed to the page view digest.
	 *
	 * @throws \Email\Check
	 */
	public function assertSubscribedToPageViewsDigest() {
		if ( !$this->targetUser->getBoolOption( 'founderemails-views-digest-' . $this->wikiId ) ) {
			throw new Check( 'Founder is not subscribed to page views digest.' );
		}
	}

	/**
	 * Returns list of details for the digest
	 *
	 * @return array
	 */
	protected function getDetailsList() {
		return [
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Page-views.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-founder-digest-views-header', $this->pageViews )->parse(),
				'details' => $this->getMessage( 'emailext-founder-digest-views-description-2' )->text()
			] 
		];
	}

	public function getButtonText() {
		return $this->getMessage( 'emailext-founder-views-digest-link-label' )->text();
	}

	public function getButtonLink() {
		return \GlobalTitle::newFromText( 'CreatePage', NS_SPECIAL, $this->wikiId )->getFullURL( [ 'modal' => 'AddPage' ] );
	}
}

