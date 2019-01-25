<?php

namespace Wikia\Service\User\Attributes;
use PHPUnit\Framework\TestCase;
use Wikia\Domain\User\Attribute;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Service\PersistenceException;

class AttributeKeyValueTest extends TestCase {

	protected $userId = 1;
	protected $otherUserId = 2;
	protected $anonUserId = 0;
	/** @var Attribute $testAttribute_1 */
	protected $testAttribute_1;
	protected $testAttribute_2;
	protected $testAttributes;
	/** @var  \PHPUnit_Framework_MockObject_MockObject $persistenceMock */
	protected $persistenceMock;

	protected function setUp() {
		$this->testAttribute_1 = new Attribute( "attr-1-name", "attr-1-value" );
		$this->testAttribute_2 = new Attribute( "attr-2-name", "attr-2-value" );
		$this->testAttributes = [ $this->testAttribute_1, $this->testAttribute_2 ];
		$this->persistenceMock = $this->getMockBuilder( AttributePersistence::class )
			->setMethods( [ 'saveAttributes', 'getAttributes', 'deleteAttribute' ] )
			->disableOriginalConstructor()
			->getMock();
	}

	public function testSetSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttributes' )
			->with( $this->userId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue()  ] )
			->willReturn( true );

		$service = new AttributeService( $this->persistenceMock );
		$ret = $service->set( $this->userId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue()  ] );

		$this->assertTrue( $ret, "the attribute was not set" );
	}

	public function testSetEmptyAttributeSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttributes' )
			->with( $this->userId, [ $this->testAttribute_1->getName() => ''  ] )
			->willReturn( true );

		$service = new AttributeService( $this->persistenceMock );
		$ret = $service->set( $this->userId, [ $this->testAttribute_1->getName() => ''  ] );

		$this->assertTrue( $ret, "the attribute was not set" );
	}

	public function testSetMultipleUsers() {
		$this->persistenceMock->expects( $this->at( 0 ) )
			->method( 'saveAttributes' )
			->with( $this->userId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue()  ] )
			->willReturn( true );
		$this->persistenceMock->expects( $this->at( 1 ) )
			->method( 'saveAttributes' )
			->with( $this->otherUserId, [ $this->testAttribute_2->getName() => $this->testAttribute_2->getValue()  ] )
			->willReturn( true );

		$service = new AttributeService( $this->persistenceMock );
		$firstUserResult = $service->set( $this->userId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue() ] );
		$otherUserResult = $service->set( $this->otherUserId, [ $this->testAttribute_2->getName() => $this->testAttribute_2->getValue() ] );

		$this->assertTrue( $firstUserResult, "the attribute was not set" );
		$this->assertTrue( $otherUserResult, "the attribute was not set" );
	}

	/**
	 * @expectedException \Exception
	 */
	public function testSetWithAnonUserId() {
		$this->persistenceMock->expects( $this->never() )
			->method( 'saveAttributes' );

		$service = new AttributeService( $this->persistenceMock );
		$service->set( $this->anonUserId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue()  ] );
	}

	public function testSetWithEmptySetOfAttributesDoesNotCallTheService() {
		$this->persistenceMock->expects( $this->never() )
			->method( 'saveAttributes' );

		$service = new AttributeService( $this->persistenceMock );
		$result = $service->set( $this->userId, [] );

		$this->assertTrue( $result );
	}

	public function testSetWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttributes' )
			->with( $this->userId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue()  ] )
			->will( $this->throwException( new PersistenceException() ) );

		$service = new AttributeService( $this->persistenceMock );
		try {
			$service->set( $this->userId, [ $this->testAttribute_1->getName() => $this->testAttribute_1->getValue()  ] );
		} catch ( PersistenceException $e ) {
			$this->fail( "Excepction should be caught and logged, not thrown" );
		}
	}

	public function testGetWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException() ) );
		$service = new AttributeService( $this->persistenceMock );

		try {
			$service->get( $this->userId );
		} catch ( PersistenceException $e ) {
			$this->fail( "Excepction should be caught and logged, not thrown" );
		}
	}

	public function testGetSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->userId )
			->willReturn(
				$this->testAttributes
			);

		$service = new AttributeService( $this->persistenceMock );
		$attributes = $service->get( $this->userId );

		$this->assertTrue( is_array( $attributes ), "expecting an array" );
		$this->assertEquals( $this->testAttribute_1, $attributes[0], "expecting an array" );
	}

	public function testDeleteSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'deleteAttribute' )
			->with( $this->userId )
			->willReturn( true );

		$service = new AttributeService( $this->persistenceMock );
		$this->assertTrue( $service->delete( $this->userId, $this->testAttribute_1 ) );
	}

	/**
	 * @expectedException \Exception
	 */
	public function testDeleteWithAnonUserId() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'deleteAttribute' );

		$service = new AttributeService( $this->persistenceMock );
		$service->delete( $this->anonUserId, $this->testAttribute_1 );
	}
}
