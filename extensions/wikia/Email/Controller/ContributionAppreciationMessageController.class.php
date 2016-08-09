<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class ContributionAppreciationMessageController extends EmailController {
	const LAYOUT_CSS = 'contributionAppreciation.css';

	private $buttonLink;
	private $editedWikiName;
	private $appreciatorName;
	private $editedPageTitleText;
	private $revisionUrl;

	public function initEmail() {
		if ( $this->currentUser->isLoggedIn() ) {
			$this->appreciatorName = $this->currentUser->getName();
		}

		$this->editedPageTitleText = $this->request->getVal( 'editedPageTitleText' );
		$this->editedWikiName = $this->request->getVal( 'editedWikiName' );
		$this->buttonLink = $this->request->getVal( 'buttonLink' );
		$this->revisionUrl = $this->request->getVal( 'revisionUrl' );

		$this->assertMessageDetails();
	}

	private function assertMessageDetails() {
		if ( empty( $this->appreciatorName ) ) {
			throw new Check( "Could not determine appreciation author" );
		}

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
			'buttonText' => $this->getMessage( 'emailext-appreciation-received-button-cta' )->text(),
			'appreciationInfo' => $this->getMessage( 'emailext-appreciation-received-summary',
					$this->editedPageTitleText,
					$this->editedWikiName,
					$this->appreciatorName
				)->text(),
			'appreciationText' => $this->getMessage( 'emailext-appreciation-received-text' )->text(),
			'viewEditText' => $this->$this->getMessage(
					'emailext-appreciation-view-edit',
					$this->editedPageTitleText
				)->text(),
			'viewEditUrl' => $this->revisionUrl,
			'buttonLink' => $this->buttonLink,
		] );
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
		$formFields = [
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

