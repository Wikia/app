<?php

namespace Wikia\Service\User\Auth;

use Wikia\HTTP\Response;
use Wikia\Interfaces\IRequest;

interface CookieHelper {
	public function getAccessToken( IRequest $request );
	public function setAuthenticationCookieWithUserId( $userId, Response $response );
	public function setAuthenticationCookieWithToken( $accessToken, Response $response );
	public function clearAuthenticationCookie( Response $response );
}
