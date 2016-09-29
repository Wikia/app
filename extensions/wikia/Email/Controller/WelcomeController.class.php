<?php

namespace Email\Controller;

use Email\EmailController;
use Email\ImageHelper;

class WelcomeController extends EmailController {

	const LAYOUT_CSS = "digestLayout.css";
	const MOBILE_URL_IOS = 'https://itunes.apple.com/us/artist/wikia-inc./id422467077';
	const MOBILE_URL_ANDROID = 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.';

	public function initEmail() {
		$this->marketingFooter = true;
	}

	protected function getSubject() {
		return $this->getMessage( 'emailext-welcome-subject', $this->getCurrentUserName() )->text();
	}

	/**
	 * @template digestLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->createSummary(),
			'details' => $this->getDetailsList(),
			'hasContentFooterMessages' => true,
			'contentFooterMessages' => $this->createContentFooterMessages(),
			'signatureIcon' => ImageHelper::getFileUrl( 'Fandom-Heart-2x.png' ),
			'signature' => $this->getMessage( 'emailext-emailconfirmation-community-team' )->text()
		] );
	}

	private function createSummary() {
		return join(' ', [
			$this->getMessage( 'emailext-welcome-summary' )->text(),
			$this->getMessage( 'emailext-welcome-summary-extended' )->text(),
			$this->getMessage( 'emailext-welcome-summary-extended-tips' )->text()]);
	}

	private function createContentFooterMessages() {
		return [
			join(' ', [
				$this->getMessage( 'emailext-welcome-footer-community' )->parse(),
				$this->getMessage( 'emailext-welcome-footer-closing' )->text()])
		];
	}

	protected function getDetailsList() {
		$basicsUrl = $this->getMessage( 'emailext-welcome-basics-url' )->text();
		return [
			[
				'iconSrc' => ImageHelper::getFileUrl( 'CreateYourProfile.png' ),
				'iconLink' => $this->getCurrentProfilePage(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-profile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-profile-description' )->text()
			],
			[
				'icons' => [
					[
						'iconSrc' => ImageHelper::getFileUrl( 'Connect-FB.png' ),
						'iconLink' => $this->getMessage( 'oasis-social-facebook-link' )->text()
					],
					[
						'iconSrc' => ImageHelper::getFileUrl( 'Connect-Tw.png' ),
						'iconLink' => $this->getMessage( 'oasis-social-twitter-link' )->text()
					],
					[
						'iconSrc' => ImageHelper::getFileUrl( 'Connect-IG.png' ),
						'iconLink' => $this->getMessage( 'oasis-social-instagram-link' )->text()
					]
				],
				'iconLink' => $this->getMessage( 'emailext-wikia-home-url' )->text(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-fandom-connect-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-fandom-connect-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Fandom.png' ),
				'iconLink' => $this->getMessage( 'emailext-wikia-home-url' )->text(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-fandom-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-fandom-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'LearnTheBasics.png' ),
				'iconLink' => $basicsUrl,
				'detailsHeader' => $this->getMessage( 'emailext-welcome-basics-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-basics-description', $basicsUrl )->parse()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'TakeFandomEverywhere.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-mobile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-mobile-description',
					self::MOBILE_URL_IOS, self::MOBILE_URL_ANDROID )->parse()
			]
		];
	}
}

