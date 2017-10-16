<?php

namespace Wikia\Service\User\Auth;

use Wikia\HTTP\Response;

interface CookieHelper {
	public function getAccessToken( \WebRequest $request );
	public function setAuthenticationCookieWithUserId( $userId, Response $response );
	public function setAuthenticationCookieWithToken( $accessToken, Response $response );
	public function clearAuthenticationCookie( Response $response );
}
