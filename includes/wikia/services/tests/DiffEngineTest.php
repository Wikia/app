<?php

class DiffEngineTest extends WikiaBaseTest {

	public function testExtensionsIsLoaded() {
		$this->assertTrue( extension_loaded( 'wikidiff2' ), '"wikidiff2" PHP extension needs to be loaded!' );
	}

	public function testGetDiff() {
		$engine = new DifferenceEngine();

		$textA = 'foo';
		$textB = 'foobar';

		$diff = $engine->generateDiffBody( $textA, $textB );
		$this->assertContains( 'class="diffchange diffchange-inline">foo</', $diff );
	}
}
