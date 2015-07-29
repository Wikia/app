<?php

namespace Wikia\Service\User\Attributes;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Wikia\Domain\User\Attribute;

class UserAttributeTest extends PHPUnit_Framework_TestCase {
	/** @var int */
	protected $userId = 1;

	/** @var string[string] */
	protected $savedAttributes = [ "gender" => "female", "nickName" => "Lebowski" ];

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $service;

	protected function setUp() {
		$this->userId = 1;
		$this->service = $this->getMockBuilder( AttributeService::class )
			->setMethods( [ 'set', 'get', 'delete' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testGetAttributesFromDefaultAttributes() {
		$defaultAttributes = [ "attr1" => "val1" ];
		$attributes = new UserAttributes( $this->service, $defaultAttributes );

		$this->assertEquals( "val1", $attributes->getAttribute( $this->userId, "attr1" ) );
		$this->assertNull( $attributes->getAttribute( $this->userId, "attr2" ) );
	}

	public function testGetAttributes() {
		$this->setupServiceExpects();
		$attributes = new UserAttributes( $this->service, [] );

		$this->assertEquals( "female", $attributes->getAttribute( $this->userId, "gender" ) );
		$this->assertEquals( "Lebowski", $attributes->getAttribute( $this->userId, "nickName") );
		$this->assertNull( $attributes->getAttribute( $this->userId, "unsetattribute" ) );
		$this->assertEquals( $this->savedAttributes, $attributes->getAttributes( $this->userId ) );
	}

	public function testGetAttributesWithDefaultParameter() {
		$this->setupServiceExpects();
		$attributes = new UserAttributes( $this->service, [] );

		$this->assertEquals( "someDefaultValue", $attributes->getAttribute( $this->userId, "attrWithNoValue", "someDefaultValue" ) );
		$this->assertEquals( "Lebowski", $attributes->getAttribute( $this->userId, "nickName", "someDefaultValue" ) );
	}
	
	public function testDefaultAttributesOverridesDefaultParameter() {
		$defaultAttributes = [ "attr1" => "val1" ];
		$attributes = new UserAttributes( $this->service, $defaultAttributes );

		$this->assertEquals( "val1", $attributes->getAttribute( $this->userId, "attr1", "defaultValue" ) );
	}

	public function testSetAttribute() {
		$this->setupServiceExpects();
		$userAttributes = new UserAttributes( $this->service, [] );
		$userAttributes->setAttribute( $this->userId, new Attribute( "newAttr", "foo" ) );
		$this->assertEquals( "foo", $userAttributes->getAttribute( $this->userId, "newAttr" ) );
		$userAttributes->setAttribute( $this->userId, new Attribute( "anotherNewAttr", null ) );
		$this->assertEquals( null, $userAttributes->getAttribute( $this->userId, "anotherNewAttr" ) );
	}

	protected function setupServiceExpects() {
		$this->service->expects( $this->once( ))
			->method( "get" )
			->with( $this->userId )
			->willReturn( array_map( function( $key, $value ) {
				return new Attribute( $key, $value);
			}, array_keys( $this->savedAttributes ), $this->savedAttributes ));
	}
}
