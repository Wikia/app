<?php

namespace Email\Controller;

use Email;
use Email\Check;
use Email\ControllerException;
use Email\EmailController;
use Wikia\Logger;
use Email\Tracking\TrackingCategories;

abstract class FounderController extends EmailController {
	// Defaults; will be overridden in subclasses
	const TRACKING_CATEGORY_EN = TrackingCategories::DEFAULT_CATEGORY;
	const TRACKING_CATEGORY_INT = TrackingCategories::DEFAULT_CATEGORY;

	/**
	 * Determine which sendgrid category to send based on target language and specific
	 * founder email being sent. See dependent classes for overridden values
	 *
	 * @return string
	 */
	public function getSendGridCategory() {
		return strtolower( $this->targetLang ) == 'en'
			? static::TRACKING_CATEGORY_EN
			: static::TRACKING_CATEGORY_INT;
	}

}

abstract class AbstractFounderEditController extends FounderController {

	/** @var \Title */
	protected $pageTitle;

	protected $previousRevId;
	protected $currentRevId;

	public function initEmail() {
		// This title is for the article being commented upon
		$titleText = $this->request->getVal( 'pageTitle' );
		$titleNamespace = $this->request->getVal( 'pageNs' );

		$this->pageTitle = \Title::newFromText( $titleText, $titleNamespace );

		$this->previousRevId = $this->request->getVal( 'previousRevId' );
		$this->currentRevId = $this->request->getVal( 'currentRevId' );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
		$this->assertValidRevisionIds();
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidTitle() {
		if ( !$this->pageTitle instanceof \Title ) {
			throw new Check( "Invalid value passed for title" );
		}

		if ( !$this->pageTitle->exists() ) {
			throw new Check( "Title doesn't exist." );
		}
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidRevisionIds() {
		if ( empty( $this->previousRevId ) ) {
			throw new Check( "Invalid value passed for previousRevId" );
		}

		if ( empty( $this->currentRevId ) ) {
			throw new Check( "Invalid value passed for currentRevId" );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'summary' => $this->getSummary(),
			'buttonText' => $this->getChangesLabel(),
			'buttonLink' => $this->getChangesLink(),
			'contentFooterMessages' => [
				$this->getFooterEncouragement(),
				$this->getFooterArticleLink(),
				$this->getFooterAllChangesLink(),
			],
			'details' => $this->getDetails(),
			'hasContentFooterMessages' => true
		] );
	}

	public function getSubject() {
		$articleTitle = $this->pageTitle->getText();
		$name = $this->getCurrentUserName();

		return $this->getMessage( 'emailext-founder-subject', $articleTitle, $name )
			->text();
	}

	protected function getSummary() {
		$articleUrl = $this->pageTitle->getFullURL();
		$articleTitle = $this->pageTitle->getText();

		return $this->getMessage( 'emailext-founder-summary', $articleUrl, $articleTitle )
			->parse();
	}

	protected function getDetails() {
		$article = \Article::newFromTitle( $this->pageTitle, \RequestContext::getMain() );
		$service = new \ArticleService( $article );
		$snippet = $service->getTextSnippet();

		return $snippet;
	}

	protected function getChangesLabel() {
		return $this->getMessage( 'emailext-founder-link-label' )->parse();
	}

	protected function getChangesLink() {
		return $this->pageTitle->getFullURL( [
			'diff' => $this->currentRevId,
			'oldid' => $this->previousRevId,
		] );
	}

	protected function getFooterEncouragement() {
		$name = $this->getCurrentUserName();
		$profileUrl = $this->getCurrentProfilePage();

		return $this->getMessage( $this->getFooterEncouragementKey(), $profileUrl, $name )
			->parse();
	}

	protected function getFooterEncouragementKey() {
		return 'emailext-founder-encourage';
	}

	protected function getFooterArticleLink() {
		$articleTitle = $this->pageTitle->getText();
		$url = $this->pageTitle->getFullURL( [
			'diff' => $this->currentRevId,
		] );

		return $this->getMessage( 'emailext-founder-footer-article', $url, $articleTitle )
			->parse();
	}

	protected function getFooterAllChangesLink() {
		$articleTitle = $this->pageTitle->getText();
		$url = $this->pageTitle->getFullURL( [
			'action' => 'history'
		] );

		return $this->getMessage( 'emailext-founder-footer-all-changes', $url, $articleTitle )
			->parse();
	}

	/**
	 * Form fields required for this email for Special:SendEmail. See
	 * EmailController::getEmailSpecificFormFields for more info.
	 * @return array
	 */
	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'pageTitle',
					'label' => "Article Title",
					'tooltip' => "eg 'Rachel_Berry' (make sure it's on this wikia!)"
				],
				[
					'type' => 'hidden',
					'name' => 'pageNs',
					'value' => NS_MAIN
				],
				[
					'type' => 'text',
					'name' => 'previousRevId',
					'label' => "Previous revision ID",
					'tooltip' => "Use the 'oldid' parameter from an article diff"
				],
				[
					'type' => 'text',
					'name' => 'currentRevId',
					'label' => "Current revision ID",
					'tooltip' => "Use the 'diff' parameter from an article diff"
				],
			]
		];

		return array_merge_recursive( $formFields, parent::getEmailSpecificFormFields() );
	}

}

class FounderEditController extends AbstractFounderEditController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_FIRST_EDIT_USER_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_FIRST_EDIT_USER_INT;
}

class FounderMultiEditController extends AbstractFounderEditController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_EDIT_USER_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_EDIT_USER_INT;

	protected function getFooterEncouragementKey() {
		return 'emailext-founder-multi-encourage';
	}
}

class FounderAnonEditController extends AbstractFounderEditController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_EDIT_ANON_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_EDIT_ANON_INT;

	public function getSubject() {
		$articleTitle = $this->pageTitle->getText();

		return $this->getMessage( 'emailext-founder-anon-subject', $articleTitle )
			->text();
	}

	protected function getFooterEncouragement() {
		return $this->getMessage( 'emailext-founder-anon-encourage' )
			->parse();
	}


	/**
	 * Form fields required for this email for Special:SendEmail. See
	 * EmailController::getEmailSpecificFormFields for more info.
	 * @return array
	 */
	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'hidden',
					'name' => 'currentUser',
					'value' => -1
				],
			]
		];

		return array_merge_recursive( $formFields, parent::getEmailSpecificFormFields() );
	}
}

class FounderActiveController extends FounderController {

	/**
	 * Define this and do nothing since we don't need the checks of our parent
	 */
	public function initEmail() {
		// NOOP
	}

	public function getSubject() {
		return $this->getMessage( 'emailext-founder-active-subject' )->text();
	}

	/**
	 * @template multiAvatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'avatarAndDetailsList' => $this->getChangeList(),
			'buttonText' => $this->getChangesLabel(),
			'buttonLink' => $this->getChangesLink(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-founder-active-footer-1' )->text(),
				$this->getMessage( 'emailext-founder-active-footer-2' )->text(),
			],
			'hasContentFooterMessages' => true
		] );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-founder-active-summary' )->parse();
	}

	private function getChangeList() {
		$changes = $this->getRecentActivity();
		$changeList = [];

		foreach ( $changes as $event ) {
			try {
				$eventUser = $this->getUserFromName( $event[ 'user' ] );
			} catch ( ControllerException $e ) {
				Logger\WikiaLogger::instance()->warning( 'User from recent activity not found', [
					'method' => __METHOD__,
					'username' => $event['user'],
				] );
				continue;
			}

			$changeList[] = [
				'editorProfilePage' => $eventUser->getUserPage()->getFullURL(),
				'editorUserName' => $eventUser->getName(),
				'editorAvatarURL' => $this->getAvatarURL( $eventUser ),
				'details' => $this->getDetails( $event ),
			];
		}

		return $changeList;
	}

	protected function getDetails( array $event ) {
		$titleKey = $event['title'];
		$ns = $event['ns'];
		$title = \Title::newFromText( $titleKey, $ns );

		$titleUrl = $title->getFullURL();
		$titleText = $title->getText();

		$msgKey = $event['type'] == 'new' ? 'emailext-founder-new-update' : 'emailext-founder-edit-update';
		return $this->getMessage( $msgKey, $titleUrl, $titleText )->parse();
	}

	private function getRecentActivity( $num = 5 ) {
		$wg = \F::app()->wg;

		$data = \ApiService::call( [
			'action' => 'query',
			'list' => 'recentchanges',
			'rctype' => implode( '|', [ 'new', 'edit' ] ),
			'rcprop' => implode( '|', [ 'user', 'title' ] ),
			'rcnamespace' => implode( '|', $wg->ContentNamespaces),
			'rcexcludeuser' => $this->getTargetUserName(),
			'rcshow' => implode( '|', [ '!minor', '!bot', '!anon', '!redirect' ] ),
			'rclimit' => $num,
			'rctoponly' => 1,
		] );

		if ( !empty( $data['query']['recentchanges'] ) ) {
			return $data['query']['recentchanges'];
		}

		return [];
	}

	protected function getChangesLabel() {
		return $this->getMessage( 'emailext-founder-active-link-label' )->parse();
	}

	protected function getChangesLink() {
		$title = \SpecialPage::getTitleFor( 'WikiActivity' );
		return $title->getFullURL();
	}

	protected function getFooterMessages() {
		return EmailController::getFooterMessages();
	}

	/**
	 * Form fields required for this email for Special:SendEmail. See
	 * EmailController::getEmailSpecificFormFields for more info.
	 * @return array
	 */
	protected static function getEmailSpecificFormFields() {
		return EmailController::getEmailSpecificFormFields();
	}
}

class FounderNewMemberController extends FounderController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_NEW_MEMBER_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_NEW_MEMBER_INT;

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'summary' => $this->getSummary(),
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->getButtonLink(),
			'details' => $this->getDetails(),
		] );
	}

	public function getSubject() {
		return $this->getMessage( 'emailext-founder-new-member-subject', $this->currentUser->getName() )->parse();
	}

	// Same message use for subject and summary
	public function getSummary() {
		return $this->getSubject();
	}

	public function getDetails() {
		return $this->getMessage( 'emailext-founder-new-member-details', $this->currentUser->getName() )->parse();
	}

	public function getButtonText() {
		return $this->getMessage( 'emailext-founder-new-member-link-label' )->text();
	}

	public function getButtonLink() {
		return $this->currentUser->getTalkPage()->getFullURL();
	}

	public function assertCanEmail() {
		parent::assertCanEmail();
		$this->assertFounderSubscribedToDigest();
		$this->assertFounderWantsNewMembersEmail();
	}

	/**
	 * If the founder is subscribed to the founder's digest, don't send them an individual email informing them
	 * a new user joined their wiki. They'll learn about that in the digest.
	 * @throws \Email\Check
	 */
	public function assertFounderSubscribedToDigest() {
		$wikiId = \F::app()->wg->CityId;
		if ( (bool)$this->targetUser->getLocalPreference( "founderemails-complete-digest", $wikiId ) ) {
			throw new Check( 'Digest mode is enabled, do not create user registration event notifications' );
		}
	}

	/**
	 * @throws \Email\Check
	 */
	public function assertFounderWantsNewMembersEmail() {
		$wikiId = \F::app()->wg->CityId;
		if ( !(bool)$this->targetUser->getLocalPreference( "founderemails-joins", $wikiId ) ) {
			throw new Check( "Founder doesn't want to be emailed about new members joining this wiki" );
		}
	}
}

class FounderTipsController extends FounderController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_TIPS_0_DAY_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_TIPS_0_DAY_INT;

	const LAYOUT_CSS = "digestLayout.css";

	protected $wikiName;
	protected $wikiId;
	protected $wikiUrl;

	public function initEmail() {
		$this->wikiName = $this->getVal( 'wikiName' );
		$this->wikiId = $this->getVal( 'wikiId' );
		$this->wikiUrl = $this->getVal( 'wikiUrl' );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidWikiName();
		$this->assertValidWikiId();
		$this->assertValidWikiUrl();
	}

	private function assertValidWikiName() {
		if ( empty( $this->wikiName ) ) {
			throw new Check( "Must pass in value for wikiName!" );
		}
	}

	private function assertValidWikiId() {
		if ( empty( $this->wikiId ) ) {
			throw new Check( "Must pass in value for wikiId!" );
		}
	}

	private function assertValidWikiUrl() {
		if ( empty( $this->wikiUrl ) ) {
			throw new Check( "Must pass in value for wikiUrl!" );
		}
	}

	protected function getSubject() {
		return $this->getMessage( 'emailext-founder-newly-created-subject', $this->wikiName )->text();
	}

	/**
	 * @template founderTips
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getMessage( 'emailext-founder-newly-created-summary', $this->wikiUrl, $this->wikiName )->parse(),
			'extendedSummary' => $this->getMessage( 'emailext-founder-newly-created-summary-extended' )->text(),
			'details' => $this->getDetailsList(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-founder-visit-community', $this->wikiUrl, $this->wikiName )->parse(),
				$this->getMessage( 'emailext-founder-happy-wikia-building' )->text(),
				$this->getMessage( 'emailext-emailconfirmation-community-team' )->text(),
			],
		] );
	}

	/**
	 * Returns list of details (icons, headers, and blurbs for those icons) for the founder tips email
	 *
	 * @return array
	 */
	protected function getDetailsList() {
		return [
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Add_page.png" ),
				"iconLink" => \GlobalTitle::newFromText( "CreatePage", NS_SPECIAL, $this->wikiId )->getFullURL( [ "modal" => "AddPage" ] ),
				"detailsHeader" => $this->getMessage( "emailext-founder-add-pages-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-add-pages-details" )->text()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Add_photo.png" ),
				"iconLink" => \GlobalTitle::newFromText( "NewFiles", NS_SPECIAL, $this->wikiId )->getFullURL( [ "modal" => "UploadImage" ] ),
				"detailsHeader" => $this->getMessage( "emailext-founder-add-photos-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-add-photos-details" )->text()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Customize.png" ),
				"iconLink" => \GlobalTitle::newFromText( wfMessage( "mainpage" )->text(), NS_MAIN, $this->wikiId )->getFullURL( [ "action" => "edit" ] ),
				"detailsHeader" => $this->getMessage( "emailext-founder-customize-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-customize-details" )->text()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Share.png" ),
				"detailsHeader" => $this->getMessage( "emailext-founder-share-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-share-details" )->text()
			]
		];
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'wikiName',
					'label' => "Wiki Name",
					'value' => \F::app()->wg->Sitename,
					'tooltip' => "The name of the Wiki (defaults to current wiki)"
				],
				[
					'type' => 'text',
					'name' => 'wikiId',
					'label' => "Wiki ID",
					'value' => \F::app()->wg->CityId,
					'tooltip' => "The ID of the Wiki (defaults to current wiki)"
				],
				[
					'type' => 'text',
					'name' => 'wikiUrl',
					'label' => "Wiki URL",
					'value' => \F::app()->wg->Server,
					'tooltip' => "The URL of the Wiki (defaults to current wiki)"
				],
			]
		];

		return array_merge_recursive( $formFields, parent::getEmailSpecificFormFields() );
	}
}

class FounderTipsThreeDaysController extends FounderTipsController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_TIPS_3_DAY_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_TIPS_3_DAY_INT;

	const WAM_LINK = "http://www.wikia.com/WAM";

	protected function getSubject() {
		return $this->getMessage( 'emailext-founder-3-days-subject', $this->wikiName )->text();
	}

	/**
	 * @template founderTips
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getMessage( 'emailext-founder-3-days-summary', $this->wikiUrl, $this->wikiName )->parse(),
			'extendedSummary' => $this->getMessage( 'emailext-founder-3-days-extended-summary' )->text(),
			'details' => $this->getDetailsList(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-founder-3-days-need-help', $this->wikiName )->parse(),
				$this->getMessage( 'emailext-founder-3-days-great-work' )->text(),
				$this->getMessage( 'emailext-emailconfirmation-community-team' )->text(),
			],
		] );
	}

	/**
	 * Returns list of details (icons, headers, and blurbs for those icons) for the founder tips email
	 *
	 * @return array
	 */
	protected function getDetailsList() {
		$themeDesignerUrl = \GlobalTitle::newFromText( "ThemeDesigner", NS_SPECIAL, $this->wikiId )->getFullURL();
		return [
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Add_photo.png" ),
				"iconLink" => \GlobalTitle::newFromText( "Videos", NS_SPECIAL, $this->wikiId )->getFullURL(),
				"detailsHeader" => $this->getMessage( "emailext-founder-3-days-add-videos-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-3-days-add-videos-details" )->text()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Update-theme.png" ),
				"iconLink" => $themeDesignerUrl,
				"detailsHeader" => $this->getMessage( "emailext-founder-3-days-update-theme-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-3-days-update-theme-details", $themeDesignerUrl )->parse()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Get-inspired.png" ),
				"iconLink" => self::WAM_LINK,
				"detailsHeader" => $this->getMessage( "emailext-founder-3-days-wam-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-3-days-wam-details", self::WAM_LINK )->parse()
			]
		];
	}


}
class FounderTipsTenDaysController extends FounderTipsController {
	const TRACKING_CATEGORY_EN = TrackingCategories::FOUNDER_TIPS_10_DAY_EN;
	const TRACKING_CATEGORY_INT = TrackingCategories::FOUNDER_TIPS_10_DAY_INT;

	protected function getSubject() {
		return $this->getMessage( 'emailext-founder-10-days-subject', $this->wikiName )->text();
	}

	/**
	 * @template founderTips
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getMessage( 'emailext-founder-10-days-summary', $this->wikiUrl, $this->wikiName )->parse(),
			'extendedSummary' => $this->getMessage( 'emailext-founder-10-days-extended-summary' )->text(),
			'details' => $this->getDetailsList(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-founder-10-days-email-what-next' )->text(),
				$this->getMessage( 'emailext-emailconfirmation-community-team' )->text(),
			],
		] );
	}

	/**
	 * Returns list of details (icons, headers, and blurbs for those icons) for the founder tips email
	 *
	 * @return array
	 */
	protected function getDetailsList() {
		return [
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Share.png" ),
				"detailsHeader" => $this->getMessage( "emailext-founder-10-days-sharing-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-10-days-sharing-details" )->text()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Power-of-email.png" ),
				"detailsHeader" => $this->getMessage( "emailext-founder-10-days-email-power-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-10-days-email-power-details" )->text()
			],
			[
				"iconSrc" => Email\ImageHelper::getFileUrl( "Get-with-google.png" ),
				"iconLink" => $this->getMessage( "emailext-founder-get-with-google" )->text(),
				"detailsHeader" => $this->getMessage( "emailext-founder-10-days-email-google-header" )->text(),
				"details" => $this->getMessage( "emailext-founder-10-days-email-google-details" )->text()
			]
		];
	}
}
