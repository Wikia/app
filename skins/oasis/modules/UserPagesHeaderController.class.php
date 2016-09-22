<?php

/**
 * Renders header for user pages (profile / talk pages, Following, Contributions, blogs) with avatar and user's data
 *
 * @author Maciej Brencz
 */
class UserPagesHeaderController extends WikiaController {

	// This is really a local class var
	var $content_actions;

	public function init() {
		$this->content_actions = $this->app->getSkinTemplateObj()->data['content_actions'];
		$this->isUserProfilePageExt = false;
		$this->actionMenu = [ ];
		$this->comments = null;
		$this->editTimestamp = null;
	}

	/**
	 * Checks whether given user name is the current user
	 * @param string $userName User name to check against the current user
	 * @return bool Whether the current user matches the given username
	 */
	public static function isItMe( $userName ) {
		$wgUser = F::app()->wg->User;
		return $wgUser->isLoggedIn() && ( $userName == $wgUser->getName() );
	}

	/**
	 * Get name of the user this page refers to
	 * @param Title $title Title of the current page
	 * @param array $namespaces User/user talk/blog namespaces
	 * @param bool $fallbackToGlobal Whether to use the username from $wgUser as fallback
	 * @return string User name this page refers to
	 */
	public static function getUserName( Title $title, $namespaces, $fallbackToGlobal = true ) {
		wfProfileIn( __METHOD__ );
		$wg = F::app()->wg;

		$userName = null;

		if ( $title->inNamespaces( $namespaces ) ) {
			// get "owner" of this user / user talk / blog page
			$parts = explode( '/', $title->getText() );
		} else if ( $title->isSpecialPage() ) {
			if ( $title->isSpecial( 'Following' ) || $title->isSpecial( 'Contributions' ) ) {
				$target = $wg->Request->getText( 'target' );
				if ( $target != '' ) {
					// /wiki/Special:Contributions?target=FooBar (RT #68323)
					$parts = [ $target ];
				} else {
					// get user this special page referrs to
					$parts = explode( '/', $wg->Request->getText( 'title', false ) );

					// remove special page name
					array_shift( $parts );
				}
			}
		}

		if ( isset( $parts[0] ) && $parts[0] != '' ) {
			//this line was usign urldecode($parts[0]) before, see RT #107278, user profile pages with '+' symbols get 'non-existing' message
			$userName = str_replace( '_', ' ', $parts[0] );
		} elseif ( $fallbackToGlobal ) {
			// fallback value
			$userName = $wg->User->getName();
		}

		wfProfileOut( __METHOD__ );
		return $userName;
	}

	/**
	 * Get list of links for given username to be shown as tabs
	 * @param string $userName
	 * @return array Array of tabs - each tab is an array containing an HTML link, the data-id attribute and whether it is selected
	 */
	private function getTabs( $userName ) {
		wfProfileIn( __METHOD__ );

		$tabs = [];
		$namespace = $this->wg->Title->getNamespace();

		// profile
		$tabs[] = [
			'link' => Linker::link( Title::newFromText( $userName, NS_USER ), wfMessage( 'profile' )->escaped() ),
			'selected' => ( $namespace == NS_USER ),
			'data-id' => 'profile',
		];

		// talk
		$tabs[] = [
			'link' => Linker::link( Title::newFromText( $userName, NS_USER_TALK ), wfMessage( 'talkpage' )->escaped() ),
			'selected' => ( $namespace == NS_USER_TALK ),
			'data-id' => 'talk',
		];

		// blog
		if ( defined( 'NS_BLOG_ARTICLE' ) && !User::isIP( $this->userName ) ) {
			$tabs[] = [
				'link' => Linker::linkKnown( Title::newFromText( $userName, NS_BLOG_ARTICLE ), wfMessage( 'blog-page' )->escaped() ),
				'selected' => ( $namespace == NS_BLOG_ARTICLE ),
				'data-id' => 'blog',
			];
		}

		// contribs
		$tabs[] = [
			'link' => Linker::linkKnown( SpecialPage::getTitleFor( "Contributions/{$userName}" ), wfMessage( 'contris_s' )->escaped() ),
			'selected' => ( $this->wg->Title->isSpecial( 'Contributions' ) ),
			'data-id' => 'contribs',
		];

		if ( self::isItMe( $userName ) ) {
			// following (only render when user is viewing his own user pages)
			if ( !empty( $this->wg->EnableWikiaFollowedPages ) ) {
				$tabs[] = [
					'link' => Linker::linkKnown( SpecialPage::getTitleFor( 'Following' ), wfMessage( 'wikiafollowedpages-following' )->escaped() ),
					'selected' => ( $this->wg->Title->isSpecial( 'Following' ) ),
					'data-id' => 'following',
				];
			}
			if ( !empty( $this->wg->EnableUserActivityExt ) ) {
				$tabs[] = [
					'link' => Linker::linkKnown( SpecialPage::getTitleFor( 'UserActivity' ), wfMessage( 'user-activity-tab' )->escaped() ),
					'selected' => ( $this->wg->Title->isSpecial( 'UserActivity' ) ),
					'data-id' => 'user-activity',
				];
			}

			// avatar dropdown menu
			$this->avatarMenu = [
				Linker::linkKnown( SpecialPage::getTitleFor( 'Preferences' ), wfMessage( 'oasis-user-page-change-avatar' )->escaped() ),
			];
		}

		wfRunHooks( 'UserPagesHeaderModuleAfterGetTabs', [ &$tabs, $namespace, $userName ] );

		wfProfileOut( __METHOD__ );
		return $tabs;
	}

	public function index() {
		$userName = self::getUserName( $this->wg->Title, BodyController::getUserPagesNamespaces() );

		// render tabbed links below masthead
		$this->tabs = $this->getTabs( $userName );
	}

	/**
	 * Render header for blog post
	 */
	public function blogPost() {
		wfProfileIn( __METHOD__ );
		// remove User_blog:xxx from title
		$titleParts = explode( '/', $this->wg->Title->getText() );
		array_shift( $titleParts );
		$this->title = implode( '/', $titleParts );

		// get user name to display in header
		$this->userName = self::getUserName( $this->wg->Title, BodyController::getUserPagesNamespaces() );

		// render avatar (48x48)
		$this->avatar = AvatarService::renderAvatar( $this->userName, 48 );

		// link to user page
		$this->userPage = AvatarService::getUrl( $this->userName );

		if ( $this->wg->EnableBlogArticles ) {
			// link to user blog page
			$this->userBlogPage = AvatarService::getUrl( $this->userName, NS_BLOG_ARTICLE );

			// user blog page message
			$this->userBlogPageMessage = wfMessage( 'user-blog-url-link', $this->userName )->inContentLanguage()->parse();
		}
		if ( !empty( $this->wg->EnableGoogleAuthorInfo )
			&& !empty( $this->wg->GoogleAuthorLinks )
			&& array_key_exists( $this->userName, $this->wg->GoogleAuthorLinks )
		) {
			$this->googleAuthorLink = $this->wg->GoogleAuthorLinks[$this->userName] . '?rel=author';
		}

		$this->showNavLinks = $this->wg->Request->getVal( 'action' ) == 'history' || $this->wg->Request->getCheck( 'diff' );

		// commments / likes / date of first edit
		if ( !empty( $this->wg->Title ) && $this->wg->Title->exists() ) {
			$service = new PageStatsService( $this->wg->Title->getArticleID() );

			$this->editTimestamp = $this->wg->Lang->date( $service->getFirstRevisionTimestamp() );
			$this->comments = $service->getCommentsCount();
		}

		$actionMenu = [];
		$dropdownActions = [ 'move', 'protect', 'unprotect', 'delete', 'undelete', 'history' ];

		// edit button / dropdown
		if ( isset( $this->content_actions['ve-edit'] ) ) {
			// new visual editor is enabled
			$actionMenu['action'] = $this->content_actions['ve-edit'];
			// add classic editor link to the possible dropdown options
			array_unshift( $dropdownActions, 'edit' );
		} else if ( isset( $this->content_actions['edit'] ) ) {
			$actionMenu['action'] = $this->content_actions['edit'];
		}

		foreach ( $dropdownActions as $action ) {
			if ( isset( $this->content_actions[$action] ) ) {
				$actionMenu['dropdown'][$action] = $this->content_actions[$action];
			}
		}
		$this->actionMenu = $actionMenu;

		// load CSS for .WikiaUserPagesHeader (BugId:9212, 10246)
		$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/core/UserPagesHeader.scss" ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render header for blog listing
	 */
	public function blogListing() {
		wfProfileIn( __METHOD__ );

		// "Create blog post" button
		$this->actionButton = [
			'href' => Skin::makeSpecialUrl( 'CreateBlogPage' ),
			'text' => wfMessage( 'blog-create-post-label' )->text(),
		];
		$this->title = $this->wg->Title->getText();
		$this->subtitle = wfMessage( 'create-blog-post-category' )->escaped();

		// load CSS for .WikiaBlogListingHeader (BugId:9212, 10246)
		$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/core/UserPagesHeader.scss" ) );

		wfProfileOut( __METHOD__ );
	}
}
