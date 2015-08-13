<?php

namespace Wikia\Service\User\Attributes;
use Wikia\Domain\User\Attribute;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Service\PersistenceException;

class AttributeKeyValueTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $anonUserId = 0;
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
			->setMethods( [ 'saveAttribute', 'getAttributes', 'deleteAttribute' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testSetSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttribute' )
			->with( $this->userId, $this->testAttribute_1 )
			->willReturn( true );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$ret = $service->set( $this->userId,  $this->testAttribute_1 );

		$this->assertTrue( $ret, "the attribute was not set" );
	}

	/**
	 * @expectedException \Exception
	 */
	public function testSetWithEmptyAttribute() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'saveAttribute' );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$ret = $service->set( $this->userId, null );
	}

	/**
	 * @expectedException \Exception
	 */
	public function testSetWithAnonUserId() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'saveAttribute' );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$ret = $service->set( $this->anonUserId, null );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testSetWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttribute' )
			->with( $this->userId, $this->testAttribute_1 )
			->will( $this->throwException( new PersistenceException() ) );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$service->set( $this->userId, $this->testAttribute_1 );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testGetWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException() ) );
		$service = new AttributeKeyValueService( $this->persistenceMock );
		$service->get( $this->userId );
	}

	public function testGetSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->userId )
			->willReturn(
				$this->testAttributes
			);

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$attributes = $service->get( $this->userId );

		$this->assertTrue( is_array( $attributes ), "expecting an array" );
		$this->assertEquals( $this->testAttribute_1, $attributes[0], "expecting an array" );
	}

	public function testDeleteSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'deleteAttribute' )
			->with( $this->userId )
			->willReturn( true );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$this->assertTrue( $service->delete( $this->userId, $this->testAttribute_1 ) );
	}

	public function testDeleteWithEmptyAttribute() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'deleteAttribute' );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$this->assertFalse( $service->delete( $this->userId, null ) );
	}

	public function testDeleteWithAnonUserId() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'deleteAttribute' );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$this->assertFalse( $service->delete( $this->anonUserId, $this->testAttribute_1 ) );
	}
}
