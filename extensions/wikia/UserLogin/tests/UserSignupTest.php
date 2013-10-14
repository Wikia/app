<?php

	require_once __DIR__ . '/UserLoginBaseTest.php';

	class UserSignupTest extends UserLoginBaseTest {

		const TEST_USERNAME = 'WikiaUser';
		const TEST_DNE_USER = 'UserNameThatDoesNotExist';
		const TEST_EMAIL = 'devbox+test@wikia-inc.com';

		private $originalServer;

		protected function setUpMock( $cacheParams=null ) {
			// mock cache
			$memcParams = array(
				'set' => null,
				'delete' => null,
				'add' => null,
				'incr' => null,
			);
			if ( is_array($cacheParams) ) {
				$memcParams = $memcParams + $cacheParams;
			}

			if ( !array_key_exists( 'get', $memcParams ) ) {
				$memcParams[ 'get' ] = null;
			}

			$this->setUpMockObject( 'stdClass', $memcParams, false, 'wgMemc' );

			$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);

			// "mock" IP
			$this->originalServer = $_SERVER;
			$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
		}

		protected function tearDown() {
			parent::tearDown();
			$_SERVER = $this->originalServer;
		}

		protected function patchSetupUser( &$mockUserObj, $params ) {
			foreach( $params[0] as $key => $value ) {
				$mockUserObj->$key = $value;
			}
		}

		public function runHooksCallback( $hookName ) {
			switch ($hookName) {
				case 'cxValidateUserName':
				case 'isValidEmailAddr':
					return true;
				default:
					return $this->callOriginalGlobalFunction( 'wfRunHooks', func_get_args() );
			}
		}

		/**
		 * @dataProvider signupDataProvider
		 */
		public function testSignup( $requestParams, $mockUserParams, $mockUserLoginFormParams, $expResult, $expMsg, $expErrParam ) {
			// setup
			$this->setUpRequest( $requestParams );
			$this->setUpMockObject( 'User', $mockUserParams, true );

			$objectName = 'ExternalUser_Wikia';
			$mockObject = true;
			$this->mockClass( $objectName, $mockObject, 'initFromName' );
			$this->mockClass( $objectName, $mockObject, 'getLocalUser' );
			$this->mockClass( $objectName, (isset($objectParams['params']['mId']) ? $objectParams['params']['mId'] : 0), 'getId' );

			if ( !is_null($mockUserLoginFormParams) ) {
				$this->setUpMockObject( 'UserLoginForm', $mockUserLoginFormParams, true, null, array(), false );
			}

			// required to prevent Phalanx checks
			$mockRunHooks = $this->getGlobalFunctionMock( 'wfRunHooks' );
			$mockRunHooks->expects( $this->any() )
				->method( 'wfRunHooks' )
				->will( $this->returnCallback( array( $this, 'runHooksCallback' ) ) );

			$this->setUpMock();

			// test
			$response = $this->app->sendRequest( 'UserSignupSpecial', 'signup' );

			$responseData = $response->getVal( 'result' );
			$this->assertEquals( $expResult, $responseData, 'result' );

			$responseData = $response->getVal( 'msg' );
			$this->assertEquals( $expMsg, $responseData, 'msg' );

			$responseData = $response->getVal( 'errParam' );
			$this->assertEquals( $expErrParam, $responseData, 'errParam' );
		}

		public function signupDataProvider() {
			global $wgWikiaMaxNameChars;

			// error - empty username
			$reqParams1 = array(
				'userloginext01' => '',
			);
			$mockUserParams1 = null;
			$mockUserLoginForm1 = null;
			$expMsg1 = wfMessage( 'userlogin-error-noname' )->escaped();
			$expErrParam1 = 'username';

			// error - username exists in temp user
			$reqParams2 = array(
				'userloginext01' => self::TEST_USERNAME,
			);
			$mockUserParams2 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true ),
						array( UserLoginSpecialController::SIGNED_UP_ON_WIKI_OPTION_NAME, null, false, 0 )
					)
				),
				'mockStatic' => array(
					'idFromName' => 11
				)
			);
			$expMsg2 = wfMessage( 'userlogin-error-userexists' )->escaped();

			// error - username length exceed limit
			$reqParams3 = array(
				'userloginext01' => 'test123456789test123456789test123456789test123456789test123456789',
			);
			$mockUserParams3 = false;
			$expMsg3 = wfMessage( 'usersignup-error-username-length', $wgWikiaMaxNameChars )->escaped();

			// error - invalid user name ( getCanonicalName() = false for creatable )
			$reqParams4 = array(
				'userloginext01' => '#'.self::TEST_USERNAME.'#',
			);
			$expMsg4 = wfMessage( 'usersignup-error-symbols-in-username' )->escaped();

			// error - empty password
			$reqParams5 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'email' => self::TEST_EMAIL,
				'userloginext02' => '',
			);
			$expMsg5 = wfMessage( 'userlogin-error-wrongpasswordempty' )->escaped();
			$expErrParam2 = 'password';

			// error - password length exceed limit
			$reqParams6 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'email' => self::TEST_EMAIL,
				'userloginext02' => 'testPasswordtestPasswordtestPasswordtestPasswordtestPasswordtestPassword',
			);
			$expMsg6 = wfMessage( 'usersignup-error-password-length' )->escaped();

			// error - empty email
			$reqParams7 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'email' => '',
			);
			$expMsg7 = wfMessage( 'usersignup-error-empty-email' )->escaped();
			$expErrParam7 = 'email';

			// error - invalid email ( isValidEmailAddr() = false )
			$reqParams8 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'email' => 'testEmail',
			);
			$expMsg8 = wfMessage( 'userlogin-error-invalidemailaddress' )->escaped();

			// error - birthdate not select
			$reqParams9 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => -1,
				'birthmonth' => -1,
				'birthday' => -1,
			);
			$expMsg9 = wfMessage( 'userlogin-error-userlogin-bad-birthday' )->escaped();
			$expErrParam9 = 'birthday';

			// error - birthday not select
			$reqParams10 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 2012,
				'birthmonth' => 11,
				'birthday' => -1,
			);

			// error - birthmonth not select
			$reqParams11 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 2012,
				'birthmonth' => -1,
				'birthday' => 22,
			);

			// error - birthyear not select
			$reqParams12 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => -1,
				'birthmonth' => 11,
				'birthday' => 22,
			);

			// error - invalid age
			$reqParams13 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 2011,
				'birthmonth' => 11,
				'birthday' => 22,
			);
			$expMsg13 = wfMessage( 'userlogin-error-userlogin-unable-info' )->escaped();

			// not pass byemail -- call addNewAccount()
			$reqParams14 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 1999,
				'birthmonth' => 11,
				'birthday' => 22,
			);
			$mockUserLoginForm14 = array(
				'load' => null,
				'addNewAccount' => array(
					'mockExpTimes' => 1,
					'mockExpValues' => null,
				),
				'addNewAccountMailPassword' => array(
					'mockExpTimes' => 0,
					'mockExpValues' => null,
				),
			);

			// pass byemail -- call addNewAccountMailPassword()
			$reqParams15 = array(
				'userloginext01' => self::TEST_DNE_USER,
				'userloginext02' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 1999,
				'birthmonth' => 11,
				'birthday' => 22,
				'byemail' => 1,
			);
			$mockUserLoginForm15 = array(
				'load' => null,
				'addNewAccount' => array(
					'mockExpTimes' => 0,
					'mockExpValues' => null,
				),
				'addNewAccountMailPassword' => array(
					'mockExpTimes' => 1,
					'mockExpValues' => null,
				),
			);

			//error - not empty fake username
			$reqParams16 = array(
				'username' => '123',
			);
			$expMsg16 = null;
			$expErrParam16 = null;

			//error - not empty fake username
			$reqParams17 = array(
				'password' => '123',
			);

			return array(
				'error - empty username' =>
				array( $reqParams1, $mockUserParams1, $mockUserLoginForm1, 'error', $expMsg1, $expErrParam1 ),
				'error - username exists in temp user' =>
				array( $reqParams2, $mockUserParams2, $mockUserLoginForm1, 'error', $expMsg2, $expErrParam1 ),
				'error - username length exceed limit' =>
				array( $reqParams3, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg3, $expErrParam1 ),
				'error - invalid user name ( getCanonicalName() = false for creatable )' =>
				array( $reqParams4, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg4, $expErrParam1 ),
				'error - empty password' =>
				array( $reqParams5, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg5, $expErrParam2 ),
				'error - password length exceed limit' =>
				array( $reqParams6, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg6, $expErrParam2 ),
				'error - empty email' =>
				array( $reqParams7, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg7, $expErrParam7 ),
				'error - invalid email ( isValidEmailAddr() = false )' =>
				array( $reqParams8, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg8, $expErrParam7 ),
				'error - birthdate not select' =>
				array( $reqParams9, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - birthday not select' =>
				array( $reqParams10, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - birthmonth not select' =>
				array( $reqParams11, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - birthyear not select' =>
				array( $reqParams12, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - invalid age' =>
				array( $reqParams13, $mockUserParams3, $mockUserLoginForm1, 'error', $expMsg13, $expErrParam9 ),
				'not pass byemail -- call addNewAccount() ONCE' =>
				array( $reqParams14, $mockUserParams3, $mockUserLoginForm14, 'ok', '', '' ),
				'pass byemail -- call addNewAccountMailPassword() ONCE' =>
				array( $reqParams15, $mockUserParams3, $mockUserLoginForm15, 'ok', '', '' ),
				'error - not empty fake username' =>
				array( $reqParams16, $mockUserParams1, $mockUserLoginForm1, 'error', $expMsg16, $expErrParam16 ),
				'error - not empty fake password' =>
				array( $reqParams17, $mockUserParams1, $mockUserLoginForm1, 'error', $expMsg16, $expErrParam16 ),
			);
		}

		/**
		 * @dataProvider changeUnconfirmedUserEmailDataProvider
		 */
		public function testChangeTempUserEmail( $params, $mockUserParams, $mockSessionParams, $mockCacheParams, $expResult, $expMsg, $expErrParam ) {
			// setup
			$this->setUpMockObject( 'User', $mockUserParams, true );

			$this->setUpSession( $mockSessionParams );

			if ( is_int($mockCacheParams) ) {
				$mockCacheParams = array(
					'get' => UserLoginHelper::LIMIT_EMAIL_CHANGES + $mockCacheParams,
				);
			}
			$this->setUpMock( $mockCacheParams );

			//Set up empty TempUser
			$this->setUpMockObject( 'TempUser', false, true );

			// test
			$response = $this->app->sendRequest( 'UserSignupSpecial', 'changeUnconfirmedUserEmail', $params );

			$responseData = $response->getVal( 'result' );
			$this->assertEquals( $expResult, $responseData, 'result' );

			$responseData = $response->getVal( 'msg' );
			$this->assertEquals( $expMsg, $responseData, 'msg' );

			$responseData = $response->getVal( 'errParam' );
			$this->assertEquals( $expErrParam, $responseData, 'errParam' );

			// tear down
			$this->tearDownSession( $mockSessionParams );
		}

		public function changeUnconfirmedUserEmailDataProvider() {
			// error - empty email
			$params1 = array(
				'email' => '',
			);
			$mockUserParams1 = array(
				'getId' => 0,
			);
			$mockSessionParams1 = null;
			$mockCacheParams1 = null;
			$expMsg1 = wfMessage( 'usersignup-error-empty-email' )->escaped();
			$expErrParam1 = 'email';

			// error - invalid email
			$params2 = array(
				'email' => 'testEmail',
			);
			$expMsg2 = wfMessage( 'usersignup-error-invalid-email' )->escaped();

			// error - empty username
			$params3 = array(
				'email' => self::TEST_EMAIL,
				'username' => '',
			);
			$expMsg3 = wfMessage( 'userlogin-error-noname' )->escaped();
			$expErrParam3 = 'username';

			// error - temp user does not exist
			$params4 = array(
				'email' => self::TEST_EMAIL,
				'username' => self::TEST_USERNAME,
			);
			$expMsg4 = wfMessage( 'userlogin-error-nosuchuser' )->escaped();

			// error - temp user id does not match with one in $_SESSION
			$mockUserParams5 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
//					'mEmail' => self::TEST_EMAIL,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true )
					)
				)
			);
			$mockSessionParams5 = array(
				'notConfirmedUserId' => 123,
			);
			$expMsg5 = wfMessage( 'usersignup-error-invalid-user' )->escaped();

			// error - email changes exceed limit
			$mockSessionParams6 = array(
				'notConfirmedUserId' => 11,
			);
			$mockCacheParams6 = 1;
			$expMsg6 = wfMessage( 'usersignup-error-too-many-changes' )->escaped();

			// error - email changes == limit
			$mockCacheParams6v2 = 0;

			// success - new email == current email ( email changes < limit ) -- do nothing
			$mockUserParams7 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => null,
				'setEmail' => array(
					'mockExpTimes' => 0,
					'mockExpValues' => null,
				),
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
					'mEmail' => self::TEST_EMAIL,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true )
					)
				)
			);
			$mockCacheParams7 = -1;
			$expMsg7 = wfMessage( 'usersignup-reconfirmation-email-sent', self::TEST_EMAIL )->escaped();

			// success - new email != current email ( email changes < limit )
			$status8 = Status::newGood();
			$mockUserParams8 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => $status8,
				'setEmail' => array(
					'mockExpTimes' => 1,
					'mockExpValues' => null,
				),
				'saveSettings' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
					'mEmail' => 'devbox+test111@wikia-inc.com',
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true ),
						array( 'language', null, false, 'en' )
					)
				)
			);

			return array (
				// error - empty email
				array( $params1, $mockUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg1, $expErrParam1 ),
				// error - invalid email
				array( $params2, $mockUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg2, $expErrParam1 ),
				// error - empty username
				array( $params3, $mockUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg3, $expErrParam3 ),
				// error - temp user does not exist
				array( $params4, $mockUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg4, $expErrParam3 ),
				// error - temp user id does not match with one in $_SESSION
				array( $params4, $mockUserParams5, $mockSessionParams5, $mockCacheParams1, 'invalidsession', $expMsg5, $expErrParam3 ),
				// error - email changes exceed limit
				array( $params4, $mockUserParams5, $mockSessionParams6, $mockCacheParams6, 'error', $expMsg6, $expErrParam1 ),
				// error - email changes == limit
				array( $params4, $mockUserParams5, $mockSessionParams6, $mockCacheParams6v2, 'error', $expMsg6, $expErrParam1 ),
				// success - new email == current email ( email changes < limit ) -- do nothing
				array( $params4, $mockUserParams7, $mockSessionParams6, $mockCacheParams7, 'ok', $expMsg7, null ),
				// success - new email != current email ( email changes < limit )
				array( $params4, $mockUserParams8, $mockSessionParams6, $mockCacheParams7, 'ok', $expMsg7, null ),
			);
		}

		/**
		 * @dataProvider sendConfirmationEmailDataProvider
		 */
		public function testSendConfirmationEmail( $mockWebRequestParams, $params, $mockEmailAuth, $mockUserParams, $mockSessionParams, $mockCacheParams, $mockMessagesMap, $mockMsgExt, $expResult, $expMsg, $expMsgEmail, $expErrParam, $expHeading, $expSubheading ) {
			// setup
			$this->setUpMockObject( 'WebRequest', $mockWebRequestParams, false, 'wgRequest');
			$this->setUpMockObject( 'User', $mockUserParams, true );

			$this->setUpSession( $mockSessionParams );

			if ( array_key_exists('byemail', $params) && $params['byemail'] ) {
				$mockMsgExtCount = 2;
			} else {
				$mockMsgExtCount = 1;
			}

			if ( isset($mockUserParams['sendConfirmationMail']['mockExpTimes']) ) {
				$mockMsgExtCount += 7;
			}

			$this->mockGlobalVariable( 'wgEmailAuthentication', $mockEmailAuth );
			$this->mockWfMessage( $mockMessagesMap );

			if ( is_int($mockCacheParams) ) {
				$mockCacheParams = array(
					'get' => UserLoginHelper::LIMIT_EMAILS_SENT + $mockCacheParams,
				);
			}
			$this->setUpMock( $mockCacheParams );

			// test
			$response = $this->app->sendRequest( 'UserSignupSpecial', 'sendConfirmationEmail', $params );

			$responseData = $response->getVal( 'result' );
			$this->assertEquals( $expResult, $responseData, 'result' );

			$responseData = $response->getVal( 'msg' );
			$this->assertEquals( $expMsg, $responseData, 'msg' );

			$responseData = $response->getVal( 'msgEmail' );
			$this->assertEquals( $expMsgEmail, $responseData, 'msgEmail' );

			$responseData = $response->getVal( 'errParam' );
			$this->assertEquals( $expErrParam, $responseData, 'errParam' );

			$responseData = $response->getVal( 'heading' );
			$this->assertEquals( $expHeading, $responseData, 'heading' );

			$responseData = $response->getVal( 'subheading' );
			$this->assertEquals( $expSubheading, $responseData, 'subheading' );

			// tear down
			$this->tearDownSession( $mockSessionParams );
		}

		/**
		 * @dataProvider isTempUserDataProvider
		 */
		public function testIsTempUser( $mockTempUserParams, $globalDisableTempUserMock, $username, $expResult ) {

			$this->mockGlobalVariable( 'wgDisableTempUser', $globalDisableTempUserMock );
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );

			//Clear static isTempUser as it stays set between tests
			UserLoginHelper::clearIsTempUserStatic($username);

			// test
			$responseData = UserLoginHelper::isTempUser($username);

			$this->assertEquals( $expResult, $responseData, 'result' );

		}

		public function sendConfirmationEmailDataProvider() {
			// GET + temp user does not exist + not pass byemail
			$mockWebRequest1 = array(
				'wasPosted' => false,
			);
			$params1 = array(
				'username' => self::TEST_USERNAME,
			);
			$mockEmailAuth1 = '';
			$mockUser1 = null;
			$mockSession1 = null;
			$mockCache1 = null;
			$mockMessagesMap1 = array(
				array('usersignup-confirmation-email-sent', self::TEST_USERNAME),
				array('usersignup-confirmation-heading'),
				array('usersignup-confirmation-subheading'),
			);
			$mockMsgExt1 = 'usersignup-confirmation-email-sent';
			$expMsg1 = 'usersignup-confirmation-email-sent';
			$expMsgEmail1 = '';
			$expHeading1 = 'usersignup-confirmation-heading';
			$expSubheading1 = 'usersignup-confirmation-subheading';

			// GET + temp user exists + not pass byemail
			$mockUser2 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 0,
					'mName' => self::TEST_USERNAME,
					'mEmail' => self::TEST_EMAIL,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true )
					)
				)
			);

			// GET + temp user does not exist + pass byemail
			$params3 = array(
				'username' => self::TEST_USERNAME,
				'byemail' => 1,
			);
			$mockMessagesMap3 = array(
				array('usersignup-account-creation-email-sent', self::TEST_USERNAME, self::TEST_USERNAME),
				array('usersignup-account-creation-heading'),
				array('usersignup-account-creation-subheading', self::TEST_USERNAME),
			);
			$mockMsgExt3 = 'usersignup-account-creation-email-sent';
			$expMsg3 = $mockMsgExt3;
			$expHeading3 = 'usersignup-account-creation-heading';
			$expSubheading3 = 'usersignup-account-creation-subheading';

			// GET + temp user exists + pass byemail

			// POST + temp user does not exist + empty action
			$mockWebRequest5 = array(
				'wasPosted' => false,
			);
			$params5 = array(
				'username' => self::TEST_USERNAME,
				'action' => '',
			);

			// POST + temp user exist + empty action

			// test resend confirmation email
			// error - empty username ( POST + action = resendconfirmation )
			$mockWebRequest101 = array(
				'wasPosted' => true,
			);
			$params101 = array(
				'username' => '',
				'action' => 'resendconfirmation',
			);
			$mockMessagesMap101 = array(
				array('userlogin-error-noname'),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg101 = 'userlogin-error-noname';
			$expHeading101 = 'usersignup-confirmation-heading-email-resent';

			// error - temp user does not exist ( POST + action = resendconfirmation )
			$params102 = array(
				'username' => self::TEST_USERNAME,
				'action' => 'resendconfirmation',
			);
			$mockMessagesMap102 = array(
				array('userlogin-error-nosuchuser'),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg102 = 'userlogin-error-nosuchuser';

			// error - temp user id does not match with one in $_SESSION ( POST + action = resendconfirmation )
			$mockUser3 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
					'mEmail' => self::TEST_EMAIL,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true )
					)
				)
			);
			$mockSession103 = array(
				'notConfirmedUserId' => 123,
			);
			$mockMessagesMap103 = array(
				array('usersignup-error-invalid-user'),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg103 = 'usersignup-error-invalid-user';

			// error - $wgEmailAuthentication == false ( POST + action = resendconfirmation )
			$mockSession104 = array(
				'notConfirmedUserId' => 11,
			);
			$mockEmailAuth104 = false;
			$mockMessagesMap104 = array(
				array('usersignup-error-invalid-email'),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg104 = 'usersignup-error-invalid-email';

			// error - invalid email ( POST + action = resendconfirmation )
			$mockEmailAuth105 = true;
			$mockUser4 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
					'mEmail' => 'testEmail',
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true )
					)
				)
			);

			// error - email is confirmed ( POST + action = resendconfirmation )
			$mockUser5 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => true,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
					'mEmail' => self::TEST_EMAIL,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true )
					)
				)
			);
			$mockMessagesMap106 = array(
				array('usersignup-error-already-confirmed'),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg106 = 'usersignup-error-already-confirmed';

			// error - pending email + email sent exceed limit ( POST + action = resendconfirmation )
			$mockUser6 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'isEmailConfirmationPending' => true,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => self::TEST_USERNAME,
					'mEmailTokenExpires' => wfTimestamp( TS_MW, strtotime('+7 days') ),
					'mEmail' => self::TEST_EMAIL,
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true ),
						array( 'language', null, false, 'en' )
					)
				)
			);
			$mockCache107 = 1;
			$mockMessagesMap107 = array(
				array('usersignup-error-throttled-email'),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg107 = 'usersignup-error-throttled-email';

			// error - email sent == limit ( POST + action = resendconfirmation )
			$mockCache108 = 0;

			// success - email sent < limit ( POST + action = resendconfirmation )
			$mockCache109 = -1;
			$status109 = Status::newGood();
			$mockMessagesMap7 = array(
				array('usersignup-confirmation-email-sent', self::TEST_EMAIL),
				array('usersignup-confirmation-heading-email-resent'),
				array('usersignup-confirmation-subheading'),
			);
			$expMsg7 = 'usersignup-confirmation-email-sent';
			$mockUser7 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'isEmailConfirmationPending' => true,
				'sendConfirmationMail' => array(
					'mockExpTimes' => 1,
					'mockExpValues' => $status109,
				),
				'params' => array(
					'mId' => 11,
					'mName' => 'TempUser11',
					'mEmailTokenExpires' => wfTimestamp( TS_MW, strtotime('+7 days') ),
					'mEmail' => self::TEST_EMAIL
				),
				'mockValueMap' => array(
					'getOption' => array(//array of parameters and returned results
						array( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null, false, true ),
						array( 'language', null, false, 'en' )
					)
				)
			);


			return array (
				'GET + temp user does not exist + not pass byemail' =>
				array($mockWebRequest1, $params1, $mockEmailAuth1, $mockUser1, $mockSession1, $mockCache1, $mockMessagesMap1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),
				'GET + temp user exists + not pass byemail' =>
				array($mockWebRequest1, $params1, $mockEmailAuth1, $mockUser1, $mockSession1, $mockCache1, $mockMessagesMap1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),
				'GET + temp user does not exist + pass byemail' =>
				array($mockWebRequest1, $params3, $mockEmailAuth1, $mockUser1, $mockSession1, $mockCache1, $mockMessagesMap3, $mockMsgExt3, 'ok', $expMsg3, $expMsgEmail1, '', $expHeading3, $expSubheading3),
				'GET + temp user exists + pass byemail' =>
				array($mockWebRequest1, $params3, $mockEmailAuth1, $mockUser2, $mockSession1, $mockCache1, $mockMessagesMap3, $mockMsgExt3, 'ok', $expMsg3, $expMsgEmail1, '', $expHeading3, $expSubheading3),
				'POST + temp user does not exist + empty action' =>
				array($mockWebRequest5, $params5, $mockEmailAuth1, $mockUser1, $mockSession1, $mockCache1, $mockMessagesMap1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),
				'POST + temp user exist + empty action' =>
				array($mockWebRequest5, $params5, $mockEmailAuth1, $mockUser2, $mockSession1, $mockCache1, $mockMessagesMap1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),

				// test resend confirmation email
				'error - empty username ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params101, $mockEmailAuth1, $mockUser1, $mockSession1, $mockCache1, $mockMessagesMap101, '', 'error', $expMsg101, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - temp user does not exist ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth1, $mockUser1, $mockSession1, $mockCache1, $mockMessagesMap102, '', 'error', $expMsg102, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - temp user id does not match with one in $_SESSION ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth1, $mockUser3, $mockSession103, $mockCache1, $mockMessagesMap103, '', 'invalidsession', $expMsg103, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - $wgEmailAuthentication == false ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth104, $mockUser3, $mockSession104, $mockCache1, $mockMessagesMap104, '', 'error', $expMsg104, $expMsgEmail1, '', $expHeading101, $expSubheading1),

				'error - invalid email ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser4, $mockSession104, $mockCache1, $mockMessagesMap104, '', 'error', $expMsg104, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - email is confirmed ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser5, $mockSession104, $mockCache1, $mockMessagesMap106, '', 'error', $expMsg106, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - pending email + email sent exceed limit ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser6, $mockSession104, $mockCache107, $mockMessagesMap107, '', 'error', $expMsg107, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - email sent == limit ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser6, $mockSession104, $mockCache108, $mockMessagesMap107, '', 'error', $expMsg107, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'success - email sent < limit ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser7, $mockSession104, $mockCache109, $mockMessagesMap7, $mockMsgExt1, 'ok', $expMsg7, $expMsgEmail1, '', $expHeading101, $expSubheading1),
			);
		}

		public function isTempUserDataProvider() {

			// TempUser globally disabled wgDisableTempUser = true
			$globalDisableTempUserMock = true;
			$globalDisableTempUserMock2 = false;

			$username = self::TEST_USERNAME;

			// TempUser exists
			$mockTempUserParams1 = array(
				'getTempUserFromName' => true
			);

			// TempUser doesn't exist
			$mockTempUserParams2 = false;

			return array (
				'TempUser globally disabled wgDisableTempUser = true' =>
				array($mockTempUserParams1, $globalDisableTempUserMock, $username, false),
				'TempUser exists' =>
				array($mockTempUserParams1, $globalDisableTempUserMock2, $username, true),
				'TempUser doesnt exist' =>
				array($mockTempUserParams2, $globalDisableTempUserMock2, $username, false),
			);
		}

	}
