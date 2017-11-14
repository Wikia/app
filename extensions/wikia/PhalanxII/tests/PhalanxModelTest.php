<?php

class PhalanxModelTest extends WikiaBaseTest {
	const VALID_USERNAME = 'WikiaTest';
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
		$this->setupFile =  dirname( __FILE__ ) . '/../Phalanx_setup.php';
		parent::setUp();
	}

	private function setUpUser( $userName, $email, $isAnon ) {
		// User
		$userMock = $this->createConfiguredMock( User::class, [
			'isAnon' => $isAnon,
			'getName' => $userName,
			'getEmail' => $email,
		] );

		$this->mockGlobalVariable( 'wgUser', $userMock );

		return $userMock;
	}

	private function setUpTitle( $title ) {
		$titleMock = $this->createConfiguredMock( Title::class, [
			'newFromText' => null,
			'getFullText' => $title,
			'getPrefixedText' => $title,
		] );

		$this->mockGlobalVariable( 'wgTitle', $titleMock );

		return $titleMock;
	}

	/**
	 * @param $block
	 * @return PhalanxService|PHPUnit_Framework_MockObject_MockObject
	 */
	private function setUpService( $block ) {
		$phalanxServiceMock = $this->getMockForAbstractClass( PhalanxService::class );

		if ( $block ) {
			$phalanxServiceMock->expects( $this->any() )
				->method( 'doMatch' )
				->willReturn( [ new PhalanxBlockInfo() ] );
		}

		return $phalanxServiceMock;
	}

	/* PhalanxUserModel class */
	/* match_user method */
	/**
	 * @dataProvider phalanxUserModelDataProvider
	 */
	public function testPhalanxUserModelMatchUser( $isAnon, $userName, $email, $block, $result, $errorMsg ) {
		$userMock = $this->setUpUser( $userName, $email, $isAnon );
		$phalanxServiceMock = $this->setUpService( $block );

		$model = new PhalanxUserModel( $userMock );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_user();

		$this->assertEquals( $result, $ret );
	}

	/* PhalanxUserModel class */
	/* match_email method */
	/**
	 * @dataProvider phalanxUserModelDataProvider
	 */
	public function testPhalanxUserModelMatchEmail( $isAnon, $userName, $email, $block, $result, $errorMsg ) {
		$userMock = $this->setUpUser( $userName, $email, $isAnon );
		$phalanxServiceMock = $this->setUpService( $block );

		$model = new PhalanxUserModel( $userMock );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_email();

		$this->assertEquals( $result, $ret );
	}

	/* PhalanxTextModel class */

	/* wiki_creation method */
	/**
	 * @dataProvider phalanxTextModelDataProvider
	 */
	public function testPhalanxTextModelWikiCreation( $text, $block, $result ) {
		$phalanxServiceMock = $this->setUpService( $block );

		$model = new PhalanxTextModel( $text );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_wiki_creation();

		$this->assertEquals( $result, $ret );
	}

	/* PhalanxContentModel class */
	/* match_question_title method */
	/**
	 * @group Slow
	 * @slowExecutionTime 0.04619 ms
	 * @dataProvider phalanxTitleDataProvider
	 */
	public function testPhalanxContentModelQuestionTitle( $title, $block, $result ) {
		$titleMock = $this->setUpTitle( $title );
		$phalanxServiceMock = $this->setUpService( $block );

		$model = new PhalanxContentModel( $titleMock );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_question_title();

		$this->assertEquals( $result, $ret );
	}

	/* PhalanxContentModel class */
	/* match_summary method */
	/**
	 * @group Slow
	 * @slowExecutionTime 0.04572 ms
	 * @dataProvider phalanxContentModelDataProvider
	 */
	public function testPhalanxContentModelSummary( $title, $text, $summary, $block_text, $block_summary, $result_text, $result_summary ) {
		$titleMock = $this->setUpTitle( $title );
		$phalanxServiceMock = $this->setUpService( $block_summary );

		$model = new PhalanxContentModel( $titleMock );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_summary( $summary );

		$this->assertEquals( $result_summary, $ret );
	}

	/* PhalanxContentModel class */
	/* match_content method */
	/**
	 * @group Slow
	 * @slowExecutionTime 0.04324 ms
	 * @dataProvider phalanxContentModelDataProvider
	 */
	public function testPhalanxContentModelContent( $title, $text, $summary, $block_text, $block_summary, $result_text, $result_summary ) {
		$titleMock = $this->setUpTitle( $title );
		$phalanxServiceMock = $this->setUpService( $block_text );

		$model = new PhalanxContentModel( $titleMock );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_content( $text );

		$this->assertEquals( $result_text, $ret );
	}

	/* PhalanxContentModel class */
	/* match_title method */
	/**
	 * @group Slow
	 * @slowExecutionTime 0.04322 ms
	 * @dataProvider phalanxTitleDataProvider
	 */
	public function testPhalanxContentModelTitle( $title, $block, $result ) {
		$titleMock = $this->setUpTitle( $title );
		$phalanxServiceMock = $this->setUpService( $block );

		$model = new PhalanxContentModel( $titleMock );
		$model->setService( $phalanxServiceMock );
		$ret = ( int ) $model->match_title();

		$this->assertEquals( $result, $ret );
	}

	/**
	 * Test models factory
	 *
	 * @dataProvider phalanxNewFromTypeProvider
	 */
	public function testPhalanxNewFromType( $type, $content, $className, $methodName ) {
		$model = PhalanxModel::newFromType( $type, $content );

		if ( $className === false ) {
			$this->assertNull( $model );
		}
		else {
			$this->assertInstanceOf( $className, $model );
			$this->assertEquals( $content, $model->$methodName() );
		}
	}

	/**
	 * @param bool $isPhalanxExempt whether session user is exempt from Phalanx blocks
	 * @dataProvider isOkForPhalanxExemptUserDataProvider
	 */
	public function testIsOkForPhalanxExemptUser( bool $isPhalanxExempt ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|User $userMock */
		$userMock = $this->getMock( User::class, [ 'isAllowed' ] );
		$userMock->expects( $this->exactly( 3 ) )
			->method( 'isAllowed' )
			->with( $this->equalTo( 'phalanxexempt' ) )
			->willReturn( $isPhalanxExempt );

		$this->mockGlobalVariable( 'wgUser', $userMock );

		$phalanxUserModel = new PhalanxUserModel( $userMock );
		$res = $phalanxUserModel->isOk();
		$this->assertEquals( $isPhalanxExempt, $res );

		$phalanxContentModel = new PhalanxContentModel( new Title() );
		$res = $phalanxContentModel->isOk();
		$this->assertEquals( $isPhalanxExempt, $res );

		$phalanxTextModel = new PhalanxTextModel( 'To jest test' );
		$res = $phalanxTextModel->isOk();
		$this->assertEquals( $isPhalanxExempt, $res );
	}

	/**
	 * @param bool $isInternalRequest whether this is internal Wikia request
	 * @param bool $isSelfCheck whether target user to look up is same as session user
	 * @dataProvider isOkForInternalRequestDataProvider
	 */
	public function testIsOkForInternalRequest( bool $isInternalRequest, bool $isSelfCheck ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|User $userMock */
		$userMock = $this->getMock( User::class, [ 'isAllowed', 'getName' ] );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->with( $this->equalTo( 'phalanxexempt' ) )
			->willReturn( false );


		$userMock->expects( $this->any() )
				->method( 'getName' )
				->willReturn( $isSelfCheck ? $this->app->wg->User->getName() : 'TestDifferentUserName' );

		$requestMock = $this->getMock( WebRequest::class, [ 'isWikiaInternalRequest', 'getIp' ] );
		$requestMock->expects( $this->exactly( 3 ) )
			->method( 'isWikiaInternalRequest' )
			->willReturn( $isInternalRequest );
		$this->mockGlobalVariable( 'wgRequest', $requestMock );

		$phalanxUserModel = new PhalanxUserModel( $userMock );
		$res = $phalanxUserModel->isOk();
		$this->assertEquals( $isInternalRequest && $isSelfCheck, $res );

		$phalanxContentModel = new PhalanxContentModel( new Title() );
		$res = $phalanxContentModel->isOk();
		$this->assertEquals( $isInternalRequest, $res );

		$phalanxTextModel = new PhalanxTextModel( 'To jest test' );
		$res = $phalanxTextModel->isOk();
		$this->assertEquals( $isInternalRequest, $res );
	}

	public function phalanxNewFromTypeProvider() {
		return array(
			array(
				'type' => Phalanx:: TYPE_TITLE,
				'content' => new Title(),
				'className' => 'PhalanxContentModel',
				'methodName' => 'getTitle'
			),
			array(
				'type' => Phalanx::TYPE_CONTENT,
				'content' => 'text',
				'className' => 'PhalanxTextModel',
				'methodName' => 'getText'
			),
			array(
				'type' => Phalanx::TYPE_USER,
				'content' => new User(),
				'className' => 'PhalanxUserModel',
				'methodName' => 'getUser'
			),
			// invalid type ID
			array(
				'type' => -1,
				'content' => false,
				'className' => false,
				'methodName' => false
			),
		);
	}

	/* data providers */
	public function phalanxUserModelDataProvider(): array {
		/* valid user */
		$validUser = [
			'isAnon' => false,
			'getName' => self::VALID_USERNAME,
			'email' => self::VALID_EMAIL,
			'block' => 0,
			'result' => 1,
			'error' => ''
		];

		/* invalid user */
		$invalidUser = [
			'isAnon' => true,
			'getName' => self::INVALID_USERNAME,
			'email' => self::INVALID_EMAIL,
			'block' => [
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_USERNAME,
				'reason' => 'Test',
				'exact' => '',
				'caseSensitive' => '',
				'id' => 4009,
				'authorId' => 184532,
			],
			'result' => 0,
			'error' => wfMsg( 'phalanx-user-block-new-account' )
		];

		/* invalid user */
		$invalidUserEmail = [
			'isAnon' => true,
			'getName' => self::INVALID_USERNAME,
			'email' => self::INVALID_EMAIL,
			'block' => [
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_EMAIL,
				'reason' => 'Test Email',
				'exact' => '',
				'caseSensitive' => '',
				'id' => 4010,
				'authorId' => 184532,
			],
			'result' => 0,
			'error' => wfMsg( 'phalanx-user-block-new-account' )
		];

		/* phalanxexempt */
		$okUser = [
			'isAnon' => false,
			'getName' => self::VALID_USERNAME,
			'email' => self::VALID_EMAIL,
			'block' => 0,
			'result' => 1,
			'error' => ''
		];

		return [ $validUser, $invalidUser, $invalidUserEmail, $okUser ];
	}

	public function phalanxTextModelDataProvider(): array {
		/* valid text */
		$validWiki = [
			'text' => self::VALID_WIKIA_NAME,
			'block' => 0,
			'result' => 1,
		];

		/* invalid text */
		$invalidWiki = [
			'title' => self::INVALID_WIKIA_NAME,
			'block' => [
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_WIKIA_NAME,
				'reason' => 'Test wiki creation block',
				'exact' => '',
				'caseSensitive' => '',
				'id' => 4013,
				'authorId' => 184532,
			],
			'result' => 0,
		];

		return [ $validWiki, $invalidWiki ];
	}

	public function phalanxContentModelDataProvider(): array {
		/* valid textbox & summary */
		$validContent = [
			'title' => self::VALID_TITLE,
			'textbox' => self::VALID_CONTENT,
			'summary' => self::VALID_SUMMARY,
			'block_text' => 0,
			'block_summary' => 0,
			'result_text' => 1,
			'result_summary' => 1
		];

		/* invalid content, valid summary */
		$invalidContent = [
			'title' => self::VALID_TITLE,
			'textbox' => self::INVALID_CONTENT,
			'summary' => self::VALID_SUMMARY,
			'block_text' => [
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_CONTENT,
				'reason' => 'Test content block',
				'exact' => '',
				'caseSensitive' => '',
				'id' => 4014,
				'authorId' => 184532,
			],
			'block_summary' => 0,
			'result_text' => 0,
			'result_summary' => 1
		];

		/* valid content, invalid summary */
		$invalidSummary = [
			'title' => self::VALID_TITLE,
			'textbox' => self::VALID_CONTENT,
			'summary' => self::INVALID_SUMMARY,
			'block_text' => 0,
			'block_summary' => [
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_SUMMARY,
				'reason' => 'Test content block',
				'exact' => '',
				'caseSensitive' => '',
				'id' => 4015,
				'authorId' => 184532,
			],
			'result_text' => 1,
			'result_summary' => 0
		];

		return [ $validContent, $invalidContent, $invalidSummary ];
	}

	public function phalanxTitleDataProvider(): array {
		/* valid title */
		$validTitle = [
			'title'		=> self::VALID_TITLE,
			'block'     => 0,
			'result'    => 1,
		];

		/* invalid title */
		$invalidTitle = [
			'title'		=> self::INVALID_TITLE,
			'block'     => [
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_TITLE,
				'reason' => 'Test answers block',
				'exact' => '',
				'caseSensitive' => '',
				'id' => 4011,
				'authorId' => 184532,
			],
			'result'    => 0,
		];

		return [ $validTitle, $invalidTitle ];
	}

	public function isOkForPhalanxExemptUserDataProvider(): array {
		return [
			'Phalanx exempt user' => [ true ],
			'Normal user' => [ false ]
		];
	}

	public function isOkForInternalRequestDataProvider(): array {
		return [
			'Internal request' => [ true, true ],
			'Internal request looking up different user' => [ true, false ],
			'External request' => [ false, false ]
		];
	}
}
