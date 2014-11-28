<?php

class ArticleNavigationTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ArticleNavigation.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testExtractDropdownDataDataProvider
	 */
	public function testExtractDropdownData($items, $expectedResult) {
		$articleNavigationHelper = new ArticleNavigationHelper();
		$result = $articleNavigationHelper->extractDropdownData($items);

		$this->assertEquals($result, $expectedResult);
	}

	public function testExtractDropdownDataDataProvider() {

		return [
			[
				[['type' => 'foo', 'href' => 'bar', 'caption' => 'foo-bar', 'tracker-name' => 'fizz']],
				[['title' => 'foo-bar', 'href' => 'bar', 'dataAttr' =>
					['key' => 'name', 'value' => 'fizz']]
				]
			], [
				[['type' => 'disabled', 'href' => 'bar', 'caption' => 'foo-bar', 'tracker-name' => 'fizz']],
				[],
			], [
				[['type' => 'foo', 'href' => 'bar', 'tracker-name' => 'fizz']],
				[],
			], [
				[['type' => 'foo', 'href' => 'bar', 'caption' => 'foo-bar']],
				[['title' => 'foo-bar', 'href' => 'bar']],
			], [
				[['href' => 'bar', 'caption' => 'foo/bar', 'type' => 'menu', 'items' =>
					[['type' => 'fizz', 'href' => 'buzz', 'caption' => 'fizz-buzz', 'tracker-name' => 'buzz-fizz']]
				]],
				[['title' => 'foo/bar', 'href' => 'bar', 'sections' =>
					[['href' => 'buzz', 'title' => 'fizz-buzz', 'dataAttr' =>
						['key' => 'name', 'value' => 'buzz-fizz']
					]]
				]]
			]
		];
	}
}
