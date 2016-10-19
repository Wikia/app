<?php

namespace Email\Controller;

use Email\EmailController;
use Email\ImageHelper;
use Email\MobileApplicationsLinksGenerator;
use Email\SocialLinksGenerator;

class WelcomeController extends EmailController {

	const LAYOUT_CSS = "digestLayout.css";

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
			'signature' => $this->getMessage( 'emailext-emailconfirmation-community-team' )->text(),
		] );
	}

	private function createSummary() {
		return join( ' ', [
			$this->getMessage( 'emailext-welcome-summary' )->text(),
			$this->getMessage( 'emailext-welcome-summary-extended' )->text(),
			$this->getMessage( 'emailext-welcome-summary-extended-tips' )->text(),
		] );
	}

	private function createContentFooterMessages() {
		return [
			join( ' ', [
				$this->getMessage( 'emailext-welcome-footer-community' )->parse(),
				$this->getMessage( 'emailext-welcome-footer-closing' )->text(),
			] ),
		];
	}

	protected function getDetailsList() {
		$basicsUrl = $this->getMessage( 'emailext-welcome-basics-url' )->text();
		$linksGenerator = new MobileApplicationsLinksGenerator( $this->targetLang );
		$mobileApplicationsLinks = $linksGenerator->generate();

		return [
			[
				'iconSrc' => ImageHelper::getFileUrl( 'CreateYourProfile.png' ),
				'iconLink' => $this->getCurrentProfilePage(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-profile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-profile-description' )->text(),
			],
			[
				'icons' => SocialLinksGenerator::generateForWelcomeEmail( $this->targetLang ),
				'iconLink' => $this->getMessage( 'emailext-wikia-home-url' )->text(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-fandom-connect-header' )
					->text(),
				'details' => $this->getMessage( 'emailext-welcome-fandom-connect-description' )
					->text(),
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'Fandom.png' ),
				'iconLink' => $this->getMessage( 'emailext-wikia-home-url' )->text(),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-fandom-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-fandom-description' )->text(),
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'LearnTheBasics.png' ),
				'iconLink' => $basicsUrl,
				'detailsHeader' => $this->getMessage( 'emailext-welcome-basics-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-basics-description', $basicsUrl )
					->parse(),
			],
			[
				'iconSrc' => ImageHelper::getFileUrl( 'TakeFandomEverywhere.png' ),
				'detailsHeader' => $this->getMessage( 'emailext-welcome-mobile-header' )->text(),
				'details' => $this->getMessage( 'emailext-welcome-mobile-description',
					$mobileApplicationsLinks[MobileApplicationsLinksGenerator::IOS_PLATFORM],
					$mobileApplicationsLinks[MobileApplicationsLinksGenerator::ANDROID_PLATFORM] )
					->parse(),
			],
		];
	}
}

