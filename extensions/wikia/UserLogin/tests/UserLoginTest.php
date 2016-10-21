<?php

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
	 * @slowExecutionTime 0.44648 ms
	 * @dataProvider loginDataProvider
	 */
	public function testLogin( $requestParams, $mockLoginFormParams, $mockUserParams, $mockHelperParams, $expResult, $expMsg, $expErrParam = '', $expUsername = null ) {
		// setup
		$this->setUpRequest( $requestParams );
		$this->setUpMockObject( 'User', $mockUserParams, true, 'wgUser' );
		$this->setUpMockObject( 'UserLoginHelper', $mockHelperParams, true );
		if ( !is_null( $mockLoginFormParams ) ) {
			$this->mockClassWithMethods( 'LoginForm', $mockLoginFormParams );
		}

		$this->setUpMock();

		// test
		$response = $this->app->sendRequest( 'UserLoginSpecial', 'login' );

		$responseData = $response->getVal( 'result' );
		$this->assertEquals( $expResult, $responseData, 'result' );

		$responseData = $response->getVal( 'msg' );
		$this->assertEquals( $expMsg, $responseData, 'msg' );

		$responseData = $response->getVal( 'errParam' );
		$this->assertEquals( $expErrParam, $responseData, 'errParam' );

		$responseData = $response->getVal( 'username' );
		$this->assertEquals( $expUsername, $responseData, 'expUsername' );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.50558 ms
	 */
	public function testWikiaMobileLoginTemplate() {
		$mobileSkin = Skin::newFromKey( 'wikiamobile' );
		$this->setUpMockObject( 'User', array( 'getSkin' => $mobileSkin ), true, 'wgUser' );
		$this->setUpMock();

		$this->setUpMobileSkin( $mobileSkin );

		$response = $this->app->sendRequest( 'UserLoginSpecial', 'index', array( 'format' => 'html' ) );
		$response->toString();// triggers set up of template path

		$this->assertEquals(
			dirname( $this->app->wg->AutoloadClasses['UserLoginSpecialController'] ) . '/templates/UserLoginSpecial_WikiaMobileIndex.php',
			$response->getView()->getTemplatePath()
		);

		$this->tearDownMobileSkin();
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

	public function loginDataProvider() {
		$testUserName = 'testUser';

		// submit request
		// no username
		$reqParams1 = array(
			'username' => '',
			'action' => 'submitlogin',
		);
		$mockLoginFormParams1 = null;
		$mockUserParams1 = null;
		$mockHelperParams1 = null;
		$expMsg1 = wfMessage( 'userlogin-error-noname' )->escaped();
		$expErrParam1 = 'username';

		// not pass token
		$reqParams2 = array(
			'username' => $testUserName,
			'action' => 'submitlogin'
		);
		$expMsg2 = wfMessage( 'userlogin-error-sessionfailure' )->escaped();

		// empty token
		$reqParams3 = array(
			'username' => $testUserName,
			'action' => 'submitlogin',
			'loginToken' => '',
		);

		// mock authenticateUserData()
		// error - NO_NAME
		$reqParams101 = array(
			'username' => $testUserName,
			'password' => 'testPassword',
			'action' => 'submitlogin'
		);
		$mockLoginFormParams101 = array( 'authenticateUserData' => LoginForm::NO_NAME );

		// error - NEED_TOKEN
		$mockLoginFormParams102 = array( 'authenticateUserData' => LoginForm::NEED_TOKEN );

		// error - THROTTLED
		$mockLoginFormParams103 = array( 'authenticateUserData' => LoginForm::THROTTLED );
		$expMsg103 = wfMessage( 'userlogin-error-login-throttled' )->escaped();

		// error - WRONG_TOKEN
		$mockLoginFormParams104 = array( 'authenticateUserData' => LoginForm::WRONG_TOKEN );

		// error - ILLEGAL
		$mockLoginFormParams105 = array( 'authenticateUserData' => LoginForm::ILLEGAL );
		$expMsg105 = wfMessage( 'userlogin-error-nosuchuser' )->escaped();

		// reset - RESET_PASS
		$mockLoginFormParams107 = array( 'authenticateUserData' => LoginForm::RESET_PASS );
		$expMsg107 = wfMessage( 'userlogin-error-resetpass_announce' )->escaped();

		// error - EMPTY_PASS
		$mockLoginFormParams108 = array( 'authenticateUserData' => LoginForm::EMPTY_PASS );
		$expMsg108 = wfMessage( 'userlogin-error-wrongpasswordempty' )->escaped();
		$expErrParam8 = 'password';

		// error - WRONG_PASS
		$mockLoginFormParams109 = array( 'authenticateUserData' => LoginForm::WRONG_PASS );
		$expMsg109 = wfMessage( 'userlogin-error-wrongpassword' )->escaped();

		// error - CLOSED_ACCOUNT_FLAG account (WRONG_PASS)
		$mockLoginFormParams110 = array( 'authenticateUserData' => LoginForm::WRONG_PASS );
		$mockUserParams110 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'getGlobalFlag' => true
		);
		$expMsg110 = wfMessage( 'userlogin-error-edit-account-closed-flag' )->escaped();

		// error - USER_BLOCKED
		$mockLoginFormParams111 = array( 'authenticateUserData' => LoginForm::USER_BLOCKED );
		$expMsg111 = wfMessage( 'userlogin-error-login-userblocked' )->escaped();

		// error - WRONG_PLUGIN_PASS
		$mockLoginFormParams112 = array( 'authenticateUserData' => LoginForm::WRONG_PLUGIN_PASS );

		// error - CREATE_BLOCKED
		$mockLoginFormParams113 = array( 'authenticateUserData' => LoginForm::CREATE_BLOCKED );
		$expMsg113 = wfMessage( 'userlogin-error-cantcreateaccount-text' )->escaped();

		// error - NOT_EXISTS
		$mockLoginFormParams114 = array( 'authenticateUserData' => LoginForm::NOT_EXISTS );

		// error - THROTTLED password throttled
		$mockLoginFormParams115 = array( 'authenticateUserData' => LoginForm::THROTTLED );

		// unconfirm - SUCCESS, but Unconfimed user - confirmation email sent
		$mockLoginFormParams118 = array( 'authenticateUserData' => LoginForm::SUCCESS );
		$mockUserParams118 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'checkPassword' => true,
			'checkTemporaryPassword' => false,
			'params' => array(
				'mId' => self::TEST_USERID,
				'mName' => self::TEST_USERNAME,
				'mEmail' => self::TEST_EMAIL
			),
			'getGlobalFlag' => true,
			'getGlobalPreference' => 'en',
		);
		$mockHelperParams118 = array( 'isPasswordThrottled' => false, 'clearPasswordThrottle' => null );
		$expMsg118 = wfMessage( 'usersignup-confirmation-email-sent', self::TEST_EMAIL )->parse();

		// SUCCESS success
		$mockLoginFormParams120 = array( 'authenticateUserData' => LoginForm::SUCCESS );
		$mockUserParams120 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'setOption' => null,
			'setCookies' => null,
			'saveSettings' => null,
			'getOption' => false,
			'invalidateCache' => null,
		);
		$mockHelperParams120 = array( 'clearPasswordThrottle' => null );

		return array(
			// error - no username
			array( $reqParams1, $mockLoginFormParams1, $mockUserParams1, $mockHelperParams1, 'error', $expMsg1, $expErrParam1 ),
			// error - not pass token
			array( $reqParams2, $mockLoginFormParams1, $mockUserParams1, $mockHelperParams1, 'error', $expMsg2 ),
			// error - empty token
			array( $reqParams3, $mockLoginFormParams1, $mockUserParams1, $mockHelperParams1, 'error', $expMsg2 ),

			// mock authenticateUserData()
			// error - NO_NAME
			array( $reqParams101, $mockLoginFormParams101, $mockUserParams1, $mockHelperParams1, 'error', $expMsg1, $expErrParam1 ),
			// error - NEED_TOKEN
			array( $reqParams101, $mockLoginFormParams102, $mockUserParams1, $mockHelperParams1, 'error', $expMsg2 ),
			// error - THROTTLED
			array( $reqParams101, $mockLoginFormParams103, $mockUserParams1, $mockHelperParams1, 'error', $expMsg103 ),
			// error - WRONG_TOKEN
			array( $reqParams101, $mockLoginFormParams104, $mockUserParams1, $mockHelperParams1, 'error', $expMsg2 ),
			// error - ILLEGAL
			array( $reqParams101, $mockLoginFormParams105, $mockUserParams1, $mockHelperParams1, 'error', $expMsg105, $expErrParam1 ),
			// reset - RESET_PASS
			array( $reqParams101, $mockLoginFormParams107, $mockUserParams1, $mockHelperParams1, 'resetpass', null ),
			// error - EMPTY_PASS
			array( $reqParams101, $mockLoginFormParams108, $mockUserParams1, $mockHelperParams1, 'error', $expMsg108, $expErrParam8 ),

			// error - WRONG_PASS
			array( $reqParams101, $mockLoginFormParams109, $mockUserParams1, $mockHelperParams1, 'error', $expMsg109, $expErrParam8 ),
			// error - CLOSED_ACCOUNT_FLAG account (WRONG_PASS)
			array( $reqParams101, $mockLoginFormParams110, $mockUserParams110, $mockHelperParams1, 'error', $expMsg110 ),
			// error - USER_BLOCKED
			array( $reqParams101, $mockLoginFormParams111, $mockUserParams1, $mockHelperParams1, 'error', $expMsg111 ),
			// error - WRONG_PLUGIN_PASS
			array( $reqParams101, $mockLoginFormParams112, $mockUserParams1, $mockHelperParams1, 'error', $expMsg109, $expErrParam8 ),
			// error - CREATE_BLOCKED
			array( $reqParams101, $mockLoginFormParams113, $mockUserParams1, $mockHelperParams1, 'error', $expMsg113 ),

			// error - NOT_EXISTS
			array( $reqParams101, $mockLoginFormParams114, $mockUserParams1, $mockHelperParams1, 'error', $expMsg105, $expErrParam1 ),
			// error - THROTTLED password throttled
			array( $reqParams101, $mockLoginFormParams115, $mockUserParams1, $mockHelperParams1, 'error', $expMsg103 ),
			// unconfirm - SUCCESS, but Unconfimed user - confirmation email sent
			array( $reqParams101, $mockLoginFormParams118, $mockUserParams118, $mockHelperParams118, 'unconfirm', $expMsg118 ),

			// SUCCESS success
			array( $reqParams101, $mockLoginFormParams120, $mockUserParams120, $mockHelperParams120, 'ok', null, '', $testUserName ),
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.49809 ms
	 * @dataProvider mailPasswordDataProvider
	 *
	 * @param $requestParams
	 * @param $mockWgUserParams
	 * @param $mockAuthParams
	 * @param $mockUserParams
	 * @param $expResult
	 * @param $expMsg
	 */
	public function testMailPassword( $requestParams, $mockWgUserParams, $mockAuthParams, $mockUserParams, $expResult, $expMsg ) {
		// setup
		$this->setUpMockObject( 'AuthPlugin', $mockAuthParams, false, 'wgAuth' );
		$this->setUpMockObject( 'User', $mockWgUserParams, false, 'wgUser' );
		$this->setUpMockObject( 'User', $mockUserParams, true );
		$this->setUpMock();
		$this->setUpRequest( $requestParams );

		// test
		$response = $this->app->sendRequest( 'UserLoginSpecial', 'mailPassword' );

		$responseData = $response->getVal( 'result' );
		$this->assertEquals( $expResult, $responseData, 'result' );

		$responseData = $response->getVal( 'msg' );
		$this->assertEquals( $expMsg, $responseData, 'msg' );
	}

	public function mailPasswordDataProvider() {
		$testUserId = self::TEST_USERID;

		// empty username
		$reqParams1 = [ 'username' => '', 'action' => 'mailpassword' ];
		$mockWgUserParams1 = null;		// not mock $wgUser
		$mockAuthParams1 = null;		// not mock $wgAuth
		$mockUserParams1 = null;		// not mock User Object
		$expMsg1 = wfMessage( 'userlogin-error-noname' )->escaped();

		// not allow user to change password
		$reqParams2 = [ 'username' => 'WikiaUser', 'action' => 'mailpassword', 'lang' => 'en' ];
		$mockAuthParams2 = [ 'allowPasswordChange' => false ];
		$expMsg2 = wfMessage( 'userlogin-error-resetpass_forbidden' )->escaped();

		// user is blocked
		$mockWgUserParams3 = [ 'isBlocked' => true ];
		$mockAuthParams3 = [ 'allowPasswordChange' => true ];
		$expMsg3 = wfMessage( 'userlogin-error-blocked-mailpassword' )->escaped();

		// user not found
		$mockWgUserParams4 = [
			'isBlocked' => false,
		];
		$mockUserParams4 = false;
		$expMsg4 = wfMessage( 'userlogin-error-noname' )->escaped();

		// User - invalid user (user id = 0)
		$mockUserParams5 = [
			'load' => null,
			'loadFromDatabase' => null,
			'getId' => 0
		];
		$expMsg5 = wfMessage( 'userlogin-error-nosuchuser', $reqParams2['username'] )->escaped();

		// User - password reminder throttled
		$mockUserParams6 = [
			'load' => null,
			'loadFromDatabase' => null,
			'getId' => $testUserId,
			'isPasswordReminderThrottled' => true
		];
		$expMsg6 = wfMessage( 'userlogin-error-throttled-mailpassword', round( F::app()->wg->PasswordReminderResendTime, 3 ) )->escaped();

		// User - mail error
		$mockUserParams7 = [
			'load' => null,
			'loadFromDatabase' => null,
			'getId' => $testUserId,
			'isPasswordReminderThrottled' => false,
			'params' => [
				'mName' => 'WikiaUser',
				'mEmail' => self::TEST_EMAIL,
			],
			'mockValueMap' => [
				'getOption' => [
					[ UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true ],
					[ 'language', null, false, 'en' ]
				]
			]
		];

		// User - email sent
		$expMsg8 = wfMessage( 'userlogin-password-email-sent', $reqParams2['username'] )->escaped();

		// User - mail error
		$mockUserParams9 = [
			'load' => null,
			'loadFromDatabase' => null,
			'getId' => $testUserId,
			'isPasswordReminderThrottled' => false,
			'params' => [
				'mName' => 'WikiaUser',
				'mEmail' => self::TEST_EMAIL,
			],
			'mockValueMap' => [
				'getOption' => [
					[ UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true ],
					[ 'language', null, false, 'en' ]
				]
			]
		];

		return [
			// #1 error - empty username
			[ $reqParams1, $mockWgUserParams1, $mockAuthParams1, $mockUserParams1, 'error', $expMsg1 ],
			// #2 error - not allow user to change password
			[ $reqParams2, $mockWgUserParams1, $mockAuthParams2, $mockUserParams1, 'error', $expMsg2 ],
			// #3 error - user is blocked
			[ $reqParams2, $mockWgUserParams3, $mockAuthParams3, $mockUserParams1, 'error', $expMsg3 ],
			// #4 error - user not found
			[ $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockUserParams4, 'error', $expMsg4 ],
			// #5 error - User - invalid user (user id = 0)
			[ $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockUserParams5, 'error', $expMsg5 ],
			// #6 error - User - password reminder throttled
			[ $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockUserParams6, 'error', $expMsg6 ],
			// #7 Removed
			// #8 success - User - email sent
			[ $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockUserParams7, 'ok', $expMsg8 ],
			// #9 success - Temp User - email sent
			[ $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockUserParams9, 'ok', $expMsg8 ],
		];
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

		// 5 redirect page -- cancel request + returnto
		$params5 = array(
			'cancel' => true,
			'returnto' => 'Special:WikiFeatures',
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

		// 10 error --  not match temporary password (checkTemporaryPassword = false)
		$params10 = array(
			'username' => 'WikiaUser',
			'newpassword' => 'testPasword',
			'retype' => 'testPasword',
			'loginToken' => self::LOGIN_TOKEN,
		);
		$mockUserParams10 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => false,
			'checkPassword' => true,
		);
		$expMsg10 = wfMessage( 'userlogin-error-wrongpassword' )->escaped();

		// 11 error -- not correct password (checkPassword = false)
		$mockUserParams11 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => true,
			'checkPassword' => false,
		);

		// 1011 error -- [10] not match temporary password (checkTemporaryPassword = false) + [11] not correct password (checkPassword = false)
		$mockUserParams1011 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => false,
			'checkPassword' => false,
		);

		// 12 error -- not valid new password (passwordtooshort)
		$mockUserParams12 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => true,
			'checkPassword' => true,
			'getPasswordValidity' => 'passwordtooshort',
		);
		$expMsg12 = wfMsgExt( 'passwordtooshort', array( 'parsemag' ), F::app()->wg->MinimalPasswordLength );

		// 13 error -- not valid new password (password-name-match)
		$mockUserParams13 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => true,
			'checkPassword' => true,
			'getPasswordValidity' => 'password-name-match',
		);
		$expMsg13 = wfMsgExt( 'password-name-match', array( 'parsemag' ), F::app()->wg->MinimalPasswordLength );

		// 14 error -- not valid new password (securepasswords-invalid)
		$mockUserParams14 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => true,
			'checkPassword' => true,
			'getPasswordValidity' => 'securepasswords-invalid',
		);
		$expMsg14 = wfMsgExt( 'securepasswords-invalid', array( 'parsemag' ), F::app()->wg->MinimalPasswordLength );

		// 15 success -- real user
		$mockUserParams15 = array(
			'load' => null,
			'loadFromDatabase' => null,
			'isAnon' => false,
			'checkTemporaryPassword' => true,
			'checkPassword' => true,
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
			// 10 error --  not match temporary password (checkTemporaryPassword = false)
			// array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams10, $mockHelperParams1, 'error', $expMsg10 ),
			// 11 error -- not correct password (checkPassword = false)
			// array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams11, $mockHelperParams1, 'error', $expMsg10 ),
			// 1011 error -- [10] not match temporary password (checkTemporaryPassword = false) + [11] not correct password (checkPassword = false)
			array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockUserParams1011, $mockHelperParams1, 'error', $expMsg10 ),
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
	 * @param String $query
	 * @param Boolean $isTitleBlacklisted
	 * @param String $expected
	 * @param String $message message displayed during unit tests execution
	 *
	 * @dataProvider getReturnToFromQueryDataProvider
	 *
	 * @FIXME For some reason methods on UserLoginSpecialController refused to be mocked
	 * @group Broken
	 */
	public function testGetReturnToFromQuery( $query, $isTitleBlacklisted, $expected, $message ) {
		$loginControllerMock = $this->getMock( 'UserLoginSpecialController', [ 'getMainPagePartialUrl', 'isTitleBlacklisted' ] );
		$loginControllerMock->expects( $this->any() )
			->method( 'getMainPagePartialUrl' )
			->will( $this->returnValue( $expected ) );
		$loginControllerMock->expects( $this->any() )
			->method( 'isTitleBlacklisted' )
			->will( $this->returnValue( $isTitleBlacklisted ) );

		$getReturnToFromQueryMethod = new ReflectionMethod( 'UserLoginSpecialController', 'getReturnToFromQuery' );
		$getReturnToFromQueryMethod->setAccessible( true );

		$result = $getReturnToFromQueryMethod->invoke( $loginControllerMock, $query );
		$this->assertEquals( $expected, $result, $message );
	}

	public function getReturnToFromQueryDataProvider() {
		return [
			[
				'query' => '',
				'isTitleBlacklisted' => false,
				'expected' => '',
				'message' => 'Query is not an array',
			],
			[
				'query' => [],
				'isTitleBlacklisted' => false,
				'expected' => self::MAIN_PAGE_TITLE_TXT,
				'message' => 'No title in query',
			],
			[
				'query' => [ 'title' => 'Test title' ],
				'isTitleBlacklisted' => false,
				'expected' => 'Test title',
				'message' => 'Valid title in query',
			],
			[
				'query' => [ 'title' => 'Blacklisted test title' ],
				'isTitleBlacklisted' => true,
				'expected' => self::MAIN_PAGE_TITLE_TXT,
				'message' => 'Invalid (blacklisted) title in query',
			],
		];
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

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05041 ms
	 * @param String $query
	 * @param bool $wasPosted Whether this request was a POST request (as opposed to a GET)
	 * @param String $expected
	 * @param String $message
	 *
	 * @dataProvider getReturnToQueryFromQueryDataProvider
	 */
	public function testGetReturnToQueryFromQuery( $query, $wasPosted, $expected, $message ) {
		$getReturnToQueryFromQueryMethod = new ReflectionMethod( 'UserLoginSpecialController', 'getReturnToQueryFromQuery' );
		$getReturnToQueryFromQueryMethod->setAccessible( true );

		$request = $this->getMock( 'WikiaRequest', [ 'wasPosted' ], [], '', false );
		$request
			->expects( $this->any() )
			->method( 'wasPosted' )
			->will( $this->returnValue( $wasPosted ) );

		$controller = new UserLoginSpecialController();
		$controller->setRequest( $request );

		$result = $getReturnToQueryFromQueryMethod->invoke( $controller, $query );
		$this->assertEquals( $expected, $result, $message );
	}

	public function getReturnToQueryFromQueryDataProvider() {
		return [
			[
				'query' => '',
				'wasPosted' => false,
				'expected' => '',
				'message' => 'Query is not an array',
			],
			[
				'query' => [],
				'wasPosted' => false,
				'expected' => '',
				'message' => 'Query without any parameters',
			],
			[
				'query' => [
					'login' => self::TEST_USERNAME,
					'returnto' => 'Special:Preferences',
					'editToken' => '123456789',
				],
				'wasPosted' => false,
				// Existing query parameters are ignored because adding new query parameters to an
				// old returnto location does not make sense.
				'expected' => '',
				'message' => 'Query without returntoquery parameter',
			],
			[
				'query' => [
					'login' => self::TEST_USERNAME,
					'returnto' => 'Some_Article',
					'returntoquery' => 'action=edit',
					'loginToken' => '123456789',
				],
				'wasPosted' => false,
				'expected' => 'action=edit',
				'message' => 'Query with returntoquery',
			],
			[
				'query' => [
					'username' => self::TEST_USERNAME,
					'loginToken' => '123456789',
				],
				'wasPosted' => true,
				'expected' => '',
				'message' => 'Query with no returnto or returntoquery but was POSTed',
			],
			[
				'query' => [
					'action' => 'edit',
					'cb' => 123,
				],
				'wasPosted' => false,
				'expected' => 'action=edit&cb=123',
				'message' => 'Query with no returnto or returntoquery',
			],
		];
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
