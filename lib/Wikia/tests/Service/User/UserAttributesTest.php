<?php

namespace Wikia\Service\User\Attributes;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Wikia\Domain\User\Attribute;

class UserAttributeTest extends TestCase {
	/** @var int */
	protected $userId = 1;

	/** @var int */
	protected $anonUserId = 0;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $service;

	/** @var  Attribute */
	protected $attribute1;

	/** @var  Attribute */
	protected $attribute2;

	/** @var Attribute[]  */
	protected $savedAttributesForUser;

	/** @var  Attribute */
	protected $defaultAttribute1;

	/** @var  Attribute */
	protected $defaultAttribute2;

	/** @var Attribute[]  */
	protected $defaultAttributes;

	protected function setUp() {
		$this->service = $this->getMockBuilder( AttributeService::class )
			->setMethods( [ 'set', 'get', 'delete' ] )
			->disableOriginalConstructor()
			->getMock();
		$this->attribute1 = new Attribute( 'nickName', 'Lebowski' );
		$this->attribute2 = new Attribute( 'gender', 'female' );
		$this->savedAttributesForUser = [ $this->attribute1, $this->attribute2 ];
		$this->defaultAttribute1 = new Attribute( 'defaultAttr1', 'defaultAttr1Val' );
		$this->defaultAttribute2 = new Attribute( 'defaultAttr2', 'defaultAttr2Val' );
		$this->defaultAttributes = [
			$this->defaultAttribute1->getName() => $this->defaultAttribute1->getValue(),
			$this->defaultAttribute2->getName() => $this->defaultAttribute2->getValue()
		];
	}

	public function testGetAttributes() {
		$this->setupServiceGetExpects();
		$attributes = new UserAttributes( $this->service, [] );

		$this->assertEquals( $this->attribute1->getValue(),
			$attributes->getAttribute( $this->userId, $this->attribute1->getName() ) );

		$this->assertEquals( $this->attribute2->getValue(),
			$attributes->getAttribute( $this->userId, $this->attribute2->getName() ) );

		$this->assertNull( $attributes->getAttribute( $this->userId, 'unsetattribute' ) );
	}

	public function testGetAttributesWithDefaultParameter() {
		$this->setupServiceGetExpects();
		$attributes = new UserAttributes( $this->service, [] );

		$this->assertEquals( 'someDefaultValue',
			$attributes->getAttribute( $this->userId, 'attrWithNoValue', 'someDefaultValue' ) );

		$this->assertEquals( $this->attribute1->getValue(),
			$attributes->getAttribute( $this->userId, $this->attribute1->getName(), 'someDefaultValue' ) );
	}

	public function testGetAttributesWithGlobalDefaultSet() {
		$this->setupServiceGetExpects();
		$attributes = new UserAttributes( $this->service, $this->defaultAttributes );

		$this->assertEquals( $this->defaultAttribute1->getValue(),
			$attributes->getAttribute( $this->userId, $this->defaultAttribute1->getName() ) );
	}

	public function testSetAttribute() {
		$userAttributes = new UserAttributes( $this->service, [] );
		$userAttributes->setAttribute( $this->userId, new Attribute( 'newAttr', 'foo' ) );
		$this->assertEquals( 'foo', $userAttributes->getAttribute( $this->userId, 'newAttr' ) );
		$userAttributes->setAttribute( $this->userId, new Attribute( 'anotherNewAttr', null ) );
		$this->assertEquals( null, $userAttributes->getAttribute( $this->userId, 'anotherNewAttr' ) );
	}

	public function testSaveAttribute() {
		$this->service->expects( $this->once() )
			->method( 'delete' )
			->with( $this->userId, $this->defaultAttribute1 );

		$this->service->expects( $this->exactly( 2 ) )
			->method( 'set' );

		$userAttributes = new UserAttributes( $this->service, $this->defaultAttributes );

		// Should be deleted during save b/c it's a default attribute with a default value
		$userAttributes->setAttribute( $this->userId,  $this->defaultAttribute1 );

		// Should be saved because it's a default attribute with a new value
		$userAttributes->setAttribute( $this->userId, new Attribute( $this->defaultAttribute2->getName(),  'someNewValue' ) );

		// Should be saved because it's a non-default attribute
		$userAttributes->setAttribute( $this->userId, new Attribute( 'nickName',  'Lebowski' ) );

		$userAttributes->save( $this->userId );
	}

	public function testDeleteAttributeSetForUser() {
		$this->setupServiceGetExpects();
		$this->service->expects( $this->once() )
			->method( 'delete' )
			->with( $this->userId, $this->attribute1 );


		$userAttributes = new UserAttributes( $this->service, [] );

		$this->assertEquals( $this->attribute1->getValue(),
			$userAttributes->getAttribute( $this->userId, $this->attribute1->getName() ) );

		$userAttributes->deleteAttribute( $this->userId, $this->attribute1 );
		$this->assertNull( $userAttributes->getAttribute( $this->userId, $this->attribute1->getName() ) );
	}

	public function testDeleteAttrbutesWithNullValue() {
		$attrNullValue = new Attribute( "someKey", null );
		$this->setupServiceGetExpects();
		$this->service->expects( $this->once() )
			->method( 'delete' )
			->with( $this->userId, $attrNullValue );

		$userAttributes = new UserAttributes( $this->service, [] );
		$userAttributes->setAttribute( $this->userId, $attrNullValue );
		$userAttributes->save( $this->userId );
	}

	protected function setupServiceGetExpects() {
		$this->service->expects( $this->once( ))
			->method( 'get' )
			->with( $this->userId )
			->willReturn( $this->savedAttributesForUser );
	}
}
