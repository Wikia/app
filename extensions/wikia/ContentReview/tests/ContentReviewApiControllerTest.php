<?php

class ContentReviewApiControllerTest extends WikiaBaseTest {

	/* @var \ContentReviewApiController $contentReviewApiControllerMock */
	private $contentReviewApiControllerMock;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();

		$this->contentReviewApiControllerMock = $this->getMockBuilder( 'ContentReviewApiController' )
			->setMethods( [ 'getTitle', 'canUserSubmit' ] )
			->getMock();
	}

	protected function tearDown() {
		/* Restore global user var */
		if ( isset( $this->wgUserBackup ) ) {
			$app = $this->contentReviewApiControllerMock->getApp();
			$app->setGlobal( 'wgUser', $this->wgUserBackup );
		}
		parent::tearDown();
	}

	/**
	 * @dataProvider submitPageForReviewProvider
	 */
	public function testSubmitPageForReview( $params, $textExpected, $message ) {

		$this->prepareControllerPropertiesMocks( $params );

		if ( $params['title'] ) {
			$this->prepareTitleMock( $params['title'] );
		}

		if ( $params['expectedException'] ) {
			$this->setExpectedException( $params['expectedException'] );
		}

		/* Run tested function */
		$this->contentReviewApiControllerMock->submitPageForReview();
	}

	private function prepareControllerPropertiesMocks( $params ) {
		/* @var \WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( '\WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'wasPosted' ] )
			->getMock();

		$app = new WikiaApp();

		if ( $params['wasPosted'] ) {
			$requestMock->method( 'wasPosted' )
				->will( $this->returnValue( $params['wasPosted'] ) );
		}

		if ( isset( $params['user'] ) ) {
			/* @var \User $userMock */
			$userMock = $this->getMockBuilder( '\User' )
				->disableOriginalConstructor()
				->setMethods( [ 'matchEditToken', 'getId' ] )
				->getMock();
			if ( isset( $params['user']['matchEditToken'] ) ) {
				$userMock->method( 'matchEditToken' )
					->will( $this->returnValue( $params['user']['matchEditToken'] ) );
			}
			if ( isset( $params['user']['id'] ) ) {
				$userMock->method( 'getId' )
					->will( $this->returnValue( $params['user']['id'] ) );
			}
			$this->wgUserBackup = $app->getGlobal( 'wgUser', $userMock );
			$app->setGlobal( 'wgUser', $userMock );
		}

		if ( isset( $params['canUserSubmit'] ) ) {
			$this->contentReviewApiControllerMock->method( 'canUserSubmit' )
				->will( $this->returnValue( $params['canUserSubmit'] ) );
		}

		/* Set dependencies */
		$this->contentReviewApiControllerMock->setApp( $app );
		$this->contentReviewApiControllerMock->setRequest( $requestMock );

	}

	private function prepareTitleMock( $params ) {
		$titleMock = $this->getMockBuilder( '\Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'getArticleID', 'isJsPage' ] )
			->getMock();
		if ( isset( $params['articleID'] ) ) {
			$titleMock->method( 'getArticleID' )
				->will( $this->returnValue( $params['articleID'] ) );
		}
		if ( isset( $params['isJsPage'] ) ) {
			$titleMock->method( 'isJsPage' )
				->will( $this->returnValue( $params['isJsPage'] ) );
		}

		$this->contentReviewApiControllerMock->method( 'getTitle' )
			->will( $this->returnValue( $titleMock ) );
	}

	public function submitPageForReviewProvider() {
		return [
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => false,
					],
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'User token don\'t match. Throw BadRequestApiException.',
			],
			[
				[
					'wasPosted' => false,
					'user' => [
						'matchEditToken' => false,
					],
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'Not post request. Throw BadRequestApiException.',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
					],
					'expectedException' => 'NotFoundApiException',
					'title' => [
						'articleID' => 0,
						'isJsPage' => false,
					],
				],
				null,
				'Non existent page',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
					],
					'expectedException' => 'NotFoundApiException',
					'title' => [
						'articleID' => 123,
						'isJsPage' => false,
					],
				],
				null,
				'Not JS page',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
						'id' => 0,
					],
					'expectedException' => 'PermissionsException',
					'title' => [
						'articleID' => 123,
						'isJsPage' => true,
					],
				],
				null,
				'Non existent user',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
						'id' => 888,
					],
					'expectedException' => 'PermissionsException',
					'title' => [
						'articleID' => 123,
						'isJsPage' => true,
					],
					'canUserSubmit' => false
				],
				null,
				'Non existent user',
			],
		];
	}
}
