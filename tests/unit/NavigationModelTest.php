<?php
class NavigationModelTest extends WikiaBaseTest {
	function testParseLines() {
		$model = new NavigationModel();

		$cases = array();

		$cases[] = array(
			'param1' => array("*1", "*1", "*1", "**2", "**2", "****4"),
			'param2' => null,
			'out' => array(
				0 => array(
					'children' => array(1, 2, 3)
				),
				1 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0
				),
				2 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0
				),
				3 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0,
					'children' => array(4, 5)
				),
				4 => array (
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText('2')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 2,
					'parentIndex' => 3,
				),
				5 => array (
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText('2')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 2,
					'parentIndex' => 3,
					'children' => array(6)
				),
				6 => array (
					'original' => '4',
					'text' => '4',
					'href' => Title::newFromText('4')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 4,
					'parentIndex' => 5,
				),
			)
		);

		$cases[] = array(
			'param1' => array("*1", "*1", "*1", "**2", "**2"),
			'param2' => array(1),
			'out' => array(
				0 => array(
					'children' => array(1)
				),
				1 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0
				)
			)
		);

		$cases[] = array(
			'param1' => array("*1", "**2", "**2", "*1", "*1"),
			'param2' => array(1, 1),
			'out' => array(
				0 => array(
					'children' => array(1)
				),
				1 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 1,
					'parentIndex' => 0,
					'children' => array(2)
				),
				2 => array (
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText('2')->fixSpecialName()->getLocalURL(),
					'specialAttr' => null,
					'depth' => 2,
					'parentIndex' => 1
				)
			)
		);

		foreach($cases as $case) {
			$this->assertEquals(
				$case['out'],
				$model->parseLines($case['param1'], $case['param2'])
			);
		}
	}

	function testParseMessage() {
		$messageName = 'test'.rand();

		$this->getGlobalFunctionMock( 'wfMsg' )
			->expects( $this->exactly( 2 ) )
			->method( 'wfMsg' )
			->will( $this->returnValue( '*whatever' ) );

		$model = new NavigationModel();

		$nodes = array(
			array(
				'children' => array(1)
			),
			array (
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
				'parentIndex' => 0,
				'depth' => 1
			)
		);

		$nodes[0]['hash'] = md5(serialize($nodes));

		$this->assertEquals($nodes, $model->parse(
			NavigationModel::TYPE_MESSAGE,
			$messageName,
			array(),
			1
		));
	}

	function testParseOneLine() {
		$model = new NavigationModel();

		$cases = array();

		$cases[] = array(
			'line' => "*whatever",
			'out' => array(
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*********whatever",
			'out' => array(
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*whatever|something",
			'out' => array(
				'original' => 'whatever',
				'text' => 'something',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*http://www.google.com",
			'out' => array(
				'original' => 'http://www.google.com',
				'text' => 'http://www.google.com',
				'href' => 'http://www.google.com',
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*http://www.google.com|Google",
			'out' => array(
				'original' => 'http://www.google.com',
				'text' => 'Google',
				'href' => 'http://www.google.com',
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*#|Google",
			'out' => array(
				'original' => '#',
				'text' => 'Google',
				'href' => '#',
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*|Google",
			'out' => array(
				'original' => '',
				'text' => 'Google',
				'href' => '#',
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*__NOLINK__edit",
			'out' => array(
				'original' => '__NOLINK__edit',
				'text' => wfMsg('edit'),
				'href' => '#',
				'specialAttr' => null,
			)
		);

		$cases[] = array(
			'line' => "*\xef\xbf\xbd|\xef\xbf\xbd",
			'out' => array(
				'original' => "\xef\xbf\xbd",
				'text' => "\xef\xbf\xbd",
				'href' => '#',
				'specialAttr' => null,
			)
		);

		foreach($cases as $case) {
			$this->assertEquals(
				$case['out'],
				$model->parseOneLine($case['line'])
			);
		}
	}

	function testParseOneLineWithoutTranslation() {
		$this->getGlobalFunctionMock( 'wfMsg' )
			->expects( $this->never() )
			->method( 'wfMsg' )
			->will( $this->returnValue( 'mocked text' ) );

		$method = new ReflectionMethod(
			'NavigationModel', 'setShouldTranslateContent'
		);
		$method->setAccessible(TRUE);

		$model = new NavigationModel();

		$method->invoke($model, false);

		$case = array(
			'original' => 'whatever',
			'text' => 'whatever',
			'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
			'specialAttr' => null,
		);
		$this->assertEquals(
			$case,
			$model->parseOneLine("*whatever")
		);

	}

	function testParseText() {
		$model = new NavigationModel();

		$cases = array();

		$cases[] = array(
			'text' => '*<nowiki>foo</nowiki>',
			'out' => array(
				0 => array(
					'children' => array(1)
				),
				1 => array (
					'original' => '<nowiki>foo</nowiki>',
					'text' => 'foo',
					'href' => '#',
					'specialAttr' => null,
					'parentIndex' => 0,
					'depth' => 1,
				)
			)
		);

		foreach($cases as $case) {
			$case['out'][0]['hash'] = md5(serialize($case['out']));
			$this->assertEquals(
				$case['out'],
				$model->parseText($case['text'])
			);
		}
	}

	function testParseErrors() {
		$model = new NavigationModel();
		$this->assertEmpty($model->getErrors());

		// magic words are not allowed on level #1
		$nodes = $model->parseText("*#category1");
		$this->assertTrue( $model->getErrors()[NavigationModel::ERR_MAGIC_WORD_IN_LEVEL_1] );

		// magic words are  allowed on level #2
		$nodes = $model->parseText("*foo\n**#category1");
		$this->assertEmpty($model->getErrors());
 	}
}
