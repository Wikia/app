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
	static private function getDefaultAvatar($avatarSize) {
		wfProfileIn(__METHOD__);
		global $wgStylePath;

		if (class_exists('Masthead')) {
			$avatarUrl = Masthead::newFromUserId(0)->getThumbnail($avatarSize);
		}
		else {
			$randomInt = rand(1, 3);
			$avatarUrl = "{$wgStylePath}/oasis/images/generic_avatar{$randomInt}.png";
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

		$url = '';

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
				if ( !is_null( $userPage ) ) {
					$url = $userPage->getLocalUrl();
				}
			}

			$linksCache[$userName] = $url;
		}

		wfProfileOut(__METHOD__);
		return $url;
	}

	/**
	 * Get URL for avatar
	 */
	static function getAvatarUrl($userName, $avatarSize = 20) {
		wfProfileIn(__METHOD__);

		static $avatarsCache;
		$key = "{$userName}::{$avatarSize}";

		if (isset($avatarsCache[$key])) {
			$avatarUrl = $avatarsCache[$key];
		}
		else {
			$user = self::getUser($userName);

			// handle anon users - return default avatar
			if (empty($user) || !class_exists('Masthead')) {
				$avatarUrl = self::getDefaultAvatar($avatarSize);

				wfProfileOut(__METHOD__);
				return $avatarUrl;
			}

			$avatarUrl = Masthead::newFromUser($user)->getThumbnail($avatarSize);

			$avatarsCache[$key] = $avatarUrl;
		}

		wfProfileOut(__METHOD__);
		return $avatarUrl;
	}

	/**
	 * Render avatar
	 */
	static function renderAvatar($userName, $avatarSize = 20) {
		wfProfileIn(__METHOD__);

		$avatarUrl = self::getAvatarUrl($userName, $avatarSize);

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
