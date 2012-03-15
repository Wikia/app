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
	var $wgLanguageCode;
	var $wgAvailableHelpLang;

	var $dropdown;
	var $isAnon;
	var $itemsBefore;
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

		if( in_array( $id, array( 'login', 'register' ) ) ) {
			$attributes['rel'] = 'nofollow';
		}

		// add class attribute
		if (isset($personalUrl['class'])){
			$attributes['class'] = $personalUrl['class'];
		}

		// add accesskey attribute
		switch ($id) {
			case 'mytalk':
				$attributes['accesskey'] = 'n';
				break;
			case 'login':
				$attributes['accesskey'] = 'o';
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
		global $wgUser, $wgComboAjaxLogin;

		if ($wgUser->isAnon()) {
			// add login and register links for anons
			$skin = $wgUser->getSkin();

			// where to redirect after login
			$returnto = wfGetReturntoParam();

			if(empty($wgComboAjaxLogin)) {
				$signUpHref = Skin::makeSpecialUrl('UserLogin', $returnto);
			} else {
				$signUpHref = Skin::makeSpecialUrl('Signup', $returnto);
			}
			$this->personal_urls['login'] = array(
				'text' => wfMsg('login'),
				'href' => $signUpHref . "&type=login",
				'class' => 'ajaxLogin'
			);

			$this->personal_urls['register'] = array(
				'text' => wfMsg('oasis-signup'),
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

		global $wgUser, $wgEnableUserLoginExt;

		$this->setupPersonalUrls();

		$this->itemsBefore = array();
		$this->isAnon = $wgUser->isAnon();
		$this->username = $wgUser->getName();

		if ($this->isAnon) {
			// facebook connect
			if (!empty($this->personal_urls['fbconnect']['html'])) {
				$this->itemsBefore[] = $this->personal_urls['fbconnect']['html'];
			}

			// render Login and Register links
			$this->loginLink = $this->renderPersonalUrl('login');
			$this->registerLink = $this->renderPersonalUrl('register');
			$this->loginDropdown = '';
			if(!empty($wgEnableUserLoginExt)) {
				$this->loginDropdown = (string)F::app()->sendRequest( 'UserLoginSpecial', 'dropdown', array('param' => 'paramvalue' ));
			}
		}
		else {
			// render user avatar and link to his user page
			$this->profileLink = AvatarService::getUrl($this->username);
			$this->profileAvatar = AvatarService::renderAvatar($this->username, 20);

			// dropdown items
			$dropdownItems = array('mytalk', 'following', 'preferences');

			// Allow hooks to modify the dropdown items.
			$this->wf->RunHooks( 'AccountNavigationModuleAfterDropdownItems', array(&$dropdownItems, &$this->personal_urls) );

			foreach($dropdownItems as $item) {
				if (isset($this->personal_urls[$item])) {
					$this->dropdown[] = $this->renderPersonalUrl($item);
				}
			}

			// link to Help:Content (never render as redlink)
			$helpLang = array_key_exists( $this->wg->LanguageCode, $this->wg->AvailableHelpLang ) ? $this->wg->LanguageCode : 'en';
			$this->dropdown[] = Wikia::link(
				Title::newFromText( wfMsgExt( 'helppage', array( 'parsemag', 'language' => $helpLang ) ) ),
				wfMsg('help'),
				array('title' => '', 'data-id' => 'help'),
				'',
				array('known')
			);

			// logout link
			$this->dropdown[] = $this->renderPersonalUrl('logout');
		}

		wfProfileOut(__METHOD__);
	}
}
