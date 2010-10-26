<?php
class UserProfilePageModule extends Module {

	public function executeMasthead() {
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

				$this->actionImage = MenuButtonModule::MESSAGE_ICON;
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

				$this->actionImage = MenuButtonModule::BLOG_ICON;
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

		// don't show stats for user pages with too long titles (RT #68818)
		if (mb_strlen($this->title) > 35) {
			$this->stats = false;
		}

		wfProfileOut(__METHOD__);

	}

	public function executeIndex() {

	}

}