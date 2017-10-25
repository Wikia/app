<?php

namespace FandomCreatorEmail\Controller;

use FandomCreatorEmail\FandomCreatorEmailController;

class ContentUpdatedController extends FandomCreatorEmailController {
	/** @var string */
	private $contentTitle;

	/** @var string */
	private $contentUrl;

	public function initEmail() {
		parent::initEmail();
		$this->contentTitle = $this->request->getVal( 'contentTitle' );
		$this->contentUrl = $this->request->getVal( 'contentUrl' );
	}

	public function getSubject(): string {
		return $this->magicWordWrapper->wrap( function() {
			return $this->getMessage(
					'emailext-watchedpage-article-edited-subject',
					$this->contentTitle,
					$this->getCurrentUserName()
			)->text();
		} );
	}

	/**
	 * @template avatarLayout
	 *
	 * other possible keys:
	 * 	details - additional email text
	 * 	editorProfilePage - link to user's profile page on this community
	 * 	buttonText - button beneath edit summary
	 * 	buttonLink - where buttonText goes
	 */
	public function body() {
		$this->magicWordWrapper->wrap( function() {
			$this->response->setData( [
					'salutation' => $this->getSalutation(),
					'summary' => $this->getSummary(),
					'editorUserName' => $this->getCurrentUserName(),
					'editorAvatarURL' => $this->getCurrentAvatarURL(),
					'contentFooterMessages' => $this->getContentFooterMessages(),
					'hasContentFooterMessages' => true,
			] );
		} );
	}

	private function getSummary(): string {
		return $this->getMessage(
				'emailext-watchedpage-article-edited',
				$this->contentUrl,
				$this->contentTitle
		)->parse();
	}

	private function getContentFooterMessages(): array {
		return [
				$this->getMessage(
						'emailext-watchedpage-article-link-text',
						$this->contentUrl,
						$this->contentTitle
				)->parse(),
		];
	}
}
