<?php

namespace Wikia\Persistence\User\Attributes;

use Swagger\Client\ApiException;
use Swagger\Client\User\Attributes\Api\UsersAttributesApi;
use Swagger\Client\User\Attributes\Models\AllUserAttributesHalResponse;
use Swagger\Client\User\Attributes\Models\UserAttributeHalResponse;
use Swagger\Client\User\Attributes\Models\UserAttributes;
use Wikia\Domain\User\Attribute;
use Wikia\Service\ForbiddenException;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Service\UnauthorizedException;

class AttributePersistenceSwaggerTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;

	/** @var AttributePersistenceSwagger */
	protected $persistence;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $apiProvider;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $userAttributesApi;

	/** @var  Attribute */
	protected $attribute;

	public function setUp() {
		$this->apiProvider = $this->getMockBuilder( ApiProvider::class )
			->setMethods( [ 'getAuthenticatedApi' ] )
			->disableOriginalConstructor()
			->getMock();
		$this->userAttributesApi = $this->getMockBuilder( UsersAttributesApi::class )
			->setMethods( [ 'saveAttribute', 'getAllAttributes', 'deleteAttribute' ] )
			->disableOriginalConstructor()
			->getMock();
		$this->apiProvider->expects( $this->any() )
			->method('getAuthenticatedApi')
			->with( AttributePersistenceSwagger::SERVICE_NAME, $this->userId, UsersAttributesApi::class )
			->willReturn( $this->userAttributesApi );

		$this->persistence = new AttributePersistenceSwagger( $this->apiProvider );
		$this->attribute = new Attribute( "attrName", "attrValue" );
	}

	public function testGetAttributesSuccess() {
		$this->setUpGetAttributesHalResponse();

		$attributes = $this->persistence->getAttributes( $this->userId );
		$this->assertEquals( 2, count( $attributes) );
		$this->assertEquals( $attributes[0], new Attribute( 'attr1', 'value1' ) );
		$this->assertEquals( $attributes[1], new Attribute( 'attr2', 'value2' ) );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testGetAttributesNullResponse() {
		$this->userAttributesApi->expects( $this->once() )
			->method( 'getAllAttributes' )
			->with( $this->userId )
			->willReturn( null );

		$this->persistence->getAttributes( $this->userId );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testGetAttributesError() {
		$this->userAttributesApi->expects( $this->once() )
			->method( 'getAllAttributes' )
			->with( $this->userId )
			->willThrowException( new ApiException( "", 500 ) );

		$this->persistence->getAttributes( $this->userId );
	}


	public function testSaveAttributeForUserSuccess() {
		$this->userAttributesApi->expects( $this->once() )
			->method( 'saveAttribute' )
			->with( $this->userId, $this->attribute->getName(), $this->attribute->getValue() )
			->willReturn( true );

		$this->assertTrue( $this->persistence->saveAttribute( $this->userId, $this->attribute ) );
	}

	/**
	 * @expectedException \Wikia\Service\UnauthorizedException
	 */
	public function testSaveAttributeForUserUnAuthorized() {
		$this->userAttributesApi->expects( $this->once( ))
			->method( 'saveAttribute' )
			->with( $this->userId, $this->attribute->getName(), $this->attribute->getValue() )
			->willThrowException( new ApiException( "", UnauthorizedException::CODE ) );

		$this->persistence->saveAttribute($this->userId,  $this->attribute );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testSaveAttributeForUserError() {
		$this->userAttributesApi->expects( $this->once( ))
			->method( 'saveAttribute' )
			->with( $this->userId, $this->attribute->getName(), $this->attribute->getValue() )
			->willThrowException( new ApiException( "", 500 ) );

		$this->persistence->saveAttribute( $this->userId, $this->attribute );
	}

	/**
	 * @expectedException \Wikia\Service\ForbiddenException
	 */
	public function testSaveAttributeForUserForbidden() {
		$this->userAttributesApi->expects( $this->once( ))
			->method( 'saveAttribute' )
			->with( $this->userId, $this->attribute->getName(), $this->attribute->getValue() )
			->willThrowException( new ApiException( "", ForbiddenException::CODE ) );

		$this->persistence->saveAttribute( $this->userId, $this->attribute );
	}

	public function testDeleteAttributeSuccess() {
		$this->userAttributesApi->expects( $this->once( ))
			->method( 'deleteAttribute' )
			->with( $this->userId, $this->attribute->getName() );

		$this->assertTrue( $this->persistence->deleteAttribute( $this->userId, $this->attribute ) );
	}

	private function setUpGetAttributesHalResponse(){
		$this->userAttributesApi->expects( $this->once() )
			->method( 'getAllAttributes' )
			->with( $this->userId )
			->willReturn( $this->getAllUserAttributesHalResponse() );
	}

	private function getAllUserAttributesHalResponse() {
		$allUserAttributesHalResponse = new AllUserAttributesHalResponse();
		$allUserAttributesHalResponse->setEmbedded( $this->getUserAttributes() );

		return $allUserAttributesHalResponse;
	}

	private function getUserAttributes() {
		$userAttribute_1 = new UserAttributeHalResponse();
		$userAttribute_1->setName( "attr1" )->setValue( "value1" );

		$userAttribute_2 = new UserAttributeHalResponse();
		$userAttribute_2->setName( "attr2" )->setValue( "value2" );

		$userAttributes = new UserAttributes();
		$userAttributes->setProperties( [ $userAttribute_1, $userAttribute_2 ] );

		return $userAttributes;
	}
}
