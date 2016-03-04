<?php

class UserEditsAdapterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testGetEdits() {
		// Params
		$result = new stdClass();
		$result->Properties->Property = [
			$this->buildResultPair( 'user_id', 1 ),
			$this->buildResultPair( 'wiki_id', 177 ),
			$this->buildResultPair( 'contributions', 6 ),
		];

		// Expected
		$expected = [
			1 => [
				177 => 6
			]
		];

		$userEdits = ( new \Wikia\ExactTarget\UserEditsAdapter( [ $result ] ) )->getEdits();
		$this->assertEquals( $expected, $userEdits );
	}

	public function testGetEditsMultipleWikis() {
		// Params
		$p1 = [
			$this->buildResultPair( 'user_id', 1 ),
			$this->buildResultPair( 'wiki_id', 177 ),
			$this->buildResultPair( 'contributions', 6 ),
		];
		$p2 = [
			$this->buildResultPair( 'user_id', 1 ),
			$this->buildResultPair( 'wiki_id', 831 ),
			$this->buildResultPair( 'contributions', 8 ),
		];
		$results = [
			$this->wrapProperty( $p1 ),
			$this->wrapProperty( $p2 )
		];

		// Expected
		$expected = [
			1 => [
				177 => 6,
				831 => 8
			]
		];

		$userEdits = ( new \Wikia\ExactTarget\UserEditsAdapter( $results ) )->getEdits();
		$this->assertEquals( $expected, $userEdits );
	}

	public function testGetEditsMultipleUsers() {
		// Params
		$p1 = [
			$this->buildResultPair( 'user_id', 1 ),
			$this->buildResultPair( 'wiki_id', 177 ),
			$this->buildResultPair( 'contributions', 6 ),
		];
		$p2 = [
			$this->buildResultPair( 'user_id', 2 ),
			$this->buildResultPair( 'wiki_id', 177 ),
			$this->buildResultPair( 'contributions', 8 ),
		];
		$results = [
			$this->wrapProperty( $p1 ),
			$this->wrapProperty( $p2 )
		];

		// Expected
		$expected = [
			1 => [
				177 => 6
			],
			2 => [
				177 => 8
			]
		];

		$userEdits = ( new \Wikia\ExactTarget\UserEditsAdapter( $results ) )->getEdits();
		$this->assertEquals( $expected, $userEdits );
	}

	public function testGetEditsMultipleUsersMultipleWikis() {
		// Params
		$p1 = [
			$this->buildResultPair( 'user_id', 1 ),
			$this->buildResultPair( 'wiki_id', 177 ),
			$this->buildResultPair( 'contributions', 6 ),
		];
		$p2 = [
			$this->buildResultPair( 'user_id', 1 ),
			$this->buildResultPair( 'wiki_id', 831 ),
			$this->buildResultPair( 'contributions', 7 ),
		];
		$p3 = [
			$this->buildResultPair( 'user_id', 2 ),
			$this->buildResultPair( 'wiki_id', 177 ),
			$this->buildResultPair( 'contributions', 8 ),
		];
		$results = [
			$this->wrapProperty( $p1 ),
			$this->wrapProperty( $p2 ),
			$this->wrapProperty( $p3 )
		];

		// Expected
		$expected = [
			1 => [
				177 => 6,
				831 => 7
			],
			2 => [
				177 => 8
			]
		];

		$userEdits = ( new \Wikia\ExactTarget\UserEditsAdapter( $results ) )->getEdits();
		$this->assertEquals( $expected, $userEdits );
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
