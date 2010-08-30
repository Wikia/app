<?php
class NavigationServiceTest extends PHPUnit_Framework_TestCase {

	function testParseLines() {
		$service = new NavigationService();

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
					'depth' => 1,
					'parentIndex' => 0
				),
				2 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'depth' => 1,
					'parentIndex' => 0
				),
				3 => array (
					'original' => '1',
					'text' => '1',
					'href' => Title::newFromText('1')->fixSpecialName()->getLocalURL(),
					'depth' => 1,
					'parentIndex' => 0,
					'children' => array(4, 5)
				),
				4 => array (
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText('2')->fixSpecialName()->getLocalURL(),
					'depth' => 2,
					'parentIndex' => 3,
				),
				5 => array (
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText('2')->fixSpecialName()->getLocalURL(),
					'depth' => 2,
					'parentIndex' => 3,
					'children' => array(6)
				),
				6 => array (
					'original' => '4',
					'text' => '4',
					'href' => Title::newFromText('4')->fixSpecialName()->getLocalURL(),
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
					'depth' => 1,
					'parentIndex' => 0,
					'children' => array(2)
				),
				2 => array (
					'original' => '2',
					'text' => '2',
					'href' => Title::newFromText('2')->fixSpecialName()->getLocalURL(),
					'depth' => 2,
					'parentIndex' => 1
				)
			)
		);

		foreach($cases as $case) {
			$this->assertEquals(
				$case['out'],
				$service->parseLines($case['param1'], $case['param2'])
			);
		}
	}

	function testParseOneLine() {

		$service = new NavigationService();

		$cases = array();

		$cases[] = array(
			'line' => "*whatever",
			'out' => array(
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
			)
		);

		$cases[] = array(
			'line' => "*********whatever",
			'out' => array(
				'original' => 'whatever',
				'text' => 'whatever',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
			)
		);

		$cases[] = array(
			'line' => "*whatever|something",
			'out' => array(
				'original' => 'whatever',
				'text' => 'something',
				'href' => Title::newFromText('whatever')->fixSpecialName()->getLocalURL(),
			)
		);

		$cases[] = array(
			'line' => "*http://www.google.com",
			'out' => array(
				'original' => 'http://www.google.com',
				'text' => 'http://www.google.com',
				'href' => 'http://www.google.com',
			)
		);

		$cases[] = array(
			'line' => "*http://www.google.com|Google",
			'out' => array(
				'original' => 'http://www.google.com',
				'text' => 'Google',
				'href' => 'http://www.google.com',
			)
		);

		foreach($cases as $case) {
			$this->assertEquals(
				$case['out'],
				$service->parseOneLine($case['line'])
			);
		}

	}
}