<?php
/**
 * Renders anon / user menu at top right corner of the page
 *
 * @author Maciej Brencz
 */

class AccountNavigationModule extends Module {

	var $personal_urls;
	var $wgBlankImgUrl;
	var $wgStylePath;

	var $dropdown;
	var $isAnon;
	var $itemsBefore;
	var $links;
	var $profileLink;
	var $profileAvatar;
	var $username;

	/**
	 * Render personal URLs item as HTML link
	 */
	private function renderPersonalUrl($id) {
		wfProfileIn(__METHOD__);
		$personalUrl = $this->personal_urls[$id];

		$attributes = array(
			'data-id' => $id,
			'href' => $personalUrl['href']
		);

		// add class attribute
		if (isset($personalUrl['class'])){
			$attributes['class'] = $personalUrl['class'];
		}

		// add accesskey attribute
		switch ($id) {
			case 'mytalk':
				$attributes['accesskey'] = 'n';
				break;
		}

		$ret = Xml::element('a', $attributes, $personalUrl['text']);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Modify personal URLs list
	 */
	private function setupPersonalUrls() {
		global $wgUser;

		if ($wgUser->isAnon()) {
			// add login and register links for anons
			$skin = $wgUser->getSkin();

			// where to redirect after login
			$returnto = "returnto={$skin->thisurl}";
			if( $skin->thisquery != '' ) {
				$returnto .= "&returntoquery={$skin->thisquery}";
			}

			$signUpHref = Skin::makeSpecialUrl('Signup', $returnto);
			$this->personal_urls['login'] = array(
				'text' => wfMsg('login'),
				'href' => $signUpHref . "&type=login",
				'class' => 'ajaxLogin'
			);

			$this->personal_urls['register'] = array(
				'text' => wfMsg('nologinlink'),
				'href' => $signUpHref . "&type=signup",
				'class' => 'ajaxRegister'
			);
		}
		else {
			// use Mypage message for userpage entry
			$this->personal_urls['userpage']['text'] = wfMsg('mypage');
		}
	}

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		global $wgUser;

		$this->setupPersonalUrls();

		$this->links = array();
		$this->itemsBefore = array();
		$this->isAnon = $wgUser->isAnon();
		$this->username = $wgUser->getName();

		if ($this->isAnon) {
			// facebook connect
			if (isset($this->personal_urls['fbconnect'])) {
				$this->itemsBefore[] = $this->personal_urls['fbconnect']['html'];
			}

			// render Login and Register links
			$this->links[] = $this->renderPersonalUrl('login');
			$this->links[] = $this->renderPersonalUrl('register');
		}
		else {
			// render user avatar and link to his user page
			$this->profileLink = AvatarService::getUrl($this->username);
			$this->profileAvatar = AvatarService::renderAvatar($this->username, 20);

			// dropdown items
			$dropdownItems = array('mytalk', 'following', 'watchlist', 'preferences');

			foreach($dropdownItems as $item) {
				if (isset($this->personal_urls[$item])) {
					$this->dropdown[] = $this->renderPersonalUrl($item);
				}
			}

			// link to Help:Content (never render as redlink)
			$this->dropdown[] = View::link(Title::newFromText('Contents', NS_HELP), wfMsg('help'), array('title' => '', 'data-id' => 'help'), '', array('known'));

			// logout link
			$this->links[] = $this->renderPersonalUrl('logout');
		}

		#print_pre($this->personal_urls);

		wfProfileOut(__METHOD__);
	}
}