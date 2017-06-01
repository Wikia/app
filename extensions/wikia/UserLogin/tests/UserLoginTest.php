<?php

use Wikia\Service\User\Auth\AuthResult;

require_once __DIR__ . '/UserLoginBaseTest.php';

/**
 * Class UserLoginTest
 */
class UserLoginTest extends UserLoginBaseTest {
	const TEST_CITY_ID = 79860;
	const TEST_USERNAME = 'WikiaUser';
	const TEST_USERID = 12345;
	const TEST_EMAIL = 'devbox+test@wikia-inc.com';
	const MAIN_PAGE_TITLE_TXT = 'Main_Page';
	const LOGIN_TOKEN = '1234567890';

	protected $skinOrg = null;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../UserLogin.setup.php';
		parent::setUp();
	}

	protected function setUpMock() {
		$this->disableMemCache();
		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );

		// "mock" IP
		$this->originalServer = $_SERVER;
		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.50775 ms
	 */
	public function testWikiaMobileChangePasswordTemplate() {
		$mobileSkin = Skin::newFromKey( 'wikiamobile' );
		$this->setUpMockObject( 'User', array( 'getSkin' => $mobileSkin ), true, 'wgUser' );
		$this->setUpMockObject( 'WebRequest', array( 'wasPosted' => true ), false, 'wgRequest' );
		$this->setUpMock();

		$this->setUpMobileSkin( $mobileSkin );

		$response = $this->app->sendRequest( 'UserLoginSpecial', 'index', array( 'format' => 'html', 'action' => wfMessage( 'resetpass_submit' )->escaped() ) );
		$response->toString();// triggers set up of template path

		$this->assertEquals(
			dirname( $this->app->wg->AutoloadClasses['UserLoginSpecialController'] ) . '/templates/UserLoginSpecial_WikiaMobileChangePassword.php',
			$response->getView()->getTemplatePath()
		);

		$this->tearDownMobileSkin();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.55212 ms
	 * @dataProvider changePasswordDataProvider
	 */
	public function testChangePassword( $params, $mockWebRequestParams, $mockWgUserParams, $mockAuthParams, $mockUserParams, $mockHelperParams, $expResult, $expMsg ) {
		// setup
		$this->mockStaticMethod( 'UserLoginHelper', 'getLoginToken', self::LOGIN_TOKEN );
		$this->setUpMockObject( 'WebRequest', $mockWebRequestParams, false, 'wgRequest', $params );
		$this->setUpMockObject( 'AuthPlugin', $mockAuthParams, false, 'wgAuth' );
		$this->setUpMockObject( 'User', $mockWgUserParams, false, 'wgUser' );
		$this->setUpMockObject( 'User', $mockUserParams, true );

		$this->setUpMockObject( 'UserLoginHelper', $mockHelperParams, true );

		if ( $expResult == 'ok' ) {
			$this->setUpMockObject( 'UserLoginSpecialController', array( 'login' => null ), true );
		}

		$this->setUpMock();

		// test
		$response = $this->app->sendRequest( 'UserLoginSpecial', 'changePassword', $params );

		$responseData = $response->getVal( 'result' );
		$this->assertEquals( $expResult, $responseData, 'result' );

		$responseData = $response->getVal( 'msg' );
		$this->assertEquals( $expMsg, $responseData, 'msg' );
	}

	public function changePasswordDataProvider() {
		$passwordSuccess = AuthResult::create( true )->build();

		// 1 do nothing -- GET
		$params1 = array(
			'username' => 'WikiaUser',
			'loginToken' => self::LOGIN_TOKEN,
		);
		$mockWebRequest1 = array( 'wasPosted' => false );
		$mockWgUserParams1 = null;
		$mockAuthParams1 = null;
		$mockUserParams1 = null;
		$mockHelperParams1 = null;

		// 2 do nothing -- POST + not empty fakeGet
		$params2 = array(
			'username' => 'WikiaUser',
			'fakeGet' => '1',
			'loginToken' => self::LOGIN_TOKEN,
		);
		$mockWebRequest2 = array( 'wasPosted' => true, 'setVal' => null );

		// 3 error -- POST + empty fakeGet + not allow password change
		$mockAuthParams3 = array( 'allowPasswordChange' => false );
		$expMsg3 = wfMessage( 'resetpass_forbidden' )->escaped();

		// 4 redirect page -- cancel request + empty returnto
		$params4 = array(
			'cancel' => true,
			'returnto' => '',
		);
		$mockHelperParams4 = array(
			'doRedirect' => array(
				'mockExpTimes' => 1,
				'mockExpValues' => null,
			),
		);

		// 6 do nothing -- not match edit token
		$mockAuthParams6 = array( 'allowPasswordChange' => true );
		$mockWgUserParams6 = array( 'matchEditToken' => false );

		// 7 error -- real user + user not found
		$mockWgUserParams7 = array( 'matchEditToken' => true );
		$mockUserParams7 = false;
		$expMsg7 = wfMessage( 'userlogin-error-nosuchuser' )->escaped();

		// 8 error -- real user + anon user
		$mockUserParams8 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => true
		);

		// 9 error -- retype != newpassword
		$params9 = array(
			'username' => 'WikiaUser',
			'newpassword' => 'testPasword',
			'retype' => 'passwordTest',
			'loginToken' => self::LOGIN_TOKEN,
		);
		$mockUserParams9 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false
		);
		$expMsg9 = wfMessage( 'badretype' )->escaped();

		$params10 = array(
			'username' => 'WikiaUser',
			'newpassword' => 'testPasword',
			'retype' => 'testPasword',
			'loginToken' => self::LOGIN_TOKEN,
		);

		// 12 error -- not valid new password (passwordtooshort)
		$mockUserParams12 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkPassword' => $passwordSuccess,
			'getPasswordValidity' => 'passwordtooshort',
		);
		$expMsg12 = wfMsgExt( 'passwordtooshort', array( 'parsemag' ), F::app()->wg->MinimalPasswordLength );

		// 13 error -- not valid new password (password-name-match)
		$mockUserParams13 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkPassword' => $passwordSuccess,
			'getPasswordValidity' => 'password-name-match',
		);
		$expMsg13 = wfMsgExt( 'password-name-match', array( 'parsemag' ), F::app()->wg->MinimalPasswordLength );

		// 14 error -- not valid new password (securepasswords-invalid)
		$mockUserParams14 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkPassword' => $passwordSuccess,
			'getPasswordValidity' => 'securepasswords-invalid',
		);
		$expMsg14 = wfMsgExt( 'securepasswords-invalid', array( 'parsemag' ), F::app()->wg->MinimalPasswordLength );

		// 15 success -- real user
		$mockUserParams15 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkPassword' => $passwordSuccess,
			'getPasswordValidity' => true,
			'setPassword' => null,
			'setCookies' => null,
			'saveSettings' => null,
		);
		$expMsg15 = wfMessage( 'resetpass_success' )->escaped();
		$mockHelperParams15 = array(
			'doRedirect' => null,
		);

		// 16 error = token mismatch
		$params16 = array(
			'username' => 'WikiaUser',
			'newpassword' => 'testPasword',
			'retype' => 'testPasword',
			'loginToken' => 'faked',
		);
		$expMsg16 = wfMessage( 'sessionfailure' )->escaped();

		return array(
			// 1 do nothing -- GET
			array( $params1, $mockWebRequest1, $mockWgUserParams1, $mockAuthParams1, $mockUserParams1, $mockHelperParams1, '', '' ),
			// 2 do nothing -- POST + not empty fakeGet
			array( $params2, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams1, $mockUserParams1, $mockHelperParams1, '', '' ),
			// 3 error -- POST + empty fakeGet + not allow password change
			array( $params1, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams3, $mockUserParams1, $mockHelperParams1, 'error', $expMsg3 ),
			// 4 redirect page -- cancel request + empty returnto
			array( $params4, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams1, $mockUserParams1, $mockHelperParams4, null, null ),
			// 5 redirect page -- cancel request + returnto
			// array( $params5, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams1, $mockUserParams1, $mockHelperParams4, null, null ),
			// 6 do nothing -- not match edit token
			array( $params1, $mockWebRequest2, $mockWgUserParams6, $mockAuthParams6, $mockUserParams1, $mockHelperParams1, '', '' ),
			// 7 error -- real user + user not found
			array( $params1, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams7, $mockHelperParams1, 'error', $expMsg7 ),
			// 8 error -- real user + anon user
			array( $params1, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams8, $mockHelperParams1, 'error', $expMsg7 ),
			// 9 error -- retype != newpassword
			array( $params9, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams9, $mockHelperParams1, 'error', $expMsg9 ),
			// 12 error -- not valid new password (passwordtooshort)
			array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams12, $mockHelperParams1, 'error', $expMsg12 ),
			// 13 error -- not valid new password (password-name-match)
			array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams13, $mockHelperParams1, 'error', $expMsg13 ),
			// 14 error -- not valid new password (securepasswords-invalid)
			array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams14, $mockHelperParams1, 'error', $expMsg14 ),
			// 15 success -- real user
			array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams15, $mockHelperParams15, 'ok', $expMsg15 ),
			// 16 error = token mismatch
			array( $params16, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams9, $mockHelperParams1, 'error', $expMsg16 ),
		);
	}

	/**
	 * @param string $page
	 * @param string $queryString
	 * @param string $extraQueryString
	 * @param int $cbVal
	 * @param Title $actualTitle
	 * @param string $actualQueryString
	 *
	 * @dataProvider getRedirectUrlDataProvider
	 */
	public function testGetRedirectUrl( $page, $queryString, $extraQueryString, $cbVal, Title $actualTitle, $actualQueryString ) {
		$request = F::app()->wg->Request;
		$request->setVal( 'returnto', $page );
		$request->setVal( 'returntoquery', $queryString );

		$userLoginHelper = new UserLoginHelper();

		$testUrl = $userLoginHelper->getRedirectUrl( $extraQueryString, $cbVal );
		$actualUrl = $actualTitle->getFullUrl( $actualQueryString );

		$this->assertEquals( $testUrl, $actualUrl );
	}

	public function getRedirectUrlDataProvider() {
		return [
			// test title w/o query string
			[
				'Foo',
				'',
				'fbconnected=1',
				123,
				Title::newFromText( 'Foo' ),
				'fbconnected=1&cb=123'
			],

			// test title w/ query string
			[
				'Foo',
				'foo=bar',
				'fbconnected=1',
				456,
				Title::newFromText( 'Foo' ),
				'foo=bar&fbconnected=1&cb=456'
			],

			// test forbidden return-to page w/o query string
			[
				'Special:Signup',
				'',
				'fbconnected=1',
				789,
				Title::newMainPage(),
				'fbconnected=1&cb=789'
			],

			// test forbidden return-to page w/ query string
			[
				'Special:UserLogout',
				'foo=bar',
				'fbconnected=1',
				123,
				Title::newMainPage(),
				'foo=bar&fbconnected=1&cb=123'
			],

			// test special characters in title and query string
			[
				'Foo',
				'foò=bär',
				'fbconnected=1',
				456,
				Title::newFromText( 'Foo' ),
				'foò=bär&fbconnected=1&cb=456'
			],

			// test title w/ query string but no extra query string
			[
				'Foo',
				'foo=bar',
				'',
				456,
				Title::newFromText( 'Foo' ),
				'foo=bar&cb=456'
			],
		];
	}
}
