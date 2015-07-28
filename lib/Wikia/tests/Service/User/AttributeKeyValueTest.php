<?php

namespace Wikia\Service\User\Preferences;
use Wikia\Domain\User\Attribute;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Service\PersistenceException;
use Wikia\Service\User\Attributes\AttributeKeyValueService;

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
			->setMethods( [ 'saveAttribute', 'getAttributes' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testSetAttributeSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttribute' )
			->with( $this->userId, $this->testAttribute_1 )
			->willReturn( true );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$ret = $service->setAttribute( $this->userId,  $this->testAttribute_1 );

		$this->assertTrue( $ret, "the attribute was not set" );
	}

	public function testSetAttributeWithEmptyAttribute() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'saveAttribute' );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$ret = $service->setAttribute( $this->userId, null );

		$this->assertFalse( $ret, "expected false when providing an empty attribute set" );
	}

	public function testSetAttributeWithAnonUserId() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'saveAttribute' );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$ret = $service->setAttribute( $this->anonUserId, null );

		$this->assertFalse( $ret, "expected false when providing an empty attribute set" );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testSetAttributeWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'saveAttribute' )
			->with( $this->userId, $this->testAttribute_1 )
			->will( $this->throwException( new PersistenceException() ) );

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$service->setAttribute( $this->userId, $this->testAttribute_1 );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testGetAttributeWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException() ) );
		$service = new AttributeKeyValueService( $this->persistenceMock );
		$service->getAttributes( $this->userId );
	}

	public function testGetAttributesSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->userId )
			->willReturn(
				$this->testAttributes
			);

		$service = new AttributeKeyValueService( $this->persistenceMock );
		$attributes = $service->getAttributes( $this->userId );

		$this->assertTrue( is_array( $attributes ), "expecting an array" );
		$this->assertEquals( $this->testAttribute_1, $attributes[0], "expecting an array" );
	}
}
