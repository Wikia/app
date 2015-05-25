<?php

class ExactTargetUpdateUserTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider updateUserEmailProvider
	 */
	function testUpdateUserEmailShouldSendData( $aUserData, $aApiParams, $aMockCustomerKey ) {

		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->getMock();

		/* @var ExactTargetApiDataExtension $mockApiDataExtension mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateFallbackCreateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateFallbackCreateRequest' )
			->with( $aApiParams );

		/* @var ExactTargetUserTaskHelper $mockUserHelper mock of ExactTargetUserTaskHelper */
		$mockUserHelper = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUserTaskHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCustomerKeys', 'getUserFromId' ] )
			->getMock();
		$mockUserHelper
			->expects( $this->once() )
			->method( 'getCustomerKeys' )
			->will( $this->returnValue( $aMockCustomerKey ) );
		$mockUserHelper
			->expects( $this->once() )
			->method( 'getUserFromId' )
			->with( $aUserData['user_id'] )
			->will( $this->returnValue( $userMock ) );

		/* @var ExactTargetUserHooksHelper $mockUserHooksHelper mock of ExactTargetUserHooksHelper */
		$mockUserHooksHelper = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUserHooksHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'prepareUserParams' ] )
			->getMock();
		$mockUserHooksHelper
			->expects( $this->once() )
			->method( 'prepareUserParams' )
			->with( $userMock )
			->will( $this->returnValue( $aUserData ) );

		/* Mock ExactTargetCreateUserTask */
		$mockCreateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetCreateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createSubscriber', 'taskId' ] )
			->getMock();
		$mockCreateUserTask
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* Mock ExactTargetDeleteUserTask */
		$mockDeleteUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetDeleteUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'deleteSubscriber', 'taskId' ] )
			->getMock();
		$mockDeleteUserTask
			->expects( $this->once() )
			->method( 'deleteSubscriber' );

		/* Mock tested class */
		/* @var Wikia\ExactTarget\ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension', 'getCreateUserTask', 'getDeleteUserTask', 'getUserHelper', 'getUserHooksHelper', 'getTaskId' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getUserHelper' )
			->will( $this->returnValue( $mockUserHelper ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getUserHooksHelper' )
			->will( $this->returnValue( $mockUserHooksHelper ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getCreateUserTask' )
			->will( $this->returnValue( $mockCreateUserTask ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getDeleteUserTask' )
			->will( $this->returnValue( $mockDeleteUserTask ) );

		/* Run tested method */
		$mockUpdateUserTask->updateUserEmail( $aUserData['user_id'], $aUserData['user_email'] );
	}


	/**
	 * DATA PROVIDERS
	 */

	function updateUserEmailProvider() {
		$sCustomerKey = 'sample_table_name';

		$aMockCustomerKey = [ 'user' => $sCustomerKey ];

		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];

		$aApiParams = [
			'DataExtension' => [
				0 => [
					'CustomerKey' => $sCustomerKey,
					'Properties' => [
						'user_email' => $aUserData['user_email']
					],
					'Keys' => [
						'user_id' => $aUserData['user_id'],
					]
				]
			]
		];

		return [
			[ $aUserData, $aApiParams, $aMockCustomerKey ]
		];
	}

}
