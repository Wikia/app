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
	 * @brief Displays the main menu for the admin dashboard
	 *
	 */
	public function index() {
		$this->getOutput()->setPageTitle( $this->msg( 'admindashboard-header' )->text() );
		if ( !$this->getUser()->isAllowed( 'admindashboard' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->tab = $this->getVal( 'tab', 'general' );

		// links
		$this->urlThemeDesigner = Title::newFromText( 'ThemeDesigner', NS_SPECIAL )->getFullURL();
		$this->urlRecentChanges = Title::newFromText( 'RecentChanges', NS_SPECIAL )->getFullURL();
		$this->urlTopNavigation = Title::newFromText( 'Wiki-navigation', NS_MEDIAWIKI )->getFullURL( 'action=edit' );
		$this->urlWikiFeatures = Title::newFromText( 'WikiFeatures', NS_SPECIAL )->getFullURL();

		$this->urlListUsers = Title::newFromText( 'ListUsers', NS_SPECIAL )->getFullURL();
		$this->urlUserRights = Title::newFromText( 'UserRights', NS_SPECIAL )->getFullURL();

		$this->urlCommunityCorner = Title::newFromText( 'Community-corner', NS_MEDIAWIKI )->getFullURL( 'action=edit' );
		$this->urlAllCategories = Title::newFromText( 'Categories', NS_SPECIAL )->getFullURL();
		$this->urlAddPage = Title::newFromText( 'CreatePage', NS_SPECIAL )->getFullURL();
		$this->urlAddPhoto = Title::newFromText( 'Upload', NS_SPECIAL )->getFullURL();
		if ( !empty( $this->wg->EnableSpecialVideosExt ) ) {
			$this->showVideoLink = true;
			$this->urlAddVideo = Title::newFromText( 'WikiaVideoAdd', NS_SPECIAL )->getFullURL();
			$this->urlAddVideoReturnUrl = SpecialPage::getTitleFor( "Videos" )->escapeLocalUrl();
		} else {
			$this->showVideoLink = false;
		}
		$this->urlCreateBlogPage = Title::newFromText( 'CreateBlogPage', NS_SPECIAL )->getFullURL();
		$this->urlMultipleUpload = Title::newFromText( 'MultipleUpload', NS_SPECIAL )->getFullURL();
		$this->urlSpecialCss = SpecialPage::getTitleFor( 'CSS' )->getFullURL();

		// special:specialpages
		$this->advancedSection = (string)$this->sendSelfRequest( 'getAdvancedSection', [ ] );

		// icon display logic
		$this->displayWikiFeatures = !empty( $this->wg->EnableWikiFeatures );
		$this->displaySpecialCss = !empty( $this->wg->EnableSpecialCssExt );

		// add messages package
		JSMessages::enqueuePackage( 'AdminDashboard', JSMessages::INLINE );

		// Add Upload Photos Dialog
		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );
	}

	/**
	 * @brief Copied and pasted code from wfSpecialSpecialpages() that have been modified and refactored.  Also removes some special pages from list.
	 *
	 */
	public function getAdvancedSection() {

		if ( !$this->wg->User->isAllowed( 'admindashboard' ) ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}
		$this->sk = $this->getContext()->getSkin();
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
