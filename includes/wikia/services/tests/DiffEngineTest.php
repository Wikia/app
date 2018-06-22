<?php

use PHPUnit\Framework\TestCase;

/**
 * @group wikidiff
 */
class DiffEngineTest extends TestCase {

	protected function setUp() {
		parent::setUp();

		if ( !extension_loaded( 'wikidiff2' ) ) {
			$this->markTestSkipped( 'wikidiff2 extension must be available' );
		}
	}

	public function testGetDiff() {
		$engine = new DifferenceEngine();

		$textA = 'foo';
		$textB = 'foobar';

		$diff = $engine->generateDiffBody( $textA, $textB );
		$this->assertContains( 'class="diffchange diffchange-inline">foo</', $diff );
	}
}
