<?php

namespace Wikia\CommunityHeader;

use \SpecialPage;

class WikiButtons {
	public $buttons;
	public $moreButtons;

	public function __construct() {
		$wgUser = \RequestContext::getMain()->getUser();

		if ( $wgUser->isLoggedIn() ) {
			if ( $wgUser->isAllowed( 'admindashboard' ) ) {
				$this->buttons = $this->adminButtons();
			} else {
				$this->buttons = $this->userButtons();
			}
			$this->moreButtons = $this->dropdownButtons();
		} else {
			$this->buttons = $this->anonButtons();
		}

	}

	private function anonButtons(): array {
		$addNewPageButton =
			new WikiButton( $this->getSpecialPageURL( 'CreatePage' ),
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-add-new-page-small', 'add-new-page', 'createpage' );

		return [ $addNewPageButton ];
	}

	private function userButtons(): array {
		$addNewPageButton =
			new WikiButton( $this->getSpecialPageURL( 'CreatePage' ),
				new Label( 'community-header-add', Label::TYPE_TRANSLATABLE_TEXT ),
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-add-new-page-small', 'add-new-page', 'createpage' );

		$wikiActivityButton =
			new WikiButton( $this->getSpecialPageURL( 'WikiActivity' ), null,
				new Label( 'community-header-wiki-activity', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-activity-small', 'wiki-activity' );

		return [ $addNewPageButton, $wikiActivityButton ];
	}

	private function adminButtons(): array {
		$addNewPageButton =
			new WikiButton( $this->getSpecialPageURL( 'CreatePage' ), null,
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-add-new-page-small', 'add-new-page', 'createpage' );

		$wikiActivityButton =
			new WikiButton( $this->getSpecialPageURL( 'WikiActivity' ), null,
				new Label( 'community-header-wiki-activity', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-activity-small', 'wiki-activity' );

		$adminDashboardURL = $this->getSpecialPageURL( 'AdminDashboard' );
		$adminDashboardButton =
			new WikiButton( $adminDashboardURL, null,
				new Label( 'community-header-admin-dashboard', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-dashboard-small', 'admin-dashboard' );

		return [ $addNewPageButton, $wikiActivityButton, $adminDashboardButton ];
	}

	private function dropdownButtons(): array {
		$addNewImageButton =
			new WikiButton( $this->getSpecialPageURL( 'Upload' ),
				new Label( 'community-header-add-new-image', Label::TYPE_TRANSLATABLE_TEXT ), null,
				null, 'more-add-new-image' );

		$addNewVideoButton =
			new WikiButton( $this->getSpecialPageURL( 'Videos' ),
				new Label( 'community-header-add-new-video', Label::TYPE_TRANSLATABLE_TEXT ), null,
				null, 'more-add-new-video', 'wiki-button-add-video' );

		$recentChangesButton =
			new WikiButton( $this->getSpecialPageURL( 'RecentChanges' ),
				new Label( 'community-header-recent-changes', Label::TYPE_TRANSLATABLE_TEXT ), null,
				null, 'more-recent-changes' );

		$allShortcutsButton =
			new WikiButton( '#',
				new Label( 'community-header-all-shortcuts', Label::TYPE_TRANSLATABLE_TEXT ), null,
				null, 'more-all-shortcuts', 'wiki-button-all-shortcuts' );

		return [
			$addNewImageButton,
			$addNewVideoButton,
			$recentChangesButton,
			$allShortcutsButton,
		];
	}

	private function getSpecialPageURL( $name ): string {
		return SpecialPage::getTitleFor( $name )->getLocalURL();
	}
}
