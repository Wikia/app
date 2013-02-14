<?php
class PhalanxModelTest extends WikiaBaseTest {
	const VALID_USERNAME = 'WikiaUser';
	const VALID_EMAIL = 'moli@wikia-inc.com';

	const INVALID_USERNAME = '75.246.151.75';
	const INVALID_EMAIL = 'test@porn.com';
	
	const VALID_TITLE = 'This_is_good_article';
	const INVALID_TITLE = 'Porn_article';
	
	const VALID_WIKIA_NAME = 'Szumo';
	const INVALID_WIKIA_NAME = 'Pornology';

	const VALID_CONTENT = 'This is good article created by ME';
	const INVALID_CONTENT = 'This is porn article created by YOU';
	const VALID_SUMMARY = 'This is very good summary';
	const INVALID_SUMMARY = 'Invalid summary';

	/***
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		parent::setUp();
	}

	/* PhalanxUserModel class */

	/* match_user method */
	/**
	 * @dataProvider phalanxUserModelDataProvider
	 */
	public function testPhalanxUserModel( $isAnon, $userName, $email, $block, $isOk, $result, $errorMsg ) {		
		// User 
		$userMock = $this->mockClassWithMethods( 'User', 
			array( 
				'isAnon'  => $isAnon,
				'getName' => $userName
			), 
			'newFromName'
		);
		$this->mockGlobalVariable('wgUser', $userMock);

		$model = new PhalanxUserModel( $userMock );
		$user = null;
		$ret = (int) $model->match_user( $user );

		$this->assertEquals( $result, $ret );
	}
	
	/* data providers */
	public function phalanxUserModelDataProvider() {
		/* valid user */
		$validUser = array(
			'isAnon'    => false,
			'getName'   => self::VALID_USERNAME,
			'email'		=> self::VALID_EMAIL,
			'block'     => 0,
			'isOk'      => 0,
			'result'    => 1,
			'error'		=> ''
		);

		/* invalid user */
		$invalidUser = array(
			'isAnon'    => true,
			'getName'   => self::INVALID_USERNAME,
			'email'		=> self::INVALID_EMAIL,
			'block'     => (object) array(
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_USERNAME,
				'reason' => 'Test',
				'exact' => '',
				'caseSensitive' => '', 
				'id' => 4009,
				'language' => '', 
				'authorId' => 184532,
			),
			'isOk'      => 0,
			'result'    => 0,
			'error'		=> wfMsg( 'phalanx-user-block-new-account' )
		);

		/* invalid user */
		$invalidUserEmail = array(
			'isAnon'    => true,
			'getName'   => self::INVALID_USERNAME,
			'email'		=> self::INVALID_EMAIL,
			'block'     => (object) array(
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_EMAIL,
				'reason' => 'Test Email',
				'exact' => '',
				'caseSensitive' => '', 
				'id' => 4010,
				'language' => '', 
				'authorId' => 184532,
			),
			'isOk'      => 0,
			'result'    => 0,
			'error'		=> wfMsg( 'phalanx-user-block-new-account' )
		);

		/* phalanxexempt */
		$okUser = array(                         
			'isAnon'    => false,
			'getName'   => self::VALID_USERNAME,
			'email'		=> self::VALID_EMAIL,
			'block'     => 0,
			'isOk'      => 1,
			'result'    => 1,
			'error'		=> ''
		);
	
		return array( $validUser, $invalidUser, $invalidUserEmail, $okUser );
	}
}
