<?php

/**
 * Class ImageServingUnitTest
 *
 * @group MediaFeatures
 */
class ImageServingUnitTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../imageServing.setup.php";
		parent::setUp();
	}

	function testSize() {
		$is = new ImageServing(array(1), 100, array("w" => 1, "h" => 1));
		$this->assertEquals( '100px-56,237,0,180', $is->getCut( 290, 180 ) );
		$this->assertEquals( '100px-68,285,0,216', $is->getCut( 350, 216 ) );

		$is = new ImageServing(array(1), 270, array("w" => 3, "h" => 1));
		$this->assertEquals( '270px-0,428,57,200', $is->getCut( 428, 285 ) );
		$this->assertEquals( '270px-0,669,119,342', $is->getCut( 669, 593 ) );

		$is = new ImageServing(array(1), 200, array("w" => 2, "h" => 1));
		$this->assertEquals( '200px-0,314,65,222', $is->getCut( 314, 654 ) );
		$this->assertEquals( '200px-0,572,36,322', $is->getCut( 572, 355 ) );
	}

	function testWidthAndHeightGetters() {
		$is = new ImageServing(null, 200, 100);

		$this->assertEquals(200, $is->getRequestedWidth());
		$this->assertEquals(100, $is->getRequestedHeight());

		$is = new ImageServing(null, 300, ['w' => 2, 'h' => 1]);

		$this->assertEquals(300, $is->getRequestedWidth());
		$this->assertEquals(150, $is->getRequestedHeight());
	}

	function testHasArticleIds() {
		$is = new ImageServing(null, 200, 100);
		$articles = array( 1234 );
		$is->setArticleIds( $articles );
		$this->assertTrue( $is->hasArticleIds( $articles ) );
	}

	function testHasEmptyArticleIds() {
		$is = new ImageServing(null, 200, 100);
		$articles = array( null );
		$is->setArticleIds( $articles );
		$this->assertFalse( $is->hasArticleIds( [ 0 ] ) );
	}

	function testHasArticleIdsDiff() {
		$is = new ImageServing(null, 200, 100);
		$is->setArticleIds( array( 1234 ) );
		$this->assertFalse( $is->hasArticleIds( array( 1111 ) ) );
	}

	function testHasArticleIdsEmpty() {
		$is = new ImageServing(null, 200, 100);
		$articles = array( 1234 );
		$this->assertFalse( $is->hasArticleIds( $articles ) );
	}
}
