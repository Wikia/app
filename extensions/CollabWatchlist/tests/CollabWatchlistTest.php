<?php

class CollabWatchlistTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		$this->markTestSkipped('Manually only');
	}
	public function testCategoryTree() {
		/* Workaround for eclipse xdebug
		$path = '/usr/share/php';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		*/
		$catTree = new CategoryTreeManip();
		$catNames = array( "Root" );
		$catTree->initialiseFromCategoryNames( $catNames );
		$catTree->printTree();
	}
}
