<?php

namespace Wikia\Service\User\Attributes;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Wikia\Domain\User\Attribute;
use Doctrine\Common\Cache\CacheProvider;

class UserAttributeTest extends PHPUnit_Framework_TestCase {
	/** @var int */
	protected $userId = 1;

	/** @var int */
	protected $anonUserId = 0;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $service;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $cache;

	/** @var  Attribute */
	protected $attribute1;

	/** @var  Attribute */
	protected $attribute2;

	/** @var  Attribute */
	protected $defaultAttribute;

	/** @var Attribute[]  */
	protected $savedAttributesForUser;

	protected function setUp() {
		$this->service = $this->getMockBuilder( AttributeService::class )
			->setMethods( [ 'set', 'get', 'delete' ] )
			->disableOriginalConstructor()
			->getMock();
		$this->cache = $this->getMockBuilder( CacheProvider::class )
			->setMethods( ['doFetch', 'doContains', 'doSave', 'doFlush', 'doDelete', 'doGetStats'] )
			->disableOriginalConstructor()
			->getMock();
		$this->cache->method('doFetch')->willReturn(false);
		$this->attribute1 = new Attribute( "nickName", "Lebowski" );
		$this->attribute2 = new Attribute( "gender", "female" );
		$this->defaultAttribute = new Attribute( "defaultName", "defaultValue" );
		$this->savedAttributesForUser = [ $this->attribute1, $this->attribute2 ];
	}

	public function testGetAttributes() {
		$this->setupServiceGetExpects();
		$attributes = new UserAttributes( $this->service, $this->cache );

		$this->assertEquals( $this->attribute1->getValue(),
			$attributes->getAttribute( $this->userId, $this->attribute1->getName() ) );

		$this->assertEquals( $this->attribute2->getValue(),
			$attributes->getAttribute( $this->userId, $this->attribute2->getName() ) );

		$this->assertNull( $attributes->getAttribute( $this->userId, "unsetattribute" ) );
	}

	public function testGetAttributesWithDefaultParameter() {
		$this->setupServiceGetExpects();
		$attributes = new UserAttributes( $this->service, $this->cache );

		$this->assertEquals( "someDefaultValue",
			$attributes->getAttribute( $this->userId, "attrWithNoValue", "someDefaultValue" ) );

		$this->assertEquals( $this->attribute1->getValue(),
			$attributes->getAttribute( $this->userId, $this->attribute1->getName(), "someDefaultValue" ) );
	}

	public function testSetAttribute() {
		$userAttributes = new UserAttributes( $this->service, $this->cache );
		$userAttributes->setAttribute( $this->userId, new Attribute( "newAttr", "foo" ) );
		$this->assertEquals( "foo", $userAttributes->getAttribute( $this->userId, "newAttr" ) );
		$userAttributes->setAttribute( $this->userId, new Attribute( "anotherNewAttr", null ) );
		$this->assertEquals( null, $userAttributes->getAttribute( $this->userId, "anotherNewAttr" ) );
	}

	public function testDeleteAttributeSetForUser() {
		$this->setupServiceGetExpects();
		$this->service->expects( $this->once() )
			->method( "delete" )
			->with( $this->userId, $this->attribute1 );


		$userAttributes = new UserAttributes( $this->service, $this->cache );

		$this->assertEquals( $this->attribute1->getValue(),
			$userAttributes->getAttribute( $this->userId, $this->attribute1->getName() ) );

		$userAttributes->deleteAttribute( $this->userId, $this->attribute1 );
		$this->assertNull( $userAttributes->getAttribute( $this->userId, $this->attribute1->getName() ) );
	}

	protected function setupServiceGetExpects() {
		$this->service->expects( $this->once( ))
			->method( "get" )
			->with( $this->userId )
			->willReturn( $this->savedAttributesForUser );
	}
}
