<?php

class CategorySelectTest extends WikiaBaseTest {
	protected static $data = [
		[
			'namespace' => 'Category',
			'name' => 'test category',
			'sortkey' => 'test sort key'
		],
		[
			'namespace' => 'Category',
			'name' => '2nd test category',
			'sortkey' => '2nd test sort key'
		]
	];

	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../CategorySelect.setup.php';
		parent::setUp();
	}

	public function testChangeFormatFromArrayToWikiText() {
		$expectedWikiText = "[[Category:test category|test sort key]]\n[[Category:2nd test category|2nd test sort key]]";

		$wikiText = CategorySelect::changeFormat( self::$data, 'array', 'wikitext' );

		$this->assertEquals( $expectedWikiText, trim( $wikiText ) );
	}

	public function testGetCategoryNames() {
		$actual = CategorySelect::getCategoryNames( self::$data );
		$expected = [ 'Test category', '2nd test category' ];
		$this->assertEquals( $expected, $actual );
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
