<?php

namespace Wikia\Service\User\Username;


class UsernameServiceFactory {
	/**
	 * @return UsernameService
	 */
	public static function createUsernameService(){
		global $wgUsernameService;
		switch ($wgUsernameService){
			case "FallbackUsernameService":
				$usernameService = new FallbackUsernameService();
				break;
			case "MediawikiUsernameService":
				$usernameService = new MediawikiUsernameService();
				break;
			default:
				$usernameService = new FallbackUsernameService();
				break;
		}
		return $usernameService;
	}
}
