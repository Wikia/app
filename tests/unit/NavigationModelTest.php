<?php

class NavigationModelTest extends WikiaBaseTest {

	function setUp() {
		parent::setUp();
		$memcMock = $this->getMock( 'MemcachedPhpBagOStuff', [ 'get', 'set' ], [], '', false );
		$memcMock->expects( $this->any() )->method( 'get' )->will( $this->returnValue( false ) );
		$memcMock->expects( $this->any() )->method( 'set' )->will( $this->returnValue( true ) );

		$this->mockGlobalVariable( 'wgMemc', $memcMock );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.01634 ms
	 */
	function testParseLines() {
		$model = new NavigationModel();

		$cases = [];

		$cases[] = [
			'param1' => [ "*1", "*1", "*1", "**2", "**2", "****4" ],
			'param2' => null,
			'out' => [
				0 => [
					'children' => [ 1, 2, 3 ]
				],
				1 => [
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText( '1' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0
				],
				2 => [
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText( '1' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0
				],
				3 => [
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText( '1' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0,
					'children' => [ 4, 5 ]
				],
				4 => [
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText( '2' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 2,
					'parentIndex' => 3,
				],
				5 => [
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText( '2' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 2,
					'parentIndex' => 3,
					'children' => [ 6 ]
				],
				6 => [
					'original' => '4',
					'text' => '4',
					'href' => Title::newFromText( '4' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 4,
					'parentIndex' => 5,
				],
			]
		];

		$cases[] = [
			'param1' => [ "*1", "*1", "*1", "**2", "**2" ],
			'param2' => [ 1 ],
			'out' => [
				0 => [
					'children' => [ 1 ]
				],
				1 => [
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText( '1' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0
				]
			]
		];

		$cases[] = [
			'param1' => [ "*1", "**2", "**2", "*1", "*1" ],
			'param2' => [ 1, 1 ],
			'out' => [
				0 => [
					'children' => [ 1 ]
				],
				1 => [
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText( '1' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0,
					'children' => [ 2 ]
				],
				2 => [
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText( '2' )->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 2,
					'parentIndex' => 1
				]
			]
		];

		foreach ( $cases as $case ) {
			$this->assertEquals(
				$case['out'],
				$model->parseLines( $case['param1'], $case['param2'] )
			);
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.02663 ms
	 */
	function testParseMessage() {
		$messageName = 'test' . rand();

		$this->mockMessage($messageName, '*whatever');

		$model = new NavigationModel();

		$nodes = [
			[
				'children' => [ 1 ]
			],
			[
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText( 'whatever' )->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
				'parentIndex' => 0,
				'depth' => 1
			]
		];

		$nodes[0]['hash'] = md5( serialize( $nodes ) );

		$this->assertEquals(
			$nodes,
			$model->parse(
				NavigationModel::TYPE_MESSAGE,
				$messageName,
				[],
				1
			)
		);
	}

	/**
	 * @group UsingDB
	 */
	function testParseOneLine() {
		$model = new NavigationModel();

		$cases = [];

		$cases[] = [
			'line' => "*whatever",
			'out' => [
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText( 'whatever' )->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*********whatever",
			'out' => [
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText( 'whatever' )->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*whatever|something",
			'out' => [
				'original' => 'whatever',
				'text' => 'something',
				'href' => Title::newFromText( 'whatever' )->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*http://www.google.com",
			'out' => [
				'original' => 'http://www.google.com',
				'text' => 'http://www.google.com',
				'href' => 'http://www.google.com',
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*http://www.google.com|Google",
			'out' => [
				'original' => 'http://www.google.com',
				'text' => 'Google',
				'href' => 'http://www.google.com',
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*#|Google",
			'out' => [
				'original' => '#',
				'text' => 'Google',
				'href' => '#',
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*|Google",
			'out' => [
				'original' => '',
				'text' => 'Google',
				'href' => '#',
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*__NOLINK__edit",
			'out' => [
				'original' => '__NOLINK__edit',
				'text' => wfMsg( 'edit' ),
				'href' => '#',
				'specialAttr' => null,
			]
		];

		$cases[] = [
			'line' => "*\xef\xbf\xbd|\xef\xbf\xbd",
			'out' => [
				'original' => "\xef\xbf\xbd",
				'text' => "\xef\xbf\xbd",
				'href' => '#',
				'specialAttr' => null,
			]
		];

		foreach ( $cases as $case ) {
			$this->assertEquals(
				$case['out'],
				$model->parseOneLine( $case['line'] )
			);
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.022 ms
	 */
	function testParseOneLineWithoutTranslation() {
		$this->mockMessage('whatever', 'mocked text');

		$method = new ReflectionMethod(
			'NavigationModel', 'setShouldTranslateContent'
		);
		$method->setAccessible( true );

		$model = new NavigationModel();

		$method->invoke( $model, false );

		$case = [
			'original' => 'whatever',
			'text' => 'whatever',
			'href' => Title::newFromText( 'whatever' )->fixSpecialName()->getLocalURL(),
			'specialAttr' => null,
		];
		$this->assertEquals(
			$case,
			$model->parseOneLine( '*whatever' )
		);
	}

	/**
	 * @group UsingDB
	 */
	function testParseText() {
		$model = new NavigationModel();

		$cases = [];

		$cases[] = [
			'text' => '*<nowiki>foo</nowiki>',
			'out' => [
				0 => [
					'children' => [ 1 ]
				],
				1 => [
					'original' => '<nowiki>foo</nowiki>',
					'text' => 'foo',
					'href' => '#',
					'specialAttr' => null,
					'parentIndex' => 0,
					'depth' => 1,
				]
			]
		];

		foreach ( $cases as $case ) {
			$case['out'][0]['hash'] = md5( serialize( $case['out'] ) );
			$this->assertEquals(
				$case['out'],
				$model->parseText( $case['text'] )
			);
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03666 ms
	 * @group UsingDB
	 */
	function testParseErrors() {
		$model = new NavigationModel();
		$this->assertEmpty( $model->getErrors() );

		// magic words are not allowed on level #1
		$nodes = $model->parseText( "*#category1" );
		$this->assertTrue( $model->getErrors()[NavigationModel::ERR_MAGIC_WORD_IN_LEVEL_1] );

		// magic words are  allowed on level #2
		$nodes = $model->parseText( "*foo\n**#category1" );
		$this->assertEmpty( $model->getErrors() );
	}
}
