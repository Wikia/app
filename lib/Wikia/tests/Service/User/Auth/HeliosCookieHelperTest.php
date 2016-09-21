<?php

namespace Wikia\Service\User\Auth;

use Wikia\Domain\UserObject;
use Wikia\HTTP\Response;
use Wikia\Service\Helios\HeliosClient;

class HeliosCookieHelperTest extends \PHPUnit_Framework_TestCase {

	const TEST_USER_ID = 12345;
	const TEST_TOKEN = 'abcdefghijk';

	private $helios;
	private $response;
	private $cookieHelper;

	public function setUp() {
		$this->response = $this->getMockBuilder( Response::class )
			->setMethods( ['setcookie'] )
			->disableOriginalConstructor()
			->getMock();
		$this->helios = $this->getMockBuilder( HeliosClient::class )
			->disableOriginalConstructor()
			->getMock();

		$this->cookieHelper = new HeliosCookieHelper( $this->helios );
	}

	public function testSetAuthenticationCookie() {
		$tokenData = (object)array( HeliosCookieHelper::ACCESS_TOKEN_COOKIE_NAME => self::TEST_TOKEN );
		$this->helios->expects( $this->once() )
			->method( 'generateToken' )
			->with( self::TEST_USER_ID )
			->willReturn( $tokenData );

		$this->response->expects( $this->once() )
			->method( 'setcookie' )
			->with(
			 	HeliosCookieHelper::ACCESS_TOKEN_COOKIE_NAME,
				$tokenData->access_token,
				$this->isType('int'),
				HeliosCookieHelper::COOKIE_PREFIX
		 	);

		$this->cookieHelper->setAuthenticationCookieWithUserId( self::TEST_USER_ID, $this->response );
	}

	public function testClearAuthenticationCookie() {
		$this->response->expects( $this->once() )
			->method( 'setcookie' )
			->with(
			 	HeliosCookieHelper::ACCESS_TOKEN_COOKIE_NAME,
				"",
				$this->isType('int'),
				HeliosCookieHelper::COOKIE_PREFIX
		 	);

		$this->cookieHelper->clearAuthenticationCookie( $this->response );
	}

}
