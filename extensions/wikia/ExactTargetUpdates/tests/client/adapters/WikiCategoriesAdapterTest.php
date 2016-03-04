<?php

class WikiCategoriesAdapterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testGetCategoriesMapping() {
		// Params
		$result = new stdClass();
		$result->Properties->Property = [
			$this->buildResultPair( 'city_id', 1 ),
			$this->buildResultPair( 'cat_id', 3 )
		];

		// Expected
		$expected = [
			[ 'city_id' => 1, 'cat_id' => 3 ]
		];

		$categoriesMapping = ( new \Wikia\ExactTarget\WikiCategoriesAdapter( [ $result ] ) )->getCategoriesMapping();
		$this->assertEquals( $expected, $categoriesMapping );
	}

	public function testGetMultipleCategoriesMapping() {
		// Params
		$p1 = [
			$this->buildResultPair( 'city_id', 5 ),
			$this->buildResultPair( 'cat_id', 23 )
		];
		$p2 = [
			$this->buildResultPair( 'city_id', 5 ),
			$this->buildResultPair( 'cat_id', 23423 )
		];
		$results = [
			$this->wrapProperty( $p1 ),
			$this->wrapProperty( $p2 )
		];

		// Expected
		$expected = [
			[ 'city_id' => 5, 'cat_id' => 23 ],
			[ 'city_id' => 5, 'cat_id' => 23423 ]
		];

		$categoriesMapping = ( new \Wikia\ExactTarget\WikiCategoriesAdapter( $results ) )->getCategoriesMapping();
		$this->assertEquals( $expected, $categoriesMapping );
	}

	private function wrapProperty( array $propertyValues ) {
		$property = new stdClass();
		$property->Properties->Property = $propertyValues;
		return $property;
	}

	private function buildResultPair( $name, $value ) {
		$pair = new stdClass();
		$pair->Name = $name;
		$pair->Value = $value;
		return $pair;
	}
}
