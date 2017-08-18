<?php

namespace Email\Controller\FandomCreator;

class ContentUpdatedController extends FandomCreatorEmailController {
	/** @var string */
	private $contentTitle;

	/** @var string */
	private $contentUrl;

	/** @var string */
	private $editSummary;

	public function initEmail() {
		parent::initEmail();
		$this->contentTitle = $this->request->getVal('contentTitle');
		$this->contentUrl = $this->request->getVal('contentUrl');
		$this->editSummary = $this->request->getVal('editSummary');
	}

	public function getSubject():string {
		return $this->magicWordWrapper->wrap(function() {
			return $this->getMessage(
					'emailext-watchedpage-article-edited-subject',
					$this->contentTitle,
					$this->getCurrentUserName()
			)->text();
		});
	}

	/**
	 * @template avatarLayout
	 *
	 * other possible keys:
	 * 	editorProfilePage - link to user's profile page on this community
	 * 	buttonText - button beneath edit summary
	 * 	buttonLink - where buttonText goes
	 */
	public function body() {
		$this->magicWordWrapper->wrap(function() {
			$this->response->setData([
					'salutation' => $this->getSalutation(),
					'summary' => $this->getSummary(),
					'editorUserName' => $this->getCurrentUserName(),
					'editorAvatarURL' => $this->getCurrentAvatarURL(),
					'details' => $this->getDetails(),
					'contentFooterMessages' => $this->getContentFooterMessages(),
					'hasContentFooterMessages' => true,
			]);
		});
	}

	private function getSummary():string {
		return $this->getMessage(
				'emailext-watchedpage-article-edited',
				$this->contentUrl,
				$this->contentTitle
		)->parse();
	}

	private function getDetails():string {
		return $this->editSummary ? "\"{$this->editSummary}\"" : $this->getMessage('emailext-watchedpage-no-summary')->text();
	}

	private function getContentFooterMessages():array {
		return [
				$this->getMessage(
						'emailext-watchedpage-article-link-text',
						$this->contentUrl,
						$this->contentTitle
				)->parse(),
		];
	}
}
