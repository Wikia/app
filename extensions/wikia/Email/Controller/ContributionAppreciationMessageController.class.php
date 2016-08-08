<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class ContributionAppreciationMessageController extends EmailController {
	const LAYOUT_CSS = 'contributionAppreciation.css';

	protected $buttonLink;
	protected $editedWikiName;
	protected $appreciatorName;
	protected $editedPageTitleText;
	protected $revisionUrl;

	public function initEmail() {
		if ( !$this->currentUser->isAnon() ) {
			$this->appreciatorName = $this->currentUser->getName();
		}

		$this->assertUserRolesSet();

		$this->editedPageTitleText = $this->request->getVal( 'editedPageTitleText' );
		$this->editedWikiName = $this->request->getVal( 'editedWikiName' );
		$this->buttonLink = $this->request->getVal( 'buttonLink' );
		$this->revisionUrl = $this->request->getVal( 'revisionUrl' );

		$this->assertMessageDetails();
	}

	protected function assertUserRolesSet() {
		if ( empty( $this->appreciatorName ) ) {
			throw new Check( "Could not determine appreciation author" );
		}
	}

	protected function assertMessageDetails() {
		if ( empty( $this->editedPageTitleText ) ) {
			throw new Check( "Edited page title (editedPageTitleText) is required" );
		}

		if ( empty( $this->editedWikiName ) ) {
			throw new Check( "Wiki where contribution was made (editedWikiName) is required" );
		}

		if ( empty( $this->revisionUrl ) ) {
			throw new Check( "Link to revision (revisionUrl) is required" );
		}
	}

	/**
	 * @template contributionAppreciation
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'buttonText' => $this->getButtonText(),
			'appreciationInfo' => $this->getAppreciationInfo(),
			'appreciationText' => $this->getAppreciationText(),
			'viewEditText' => $this->getViewEditText(),
			'viewEditUrl' => $this->revisionUrl,
			'buttonLink' => $this->buttonLink,
		] );
	}

	/**
	 * Get the localized button text
	 *
	 * @return string
	 */
	protected function getButtonText() {
		return $this->getMessage( 'emailext-appreciation-received-button-cta' )->text();
	}

	/**
	 * Get the localized text describing the "view edit" link below button
	 *
	 * @return string
	 */
	protected function getViewEditText() {
		return $this->getMessage(
			'emailext-appreciation-view-edit',
			$this->editedPageTitleText
		)->parse();
	}

	/**
	 * Get the body of email - info about appreciation
	 *
	 * @return string
	 */
	protected function getAppreciationInfo() {
		return $this->getMessage( 'emailext-appreciation-received-summary',
			$this->editedPageTitleText,
			$this->editedWikiName,
			$this->appreciatorName
		)->text();
	}

	/**
	 * Get the text of appreciation
	 *
	 * @return string
	 */
	protected function getAppreciationText() {
		return $this->getMessage( 'emailext-appreciation-received-text' )->text();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return $this->getMessage( 'emailext-appreciation-received-subject', $this->editedWikiName )->text();
	}

	protected static function getEmailSpecificFormFields() {
		$formFields =  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'revisionUrl',
					'label' => 'URL to the revision diff',
					'tooltip' => 'Url of the diff page of revision you want to give appreciation for'
				],
				[
					'type' => 'text',
					'name' => 'editedPageTitleText',
					'label' => 'Title of edited article',
					'tooltip' => 'Title of the article that was edited'
				],
				[
					'type' => 'text',
					'name' => 'editedWikiName',
					'label' => 'Wiki name',
					'tooltip' => 'Name of wiki of article that was edited'
				],
			]
		];

		return $formFields;
	}
}

