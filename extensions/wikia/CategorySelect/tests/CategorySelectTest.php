<?php

class CategorySelectTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../CategorySelect.setup.php';
		parent::setUp();
	}

	public function testChangeFormatFromArrayToWikiText() {
		$categories = [];
		$categories[] = [
			'namespace' => 'Category',
			'name' => 'test category',
			'sortkey' => 'test sort key'
		];
		$categories[] = [
			'namespace' => 'Category',
			'name' => '2nd test category',
			'sortkey' => '2nd test sort key'
		];

		$expectedWikiText = "[[Category:test category|test sort key]]\n[[Category:2nd test category|2nd test sort key]]";

		$wikiText = CategorySelect::changeFormat($categories, 'array', 'wikitext');

		$this->assertEquals($expectedWikiText, trim($wikiText));
	}

	public function testGetUniqueCategories() {
		$categories = [];
		$categories[] = [
			'namespace' => 'Category',
			'name' => 'this is a duplicate'
		];

		$categories[] = $categories[ 0 ];

		$expected = [ $categories[ 0 ] ];

		$actual = CategorySelect::getUniqueCategories( $categories );

		$this->assertEquals( $expected, $actual );
	}
}
