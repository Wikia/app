<?php
class UserService extends Service
{
	public static function getNameFromUrl($url) {
		$out = false;

		$userUrlParted = explode(':', $url, 3);
		if (isset($userUrlParted[2])) {
			$user = User::newFromName($userUrlParted[2]);
			if ($user instanceof User) {
				$out = $user->getName();
			}
		}

		return $out;
	}
}