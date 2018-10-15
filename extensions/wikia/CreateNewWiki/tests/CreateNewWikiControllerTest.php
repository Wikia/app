<?php

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Tasks\Tasks\CreateNewWikiTask;

class CreateNewWikiControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07 ms
	 * @group hyun
	 * @dataProvider getCreateWikiDataProvider
	 *
	 * @param array $testData
	 */
	public function testCreateWikiSuccess( array $testData ) {
		$wikiName = 'Muppet is great';
		$wikiDomain = 'muppet';
		$wikiLanguage = 'en';
		$wikiVertical = '3';

		$requestParams = array("wName" => $wikiName,
			"wDomain" => $wikiDomain,
			"wLanguage" => $wikiLanguage,
			"wVertical" => $wikiVertical);

		$userMock = $this->mockClassWithMethods(
			User::class,
			[
				'getId' => 1,
				'isLoggedIn' => $testData['userLogged'],
				'isEmailConfirmed' =>  $testData['userEmailConfirmed'],
			]
		);

		$this->mockGlobalVariable( 'wgUser', $userMock );

		$requestMock = $this->getMockBuilder( WikiaRequest::class )
			->setMethods( [ 'assertValidWriteRequest', 'getArray' ] )
			->setConstructorArgs( [ [] ] )
			->getMock();

		$requestMock->expects($this->any())
			->method('getArray')
			->will($this->returnValue($requestParams));

		if ( !$testData['validRequest'] ) {
			$requestMock->expects( $this->any() )
				->method( 'assertValidWriteRequest' )
				->willThrowException( new BadRequestException() );
		}

		$taskId = 123;
		$taskMock = $this->createMock( BaseTask::class );
		$taskMock->expects( $this->any() )
			->method( 'call' )
			->willReturnSelf();
		$taskMock->expects( $this->any() )
			->method( 'setQueue' )
			->with( \Wikia\Tasks\Queues\PriorityQueue::NAME )
			->willReturnSelf();
		$taskMock->expects( $this->any() )
			->method( 'queue' )
			->willReturn( $taskId );

		$this->mockStaticMethod( BaseTask::class, 'newLocalTask', $taskMock );

		$responseMock = new WikiaResponse( 'json', $requestMock );

		if ( !empty( $testData['expectedException'] ) ) {
			$this->expectException( $testData['expectedException'] );
		}

		$createNewWikiController = new CreateNewWikiController();

		$createNewWikiController->setRequest( $requestMock );
		$createNewWikiController->setResponse( $responseMock );
		$createNewWikiController->setContext( new RequestContext() );

		$createNewWikiController->CreateWiki();

		$response = $createNewWikiController->getResponse();

		if ($testData['status'] === 'ok') {
			$this->assertEquals( 201, $response->getCode(),
				'Method responded with HTTP 201 Created' );
			$this->assertEquals( $taskId, $response->getVal( 'task_id' ), 'Task ID is emitted in JSON response' );
		}
		else {
			$this->assertEquals( $testData['status'], $response->getVal(CreateNewWikiController::STATUS_FIELD) );
			$this->assertEquals( $testData['expectedCode'], $response->getCode() );
		}
	}

	public function getCreateWikiDataProvider() {
		return [
			'Everything is OK' => [ [
				'validRequest' => true,
				'userLogged' => true,
				'userEmailConfirmed' => true,
				'status' => 'ok',
				'expectedException' => false
			] ],
			'User not logged-in and therefore without confirmed e-mail' => [ [
				'validRequest' => true,
				'userLogged' => false,
				'userEmailConfirmed' => false,
				'status' => 'error',
				'expectedException' => false,
				'expectedCode' => 401,
			] ],
			"Bad request" => [ [
				'validRequest' => false,
				'userLogged' => true,
				'userEmailConfirmed' => true,
				'status' => null,
				'expectedException' => 'BadRequestException',
			] ]
		];
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03212 ms
	 */
	public function testCheckWikiNameSuccess() {

		$wikiName = 'muppet';
		$wikiLang = 'en';

		$wgRequest = $this->getMock('WebRequest');
		$wgRequest->expects($this->exactly(2))
			->method('getVal')
			->will($this->onConsecutiveCalls($wikiName, $wikiLang));

		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));

		$this->mockGlobalVariable('wgRequest',$wgRequest);
		$this->mockStaticMethod('CreateWikiChecks','checkWikiNameIsCorrect','');

		$response = $app->sendRequest('CreateNewWiki', 'CheckWikiName');

		$this->assertEquals("", $response->getVal('res'));
	}
}
