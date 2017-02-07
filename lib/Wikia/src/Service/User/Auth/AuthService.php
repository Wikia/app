<?php

namespace Wikia\Service\User\Auth;

interface AuthService {
	public function authenticate( $username, $password ): AuthResult;
}
