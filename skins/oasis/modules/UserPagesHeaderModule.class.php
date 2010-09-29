<?php
/**
 * Renders header for user pages (profile / talk pages, Following, Contributions, blogs) with avatar and user's data
 *
 * @author Maciej Brencz
 */

class UserPagesHeaderModule extends Module {

	var $wgBlankImgUrl;
	var $wgStylePath;

	var $content_actions;
	var $displaytitle;
	var $subtitle;
	var $title;

	var $actionButton;
	var $actionImage;
	var $actionMenu;
	var $actionName;
	var $avatar;
	var $avatarMenu;
	var $comments;
	var $editTimestamp;
	var $likes;
	var $stats;
	var $tabs;
	var $userName;
	var $userPage;

	/**
	 * Checks whether given user name is the current user
	 */
	public static function isItMe($userName) {
		global $wgUser;
		return $wgUser->isLoggedIn() && ($userName == $wgUser->getName());
	}

	/**
	 * Get name of the user this page referrs to
	 */
	private static function getUserName() {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgUser, $wgRequest;

		if (in_array($wgTitle->getNamespace(), BodyModule::getUserPagesNamespaces())) {
			// get "owner" of this user / user talk / blog page
			$parts = explode('/', $wgTitle->getText());
		}
		else if ($wgTitle->getNamespace() == NS_SPECIAL) {
			if ($wgTitle->isSpecial( 'Following' ) || $wgTitle->isSpecial( 'Contributions' )) {
				$target = $wgRequest->getText('target');
				if ($target != '') {
					// /wiki/Special:Contributions?target=FooBar (RT #68323)
					$parts = array($target);
				}
				else {
					// get user this special page referrs to
					$parts = explode('/', $wgRequest->getText('title', false));

					// remove special page name
					array_shift($parts);
				}
			}
		}

		if (isset($parts[0]) && $parts[0] != '') {
			$userName = $parts[0];
		}
		else {
			// fallback value
			$userName = $wgUser->getName();
		}

		wfProfileOut(__METHOD__);
		return $userName;
	}

	/**
	 * Get list of links for given username to be shown as tabs
	 */
	private function getTabs($userName) {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgUser, $wgEnableWikiaFollowedPages;

		$tabs = array();
		$namespace = $wgTitle->getNamespace();

		// profile
		$tabs[] = array(
			'link' => View::link(Title::newFromText($userName, NS_USER), wfMsg('profile')),
			'selected' => ($namespace == NS_USER),
		);

		// talk
		$tabs[] = array(
			'link' => View::link(Title::newFromText($userName, NS_USER_TALK), wfMsg('talkpage')),
			'selected' => ($namespace == NS_USER_TALK),
		);

		// blog
		if (defined('NS_BLOG_ARTICLE')) {
			$tabs[] = array(
				'link' => View::link(Title::newFromText($userName, NS_BLOG_ARTICLE), wfMsg('blog-page'), array(), array(), 'known'),
				'selected' => ($namespace == NS_BLOG_ARTICLE),
			);
		}

		// contribs
		$tabs[] = array(
			'link' => View::link(SpecialPage::getTitleFor("Contributions/{$userName}"), wfMsg('contris_s')),
			'selected' => ($wgTitle->isSpecial( 'Contributions' )),
		);

		if (self::isItMe($userName)) {
			// following (only render when user is viewing his own user pages)
			if (!empty($wgEnableWikiaFollowedPages)) {
				$tabs[] = array(
					'link' => View::link(SpecialPage::getTitleFor('Following'), wfMsg('wikiafollowedpages-following')),
					'selected' => ($wgTitle->isSpecial( 'Following' )),
				);
			}

			// avatar dropdown menu
			$this->avatarMenu = array(
				View::link(SpecialPage::getTitleFor('Preferences'), wfMsg('oasis-user-page-change-avatar'))
			);
		}

		wfProfileOut(__METHOD__);
		return $tabs;
	}

	/**
	 * Get and format stats for given user
	 */
	private function getStats($userName) {
		wfProfileIn(__METHOD__);
		global $wgLang;

		$user = User::newFromName($userName);
		$stats = array();

		if (!empty($user) && $user->isLoggedIn()) {
			$userStatsService = new UserStatsService($user->getId());
			$stats = $userStatsService->getStats();

			if (!empty($stats)) {
				// date and points formatting
				$stats['date'] = $wgLang->date(wfTimestamp(TS_MW, $stats['date']));
				$stats['edits'] = $wgLang->formatNum($stats['edits']);
			}
		}

		wfProfileOut(__METHOD__);
		return $stats;
	}

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		global $wgTitle;

		$namespace = $wgTitle->getNamespace();

		// get user name to display in header
		$this->userName = self::getUserName();

		// render avatar (100x100)
		$this->avatar = AvatarService::renderAvatar($this->userName, 100);

		// show "Unregistered contributor" + IP for anon accounts
		if (User::isIP($this->userName)) {
			$this->displaytitle = true;
			$this->title = wfMsg('oasis-anon-header', $this->userName);
		}
		// show full title of subpages in user (talk) namespace
		else if (in_array($namespace, array(NS_USER, NS_USER_TALK))) {
			$this->title = $wgTitle->getText();
		}
		else {
			$this->title = $this->userName;
		}

		// link to user page
		$this->userPage = AvatarService::getUrl($this->userName);

		// render tabbed links
		$this->tabs = $this->getTabs($this->userName);

		// user stats (edit points, account creation date)
		$this->stats = $this->getStats($this->userName);

		// no "user" likes
		$this->likes = false;

		$this->actionMenu = array(
			'action' => array(),
			'dropdown' => array(),
		);

		// page type specific stuff
		if ($namespace == NS_USER) {
			// edit button
			if (isset($this->content_actions['edit'])) {
				$this->actionMenu['action'] = array(
					'href' => $this->content_actions['edit']['href'] ."#EditPage",
					'text' => wfMsg('oasis-page-header-edit-profile'),
				);

				$this->actionImage = MenuButtonModule::EDIT_ICON;
				$this->actionName = 'editprofile';
			}
		}
		else if ($namespace == NS_USER_TALK) {
			// "Leave a message" button
			if (isset($this->content_actions['addsection']['href'])) {
				$this->actionMenu['action'] = array(
					'href' => $this->content_actions['addsection']['href'] ."#EditPage",
					'text' => wfMsg('add_comment'),
				);

				$this->actionImage = MenuButtonModule::ADD_ICON;
				$this->actionName = 'leavemessage';

				// different handling for "My talk page"
				if (self::isItMe($this->userName)) {
					$this->actionMenu['action']['text'] = wfMsg('edit');
					$this->actionMenu['action']['href'] = $this->content_actions['edit']['href'] ."#EditPage";

					$this->actionImage = MenuButtonModule::EDIT_ICON;
					$this->actionName = 'edit';
				}
			}
		}
		else if (defined('NS_BLOG_ARTICLE') && $namespace == NS_BLOG_ARTICLE) {
			// "Create a blog post" button
			if (self::isItMe($this->userName)) {
				wfLoadExtensionMessages('Blogs');

				$this->actionButton = array(
					'href' => SpecialPage::getTitleFor('CreateBlogPage')->getLocalUrl() ."#EditPage",
					'text' => wfMsg('blog-create-post-label'),
				);

				$this->actionName = 'createblogpost';
			}
		}

		// dropdown actions for "Profile" and "Talk page" tabs
		if (in_array($namespace, array(NS_USER, NS_USER_TALK))) {
			$actions = array('move', 'protect', 'unprotect', 'delete', 'undelete');

			// add "edit" item to "Leave a message" button
			if ($this->actionName == 'leavemessage') {
				array_unshift($actions, 'edit');
			}

			foreach($actions as $action) {
				if (isset($this->content_actions[$action])) {
					$this->actionMenu['dropdown'][$action] = $this->content_actions[$action];
				}
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Render header for blog post
	 */
	public function executeBlogPost() {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgLang;

		// remove User_blog:xxx from title
		$titleParts = explode('/', $wgTitle->getText());
		array_shift($titleParts);
		$this->title = implode('/', $titleParts);

		// get user name to display in header
		$this->userName = self::getUserName();

		// render avatar (48x48)
		$this->avatar = AvatarService::renderAvatar($this->userName, 48);

		// link to user page
		$this->userPage = AvatarService::getUrl($this->userName);

		// user stats (edit points, account creation date)
		$this->stats = $this->getStats($this->userName);

		// commments / likes / date of first edit
		if (!empty($wgTitle) && $wgTitle->exists()) {
			$service = new PageStatsService($wgTitle->getArticleId());

			$this->editTimestamp = $wgLang->date($service->getFirstRevisionTimestamp());
			$this->comments = $service->getCommentsCount();
			$this->likes = true;
		}

		// edit button / dropdown
		if (isset($this->content_actions['edit'])) {
			$this->actionMenu['action'] = $this->content_actions['edit'];
		}

		// dropdown actions
		$actions = array('move', 'protect', 'unprotect', 'delete', 'undelete');
		foreach($actions as $action) {
			if (isset($this->content_actions[$action])) {
				$this->actionMenu['dropdown'][$action] = $this->content_actions[$action];
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Render header for blog listing
	 */
	public function executeBlogListing() {
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('Blogs');
		// "Create blog post" button
		$this->actionButton = array(
			'href' => SpecialPage::getTitleFor('CreateBlogPage')->getLocalUrl() ."#EditPage",
			'text' => wfMsg('blog-create-post-label'),
		);
		$this->title = wfMsg('create-blog-post-category');

		wfProfileOut(__METHOD__);
	}
}