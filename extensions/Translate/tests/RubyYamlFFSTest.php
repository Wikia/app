<?php

class RubyYamlFFSTest extends MediaWikiTestCase {

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
		'FILES' => array(
			'class' => 'RubyYamlFFS',
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

	/**
	 * @dataProvider unflattenDataProvider
	 */
	public function testUnflattenPural( $key, $value, $result ) {
		$ffs = $this->group->getFFS();
		$this->assertEquals(
			$result,
			$ffs->unflattenPlural( $key, $value )
		);
	}

	public function unflattenDataProvider() {
		return array(
			array( 'key', '{{PLURAL}}', false ),
			array( 'key', 'value', array( 'key' => 'value' ) ),
			array( 'key', '{{PLURAL|one=cat|other=cats}}',
				array( 'key.one' => 'cat', 'key.other' => 'cats' )
			),
			array( 'key', '{{PLURAL|one=шляху %{related_ways}|шляхоў %{related_ways}}}',
				array( 'key.one' => 'шляху %{related_ways}', 'key.other' => 'шляхоў %{related_ways}' )
			),
			array( 'key', '{{PLURAL|foo=cat}}',
				array( 'key.other' => 'foo=cat' )
			),
			array( 'key', '{{PLURAL|zero=0|one=1|two=2|few=3|many=160|other=898}}',
				array( 'key.zero' => '0', 'key.one' => '1', 'key.two' => '2',
				       'key.few' => '3', 'key.many' => '160', 'key.other' => '898' )
			),
		);
	}

}
