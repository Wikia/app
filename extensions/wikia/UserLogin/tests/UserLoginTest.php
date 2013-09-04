<?php

	require_once __DIR__ . '/UserLoginBaseTest.php';

	class UserLoginTest extends UserLoginBaseTest {
		const TEST_CITY_ID = 79860;
		const TEST_USERNAME = 'WikiaUser';

		protected $skinOrg = null;

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../UserLogin.setup.php';
			parent::setUp();
		}

		protected function setUpMock() {
			// mock cache
			$memcParams = array(
				'set' => null,
				'get' => null,
				'delete' => null
			);

			$this->setUpMockObject( 'stdClass', $memcParams, false, 'wgMemc' );

			$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);
		}

		/**
		 * @dataProvider loginDataProvider
		 */
		public function testLogin( $requestParams, $mockLoginFormParams, $mockUserParams, $mockTempUserParams, $mockHelperParams, $expResult, $expMsg, $expErrParam='' ) {
			// setup
			$this->setUpRequest( $requestParams );
			$this->setUpMockObject( 'User', $mockUserParams, true, 'wgUser' );
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );
			$this->setUpMockObject( 'UserLoginHelper', $mockHelperParams, true );
			if ( !is_null($mockLoginFormParams) ) {
				$this->setUpMockObject( 'LoginForm', $mockLoginFormParams, true, null, array(), false );
			}

			$mockMsgExtCount = ( $expResult == 'unconfirm' ) ? 1 : 0 ;
			$this->getGlobalFunctionMock( 'wfMsgExt' )
				->expects( $this->exactly( $mockMsgExtCount ) )
				->method( 'wfMsgExt' )
				->will( $this->returnValue( $expMsg ) );

			$this->setUpMock();

			// test
			$response = $this->app->sendRequest( 'UserLoginSpecial', 'login' );

			$responseData = $response->getVal( 'result' );
			$this->assertEquals( $expResult, $responseData, 'result' );

			$responseData = $response->getVal( 'msg' );
			$this->assertEquals( $expMsg, $responseData, 'msg' );

			$responseData = $response->getVal( 'errParam' );
			$this->assertEquals( $expErrParam, $responseData, 'errParam' );
		}

		public function testWikiaMobileLoginTemplate() {
			$mobileSkin = Skin::newFromKey( 'wikiamobile' );
			$this->setUpMockObject( 'User', array( 'getSkin' => $mobileSkin ), true, 'wgUser' );
			$this->setUpMock();

			$this->setUpMobileSkin( $mobileSkin );

			$response = $this->app->sendRequest( 'UserLoginSpecial', 'index', array( 'format' => 'html' ) );
			$response->toString();//triggers set up of template path

			$this->assertEquals(
				dirname( $this->app->wg->AutoloadClasses['UserLoginSpecialController'] ) . '/templates/UserLoginSpecial_WikiaMobileIndex.php',
				$response->getView()->getTemplatePath()
			);

			$this->tearDownMobileSkin();
		}

		public function testWikiaMobileChangePasswordTemplate(){
			$mobileSkin = Skin::newFromKey( 'wikiamobile' );
			$this->setUpMockObject( 'User', array( 'getSkin' => $mobileSkin ), true, 'wgUser' );
			$this->setUpMockObject( 'WebRequest', array( 'wasPosted' => true ), false, 'wgRequest' );
			$this->setUpMock();

			$this->setUpMobileSkin( $mobileSkin );

			$response = $this->app->sendRequest( 'UserLoginSpecial', 'index', array( 'format' => 'html', 'action' => wfMsg( 'resetpass_submit' ) ) );
			$response->toString();//triggers set up of template path

			$this->assertEquals(
				dirname( $this->app->wg->AutoloadClasses['UserLoginSpecialController'] ) . '/templates/UserLoginSpecial_WikiaMobileChangePassword.php',
				$response->getView()->getTemplatePath()
			);

			$this->tearDownMobileSkin();
		}

		public function loginDataProvider() {
			// submit request
			// no username
			$reqParams1 = array(
				'username' => '',
				'action' => 'submitlogin',
			);
			$mockLoginFormParams1 = null;
			$mockUserParams1 = null;
			$mockTempUserParams1 = null;
			$mockHelperParams1 = null;
			$expMsg1 = wfMsg('userlogin-error-noname');
			$expErrParam1 = 'username';

			// not pass token
			$reqParams2 = array(
				'username' => 'testUser',
				'action' => 'submitlogin'
			);
			$expMsg2 = wfMsg('userlogin-error-sessionfailure');

			// empty token
			$reqParams3 = array(
				'username' => 'testUser',
				'action' => 'submitlogin',
				'loginToken' => '',
			);



			// mock authenticateUserData()
			// error - NO_NAME
			$reqParams101 = array(
				'username' => 'testUser',
				'password' => 'testPassword',
				'action' => 'submitlogin'
			);
			$mockLoginFormParams101 = array( 'authenticateUserData' => LoginForm::NO_NAME );

			// error - NEED_TOKEN
			$mockLoginFormParams102 = array( 'authenticateUserData' => LoginForm::NEED_TOKEN );

			// error - THROTTLED
			$mockLoginFormParams103 = array( 'authenticateUserData' => LoginForm::THROTTLED );
			$expMsg103 = wfMsg('userlogin-error-login-throttled');

			// error - WRONG_TOKEN
			$mockLoginFormParams104 = array( 'authenticateUserData' => LoginForm::WRONG_TOKEN );

			// error - ILLEGAL
			$mockLoginFormParams105 = array( 'authenticateUserData' => LoginForm::ILLEGAL );
			$expMsg105 = wfMsg('userlogin-error-nosuchuser');

			// reset - RESET_PASS
			$mockLoginFormParams107 = array( 'authenticateUserData' => LoginForm::RESET_PASS );
			$expMsg107 = wfMsg('userlogin-error-resetpass_announce');

			// error - EMPTY_PASS
			$mockLoginFormParams108 = array( 'authenticateUserData' => LoginForm::EMPTY_PASS );
			$expMsg108 = wfMsg('userlogin-error-wrongpasswordempty');
			$expErrParam8 = 'password';

			// error - WRONG_PASS
			$mockLoginFormParams109 = array( 'authenticateUserData' => LoginForm::WRONG_PASS );
			$expMsg109 = wfMsg('userlogin-error-wrongpassword');

			// error - CLOSED_ACCOUNT_FLAG account (WRONG_PASS)
			$mockLoginFormParams110 = array( 'authenticateUserData' => LoginForm::WRONG_PASS );
			$mockUserParams110 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'getOption' => true
			);
			$expMsg110 = wfMsg('userlogin-error-edit-account-closed-flag');

			// error - USER_BLOCKED
			$mockLoginFormParams111 = array( 'authenticateUserData' => LoginForm::USER_BLOCKED );
			$expMsg111 = wfMsg( 'userlogin-error-login-userblocked' );

			// error - WRONG_PLUGIN_PASS
			$mockLoginFormParams112 = array( 'authenticateUserData' => LoginForm::WRONG_PLUGIN_PASS );

			// error - CREATE_BLOCKED
			$mockLoginFormParams113 = array( 'authenticateUserData' => LoginForm::CREATE_BLOCKED );
			$expMsg113 = wfMsg( 'userlogin-error-cantcreateaccount-text' );

			// error - NOT_EXISTS
			$mockLoginFormParams114 = array( 'authenticateUserData' => LoginForm::NOT_EXISTS );
			$mockTempUserParams114 = false;

			// error - NOT_EXISTS - Temp User account with password throttled
			$mockTempUserParams115 = array( 'getTempUserFromName' => true );
			$mockHelperParams115 = array( 'isPasswordThrottled' => true );

			// error - NOT_EXISTS - Temp User account with wrong password
			$mockUserParams116 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'checkPassword' => false,
				'checkTemporaryPassword' => false,
			);
			$mockTempUserParams116 = array( 'setTempUserSession' => null );
			$mockHelperParams116 = array( 'isPasswordThrottled' => false );

			// reset - NOT_EXISTS - Temp User account with temporary password
			$mockUserParams117 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'checkPassword' => false,
				'checkTemporaryPassword' => true,
			);

			// unconfirm - NOT_EXISTS - Temp User account with temporary password
			$mockUserParams118 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'checkPassword' => true,
				'checkTemporaryPassword' => false,
			);
			$mockHelperParams118 = array( 'isPasswordThrottled' => false, 'clearPasswordThrottle' => null );
			$expMsg118 = wfMsg( 'usersignup-confirmation-email-sent', '' );

			// success
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
				array($reqParams1, $mockLoginFormParams1, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg1, $expErrParam1),
				// error - not pass token
				array($reqParams2, $mockLoginFormParams1, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg2),
				// error - empty token
				array($reqParams3, $mockLoginFormParams1, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg2),

				// mock authenticateUserData()
				// error - NO_NAME
				array($reqParams101, $mockLoginFormParams101, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg1, $expErrParam1),
				// error - NEED_TOKEN
				array($reqParams101, $mockLoginFormParams102, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg2),
				// error - THROTTLED
				array($reqParams101, $mockLoginFormParams103, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg103),
				// error - WRONG_TOKEN
				array($reqParams101, $mockLoginFormParams104, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg2),
				// error - ILLEGAL
				array($reqParams101, $mockLoginFormParams105, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg105, $expErrParam1),
				// reset - RESET_PASS
				array($reqParams101, $mockLoginFormParams107, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'resetpass', null),
				// error - EMPTY_PASS
				array($reqParams101, $mockLoginFormParams108, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg108, $expErrParam8),

				// error - WRONG_PASS
				array($reqParams101, $mockLoginFormParams109, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg109, $expErrParam8),
				// error - CLOSED_ACCOUNT_FLAG account (WRONG_PASS)
				array($reqParams101, $mockLoginFormParams110, $mockUserParams110, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg110),
				// error - USER_BLOCKED
				array($reqParams101, $mockLoginFormParams111, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg111),
				// error - WRONG_PLUGIN_PASS
				array($reqParams101, $mockLoginFormParams112, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg109, $expErrParam8),
				// error - CREATE_BLOCKED
				array($reqParams101, $mockLoginFormParams113, $mockUserParams1, $mockTempUserParams1, $mockHelperParams1, 'error', $expMsg113),

				// error - NOT_EXISTS
				array($reqParams101, $mockLoginFormParams114, $mockUserParams1, $mockTempUserParams114, $mockHelperParams1, 'error', $expMsg105, $expErrParam1),
				// error - NOT_EXISTS - Temp User account with password throttled
				array($reqParams101, $mockLoginFormParams114, $mockUserParams1, $mockTempUserParams115, $mockHelperParams115, 'error', $expMsg103),
				// error - NOT_EXISTS - Temp User account with wrong password
				array($reqParams101, $mockLoginFormParams114, $mockUserParams116, $mockTempUserParams116, $mockHelperParams116, 'error', $expMsg109, $expErrParam8),
				// reset - NOT_EXISTS - Temp User account with temporary password
				array($reqParams101, $mockLoginFormParams114, $mockUserParams117, $mockTempUserParams116, $mockHelperParams116, 'resetpass', null),
				// unconfirm - NOT_EXISTS - Temp User account with temporary password
				array($reqParams101, $mockLoginFormParams114, $mockUserParams118, $mockTempUserParams116, $mockHelperParams118, 'unconfirm', $expMsg118),

				// SUCCESS
				array($reqParams101, $mockLoginFormParams120, $mockUserParams120, $mockTempUserParams1, $mockHelperParams120, 'ok', null),
			);
		}

		/**
		 * @dataProvider mailPasswordDataProvider
		 */
		public function testMailPassword( $requestParams, $mockWgUserParams, $mockAuthParams, $mockTempUserParams, $mockUserParams, $mockLoginFormParams, $expResult, $expMsg, $expErrParam='' ) {
			// setup
			$this->setUpMockObject( 'AuthPlugin', $mockAuthParams, false, 'wgAuth' );
			$this->setUpMockObject( 'User', $mockWgUserParams, false, 'wgUser' );
			$this->setUpMockObject( 'User', $mockUserParams, true );
			if ( $mockTempUserParams ) {
				$mockTempUserParams = new TempUser( $mockTempUserParams );
			}
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );
			if ( !is_null($mockLoginFormParams) ) {
				$this->setUpMockObject( 'LoginForm', $mockLoginFormParams, true, null, array(), false );
			}
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
			$testUser = User::newFromName( self::TEST_USERNAME );
			$testUserId = $testUser->getId();

			// empty username
			$reqParams1 = array( 'username' => '', 'action' => 'mailpassword' );
			$mockWgUserParams1 = null;		// not mock $wgUser
			$mockAuthParams1 = null;		// not mock $wgAuth
			$mockTempUserParams1 = null;	// not mock TempUser Object
			$mockUserParams1 = null;		// not mock User Object
			$mockLoginFormParams1 = null;	// not mock LoginForm Object
			$expMsg1 = wfMsg('userlogin-error-noname');

			// not allow user to change password
			$reqParams2 = array( 'username' => 'WikiaUser', 'action' => 'mailpassword' );
			$mockAuthParams2 = array( 'allowPasswordChange' => false );
			$expMsg2 = wfMsg('userlogin-error-resetpass_forbidden');

			// user is blocked
			$mockWgUserParams3 = array( 'isBlocked' => true );
			$mockAuthParams3 = array( 'allowPasswordChange' => true );
			$expMsg3 = wfMsg('userlogin-error-blocked-mailpassword');

			// user not found
			$mockWgUserParams4 = array( 'isBlocked' => false );
			$mockTempUserParams4 = false;
			$mockUserParams4 = false;
			$expMsg4 = wfMsg('userlogin-error-noname');

			// User - invalid user (user id = 0)
			$mockUserParams5 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'getId' => 0
			);
			$expMsg5 = wfMsg('userlogin-error-nosuchuser', $reqParams2['username']);

			// User - password reminder throttled
			$mockUserParams6 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'getId' => $testUserId,
				'isPasswordReminderThrottled' => true
			);
			$expMsg6 = wfMsg('userlogin-error-throttled-mailpassword', round( F::app()->wg->PasswordReminderResendTime, 3));

			// User - mail error
			$mockUserParams7 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'getId' => $testUserId,
				'isPasswordReminderThrottled' => false
			);
			$status7 = Status::newFatal('');
			$mockLoginFormParams7 = array( 'mailPasswordInternal' => $status7 );
			$expMsg7 = wfMsgExt('userlogin-error-mail-error', array('parseinline'), $status7->getMessage());

			// User - email sent
			$status8 = Status::newGood();
			$mockLoginFormParams8 = array( 'mailPasswordInternal' => $status8 );
			$expMsg8 = wfMsg('userlogin-password-email-sent', $reqParams2['username']);

			// TempUser - email sent
			$mockTempUserParams9 = array(
				'user_id' => $testUserId,
				'user_name' => 'WikiaUser',
			);

			return array(
				// error - empty username
				array( $reqParams1, $mockWgUserParams1, $mockAuthParams1, $mockTempUserParams1, $mockUserParams1, $mockLoginFormParams1, 'error', $expMsg1 ),
				// error - not allow user to change password
				array( $reqParams2, $mockWgUserParams1, $mockAuthParams2, $mockTempUserParams1, $mockUserParams1, $mockLoginFormParams1, 'error', $expMsg2 ),
				// error - user is blocked
				array( $reqParams2, $mockWgUserParams3, $mockAuthParams3, $mockTempUserParams1, $mockUserParams1, $mockLoginFormParams1, 'error', $expMsg3 ),
				// error - user not found
				array( $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockTempUserParams4, $mockUserParams4, $mockLoginFormParams1, 'error', $expMsg4 ),
				// error - User - invalid user (user id = 0)
				array( $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockTempUserParams4, $mockUserParams5, $mockLoginFormParams1, 'error', $expMsg5 ),
				// error - User - password reminder throttled
				array( $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockTempUserParams4, $mockUserParams6, $mockLoginFormParams1, 'error', $expMsg6 ),
				// error - User - mail error
				array( $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockTempUserParams4, $mockUserParams7, $mockLoginFormParams7, 'error', $expMsg7 ),
				// success - User - email sent
				array( $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockTempUserParams4, $mockUserParams7, $mockLoginFormParams8, 'ok', $expMsg8 ),
				// success - Temp User - email sent
				array( $reqParams2, $mockWgUserParams4, $mockAuthParams3, $mockTempUserParams9, $mockUserParams7, $mockLoginFormParams8, 'ok', $expMsg8 ),
			);
		}

		/**
		 * @dataProvider changePasswordDataProvider
		 */
		public function testChangePassword($params, $mockWebRequestParams, $mockWgUserParams, $mockAuthParams, $mockTempUserParams, $mockUserParams, $mockHelperParams, $expResult, $expMsg) {
			// setup
			$this->setUpMockObject( 'WebRequest', $mockWebRequestParams, false, 'wgRequest', $params );
			$this->setUpMockObject( 'AuthPlugin', $mockAuthParams, false, 'wgAuth' );
			$this->setUpMockObject( 'User', $mockWgUserParams, false, 'wgUser' );
			$this->setUpMockObject( 'User', $mockUserParams, true );
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );

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
			);
			$mockWebRequest1 = array( 'wasPosted' => false );
			$mockWgUserParams1 = null;
			$mockAuthParams1 = null;
			$mockTempUserParams1 = null;
			$mockUserParams1 = null;
			$mockHelperParams1 = null;

			// 2 do nothing -- POST + not empty fakeGet
			$params2 = array(
				'username' => 'WikiaUser',
				'fakeGet' => '1',
			);
			$mockWebRequest2 = array( 'wasPosted' => true, 'setVal' => null );

			// 3 error -- POST + empty fakeGet + not allow password change
			$mockAuthParams3 = array( 'allowPasswordChange' => false );
			$expMsg3 = wfMsg( 'resetpass_forbidden' );

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
			$mockTempUserParams7 = false;
			$mockUserParams7 = false;
			$expMsg7 = wfMsg( 'userlogin-error-nosuchuser' );

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
			);
			$mockUserParams9 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isAnon' => false
			);
			$expMsg9 = wfMsg( 'badretype' );

			// 10 error --  not match temporary password (checkTemporaryPassword = false)
			$params10 = array(
				'username' => 'WikiaUser',
				'newpassword' => 'testPasword',
				'retype' => 'testPasword',
			);
			$mockUserParams10 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isAnon' => false,
				'checkTemporaryPassword' => false,
				'checkPassword' => true,
			);
			$expMsg10 = wfMsg( 'userlogin-error-wrongpassword' );

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
			$expMsg15 = wfMsg( 'resetpass_success' );
			$mockHelperParams15 = array(
				'doRedirect' => null,
			);

			// 16 success -- temp user


			return array(
				// 1 do nothing -- GET
				array( $params1, $mockWebRequest1, $mockWgUserParams1, $mockAuthParams1, $mockTempUserParams1, $mockUserParams1, $mockHelperParams1, '', '' ),
				// 2 do nothing -- POST + not empty fakeGet
				array( $params2, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams1, $mockTempUserParams1, $mockUserParams1, $mockHelperParams1, '', '' ),
				// 3 error -- POST + empty fakeGet + not allow password change
				array( $params1, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams3, $mockTempUserParams1, $mockUserParams1, $mockHelperParams1, 'error', $expMsg3 ),
				// 4 redirect page -- cancel request + empty returnto
				array( $params4, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams1, $mockTempUserParams1, $mockUserParams1, $mockHelperParams4, null, null ),
				// 5 redirect page -- cancel request + returnto
				//array( $params5, $mockWebRequest2, $mockWgUserParams1, $mockAuthParams1, $mockTempUserParams1, $mockUserParams1, $mockHelperParams4, null, null ),
				// 6 do nothing -- not match edit token
				array( $params1, $mockWebRequest2, $mockWgUserParams6, $mockAuthParams6, $mockTempUserParams1, $mockUserParams1, $mockHelperParams1, '', '' ),
				// 7 error -- real user + user not found
				array( $params1, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams7, $mockHelperParams1, 'error', $expMsg7 ),
				// 8 error -- real user + anon user
				array( $params1, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams8, $mockHelperParams1, 'error', $expMsg7 ),
				// 9 error -- retype != newpassword
				array( $params9, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams9, $mockHelperParams1, 'error', $expMsg9 ),
				// 10 error --  not match temporary password (checkTemporaryPassword = false)
				//array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams10, $mockHelperParams1, 'error', $expMsg10 ),
				// 11 error -- not correct password (checkPassword = false)
				//array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams11, $mockHelperParams1, 'error', $expMsg10 ),
				// 1011 error -- [10] not match temporary password (checkTemporaryPassword = false) + [11] not correct password (checkPassword = false)
				array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams1011, $mockHelperParams1, 'error', $expMsg10 ),
				// 12 error -- not valid new password (passwordtooshort)
				array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams12, $mockHelperParams1, 'error', $expMsg12 ),
				// 13 error -- not valid new password (password-name-match)
				array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams13, $mockHelperParams1, 'error', $expMsg13 ),
				// 14 error -- not valid new password (securepasswords-invalid)
				array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams14, $mockHelperParams1, 'error', $expMsg14 ),
				// 15 success -- real user
				array( $params10, $mockWebRequest2, $mockWgUserParams7, $mockAuthParams6, $mockTempUserParams7, $mockUserParams15, $mockHelperParams15, 'ok', $expMsg15 ),
				// 16 success -- temp user

			);
		}

	}
