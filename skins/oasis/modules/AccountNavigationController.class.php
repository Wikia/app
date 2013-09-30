<?php
/**
 * Renders anon / user menu at top right corner of the page
 *
 * @author Maciej Brencz
 */

class AccountNavigationController extends WikiaController {

	// This one really is a local class variable
	var $personal_urls;

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

		$ret = Xml::openElement('a', $attributes);
		$ret.= $personalUrl['text'];
		if(array_key_exists('afterText', $personalUrl)) {
			$ret.= $personalUrl['afterText'];
		}
		$ret.= Xml::closeElement('a');

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Modify personal URLs list
	 */
	private function setupPersonalUrls() {
		global $wgUser, $wgComboAjaxLogin;

		// Import the starting set of urls from the skin template
		$this->personal_urls = F::app()->getSkinTemplateObj()->data['personal_urls'];
		if ($wgUser->isAnon()) {
			// add login and register links for anons
			//$skin = RequestContext::getMain()->getSkin();

			// where to redirect after login
			$query = F::app()->wg->Request->getValues();
			if ( isset($query['title']) ) {
				if ( !self::isBlacklisted( $query['title'] ) ) {
					$returnto = $query['title'] ;
				} else {
					$returnto = Title::newMainPage()->getPartialURL();
				}
			} else {
				$returnto = Title::newMainPage()->getPartialURL();
			}
			$returnto = wfGetReturntoParam($returnto);

			$this->personal_urls['login'] = array(
				'text' => wfMsg('login'),
				'href' => Skin::makeSpecialUrl('UserLogin', $returnto),
				'class' => 'ajaxLogin',
				'afterText' => Xml::element('img', array(
					'src' => $this->wg->BlankImgUrl,
					'class' => 'chevron',
					'width' => '0',
					'height' => '0',
				), ''),
			);

			$this->personal_urls['register'] = array(
				'text' => wfMsg('oasis-signup'),
				'href' => Skin::makeSpecialUrl('UserSignup', $returnto),
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
				$this->itemsBefore = array($this->personal_urls['fbconnect']['html']);
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
			$possibleItems = array('mytalk', 'following', 'preferences');
			$dropdownItems = array();

			// Allow hooks to modify the dropdown items.
			wfRunHooks( 'AccountNavigationModuleAfterDropdownItems', array(&$possibleItems, &$this->personal_urls) );

			foreach($possibleItems as $item) {
				if (isset($this->personal_urls[$item])) {
					$dropdownItems[] = $this->renderPersonalUrl($item);
				}
			}

			// link to Help:Content (never render as redlink)
			$helpLang = array_key_exists( $this->wg->LanguageCode, $this->wg->AvailableHelpLang ) ? $this->wg->LanguageCode : 'en';
			$dropdownItems[] = Wikia::link(
				Title::newFromText( wfMsgExt( 'helppage', array( 'parsemag', 'language' => $helpLang ) ) ),
				wfMsg('help'),
				array('title' => '', 'data-id' => 'help'),
				'',
				array('known')
			);

			// logout link
			$dropdownItems[] = $this->renderPersonalUrl('logout');
			$this->dropdown = $dropdownItems;
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Checks whether provided string is on blacklist.
	 *
	 * @param $haystack String Redirectto page name to be checked against blacklist
	 * @return bool
	 */
	public static function isBlacklisted( $haystack ){
		$returntoBlacklist = array('Special:UserLogout', 'Special:UserSignup', 'Special:WikiaConfirmEmail', 'Special:Badtitle');
		foreach ( $returntoBlacklist as $blackItem ) {
			if ( strpos( $haystack, $blackItem ) === 0 ) {
				return true;
			}
		}
		return false;
	}
}
