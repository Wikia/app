<?php

/**
 * Admin Dashboard Special Page
 * @author Hyun
 * @author Owen
 *
 */
class AdminDashboardSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'AdminDashboard', '', false );
	}

	/**
	 * Displays the main menu for the admin dashboard
	 */
	public function index() {
		$this->getOutput()->setPageTitle( $this->msg( 'admindashboard-header' )->text() );
		if ( !$this->getUser()->isAllowed( 'admindashboard' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->tab = $this->getVal( 'tab', 'general' );

		// links
		$this->urlThemeDesigner = SpecialPage::getTitleFor( 'ThemeDesigner' )->getFullURL();
		$this->urlRecentChanges = SpecialPage::getTitleFor( 'RecentChanges' )->getFullURL();
		$this->urlTopNavigation = Title::newFromText( 'Wiki-navigation', NS_MEDIAWIKI )->getFullURL( 'action=edit' );
		$this->urlWikiFeatures = SpecialPage::getTitleFor( 'WikiFeatures' )->getFullURL();

		$this->urlListUsers = SpecialPage::getTitleFor( 'ListUsers' )->getFullURL();
		$this->urlUserRights = SpecialPage::getTitleFor( 'UserRights' )->getFullURL();

		$this->urlCommunityCorner = Title::newFromText( 'Community-corner', NS_MEDIAWIKI )->getFullURL( 'action=edit' );
		$this->urlAllCategories = SpecialPage::getTitleFor( 'Categories' )->getFullURL();
		$this->urlAddPage = SpecialPage::getTitleFor( 'CreatePage' )->getFullURL();
		$this->urlAddPhoto = SpecialPage::getTitleFor( 'Upload' )->getFullURL();
		if ( !empty( $this->wg->EnableSpecialVideosExt ) ) {
			$this->showVideoLink = true;
			$this->urlAddVideo = SpecialPage::getTitleFor( 'WikiaVideoAdd' )->getFullURL();
			$this->urlAddVideoReturnUrl = SpecialPage::getTitleFor( 'Videos' )->escapeLocalURL();
		} else {
			$this->showVideoLink = false;
		}
		$this->urlCreateBlogPage = SpecialPage::getTitleFor( 'CreateBlogPage' )->getFullURL();
		$this->urlMultipleUpload = SpecialPage::getTitleFor( 'MultipleUpload' )->getFullURL();
		$this->urlSpecialCss = SpecialPage::getTitleFor( 'CSS' )->getFullURL();

		// special:specialpages
		$this->advancedSection = (string)$this->sendSelfRequest( 'getAdvancedSection', [ ] );

		// icon display logic
		$this->displayWikiFeatures = !empty( $this->wg->EnableWikiFeatures );
		$this->displaySpecialCss = !empty( $this->wg->EnableSpecialCssExt );

		// Add Upload Photos Dialog
		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );
	}

	/**
	 * Returns the list of special pages that belong to the 'Advanced' section of Admin Dashboard	 *
	 */
	public function getAdvancedSection() {
		if ( !$this->wg->User->isAllowed( 'admindashboard' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$pages = SpecialPageFactory::getUsablePages();

		if ( count( $pages ) == 0 ) {
			return;
		}

		// Put them into a sortable array
		$groups = [ ];
		/**
		 * @var string $pagename
		 * @var SpecialPage $page
		 */
		foreach ( $pages as $pagename => $page ) {
			if ( !AdminDashboardLogic::isGeneralApp( $pagename ) && $page->isListed() ) {
				$group = SpecialPageFactory::getGroup( $page );
				if ( !isset( $groups[$group] ) ) {
					$groups[$group] = [ ];
				}
				$groups[$group][$page->getDescription()] = [ $page->getTitle(), $page->isRestricted() ];
			}
		}

		// Sort
		if ( $this->wg->SortSpecialPages ) {
			foreach ( $groups as $group => $sortedPages ) {
				ksort( $groups[$group] );
			}
		}

		// Always move "other" to end
		if ( array_key_exists( 'other', $groups ) ) {
			$other = $groups['other'];
			unset( $groups['other'] );
			$groups['other'] = $other;
		}
		$this->groups = $groups;
	}
}
