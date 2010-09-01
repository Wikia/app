<?php
class AvatarService extends Service {

	/**
	 * Internal method for getting user object with caching
	 */
	static private function getUser($userName) {
		wfProfileIn(__METHOD__);

		static $usersCache;

		if (isset($usersCache[$userName])) {
			$user = $usersCache[$userName];
		}
		else {
			$user = User::newFromName($userName);

			$usersCache[$userName] = $user;
		}

		wfProfileOut(__METHOD__);
		return $user;
	}

	/**
	 * Get URL to default avatar
	 */
	static private function getDefaultAvatar() {
		wfProfileIn(__METHOD__);
		global $wgStylePath;

		static $avatarUrl;

		if (!isset($avatarUrl)) {
			if (class_exists('Masthead')) {
				$defaultAvatars = Masthead::newFromUserId(0)->getDefaultAvatars();
				$avatarUrl = array_shift($defaultAvatars);
			}
			else {
				$randomInt = rand(1, 3);
				$avatarUrl = "{$wgStylePath}/oasis/images/generic_avatar{$randomInt}.png";
			}
		}

		wfProfileOut(__METHOD__);
		return $avatarUrl;
	}

	/**
	 * Get URL to user page / Special:Contributions
	 */
	static function getUrl($userName) {
		wfProfileIn(__METHOD__);

		static $linksCache;

		if (isset($linksCache[$userName])) {
			$url = $linksCache[$userName];
		}
		else {
			if (User::isIP($userName)) {
				// anon: point to Special:Contributions
				$url = Skin::makeSpecialUrl('Contributions').'/'.$userName;
			}
			else {
				// user: point to user page
				$userPage = Title::newFromText($userName, NS_USER);
				$url = $userPage->getLocalUrl();
			}

			$linksCache[$userName] = $url;
		}

		wfProfileOut(__METHOD__);
		return $url;
	}

	/**
	 * Get URL for avatar
	 */
	static function getAvatarUrl($userName) {
		wfProfileIn(__METHOD__);

		static $avatarsCache;

		if (isset($avatarsCache[$userName])) {
			$avatarUrl = $avatarsCache[$userName];
		}
		else {
			$user = self::getUser($userName);

			// handle anon users - return default avatar
			if (empty($user) || !class_exists('Masthead')) {
				$avatarUrl = self::getDefaultAvatar();

				wfProfileOut(__METHOD__);
				return $avatarUrl;
			}

			$avatarUrl = Masthead::newFromUser($user)->getUrl();

			$avatarsCache[$userName] = $avatarUrl;
		}

		wfProfileOut(__METHOD__);
		return $avatarUrl;
	}

	/**
	 * Render avatar
	 */
	static function renderAvatar($userName, $avatarSize = 20) {
		wfProfileIn(__METHOD__);

		$avatarUrl = self::getAvatarUrl($userName);

		$ret = Xml::element('img', array(
			'src' => $avatarUrl,
			'width' => $avatarSize,
			'height' => $avatarSize,
			'class' => 'avatar',
			'alt' => $userName,
		));

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Render link to user page / Special:Contributions
	 */
	static function renderLink($userName) {
		wfProfileIn(__METHOD__);

		// for anons show "A Wikia user" instead of IP address
		if (User::isIP($userName)) {
			$label = wfMsg('oasis-anon-user');
		}
		else {
			$label = $userName;
		}

		$link = Xml::element('a',
			array('href' => self::getUrl($userName)),
			$label);

		wfProfileOut(__METHOD__);
		return $link;
	}

	/**
	 * Render avatar and link to user page
	 */
	static function render($userName, $avatarSize = 20) {
		wfProfileIn(__METHOD__);

		// render avatar
		$ret = self::renderAvatar($userName, $avatarSize);

		// add small spacing
		$ret .= ' ';

		// render link to user page / Special:Contributions
		$ret .= self::renderLink($userName);

		wfProfileOut(__METHOD__);
		return $ret;
	}
}