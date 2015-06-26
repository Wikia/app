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

	protected function getSubject() {
		return $this->getMessage( 'emailext-welcome-subject', $this->getCurrentUserName() )->parse();
	}

	/**
	 * @template digestLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'details' => $this->getDetailsList(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-welcome-footer-community' )->parse(),
				$this->getMessage( 'emailext-welcome-footer-thanks' )->text()
			],
			'hasContentFooterMessages' => true,
		] );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-welcome-summary' )->text();
	}

	protected function getDetailsList() {
		if ( in_array( $this->targetLang, [ 'de', 'en', 'es', 'ja', 'pt', 'ru', 'zh' ] ) ) {
			$basicsUrl = \GlobalTitle::newFromText( 'Videos', NS_SPECIAL, \Wikia::COMMUNITY_WIKI_ID )->getFullURL();
		} else {
			$basicsUrl = \GlobalTitle::newFromText( 'Wikia_Basics', NS_HELP, \Wikia::COMMUNITY_WIKI_ID )->getFullURL();
		}
		return [
			[
				'iconSrc' => ImageHelper::getFileInfo( 'Create-profile.png' )['url'],
				'detailsHeader' => $this->getMessage( 'emailext-welcome-profile-header',
					$this->getCurrentProfilePage() )->parse(),
				'details' => $this->getMessage( 'emailext-welcome-profile-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileInfo( 'Learn-basics.png' )['url'],
				'detailsHeader' => $this->getMessage( 'emailext-welcome-basics-header',
					$basicsUrl )->parse(),
				'details' => $this->getMessage( 'emailext-welcome-basics-description' )->parse()
			],
			[
				'iconSrc' => ImageHelper::getFileInfo( 'Favorite-fandom.png' )['url'],
				'detailsHeader' => $this->getMessage( 'emailext-welcome-fandom-header' )->parse(),
				'details' => $this->getMessage( 'emailext-welcome-fandom-description' )->text()
			],
			[
				'iconSrc' => ImageHelper::getFileInfo( 'Take-everywhere.png' )['url'],
				'detailsHeader' => $this->getMessage( 'emailext-welcome-mobile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-mobile-description',
					self::MOBILE_URL_IOS, self::MOBILE_URL_ANDROID )->parse()
			]
		];
	}
}

