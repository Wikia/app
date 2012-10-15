<?php

class FRParserCacheStableTest extends PHPUnit_Framework_TestCase {
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		$this->cache = FRParserCacheStable2::singleton();
		parent::setUp();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {}

	// Tests for ParserCache changes - make sure stable keys are different
	public function testGetParserOutputKey() {
		$article = new Article( Title::newMainPage() );
		$key = $this->cache->getParserOutputKey( $article, '' );
		$this->assertRegExp( '/:stable-pcache:/', $key, 'Stable/latest cache has separation' );
	}

	// Tests for ParserCache changes - make sure stable keys are different
	public function testGetOptionsKey() {
		$article = new Article( Title::newMainPage() );
		$key = $this->cache->getOptionsKey( $article );
		$this->assertRegExp( '/:stable-pcache:/', $key, 'Stable/latest cache has separation' );
	}
}

// Make a special FRParserCacheStable class were some things are public.
// Reflections would be nicer...but thats PHP 5.3.2...
class FRParserCacheStable2 extends FRParserCacheStable {
	public static function singleton() {
		static $instance;
		if ( !isset( $instance ) ) {
			global $parserMemc;
			$instance = new self( $parserMemc ); // no LSB...sigh
		}
		return $instance;
	}

	public function getParserOutputKey( $article, $hash ) {
		return parent::getParserOutputKey( $article, $hash );
	}

	public function getOptionsKey( $article ) {
		return parent::getOptionsKey( $article );
	}
}
