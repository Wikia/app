<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;
use Email\Tracking\TrackingCategories;
use Email\ImageHelper;

class WelcomeController extends EmailController {
	const TRACKING_CATEGORY = TrackingCategories::WELCOME;
	const MOBILE_URL_IOS = 'https://itunes.apple.com/us/artist/wikia-inc./id422467077';
	const MOBILE_URL_ANDROID = 'https://play.google.com/store/apps/developer?id=Wikia,+Inc';

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
			'summary' => $this->getMessage( 'emailext-welcome-summary' )->text(),
			'extendedSummary' => $this->getMessage( 'emailext-welcome-summary-extended' )->text(),
			'details' => $this->getDetailsList(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-welcome-footer-community' )->parse(),
				$this->getMessage( 'emailext-welcome-footer-closing' )->text(),
				$this->getMessage( 'emailext-emailconfirmation-community-team' )->text()
			],
			'hasContentFooterMessages' => true,
		] );
	}

	protected function getDetailsList() {
		$basicsUrl = $this->getMessage( 'emailext-welcome-basics-url' )->text();
		return [
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Create-profile.png' ),
				'iconLink' => $this->getCurrentProfilePage(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-profile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-profile-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Learn-basics.png' ),
				'iconLink' => $basicsUrl,
				'detailsHeader' => $this->getMessage( 'emailext-welcome-basics-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-basics-description', $basicsUrl )->parse()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Favorite-fandom.png' ),
				'iconLink' => $this->getMessage( 'emailext-wikia-home-url' )->text(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-fandom-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-fandom-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Take-everywhere.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-mobile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-mobile-description',
					self::MOBILE_URL_IOS, self::MOBILE_URL_ANDROID )->parse()
			]
		];
	}
}

