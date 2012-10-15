<?php

class MessageGroupBaseTest extends MediaWikiTestCase {

	/**
	 * @var MessageGroup
	 */
	protected $group;

	protected $groupConfiguration = array(
		'BASIC' => array(
			'class' => 'FileBasedMessageGroup',
			'id' => 'test-id',
			'label' => 'Test Label',
			'namespace' => 'NS_MEDIAWIKI',
			'description' => 'Test description',
		),
	);

	protected function setUp() {
		parent::setUp();
		$this->group = MessageGroupBase::factory( $this->groupConfiguration );
	}

	protected function tearDown() {
		unset( $this->group );
		parent::tearDown();
	}

	public function testGetConfiguration() {
		$this->assertEquals(
			$this->groupConfiguration,
			$this->group->getConfiguration(),
			"configuration should not change."
		);
	}

	public function testGetId() {
		$this->assertEquals(
			$this->groupConfiguration['BASIC']['id'],
			$this->group->getId(),
			"id comes from config."
		);
	}

	public function testGetSourceLanguage() {
		$this->assertEquals(
			'en',
			$this->group->getSourceLanguage(),
			"source language defaults to en."
		);
	}

	public function testGetNamespaceConstant() {
		$this->assertEquals(
			NS_MEDIAWIKI,
			$this->group->getNamespace(),
			"should parse string namespace contant."
		);
	}

	public function testGetNamespaceNumber() {
		$conf = $this->groupConfiguration;
		$conf['BASIC']['namespace'] = NS_IMAGE;
		$this->group = MessageGroupBase::factory( $conf );

		$this->assertEquals(
			NS_IMAGE,
			$this->group->getNamespace(),
			"should parse integer namespace number."
		);
	}

	public function testGetNamespaceString() {
		$conf = $this->groupConfiguration;
		$conf['BASIC']['namespace'] = 'image';
		$this->group = MessageGroupBase::factory( $conf );

		$this->assertEquals(
			NS_IMAGE,
			$this->group->getNamespace(),
			"should parse string namespace name."
		);
	}

	/**
	 * @expectedException MWException
	 * @expectedExceptionMessage No valid namespace defined
	 */
	public function testGetNamespaceInvalid() {
		$conf = $this->groupConfiguration;
		$conf['BASIC']['namespace'] = 'ergweofijwef';
		MessageGroupBase::factory( $conf );
	}

}
