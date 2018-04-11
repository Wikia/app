<?php
/**
 * Test the database access and core functionallity of MathRenderer.
 *
 * @group Math
 */
class MathRendererTest extends MediaWikiTestCase {
	/**
	 * Checks the tex and hash functions
	 * @covers MathRenderer::getTex()
	 * @covers MathRenderer::__construct()
	 */
	public function testBasics() {
		$renderer = $this->getMockForAbstractClass( 'MathRenderer', array ( MathDatabaseTest::SOME_TEX ) );
		// check if the TeX input was corretly passed to the class
		$this->assertEquals( MathDatabaseTest::SOME_TEX, $renderer->getTex(), "test getTex" );
	}

	/**
	 *  Test behavior of writeCache() when nothing was changed
	 * @covers MathRenderer::writeCache()
	 */
	public function testWriteCacheSkip() {
		$renderer = $this->getMockBuilder( 'MathRenderer' )
			->setMethods( array( 'writeToDatabase' , 'render' ) )
			->disableOriginalConstructor()
			->getMock();
		$renderer->expects( $this->never() )
		->method( 'writeToDatabase' );
		$renderer->writeCache();
	}

	/**
	 * Test behavior of writeCache() when values were changed.
	 * @covers MathRenderer::writeCache()
	 */
	public function testWriteCache() {
		$renderer = $this->getMockBuilder( 'MathRenderer' )
			->setMethods( array( 'writeToDatabase' , 'render' ) )
			->disableOriginalConstructor()
			->getMock();
		$renderer->expects( $this->never() )
			->method( 'writeToDatabase' );
		$renderer->writeCache();
	}
}