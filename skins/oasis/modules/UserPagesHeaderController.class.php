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
		$this->actionMenu = array();
		$this->comments = null;
		$this->editTimestamp = null;

		//User pages have custom page header
		$this->wg->SuppressPageHeader = true;
	}

	/**
	 * Checks whether given user name is the current user
	 */
	public static function isItMe( $userName ) {
		global $wgUser;
		return $wgUser->isLoggedIn() && ( $userName == $wgUser->getName() );
	}

	/**
	 * Get name of the user this page referrs to
	 */
	public static function getUserName( Title $title, $namespaces, $fallbackToGlobal = true ) {
		wfProfileIn( __METHOD__ );
		global $wgUser, $wgRequest;

		$userName = null;

		if ( in_array( $title->getNamespace(), $namespaces ) ) {
			// get "owner" of this user / user talk / blog page
			$parts = explode('/', $title->getText());
		}
		else if( $title->getNamespace() == NS_SPECIAL ) {
				if( $title->isSpecial( 'Following' ) || $title->isSpecial( 'Contributions' )) {
					$target = $wgRequest->getText('target');
					if( $target != '' ) {
						// /wiki/Special:Contributions?target=FooBar (RT #68323)
						$parts = array( $target );
					}
					else {
						// get user this special page referrs to
						$parts = explode( '/', $wgRequest->getText( 'title', false ) );

						// remove special page name
						array_shift( $parts );
					}
				}
			}

		if ( isset( $parts[0] ) && $parts[0] != '' ) {
			//this line was usign urldecode($parts[0]) before, see RT #107278, user profile pages with '+' symbols get 'non-existing' message
			$userName = str_replace( '_', ' ', $parts[0] );
		}
		elseif ( $fallbackToGlobal ) {
			// fallback value
			$userName = $wgUser->getName();
		}

		wfProfileOut( __METHOD__ );
		return $userName;
	}

	/**
	 * Get list of links for given username to be shown as tabs
	 */
	private function getTabs( $userName ) {
		wfProfileIn( __METHOD__ );
		global $wgTitle, $wgEnableWikiaFollowedPages;

		$tabs = array();
		$namespace = $wgTitle->getNamespace();

		// profile
		$tabs[] = array(
				'link' => Wikia::link( Title::newFromText( $userName, NS_USER ), wfMsg( 'profile' ) ),
				'selected' => ($namespace == NS_USER),
				'data-id' => 'profile',
				);

		// talk
		$tabs[] = array(
				'link' => Wikia::link( Title::newFromText( $userName, NS_USER_TALK ), wfMsg( 'talkpage' ) ),
				'selected' => ( $namespace == NS_USER_TALK ),
				'data-id' => 'talk',
				);

		// blog
		if( defined( 'NS_BLOG_ARTICLE' ) && !User::isIP( $this->userName ) ) {
			$tabs[] = array(
				'link' => Wikia::link( Title::newFromText( $userName, NS_BLOG_ARTICLE ), wfMsg( 'blog-page' ), array(), array(), 'known' ),
				'selected' => ( $namespace == NS_BLOG_ARTICLE ),
				'data-id' => 'blog',
			);
		}

		// contribs
		$tabs[] = array(
			'link' => Wikia::link( SpecialPage::getTitleFor( "Contributions/{$userName}" ), wfMsg( 'contris_s' ) ),
			'selected' => ( $wgTitle->isSpecial( 'Contributions' ) ),
			'data-id' => 'contribs',
		);

		if ( self::isItMe( $userName ) ) {
			// following (only render when user is viewing his own user pages)
			if ( !empty( $wgEnableWikiaFollowedPages ) ) {
				$tabs[] = array(
					'link' => Wikia::link( SpecialPage::getTitleFor( 'Following' ), wfMsg( 'wikiafollowedpages-following' ) ),
					'selected' => ( $wgTitle->isSpecial( 'Following' ) ),
					'data-id' => 'following',
				);
			}
			if ( !empty( F::app()->wg->EnableUserActivityExt ) ) {
				$tabs[] = [
					'link' => Wikia::link( SpecialPage::getTitleFor( 'UserActivity' ), wfMessage( 'user-activity-tab' )->text() ),
					'selected' => ( $wgTitle->isSpecial( 'UserActivity' ) ),
					'data-id' => 'user-activity',
				];
			}

			// avatar dropdown menu
			$this->avatarMenu = array(
				Wikia::link( SpecialPage::getTitleFor( 'Preferences' ), wfMsg( 'oasis-user-page-change-avatar' ) )
			);
		}

		Hooks::run( 'UserPagesHeaderModuleAfterGetTabs', array( &$tabs, $namespace, $userName ) );

		wfProfileOut( __METHOD__ );
		return $tabs;
	}

	/**
	 * Get and format stats for given user
	 */
	private function getStats( $userName ) {
		wfProfileIn( __METHOD__ );
		global $wgLang;

		$user = User::newFromName( $userName );
		$stats = array();

		if ( !empty( $user ) && $user->isLoggedIn() ) {
			$userStatsService = new UserStatsService( $user->getId() );
			$stats = $userStatsService->getStats();

			if ( !empty( $stats ) ) {
				// date and points formatting
				if ( !empty( $stats['firstContributionTimestamp'] ) ) {
					$stats['date'] = $wgLang->date( wfTimestamp( TS_MW, $stats['firstContributionTimestamp'] ) );
				}
				$stats['edits'] = $wgLang->formatNum( $stats['editcount'] );
			}
		}

		wfProfileOut( __METHOD__ );
		return $stats;
	}

	public function executeIndex() {
		wfProfileIn( __METHOD__ );

		global $wgTitle, $wgUser, $wgCityId, $wgIsPrivateWiki;

		//fb#1090
		$this->isInternalWiki = empty( $wgCityId );
		$this->isUserAnon = $wgUser->isAnon();
		$this->isPrivateWiki = $wgIsPrivateWiki;

		$namespace = $wgTitle->getNamespace();

		// get user name to display in header
		$this->userName = self::getUserName( $wgTitle, BodyController::getUserPagesNamespaces() );

		// render avatar (100x100)
		$this->avatar = AvatarService::renderAvatar( $this->userName, 100 );
		$this->lastActionData = array();

		// show "Unregistered contributor" + IP for anon accounts
		if ( User::isIP( $this->userName ) ) {
			$this->displaytitle = true;
			$this->title = wfMsg( 'oasis-anon-header', $this->userName );
		}
		// show full title of subpages in user (talk) namespace
		else if ( in_array( $namespace, array( NS_USER, NS_USER_TALK ) ) ) {
			$this->title = $wgTitle->getText();
		}
		else {
			$this->title = $this->userName;
		}

		// link to user page
		$this->userPage = AvatarService::getUrl( $this->userName );

		// render tabbed links
		$this->tabs = $this->getTabs( $this->userName );

		// user stats (edit points, account creation date)
		$this->stats = $this->getStats( $this->userName );

		$actionMenu = array(
				'action' => array(),
				'dropdown' => array(),
				);

		// page type specific stuff
		if ( $namespace == NS_USER ) {
			// edit button
			if ( isset( $this->content_actions['edit'] ) ) {
				$actionMenu['action'] = array(
					'href' => $this->content_actions['edit']['href'],
					'text' => wfMsg( 'oasis-page-header-edit-profile' ),
				);

				$this->actionImage = MenuButtonController::EDIT_ICON;
				$this->actionName = 'editprofile';
			}
		}
		else if ( $namespace == NS_USER_TALK ) {
			// "Leave a message" button
			if ( isset( $this->content_actions['addsection']['href'] ) ) {
				$actionMenu['action'] = array(
					'href' => $this->content_actions['addsection']['href'],
					'text' => wfMsg( 'add_comment' ),
				);

				$this->actionImage = MenuButtonController::MESSAGE_ICON;
				$this->actionName = 'leavemessage';

				// different handling for "My talk page"
				if ( self::isItMe($this->userName ) ) {
					$actionMenu['action']['text'] = wfMsg( 'edit' );
					$actionMenu['action']['href'] = $this->content_actions['edit']['href'];

					$this->actionImage = MenuButtonController::EDIT_ICON;
					$this->actionName = 'edit';
				}
			}
		}
		else if( defined( 'NS_BLOG_ARTICLE' ) && $namespace == NS_BLOG_ARTICLE ) {
			// "Create a blog post" button
			if ( self::isItMe( $this->userName ) ) {
				$this->actionButton = array(
					'href' => SpecialPage::getTitleFor( 'CreateBlogPage' )->getLocalUrl(),
					'text' => wfMsg( 'blog-create-post-label' ),
				);

				$this->actionImage = MenuButtonController::BLOG_ICON;
				$this->actionName = 'createblogpost';
			}
		}

		// dropdown actions for "Profile" and "Talk page" tabs
		if ( in_array( $namespace, array( NS_USER, NS_USER_TALK ) ) ) {
			$actions = array( 'move', 'protect', 'unprotect', 'delete', 'undelete', 'history' );

			// add "edit" item to "Leave a message" button
			if ( $this->actionName == 'leavemessage' ) {
				array_unshift( $actions, 'edit' );
			}

			foreach( $actions as $action ) {
				if ( isset( $this->content_actions[$action] ) ) {
					$actionMenu['dropdown'][$action] = $this->content_actions[$action];
				}
			}
		}
		$this->actionMenu = $actionMenu;

		// don't show stats for user pages with too long titles (RT #68818)
		if ( mb_strlen( $this->title ) > 35) {
			$this->stats = false;
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * dirty way to get the user url
	 * returns the full path of the users
	 **/
	public static function getUserURL() {
		global $wgUser;

		$user_name = $wgUser->mName;
		$userURL = explode( '/', AvatarService::getUrl( $user_name ) );
		$userURL = $userURL[count( $userURL ) -1];
		return $userURL;
	}
}
