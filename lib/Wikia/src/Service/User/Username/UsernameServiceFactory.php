<?php

namespace Wikia\Service\User\Username;


class UsernameServiceFactory {

	/**
	 * @return UsernameService
	 */
	public static function createUsernameService(){
		return new FallbackUsernameService();
	}

}
