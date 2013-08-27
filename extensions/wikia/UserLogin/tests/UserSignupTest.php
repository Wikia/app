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
				'get' => null,
				'delete' => null,
				'add' => null,
				'incr' => null,
			);
			if ( is_array($cacheParams) ) {
				$memcParams = $memcParams + $cacheParams;
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
		public function testSignup( $requestParams, $mockTempUserParams, $mockUserLoginFormParams, $expResult, $expMsg, $expErrParam ) {
			// setup
			$this->setUpRequest( $requestParams );
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );

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
				'username' => '',
			);
			$mockTempUserParams1 = null;
			$mockUserLoginForm1 = null;
			$expMsg1 = wfMsg( 'userlogin-error-noname' );
			$expErrParam1 = 'username';

			// error - username exists in temp user
			$reqParams2 = array(
				'username' => self::TEST_USERNAME,
			);
			$mockTempUserParams2 = array(
				'params' => array(
					'user_id' => 0,
					'user_name' => self::TEST_USERNAME,
					'user_wiki_id' => 0,
				),
			);
			$expMsg2 = wfMsg( 'userlogin-error-userexists' );

			// error - username length exceed limit
			$reqParams3 = array(
				'username' => 'test123456789test123456789test123456789test123456789test123456789',
			);
			$mockTempUserParams3 = false;
			$expMsg3 = wfMsg( 'usersignup-error-username-length', $wgWikiaMaxNameChars );

			// error - invalid user name ( getCanonicalName() = false for creatable )
			$reqParams4 = array(
				'username' => '#'.self::TEST_USERNAME.'#',
			);
			$expMsg4 = wfMsg( 'usersignup-error-symbols-in-username' );

			// error - empty password
			$reqParams5 = array(
				'username' => self::TEST_DNE_USER,
				'email' => self::TEST_EMAIL,
				'password' => '',
			);
			$expMsg5 = wfMsg( 'userlogin-error-wrongpasswordempty' );
			$expErrParam2 = 'password';

			// error - password length exceed limit
			$reqParams6 = array(
				'username' => self::TEST_DNE_USER,
				'email' => self::TEST_EMAIL,
				'password' => 'testPasswordtestPasswordtestPasswordtestPasswordtestPasswordtestPassword',
			);
			$expMsg6 = wfMsg( 'usersignup-error-password-length' );

			// error - empty email
			$reqParams7 = array(
				'username' => self::TEST_DNE_USER,
				'email' => '',
			);
			$expMsg7 = wfMsg( 'usersignup-error-empty-email' );
			$expErrParam7 = 'email';

			// error - invalid email ( isValidEmailAddr() = false )
			$reqParams8 = array(
				'username' => self::TEST_DNE_USER,
				'email' => 'testEmail',
			);
			$expMsg8 = wfMsg( 'userlogin-error-invalidemailaddress' );

			// error - birthdate not select
			$reqParams9 = array(
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => -1,
				'birthmonth' => -1,
				'birthday' => -1,
			);
			$expMsg9 = wfMsg( 'userlogin-error-userlogin-bad-birthday' );
			$expErrParam9 = 'birthday';

			// error - birthday not select
			$reqParams10 = array(
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 2012,
				'birthmonth' => 11,
				'birthday' => -1,
			);

			// error - birthmonth not select
			$reqParams11 = array(
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 2012,
				'birthmonth' => -1,
				'birthday' => 22,
			);

			// error - birthyear not select
			$reqParams12 = array(
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => -1,
				'birthmonth' => 11,
				'birthday' => 22,
			);

			// error - invalid age
			$reqParams13 = array(
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
				'email' => self::TEST_EMAIL,
				'birthyear' => 2011,
				'birthmonth' => 11,
				'birthday' => 22,
			);
			$expMsg13 = wfMsg( 'userlogin-error-userlogin-unable-info' );

			// not pass byemail -- call addNewAccount()
			$reqParams14 = array(
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
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
				'username' => self::TEST_DNE_USER,
				'password' => 'testPassword',
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

			return array(
				'error - empty username' =>
				array( $reqParams1, $mockTempUserParams1, $mockUserLoginForm1, 'error', $expMsg1, $expErrParam1 ),
				'error - username exists in temp user' =>
				array( $reqParams2, $mockTempUserParams2, $mockUserLoginForm1, 'error', $expMsg2, $expErrParam1 ),
				'error - username length exceed limit' =>
				array( $reqParams3, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg3, $expErrParam1 ),
				'error - invalid user name ( getCanonicalName() = false for creatable )' =>
				array( $reqParams4, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg4, $expErrParam1 ),
				'error - empty password' =>
				array( $reqParams5, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg5, $expErrParam2 ),
				'error - password length exceed limit' =>
				array( $reqParams6, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg6, $expErrParam2 ),
				'error - empty email' =>
				array( $reqParams7, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg7, $expErrParam7 ),
				'error - invalid email ( isValidEmailAddr() = false )' =>
				array( $reqParams8, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg8, $expErrParam7 ),
				'error - birthdate not select' =>
				array( $reqParams9, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - birthday not select' =>
				array( $reqParams10, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - birthmonth not select' =>
				array( $reqParams11, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - birthyear not select' =>
				array( $reqParams12, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg9, $expErrParam9 ),
				'error - invalid age' =>
				array( $reqParams13, $mockTempUserParams3, $mockUserLoginForm1, 'error', $expMsg13, $expErrParam9 ),
				'not pass byemail -- call addNewAccount() ONCE' =>
				array( $reqParams14, $mockTempUserParams3, $mockUserLoginForm14, 'ok', '', '' ),
				'pass byemail -- call addNewAccountMailPassword() ONCE' =>
				array( $reqParams15, $mockTempUserParams3, $mockUserLoginForm15, 'ok', '', '' ),
			);
		}

		/**
		 * @dataProvider changeTempUserEmailDataProvider
		 */
		public function testChangeTempUserEmail( $params, $mockUserParams, $mockTempUserParams, $mockSessionParams, $mockCacheParams, $expResult, $expMsg, $expErrParam ) {
			// setup
			$this->setUpMockObject( 'User', $mockUserParams, true );
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );

			$this->setUpSession( $mockSessionParams );

			if ( is_int($mockCacheParams) ) {
				$mockCacheParams = array(
					'get' => UserLoginHelper::LIMIT_EMAIL_CHANGES + $mockCacheParams,
				);
			}
			$this->setUpMock( $mockCacheParams );

			// test
			$response = $this->app->sendRequest( 'UserSignupSpecial', 'changeTempUserEmail', $params );

			$responseData = $response->getVal( 'result' );
			$this->assertEquals( $expResult, $responseData, 'result' );

			$responseData = $response->getVal( 'msg' );
			$this->assertEquals( $expMsg, $responseData, 'msg' );

			$responseData = $response->getVal( 'errParam' );
			$this->assertEquals( $expErrParam, $responseData, 'errParam' );

			// tear down
			$this->tearDownSession( $mockSessionParams );
		}

		public function changeTempUserEmailDataProvider() {
			// error - empty email
			$params1 = array(
				'email' => '',
			);
			$mockUserParams1 = array(
				'getId' => 0,
			);
			$mockTempUserParams1 = null;
			$mockSessionParams1 = null;
			$mockCacheParams1 = null;
			$expMsg1 = wfMsg( 'usersignup-error-empty-email' );
			$expErrParam1 = 'email';

			// error - invalid email
			$params2 = array(
				'email' => 'testEmail',
			);
			$expMsg2 = wfMsg( 'usersignup-error-invalid-email' );

			// error - empty username
			$params3 = array(
				'email' => self::TEST_EMAIL,
				'username' => '',
			);
			$expMsg3 = wfMsg( 'userlogin-error-noname' );
			$expErrParam3 = 'username';

			// error - temp user does not exist
			$params4 = array(
				'email' => self::TEST_EMAIL,
				'username' => self::TEST_USERNAME,
			);
			$mockTempUserParams4 = false;
			$expMsg4 = wfMsg( 'userlogin-error-nosuchuser' );

			// error - temp user id does not match with one in $_SESSION
			$mockTempUserParams5 = array(
				'setTempUserSession' => null,
				'saveSettingsTempUserToUser' => null,
				'updateData' => null,
				'params' => array(
					'user_id' => 11,
					'user_name' => self::TEST_USERNAME,
				),
			);
			$mockSessionParams5 = array(
				'tempUserId' => 123,
			);
			$expMsg5 = wfMsg( 'usersignup-error-invalid-user' );

			// error - email changes exceed limit
			$mockSessionParams6 = array(
				'tempUserId' => 11,
			);
			$mockCacheParams6 = 1;
			$expMsg6 = wfMsg( 'usersignup-error-too-many-changes' );

			// error - email changes == limit
			$mockCacheParams6v2 = 0;

			// success - new email == current email ( email changes < limit ) -- do nothing
			$mockTempUserParams7 = array(
				'setTempUserSession' => null,
				'saveSettingsTempUserToUser' => null,
				'updateData' => array(
					'mockExpTimes' => 0,
					'mockExpValues' => null,
				),
				'params' => array(
					'user_id' => 11,
					'user_name' => self::TEST_USERNAME,
					'user_email' => self::TEST_EMAIL,
				),
			);
			$mockCacheParams7 = -1;
			$expMsg7 = wfMsg( 'usersignup-reconfirmation-email-sent', htmlspecialchars(self::TEST_EMAIL) );

			// success - new email != current email ( email changes < limit )
			$status8 = Status::newGood();
			$mockUserParams8 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'sendReConfirmationMail' => $status8,
			);
			$mockTempUserParams8 = array(
				'setTempUserSession' => null,
				'saveSettingsTempUserToUser' => null,
				'updateData' => array(
					'mockExpTimes' => 1,
					'mockExpValues' => null,
				),
				'params' => array(
					'user_id' => 11,
					'user_name' => self::TEST_USERNAME,
					'user_email' => 'devbox+test111@wikia-inc.com',
				),
			);

			return array (
				// error - empty email
				array( $params1, $mockUserParams1, $mockTempUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg1, $expErrParam1 ),
				// error - invalid email
				array( $params2, $mockUserParams1, $mockTempUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg2, $expErrParam1 ),
				// error - empty username
				array( $params3, $mockUserParams1, $mockTempUserParams1, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg3, $expErrParam3 ),
				// error - temp user does not exist
				array( $params4, $mockUserParams1, $mockTempUserParams4, $mockSessionParams1, $mockCacheParams1, 'error', $expMsg4, $expErrParam3 ),
				// error - temp user id does not match with one in $_SESSION
				array( $params4, $mockUserParams1, $mockTempUserParams5, $mockSessionParams5, $mockCacheParams1, 'invalidsession', $expMsg5, $expErrParam3 ),
				// error - email changes exceed limit
				array( $params4, $mockUserParams1, $mockTempUserParams5, $mockSessionParams6, $mockCacheParams6, 'error', $expMsg6, $expErrParam1 ),
				// error - email changes == limit
				array( $params4, $mockUserParams1, $mockTempUserParams5, $mockSessionParams6, $mockCacheParams6v2, 'error', $expMsg6, $expErrParam1 ),
				// success - new email == current email ( email changes < limit ) -- do nothing
				array( $params4, $mockUserParams1, $mockTempUserParams7, $mockSessionParams6, $mockCacheParams7, 'ok', $expMsg7, null ),
				// success - new email != current email ( email changes < limit )
				array( $params4, $mockUserParams8, $mockTempUserParams8, $mockSessionParams6, $mockCacheParams7, 'ok', $expMsg7, null ),
			);
		}

		/**
		 * @dataProvider sendConfirmationEmailDataProvider
		 */
		public function testSendConfirmationEmail( $mockWebRequestParams, $params, $mockEmailAuth, $mockUserParams, $mockTempUserParams, $mockSessionParams, $mockCacheParams, $mockMsgExt, $expResult, $expMsg, $expMsgEmail, $expErrParam, $expHeading, $expSubheading ) {
			// setup
			$this->setUpMockObject( 'WebRequest', $mockWebRequestParams, false, 'wgRequest');
			$this->setUpMockObject( 'User', $mockUserParams, true );
			$this->setUpMockObject( 'TempUser', $mockTempUserParams, true );

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
			$this->getGlobalFunctionMock( 'wfMsgExt' )
				->expects( $this->exactly( $mockMsgExtCount ) )
				->method( 'wfMsgExt' )
				->will( $this->returnValue( $mockMsgExt ) );

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
			$mockTempUser1 = false;
			$mockSession1 = null;
			$mockCache1 = null;
			$mockMsgExt1 = wfMsg( 'usersignup-confirmation-email-sent', self::TEST_USERNAME );
			$expMsg1 = wfMsg( 'usersignup-confirmation-email-sent', self::TEST_USERNAME );
			$expMsgEmail1 = '';
			$expHeading1 = wfMsg( 'usersignup-confirmation-heading' );
			$expSubheading1 = wfMsg( 'usersignup-confirmation-subheading' );

			// GET + temp user exists + not pass byemail
			$mockTempUser2 = array(
				'params' => array(
					'user_id' => 0,
					'user_name' => self::TEST_USERNAME,
					'user_email' => self::TEST_EMAIL,
				),
			);

			// GET + temp user does not exist + pass byemail
			$params3 = array(
				'username' => self::TEST_USERNAME,
				'byemail' => 1,
			);
			$mockMsgExt3 = wfMsg( 'usersignup-account-creation-email-sent', self::TEST_USERNAME, self::TEST_USERNAME );
			$expMsg3 = $mockMsgExt3;
			$expHeading3 = wfMsg( 'usersignup-account-creation-heading' );
			$expSubheading3 = wfMsg( 'usersignup-account-creation-subheading', self::TEST_USERNAME );

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
			$expMsg101 = wfMsg( 'userlogin-error-noname' );
			$expHeading101 = wfMsg( 'usersignup-confirmation-heading-email-resent' );

			// error - temp user does not exist ( POST + action = resendconfirmation )
			$params102 = array(
				'username' => self::TEST_USERNAME,
				'action' => 'resendconfirmation',
			);
			$mockTempUser102 = false;
			$expMsg102 = wfMsg( 'userlogin-error-nosuchuser' );

			// error - temp user id does not match with one in $_SESSION ( POST + action = resendconfirmation )
			$mockTempUserParams103 = array(
				'setTempUserSession' => null,
				'saveSettingsTempUserToUser' => null,
				'updateData' => null,
				'params' => array(
					'user_id' => 11,
					'user_name' => self::TEST_USERNAME,
					'user_email' => self::TEST_EMAIL,
				),
			);
			$mockSession103 = array(
				'tempUserId' => 123,
			);
			$expMsg103 = wfMsg( 'usersignup-error-invalid-user' );

			// error - $wgEmailAuthentication == false ( POST + action = resendconfirmation )
			$mockSession104 = array(
				'tempUserId' => 11,
			);
			$mockEmailAuth104 = false;
			$expMsg104 = wfMsg( 'usersignup-error-invalid-email' );

			// error - invalid email ( POST + action = resendconfirmation )
			$mockEmailAuth105 = true;
			$mockTempUserParams105 = array(
				'setTempUserSession' => null,
				'saveSettingsTempUserToUser' => null,
				'updateData' => null,
				'params' => array(
					'user_id' => 11,
					'user_name' => self::TEST_USERNAME,
					'user_email' => 'testEmail',
				),
			);

			// error - email is confirmed ( POST + action = resendconfirmation )
			$mockUser106 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => true,
				'sendConfirmationMail' => null,
				'params' => array(
					'mId' => 11,
					'mName' => 'TempUser11',
				)
			);
			$mockTempUserParams106 = array(
				'setTempUserSession' => null,
				'saveSettingsTempUserToUser' => null,
				'updateData' => null,
				'params' => array(
					'user_id' => 11,
					'user_name' => self::TEST_USERNAME,
					'user_email' => self::TEST_EMAIL,
				),
			);
			$expMsg106 = wfMsg( 'usersignup-error-already-confirmed' );

			// error - pending email + email sent exceed limit ( POST + action = resendconfirmation )
			$mockUser107 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'isEmailConfirmationPending' => true,
				'sendConfirmationMail' => null,
				'getOption' => 'en',
				'params' => array(
					'mId' => 11,
					'mName' => 'TempUser11',
					'mEmailTokenExpires' => wfTimestamp( TS_MW, strtotime('+7 days') ),
				),
			);
			$mockCache107 = 1;
			$expMsg107 = wfMsg( 'usersignup-error-throttled-email' );

			// error - email sent == limit ( POST + action = resendconfirmation )
			$mockCache108 = 0;

			// success - email sent < limit ( POST + action = resendconfirmation )
			$mockCache109 = -1;
			$status109 = Status::newGood();
			$mockUser109 = array(
				'load' => null,
				'loadFromDatabase' => null,
				'isEmailConfirmed' => false,
				'isEmailConfirmationPending' => true,
				'getOption' => 'en',
				'sendConfirmationMail' => array(
					'mockExpTimes' => 1,
					'mockExpValues' => $status109,
				),
				'params' => array(
					'mId' => 11,
					'mName' => 'TempUser11',
					'mEmailTokenExpires' => wfTimestamp( TS_MW, strtotime('+7 days') ),
				)
			);

			return array (
				'GET + temp user does not exist + not pass byemail' =>
				array($mockWebRequest1, $params1, $mockEmailAuth1, $mockUser1, $mockTempUser1, $mockSession1, $mockCache1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),
				'GET + temp user exists + not pass byemail' =>
				array($mockWebRequest1, $params1, $mockEmailAuth1, $mockUser1, $mockTempUser2, $mockSession1, $mockCache1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),
				'GET + temp user does not exist + pass byemail' =>
				array($mockWebRequest1, $params3, $mockEmailAuth1, $mockUser1, $mockTempUser1, $mockSession1, $mockCache1, $mockMsgExt3, 'ok', $expMsg3, $expMsgEmail1, '', $expHeading3, $expSubheading3),
				'GET + temp user exists + pass byemail' =>
				array($mockWebRequest1, $params3, $mockEmailAuth1, $mockUser1, $mockTempUser2, $mockSession1, $mockCache1, $mockMsgExt3, 'ok', $expMsg3, $expMsgEmail1, '', $expHeading3, $expSubheading3),
				'POST + temp user does not exist + empty action' =>
				array($mockWebRequest5, $params5, $mockEmailAuth1, $mockUser1, $mockTempUser1, $mockSession1, $mockCache1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),
				'POST + temp user exist + empty action' =>
				array($mockWebRequest5, $params5, $mockEmailAuth1, $mockUser1, $mockTempUser2, $mockSession1, $mockCache1, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading1, $expSubheading1),

				// test resend confirmation email
				'error - empty username ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params101, $mockEmailAuth1, $mockUser1, $mockTempUser1, $mockSession1, $mockCache1, '', 'error', $expMsg101, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - temp user does not exist ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth1, $mockUser1, $mockTempUser102, $mockSession1, $mockCache1, '', 'error', $expMsg102, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - temp user id does not match with one in $_SESSION ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth1, $mockUser1, $mockTempUserParams103, $mockSession103, $mockCache1, '', 'invalidsession', $expMsg103, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - $wgEmailAuthentication == false ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth104, $mockUser1, $mockTempUserParams103, $mockSession104, $mockCache1, '', 'error', $expMsg104, $expMsgEmail1, '', $expHeading101, $expSubheading1),

				'error - invalid email ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser1, $mockTempUserParams105, $mockSession104, $mockCache1, '', 'error', $expMsg104, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - email is confirmed ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser106, $mockTempUserParams106, $mockSession104, $mockCache1, '', 'error', $expMsg106, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - pending email + email sent exceed limit ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser107, $mockTempUserParams106, $mockSession104, $mockCache107, '', 'error', $expMsg107, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'error - email sent == limit ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser107, $mockTempUserParams106, $mockSession104, $mockCache108, '', 'error', $expMsg107, $expMsgEmail1, '', $expHeading101, $expSubheading1),
				'success - email sent < limit ( POST + action = resendconfirmation )' =>
				array($mockWebRequest101, $params102, $mockEmailAuth105, $mockUser109, $mockTempUserParams106, $mockSession104, $mockCache109, $mockMsgExt1, 'ok', $expMsg1, $expMsgEmail1, '', $expHeading101, $expSubheading1),
			);
		}

	}
